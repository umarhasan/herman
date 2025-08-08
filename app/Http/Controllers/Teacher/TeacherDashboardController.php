<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Teacher;
class TeacherDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dob = $user->date_of_birth;

        return view('teacher.dashboard',compact('user', 'dob'));
    }

    public function Countdown()
    {
        $user = Auth::user();
        $dob = $user->date_of_birth;

        return view('teacher.Countdown.index',compact('user', 'dob'));
    }
    public function edit()
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        return view('teacher.profile', compact('teacher', 'user'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'video_url' => 'nullable|url',
            'hourly_rate' => 'nullable|numeric',
            'bio' => 'nullable|string',
            'available_days' => 'nullable|array', // ✅ validate as array
            'available_days.*' => 'in:Mon,Tue,Wed,Thu,Fri,Sat,Sun', // ✅ validate each item
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // ✅ Handle profile image
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
            $user->save();
        }

        // ✅ Store available_days as JSON (array)
        $user->teacher()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'video_url' => $request->video_url,
                'hourly_rate' => $request->hourly_rate,
                'bio' => $request->bio,
                'available_days' => $request->available_days, // ✅ store as array
            ]
        );

        return redirect()->route('teacher.profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function rate(Request $request, $teacherId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $teacher = Teacher::findOrFail($teacherId);

        // Prevent duplicate ratings by same user, or allow updates
        Rating::updateOrCreate(
            ['teacher_id' => $teacher->id, 'user_id' => auth()->id()],
            ['rating' => $request->rating]
        );

        return back()->with('success', 'Thanks for your rating!');
    }
}
