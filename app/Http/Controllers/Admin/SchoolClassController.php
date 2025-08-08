<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = SchoolClass::all();
        return view('admin.classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.classes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:school_classes,name']);
        SchoolClass::create($request->only('name', 'description'));
        return redirect()->route('admin.classes.index')->with('success', 'Class created.');
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
    public function edit(SchoolClass $class)
    {
        return view('admin.classes.edit', compact('class'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolClass $class)
    {
        $request->validate(['name' => 'required|unique:school_classes,name,' . $class->id]);
        $class->update($request->only('name', 'description'));
        return redirect()->route('admin.classes.index')->with('success', 'Class updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolClass $class)
    {
        $class->delete();
        return redirect()->route('admin.classes.index')->with('success', 'Class deleted.');
    }


    public function assignSubjects(SchoolClass $class)
    {
        $subjects = Subject::all();
        $assignedSubjects = $class->subjects->pluck('id')->toArray();

        return view('admin.classes.assign-subjects', compact('class', 'subjects', 'assignedSubjects'));
    }

    // Save assigned subjects
    public function storeSubjects(Request $request, SchoolClass $class)
    {
        $class->subjects()->sync($request->subject_ids ?? []);
        return redirect()->route('admin.classes.index')->with('success', 'Subjects assigned to class successfully.');
    }
}
