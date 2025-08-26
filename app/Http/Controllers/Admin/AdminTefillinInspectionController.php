<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inspection;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AdminTefillinInspectionController extends Controller
{
    // Index
    public function index()
    {
        $inspections = Inspection::with('user')->where('type','tefillin')->paginate(10);
        return view('admin.tefillin_inspections.index',compact('inspections'));
    }
    // Create
    public function create()
    {
        $users = User::all();
        $types = ['tefillin','mezuza'];
        $statuses = ['pass','fail','repair_needed'];
        return view('admin.tefillin_inspections.create', compact('users','types','statuses'));
    }

}
