<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTefillinInspectionRequest;
use App\Http\Requests\UpdateTefillinInspectionRequest;
use App\Models\TefillinInspection;
use Illuminate\Support\Facades\Auth;

class ParentTefillinInspectionController extends Controller
{
    public function index()
    {
        $inspections = TefillinInspection::where('user_id', Auth::id())
            ->orderBy('side')->orderBy('part_name')->paginate(20);

        return view('parent.tefillin_inspections.index', compact('inspections'));
    }

    public function create()
    {
        return view('parent.tefillin_inspections.create', [
            'parts' => ['A','B','C','D'],
            'sides' => ['left','right','head'],
        ]);
    }

    public function store(StoreTefillinInspectionRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        TefillinInspection::create($data);
        return to_route('parent.tefillin_inspections.index')->with('success','Submitted');
    }

    public function edit(TefillinInspection $tefillin_inspection)
    {
        abort_unless($tefillin_inspection->user_id === Auth::id(), 403);
        return view('parent.tefillin_inspections.edit', [
            'inspection' => $tefillin_inspection,
            'parts' => ['A','B','C','D'],
            'sides' => ['left','right','head'],
        ]);
    }

    public function update(UpdateTefillinInspectionRequest $request, TefillinInspection $tefillin_inspection)
    {
        abort_unless($tefillin_inspection->user_id === Auth::id(), 403);
        $tefillin_inspection->update($request->validated());
        return to_route('parent.tefillin_inspections.index')->with('success','Updated');
    }
}
