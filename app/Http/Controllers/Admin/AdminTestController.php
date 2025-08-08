<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Test;
use Illuminate\Http\Request;

class AdminTestController extends Controller
{
    public function index()
    {
        $tests = Test::with('class', 'subject')->latest()->get();
        return view('admin.tests.index', compact('tests'));
    }

    public function create()
    {
        $classes = SchoolClass::all();
        $subjects = Subject::all();
        return view('admin.tests.create', compact('classes', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
        ]);

        $test = Test::create($request->all());

        return redirect()->route('admin.tests.questions.create', $test->id)
            ->with('success', 'Test created. Now add questions.');
    }

    public function edit(Test $test)
    {
        $classes = SchoolClass::all();
        $subjects = Subject::all();
        return view('admin.tests.edit', compact('test', 'classes', 'subjects'));
    }

    public function update(Request $request, Test $test)
    {
        $request->validate([
            'title' => 'required|string',
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
        ]);

        $test->update($request->all());

        return redirect()->route('admin.tests.index')->with('success', 'Test updated successfully.');
    }

    public function destroy(Test $test)
    {
        $test->questions()->delete(); // delete related questions too
        $test->delete();
        return back()->with('success', 'Test and related questions deleted.');
    }
}
