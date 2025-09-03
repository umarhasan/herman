<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class RecordBookController extends Controller
{
    public function recordBook(){
        $users = User::orderBy('name')->get();
        return view('admin.recordbook.index', compact('users'));
    }

    public function show(User $user){
        // ab sirf tefillin aur mezuza
        $tefillin = $user->tefillinRecords()
                         ->orderBy('parshe_number')
                         ->get();

        $mezuza = $user->mezuzaRecords()
                       ->orderBy('location')
                       ->get();
        // **Batim ko Tefillin me merge karne ke liye fetch karo**
        $batim = $user->batimRecords()
                  ->orderBy('inspected_on','desc')
                  ->get()
                  ->unique('type');

        return view('admin.recordbook.show', compact('user','tefillin','mezuza','batim'));
    }

    public function pdf(User $user){
        $tefillin = $user->tefillinRecords()
                         ->orderBy('parshe_number')
                         ->get();

        $mezuza = $user->mezuzaRecords()
                       ->orderBy('location')
                       ->get();
        $batim = $user->batimRecords()
        ->orderBy('inspected_on','desc')
        ->get()
        ->unique('type');
        $pdf = Pdf::loadView('admin.recordbook.pdf', compact('user','tefillin','mezuza','batim'))
                  ->setPaper('a4','portrait');

        return $pdf->download('record-book-'.$user->id.'.pdf');
    }
}

