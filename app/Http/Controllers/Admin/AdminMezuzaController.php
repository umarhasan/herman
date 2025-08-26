<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inspection;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AdminMezuzaController extends Controller
{
    // Index
    public function index()
    {
        $mezuza = Inspection::with('user')->where('type','mezuza')->paginate(10);
        return view('admin.mezuza_inspections.index',compact('mezuza'));
    }

}
