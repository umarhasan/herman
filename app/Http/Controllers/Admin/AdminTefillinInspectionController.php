<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TefillinInspection;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AdminTefillinInspectionController extends Controller
{
    public function index()
    {
        $inspections = TefillinInspection::with('user')->paginate(10);
        return view('admin.tefillin_inspections.index',compact('inspections'));
    }
    public function create()
    {
        $users = User::all();
        $sides = ['head', 'hand'];
        $parts = ['A', 'B', 'C', 'D']; // sirf head ke liye

        return view('admin.tefillin_inspections.create', compact('users', 'sides', 'parts'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'user_id'=>'required|exists:users,id',
            'side'=>'required|in:head,hand',
            'part_name'=>'nullable|in:A,B,C,D',
            'date_of_buy'=>'required|date',
            'image'=>'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tefillin','public');
        }

        TefillinInspection::create($data);

        return redirect()->route('admin.tefillin_inspections.index')
            ->with('success','Inspection added');
    }

    public function edit(TefillinInspection $tefillin_inspection)
    {
        $users = User::all();
        $sides = ['head', 'hand'];
        $parts = ['A', 'B', 'C', 'D'];

        return view('admin.tefillin_inspections.edit', [
            'inspection' => $tefillin_inspection,
            'users' => $users,
            'sides' => $sides,
            'parts' => $parts,
        ]);
    }

    public function update(Request $request, TefillinInspection $tefillin_inspection)
    {
        $data = $request->validate([
            'user_id'     => 'required|exists:users,id',
            'side'        => 'required|in:head,hand',
            'part_name'   => 'nullable|in:A,B,C,D',
            'date_of_buy' => 'required|date',
            'status'      => 'required|in:active,removed',  // <-- yahan add karo
            'image'       => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($tefillin_inspection->image) {
                Storage::disk('public')->delete($tefillin_inspection->image);
            }
            $data['image'] = $request->file('image')->store('tefillin','public');
        }

        $tefillin_inspection->update($data);

        return redirect()->route('admin.tefillin_inspections.index')
            ->with('success','Inspection updated');
    }

    public function destroy(TefillinInspection $tefillin_inspection)
    {

        if ($tefillin_inspection->side === 'head') {

            switch ($tefillin_inspection->part_name) {
                case 'A':
                    TefillinInspection::where('user_id',$tefillin_inspection->user_id)
                        ->where('side','head')
                        ->whereIn('part_name',['A','B','C','D'])
                        ->update(['status'=>'removed']);
                    break;
                case 'B':
                    TefillinInspection::where('user_id',$tefillin_inspection->user_id)
                        ->where('side','head')
                        ->whereIn('part_name',['B','C','D'])
                        ->update(['status'=>'removed']);
                    break;
                case 'C':
                    TefillinInspection::where('user_id',$tefillin_inspection->user_id)
                        ->where('side','head')
                        ->whereIn('part_name',['C','D'])
                        ->update(['status'=>'removed']);
                    break;
                case 'D':
                    $tefillin_inspection->update(['status'=>'removed']);
                    break;
            }
        } else {
            $tefillin_inspection->update(['status'=>'removed']);
        }

        return back()->with('success','Removed successfully');
    }
}
