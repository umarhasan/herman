<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class AdminResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resources = Resource::with('schoolClass', 'subject')->latest()->get();
        return view('admin.resources.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = SchoolClass::all();
        $subjects = Subject::all();
        return view('admin.resources.create', compact('classes', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'school_class_id' => 'required',
            'subject_id' => 'required',
            'file' => 'required'
        ]);

        $path = $request->file('file')->store('resources', 'public');

        Resource::create([
            'title' => $request->title,
            'school_class_id' => $request->school_class_id,
            'subject_id' => $request->subject_id,
            'file_path' => $path,
        ]);

        return redirect()->route('admin.resources.index')->with('success', 'Resource uploaded.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource)
    {
        \Storage::disk('public')->delete($resource->file_path);
        $resource->delete();
        return back()->with('success', 'Deleted.');
    }
}
