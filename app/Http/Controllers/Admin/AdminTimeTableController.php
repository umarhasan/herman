<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Subject;
use App\Models\TimeTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ClassSubject;
use App\Models\SchoolClass;
use App\Models\TeacherClassSubject;

class AdminTimeTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $timetables = TimeTable::with(['schoolClass', 'subject', 'teacher'])->get();
        // return $timetables->schoolClass->name;
        return view('admin.timetables.index', compact('timetables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = User::role('teacher')->get(); // sirf teachers bhejna hai
        return view('admin.timetables.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'day' => 'required|string|max:10',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        TimeTable::create($request->all());

        return redirect()->route('admin.timetables.index')->with('success', 'Timetable created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $timetable = TimeTable::findOrFail($id);
        $teachers = User::role('teacher')->get();

        return view('admin.timetables.edit', compact('timetable', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'day' => 'required|string|max:10',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $timetable = TimeTable::findOrFail($id);

        $timetable->update([
            'school_class_id' => $request->school_class_id,
            'subject_id'      => $request->subject_id,
            'teacher_id'      => $request->teacher_id,
            'day'             => $request->day,
            'start_time'      => $request->start_time,
            'end_time'        => $request->end_time,
        ]);

        return redirect()->route('admin.timetables.index')->with('success', 'Timetable updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $timetable = TimeTable::findOrFail($id);
        $timetable->delete();

        return redirect()->route('admin.timetables.index')->with('success', 'Timetable deleted successfully.');
    }


    public function getClassesSubjects($teacherId)
    {
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
