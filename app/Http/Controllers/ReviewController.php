<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function storeProjectReview(Request $request, Project $project)
    {
        // Verify that the authenticated user is the client of this project
        if (Auth::id() !== $project->client_id) {
            return back()->with('error', 'Unauthorized action.');
        }

        // Verify that the project is completed
        if ($project->status !== 'completed') {
            return back()->with('error', 'You can only review completed projects.');
        }

        // Verify that no review exists
        if ($project->review()->exists()) {
            return back()->with('error', 'You have already reviewed this project.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string|min:10',
            'is_public' => 'boolean'
        ]);

        $review = Review::create([
            'project_id' => $project->id,
            'client_id' => Auth::id(),
            'freelancer_id' => $project->freelancer_id,
            'rating' => $validated['rating'],
            'title' => $validated['title'],
            'comment' => $validated['comment'],
            'is_public' => $validated['is_public'] ?? true,
        ]);

        return redirect()->route('orders.show', $project)
            ->with('success', 'Thank you for your review!');
    }

    public function edit(Review $review)
    {
        // Check if user owns this review
        if (Auth::id() !== $review->client_id) {
            return back()->with('error', 'Unauthorized action.');
        }

        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        // Check if user owns this review
        if (Auth::id() !== $review->client_id) {
            return back()->with('error', 'Unauthorized action.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string|min:10',
            'is_public' => 'boolean'
        ]);

        $review->update($validated);

        return redirect()->route('orders.show', $review->project)
            ->with('success', 'Review updated successfully!');
    }

    public function destroy(Review $review)
    {
        // Check if user owns this review
        if (Auth::id() !== $review->client_id) {
            return back()->with('error', 'Unauthorized action.');
        }

        $project = $review->project;
        $review->delete();

        return redirect()->route('orders.show', $project)
            ->with('success', 'Review deleted successfully!');
    }

    // Tutee: List reviews given
    public function tuteeIndex()
    {
        if (Auth::user()->role !== 'tutee') {
            abort(403, 'Unauthorized');
        }
        $reviews = Review::where('tutee_id', Auth::id())->with('tutor')->latest()->get();
        return view('tutee.reviews.index', compact('reviews'));
    }

    // Tutee: Create review form
    public function create(Service $service)
    {
        if (Auth::user()->role !== 'tutee') {
            abort(403, 'Unauthorized');
        }
        return view('tutee.reviews.create', compact('service'));
    }

    // Tutee: Store review
    public function storeTuteeReview(Request $request, Service $service)
    {
        if (Auth::user()->role !== 'tutee') {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
        ]);
        Review::create([
            'tutee_id' => Auth::id(),
            'tutor_id' => $service->user_id,
            'session_id' => $service->id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);
        return redirect()->route('tutee.reviews.index')->with('success', 'Review submitted!');
    }

    // Tutor: List received reviews
    public function tutorIndex()
    {
        if (Auth::user()->role !== 'tutor') {
            abort(403, 'Unauthorized');
        }
        $reviews = Review::where('tutor_id', Auth::id())->with('tutee')->latest()->get();
        return view('tutor.reviews.index', compact('reviews'));
    }

    // Tutor: Respond to review
    public function respond(Request $request, Review $review)
    {
        if (Auth::user()->role !== 'tutor') {
            abort(403, 'Unauthorized');
        }
        $this->authorize('update', $review);
        $request->validate(['response' => 'required|string']);
        $review->update(['response' => $request->response]);
        return back()->with('success', 'Response submitted!');
    }

    // Show a review (for both roles)
    public function show(Review $review)
    {
        return view('reviews.show', compact('review'));
    }
}
