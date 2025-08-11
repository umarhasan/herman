<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Teacher;
use App\Models\TeacherClassSubject;
use App\Models\ClassSubject;
use App\Models\TimeTable;
use App\Models\Rating;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dob = $user->date_of_birth;

        return view('admin.dashboard', compact('user', 'dob'));
    }

    public function Countdown()
    {
        $user = Auth::user();
        $dob = $user->date_of_birth;

        return view('admin.Countdown.index', compact('user', 'dob'));
    }
    public function edit()
    {
        $user = Auth::user();
        // Ensure teacher record belongs to logged in user
        $teacher = $user->teacher;
        return view('teacher.profile', compact('teacher', 'user'));
    }

    public function update(Request $request)
    {

        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();

        // Profile Image Update
        if ($request->hasFile('profile_image')) {
            if (!empty($user->profile_image) && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        $user->date_of_birth = $request->date_of_birth;
        $user->save();

        // Update teacher table data
        $teacher->update([
            'video_url'      => $request->video_url,
            'hourly_rate'    => $request->hourly_rate,
            'bio'            => $request->bio,
            'topic'          => $request->topic,
            'available_days' => json_encode($request->available_days ?? []),
        ]);



        return redirect()->route('teacher.profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function rate(Request $request, $teacherId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $teacher = Teacher::findOrFail($teacherId);

        Rating::updateOrCreate(
            ['teacher_id' => $teacher->id, 'user_id' => auth()->id()],
            ['rating' => $request->rating]
        );

        return back()->with('success', 'Thanks for your rating!');
    }
}
