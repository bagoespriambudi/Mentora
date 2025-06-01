<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Project $project)
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
}
