<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TefillinRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class TefillinRecordController extends Controller
{
    public function index()
    {
        $records = TefillinRecord::with('user')->orderBy('type')->orderBy('parshe_number')->paginate(20);
        return view('admin.tefillin.index', compact('records'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('admin.tefillin.form', ['record'=>new TefillinRecord(),'users'=>$users]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type'=>['required', Rule::in(['head','arm'])],
            'parshe_number'=>'required|integer|between:1,4',
            'written_on'=>'nullable|date',
            'bought_on'=>'nullable|date',
            'bought_from'=>'nullable|string|max:255',
            'paid'=>'nullable|numeric',
            'inspected_by'=>'nullable|string|max:255',
            'inspected_on'=>'nullable|date',
            'user_id'=>'nullable|exists:users,id',
            'phone_number'=>'nullable|string|max:20',
        ]);

        // Arm always parshe 1
        if($data['type'] === 'arm') $data['parshe_number'] = 1;

        // Auto-generate reference_no
        if(empty($request->reference_no)) {
            $last = TefillinRecord::latest()->first();
            $number = $last ? $last->id + 1 : 1;
            $prefix = strtoupper(substr($data['type'],0,1));
            $data['reference_no'] = $prefix.'-'.date('Y').'-'.str_pad($number,4,'0',STR_PAD_LEFT);
        } else {
            $data['reference_no'] = $request->reference_no;
        }

        // Set next due date
        if(!empty($data['inspected_on'])) {
            $data['next_due_date'] = Carbon::parse($data['inspected_on'])->addMonths(42)->toDateString();
        }

        $record = TefillinRecord::create($data);

        // Reset higher parshi inspection
        if(!empty($data['inspected_on']) && !empty($data['user_id'])) {
            TefillinRecord::where('user_id',$data['user_id'])
                ->where('type',$data['type'])
                ->where('parshe_number','>',$data['parshe_number'])
                ->update(['inspected_on'=>null,'next_due_date'=>null]);
        }

        return redirect()->route('admin.tefillin-records.index')->with('success','Record saved.');
    }

    public function edit(TefillinRecord $tefillin_record)
    {
        $users = User::orderBy('name')->get();
        return view('admin.tefillin.form', ['record'=>$tefillin_record,'users'=>$users]);
    }

    public function update(Request $request, TefillinRecord $tefillin_record)
    {
        $data = $request->validate([
            'type'=>['required', Rule::in(['head','arm'])],
            'parshe_number'=>'required|integer|between:1,4',
            'written_on'=>'nullable|date',
            'bought_on'=>'nullable|date',
            'bought_from'=>'nullable|string|max:255',
            'paid'=>'nullable|numeric',
            'inspected_by'=>'nullable|string|max:255',
            'inspected_on'=>'nullable|date',
            'user_id'=>'nullable|exists:users,id',
            'phone_number'=>'nullable|string|max:20',
        ]);

        if($data['type'] === 'arm') $data['parshe_number'] = 1;

        // Auto-generate reference_no if empty
        if(empty($request->reference_no)) {
            $last = TefillinRecord::latest()->first();
            $number = $last ? $last->id + 1 : 1;
            $prefix = strtoupper(substr($data['type'],0,1));
            $data['reference_no'] = $prefix.'-'.date('Y').'-'.str_pad($number,4,'0',STR_PAD_LEFT);
        } else {
            $data['reference_no'] = $request->reference_no;
        }

        if(!empty($data['inspected_on'])) {
            $data['next_due_date'] = Carbon::parse($data['inspected_on'])->addMonths(42)->toDateString();
        } else {
            $data['next_due_date'] = null;
        }

        $tefillin_record->update($data);

        if(!empty($data['inspected_on']) && !empty($data['user_id'])) {
            TefillinRecord::where('user_id',$data['user_id'])
                ->where('type',$data['type'])
                ->where('parshe_number','>',$data['parshe_number'])
                ->update(['inspected_on'=>null,'next_due_date'=>null]);
        }

        return redirect()->route('admin.tefillin-records.index')->with('success','Record updated.');
    }
    public function show(TefillinRecord $tefillin_record)
{
    return view('admin.tefillin.show', compact('tefillin_record'));
}
    public function destroy(TefillinRecord $tefillin_record)
    {
        $tefillin_record->delete();
        return back()->with('success','Record deleted.');
    }
}
