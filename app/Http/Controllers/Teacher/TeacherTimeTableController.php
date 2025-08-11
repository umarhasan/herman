<?php

namespace App\Http\Controllers\Teacher;

use App\Models\TimeTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TeacherClassSubject;
use App\Models\ClassSubject;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TeacherTimeTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacherId = Auth::id();
        $timetables = TimeTable::with(['schoolClass', 'subject', 'teacher'])
            ->where('teacher_id', $teacherId)
            ->get();

        return view('teacher.timetables.index', compact('timetables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $teacherId = Auth::id();

    $teacherClassSubjects = TeacherClassSubject::where('teacher_id', $teacherId)->get();
    $classSubjects = [];

    foreach ($teacherClassSubjects as $tcs) {
        $classSubject = ClassSubject::with('schoolClass', 'subject')->find($tcs->class_subject_id);
        if ($classSubject) {
            $classSubjects[$classSubject->schoolClass->id]['class_name'] = $classSubject->schoolClass->name;
            $classSubjects[$classSubject->schoolClass->id]['subjects'][] = [
                'id' => $classSubject->subject->id,
                'name' => $classSubject->subject->name,
            ];
        }
    }

    return view('teacher.timetables.create', [
        'user' => Auth::user(),
        'classSubjects' => $classSubjects
    ]);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'start_time' => 'required|array',
            'end_time' => 'required|array',
        ]);

        $teacherId = Auth::id(); // Logged in teacher

        foreach ($request->start_time as $day => $startTimes) {
            if (!is_array($startTimes)) {
                continue; // Skip if no array of times
            }

            foreach ($startTimes as $index => $startTime) {
                $endTime = $request->end_time[$day][$index] ?? null;

                // Only save if both times exist
                if ($startTime && $endTime) {
                    TimeTable::create([
                        'school_class_id' => $request->school_class_id,
                        'subject_id' => $request->subject_id,
                        'teacher_id' => $teacherId,
                        'day' => $day,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                    ]);
                }
            }
        }

        return redirect()
            ->route('teacher.timetables.index')
            ->with('success', 'Timetable created successfully.');
    }

    public function edit(string $id)
    {
        $timetable = TimeTable::findOrFail($id);

        // Logged-in user
        $authUser = Auth::user();

        // Sirf logged-in teacher ki classes & subjects
        $classSubjects = [];
        $teacherClassSubjects = TeacherClassSubject::where('teacher_id', $authUser->id)->get();

        foreach ($teacherClassSubjects as $tcs) {
            $classSubject = ClassSubject::with('schoolClass', 'subject')->find($tcs->class_subject_id);
            if ($classSubject) {
                $classSubjects[$classSubject->schoolClass->id]['class_name'] = $classSubject->schoolClass->name;
                $classSubjects[$classSubject->schoolClass->id]['subjects'][] = [
                    'id' => $classSubject->subject->id,
                    'name' => $classSubject->subject->name,
                ];
            }
        }

        return view('teacher.timetables.edit', [
            'timetable' => $timetable,
            'user' => $authUser,
            'classSubjects' => $classSubjects
        ]);
    }

    public function update(Request $request, string $id)
    {



        $timetable = TimeTable::findOrFail($id);

        $timetable->update([
            'school_class_id' => $request->school_class_id,
            'subject_id'      => $request->subject_id,
            'teacher_id'      => $request->teacher_id,
            'day'             => $request->day,
            'start_time'      => $request->start_time,
            'end_time'        => $request->end_time,
        ]);

        return redirect()->route('teacher.timetables.index')->with('success', 'Timetable updated successfully.');
    }

    public function destroy(Request $request)
    {
        $ids = $request->ids;

        if (!$ids || count($ids) === 0) {
            return redirect()->back()->with('error', 'No timetable selected.');
        }

        TimeTable::whereIn('id', $ids)->delete();

        return redirect()->route('teacher.timetables.index')->with('success', 'Selected timetables deleted successfully.');
    }



    public function getClassesSubjects()
    {
        $teacherId = Auth::id();
        $teacherClassSubjects = TeacherClassSubject::where('teacher_id', $teacherId)->get();
        $classSubjects = [];

        foreach ($teacherClassSubjects as $tcs) {
            $classSubject = ClassSubject::with('schoolClass', 'subject')->find($tcs->class_subject_id);
            if ($classSubject) {
                $classSubjects[$classSubject->schoolClass->id]['class_name'] = $classSubject->schoolClass->name;
                $classSubjects[$classSubject->schoolClass->id]['subjects'][] = [
                    'id' => $classSubject->subject->id,
                    'name' => $classSubject->subject->name,
                ];
            }
        }

        return response()->json($classSubjects);
    }
}
