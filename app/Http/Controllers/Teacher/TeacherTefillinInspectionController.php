<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TefillinInspection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeacherTefillinInspectionController extends Controller
{
    public function index()
    {
        $inspections = TefillinInspection::where('user_id', Auth::id())->latest()->paginate(10);

        return view('teacher.tefillin_inspections.index', compact('inspections'));
    }

    public function create()
    {
        $sides = ['head', 'hand'];
        $parts = ['A','B','C','D'];

        return view('teacher.tefillin_inspections.create', compact('sides','parts'));
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'side'=>'required|in:head,hand',
            'part_name'=>'nullable|in:A,B,C,D',
            'date_of_buy'=>'required|date',
            'image'=>'nullable|image|max:2048'
        ]);

        $data['user_id'] = Auth::id();
        $data['status'] = 'active';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tefillin','public');
        }

        TefillinInspection::create($data);

        return redirect()->route('teacher.tefillin_inspections.index')
            ->with('success','Inspection created');
    }

    public function edit(TefillinInspection $tefillin_inspection)
    {
        $this->authorizeOwnership($tefillin_inspection);

        $sides = ['head', 'hand'];
        $parts = ['A','B','C','D'];

        return view('teacher.tefillin_inspections.edit', [
            'inspection'=>$tefillin_inspection,
            'sides'=>$sides,
            'parts'=>$parts
        ]);
    }

    public function update(Request $request, TefillinInspection $tefillin_inspection)
    {
        $this->authorizeOwnership($tefillin_inspection);

        $data = $request->validate([
            'side'=>'required|in:head,hand',
            'part_name'=>'nullable|in:A,B,C,D',
            'date_of_buy'=>'required|date',
            'image'=>'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($tefillin_inspection->image) {
                Storage::disk('public')->delete($tefillin_inspection->image);
            }
            $data['image'] = $request->file('image')->store('tefillin','public');
        }

        $tefillin_inspection->update($data);

        return redirect()->route('teacher.tefillin_inspections.index')
            ->with('success','Inspection updated');
    }

    public function destroy(TefillinInspection $tefillin_inspection)
    {
        $this->authorizeOwnership($tefillin_inspection);

        if ($tefillin_inspection->image) {
            Storage::disk('public')->delete($tefillin_inspection->image);
        }
        $tefillin_inspection->delete();

        return redirect()->route('teacher.tefillin_inspections.index')
            ->with('success','Inspection deleted');
    }

    private function authorizeOwnership(TefillinInspection $inspection)
    {
        if ($inspection->user_id !== Auth::id()) {
            abort(403,'Unauthorized');
        }
    }
}
