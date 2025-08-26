<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminInspectionController extends Controller
{
    public function index()
    {
        $inspections = Inspection::with('user')->latest()->paginate(10);
        return view('admin.inspections.index', compact('inspections'));
    }

    public function create()
    {
        $users = User::all();
        $types = ['tefillin', 'mezuza'];
        $statuses = ['pass', 'fail', 'repair_needed'];
        return view('admin.inspections.create', compact('users','types','statuses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'reference_no'        => 'required|unique:inspections,reference_no',
            'user_id'             => 'nullable|exists:users,id',
            'type'                => 'required|in:tefillin,mezuza',
            'date_of_inspection'  => 'required|date',
            'inspector_name'      => 'required|string|max:255',
            'status'              => 'required|in:pass,fail,repair_needed',
            'notes'               => 'nullable|string',
            'attachment'          => 'nullable|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('inspections','public');
        }

        Inspection::create($data);

        // ✅ Type-wise redirect
        if ($request->type === 'tefillin') {
            return redirect()->route('admin.tefillin_inspections.index')
                ->with('success','Tefillin Inspection created successfully');
        } elseif ($request->type === 'mezuza') {
            return redirect()->route('admin.mezuza_inspections.index')
                ->with('success','Mezuza Inspection created successfully');
        }

        return redirect()->route('admin.inspections.index');
    }

    public function edit(Inspection $inspection)
    {
        $users = User::all();
        $types = ['tefillin', 'mezuza'];
        $statuses = ['pass', 'fail', 'repair_needed'];
        return view('admin.inspections.edit', compact('inspection','users','types','statuses'));
    }

    public function update(Request $request, Inspection $inspection)
    {
        $data = $request->validate([
            'reference_no'        => 'required|unique:inspections,reference_no,'.$inspection->id,
            'user_id'             => 'nullable|exists:users,id',
            'type'                => 'required|in:tefillin,mezuza',
            'date_of_inspection'  => 'required|date',
            'inspector_name'      => 'required|string|max:255',
            'status'              => 'required|in:pass,fail,repair_needed',
            'notes'               => 'nullable|string',
            'attachment'          => 'nullable|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        if ($request->hasFile('attachment')) {
            if ($inspection->attachment) {
                Storage::disk('public')->delete($inspection->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('inspections','public');
        }

        $inspection->update($data);

        // ✅ Type-wise redirect
        if ($request->type === 'tefillin') {
            return redirect()->route('admin.tefillin_inspections.index')
                ->with('success','Tefillin Inspection updated successfully');
        } elseif ($request->type === 'mezuza') {
            return redirect()->route('admin.mezuza_inspections.index')
                ->with('success','Mezuza Inspection updated successfully');
        }

        return redirect()->route('admin.inspections.index');
    }

    public function destroy(Inspection $inspection)
    {
        $type = $inspection->type;

        if ($inspection->attachment) {
            Storage::disk('public')->delete($inspection->attachment);
        }
        $inspection->delete();

        // ✅ Type-wise redirect after delete
        if ($type === 'tefillin') {
            return redirect()->route('admin.tefillin_inspections.index')
                ->with('success','Tefillin Inspection deleted successfully');
        } elseif ($type === 'mezuza') {
            return redirect()->route('admin.mezuza_inspections.index')
                ->with('success','Mezuza Inspection deleted successfully');
        }

        return back()->with('success','Inspection deleted successfully');
    }
}
