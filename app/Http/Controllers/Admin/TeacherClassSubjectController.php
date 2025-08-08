<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\ClassSubject;
use Illuminate\Http\Request;
use App\Models\TeacherClassSubject;
use App\Http\Controllers\Controller;

class TeacherClassSubjectController extends Controller
{
    public function create($id)
    {
        // Step 1: Get the teacher
        $teachers = User::role('teacher')->where('id', $id)->first();

        // Step 2: Get the class of the teacher (assuming a class_id relation exists)
        $classId = $teachers->class_id;

        // Step 3: Get subjects for the teacher's class only
        $classSubjects = ClassSubject::with(['subject', 'schoolClass'])
        ->where('school_class_id', $classId)
        ->get()
        ->groupBy(function ($item) {
            return $item->schoolClass?->name ?? 'Unassigned';
        });

        // Step 4: Get already assigned class_subjects to this teacher
        $assignedIds = TeacherClassSubject::where('teacher_id', $id)
        ->pluck('class_subject_id')
        ->toArray();

        return view('admin.assignments.create', compact('teachers', 'classSubjects', 'assignedIds'));
    }

    public function store(Request $request)
    {
        // Class Subject Store
        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'class_subject_ids' => 'required|array', // ✅ correct field name
        ]);

        // Delete old assignments
        TeacherClassSubject::where('teacher_id', $request->teacher_id)->delete();

        // Insert new assignments
        foreach ($request->class_subject_ids as $classSubjectId) { // ✅ correct field name
            TeacherClassSubject::create([
                'teacher_id' => $request->teacher_id,
                'class_subject_id' => $classSubjectId,
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Subjects & classes assigned to teacher.');
    }
}
