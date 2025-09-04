<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\MezuzaRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MezuzaRecordController extends Controller
{
    public function index(){ $records = MezuzaRecord::with('user')->latest()->paginate(30); return view('admin.mezuza.index', compact('records')); }
    public function create(){ $users = User::orderBy('name')->get(); return view('admin.mezuza.form',['record'=>new MezuzaRecord(),'users'=>$users]); }

    public function store(Request $request){
        $data = $request->validate([
            'location'=>'required|max:255',
            'door_description'=>'nullable|max:255', // which door
            'bought_from'=>'nullable|max:255',
            'bought_from_phone'=>'nullable|regex:/^\+?[0-9]{7,15}$/', // phone validation
            'paid'=>'nullable|numeric',
            'written_on'=>'nullable|date',
            'inspected_by'=>'nullable|max:255',
            'inspected_on'=>'nullable|date',
            'reminder_email_on'=>'nullable|date',
            'condition'=>'nullable|string|max:255',
            'notes'=>'nullable|string',
            'user_id'=>'nullable|exists:users,id',
        ]);

        $lastId = MezuzaRecord::max('id') + 1;
        $data['reference_no'] = 'MEZ-'.date('Y').'-'.str_pad($lastId,5,'0',STR_PAD_LEFT);


        if (!empty($data['inspected_on'])) {
            $data['next_due_date'] = Carbon::parse($data['inspected_on'])->addMonths(42)->toDateString();
        }

        MezuzaRecord::create($data);
        return redirect()->route('admin.mezuza-records.index')->with('success','Created.');
    }

    public function show(MezuzaRecord $mezuza_record){ return view('admin.mezuza.show', ['record'=>$mezuza_record->load('user')]); }
    public function edit(MezuzaRecord $mezuza_record){ $users = User::orderBy('name')->get(); return view('admin.mezuza.form',['record'=>$mezuza_record,'users'=>$users]); }

    public function update(Request $request, MezuzaRecord $mezuza_record){
        $data = $request->validate([
            'location'=>'required|max:255',
            'written_on'=>'nullable|date',
            'door_description'=>'nullable|max:255',
            'bought_from_phone'=>'nullable|regex:/^\+?[0-9]{7,15}$/',
            'bought_from'=>'nullable|max:255',
            'paid'=>'nullable|numeric',
            'inspected_by'=>'nullable|max:255',
            'inspected_on'=>'nullable|date',
            'reminder_email_on'=>'nullable|date',
            'condition'=>'nullable|string|max:255',
            'notes'=>'nullable|string',
            'user_id'=>'nullable|exists:users,id',
        ]);

        $lastId = MezuzaRecord::max('id') + 1;
        $data['reference_no'] = 'MEZ-'.date('Y').'-'.str_pad($lastId,5,'0',STR_PAD_LEFT);

        if (!empty($data['inspected_on'])) $data['next_due_date'] = Carbon::parse($data['inspected_on'])->addMonths(42)->toDateString();
        else $data['next_due_date'] = null;

        $mezuza_record->update($data);
        return redirect()->route('admin.mezuza-records.index')->with('success','Updated.');
    }

    public function destroy(MezuzaRecord $mezuza_record){ $mezuza_record->delete(); return back()->with('success','Deleted.'); }
}
