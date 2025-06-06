<?php

namespace App\Http\Controllers;

use App\Models\TutorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TutorProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        if (!auth()->check() || auth()->user()->role !== 'tutor') {
            abort(403, 'Unauthorized');
        }
        $profile = auth()->user()->tutorProfile;
        if (!$profile) {
            $profile = auth()->user()->tutorProfile()->create([
                'hourly_rate' => 0,
                'bio' => '',
                'expertise' => [],
                'availability' => [],
                'is_available' => true,
            ]);
        }
        $isProfileComplete = $this->isProfileComplete($profile);
        return view('tutor.profile.show', compact('profile', 'isProfileComplete'));
    }

    public function edit()
    {
        if (!auth()->check() || auth()->user()->role !== 'tutor') {
            abort(403, 'Unauthorized');
        }
        $profile = auth()->user()->tutorProfile;
        if (!$profile) {
            $profile = auth()->user()->tutorProfile()->create([
                'hourly_rate' => 0,
                'bio' => '',
                'expertise' => [],
                'availability' => [],
                'is_available' => true,
            ]);
        }
        $isProfileComplete = $this->isProfileComplete($profile);
        return view('tutor.profile.edit', compact('profile', 'isProfileComplete'));
    }

    public function update(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'tutor') {
            abort(403, 'Unauthorized');
        }
        $profile = auth()->user()->tutorProfile;

        $validated = $request->validate([
            'bio' => 'nullable|string|max:1000',
            'hourly_rate' => 'required|numeric|min:0',
            'expertise' => 'required|array|min:1',
            'expertise.*' => 'required|string',
            'availability' => 'required|array',
            'availability.*.day' => 'required|string',
            'availability.*.start_time' => 'required|date_format:H:i',
            'availability.*.end_time' => 'required|date_format:H:i|after:availability.*.start_time',
            'qualification_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        if ($request->hasFile('qualification_file')) {
            // Delete old file if exists
            if ($profile->qualification_file) {
                Storage::delete($profile->qualification_file);
            }
            
            $path = $request->file('qualification_file')->store('qualifications');
            $validated['qualification_file'] = $path;
        }

        $profile->update($validated);

        return redirect()->route('tutor.profile.show')
            ->with('success', 'Profile updated successfully.');
    }

    public function downloadQualification()
    {
        if (!auth()->check() || auth()->user()->role !== 'tutor') {
            abort(403, 'Unauthorized');
        }
        $profile = auth()->user()->tutorProfile;
        
        if (!$profile->qualification_file) {
            return back()->with('error', 'No qualification file found.');
        }

        return Storage::download($profile->qualification_file);
    }

    public function publish()
    {
        if (!auth()->check() || auth()->user()->role !== 'tutor') {
            abort(403, 'Unauthorized');
        }
        $profile = auth()->user()->tutorProfile;
        if (!$this->isProfileComplete($profile)) {
            return redirect()->route('tutor.profile.show')->with('error', 'Please complete your profile before publishing.');
        }
        $profile->is_available_for_sessions = true;
        $profile->save();
        return redirect()->route('tutor.profile.show')->with('success', 'Your profile is now public and open for sessions!');
    }

    private function isProfileComplete($profile)
    {
        return $profile->bio && $profile->hourly_rate && !empty($profile->expertise)
            && !empty($profile->availability) && $profile->qualification_file;
    }
} 