<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;
use App\Models\TeacherClassSubject;
use App\Models\ClassSubject;
use App\Models\Timetable;
use App\Models\Rating;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dob = $user->date_of_birth;

        return view('teacher.dashboard', compact('user', 'dob'));
    }

    public function Countdown()
    {
        $user = Auth::user();
        $dob = $user->date_of_birth;

        return view('teacher.Countdown.index', compact('user', 'dob'));
    }

    public function edit()
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        // Teacher ke classes & subjects fetch
        $classes = TeacherClassSubject::where('teacher_id', $teacher->id)
            ->with(['classSubject.schoolClass', 'classSubject.subject'])
            ->get()
            ->groupBy(function ($item) {
                return $item->classSubject->schoolClass->id; // Group by class ID
            });

        // Timetable fetch (day wise group)
        $timetable = Timetable::where('teacher_id', $teacher->id)
            ->with(['subject', 'subject.schoolClass'])
            ->orderBy('day')
            ->orderBy('start_time')
            ->get()
            ->groupBy('day'); // Array wise grouping

        return view('teacher.profile', compact('teacher', 'user', 'classes', 'timetable'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'video_url' => 'nullable|url',
            'hourly_rate' => 'nullable|numeric',
            'bio' => 'nullable|string',
            'available_days' => 'nullable|array',
            'available_days.*' => 'in:Mon,Tue,Wed,Thu,Fri,Sat,Sun',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // timetable fields
            'timetable' => 'nullable|array',
            'timetable.*.subject_id' => 'required_with:timetable.*.day',
            'timetable.*.day' => 'nullable|string|in:Mon,Tue,Wed,Thu,Fri,Sat,Sun',
            'timetable.*.start_time' => 'nullable|date_format:H:i',
            'timetable.*.end_time' => 'nullable|date_format:H:i|after:timetable.*.start_time',
        ]);

        $user = Auth::user();

        // Profile image update
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        // Update phone and DOB
        $user->phone = $request->phone;
        $user->date_of_birth = $request->date_of_birth;
        $user->save();

        // Teacher table update/create
        $user->teacher()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'video_url' => $request->video_url,
                'hourly_rate' => $request->hourly_rate,
                'bio' => $request->bio,
                'available_days' => $request->available_days,
            ]
        );

        // Timetable save/update (auth teacher_id)
        if ($request->timetable) {
            $teacherId = $user->teacher->id;

            foreach ($request->timetable as $entry) {
                if (!empty($entry['day']) && !empty($entry['subject_id'])) {
                    Timetable::updateOrCreate(
                        [
                            'teacher_id' => $teacherId,
                            'subject_id' => $entry['subject_id'],
                            'day' => $entry['day'],
                        ],
                        [
                            'start_time' => $entry['start_time'],
                            'end_time' => $entry['end_time'],
                        ]
                    );
                }
            }
        }

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
