<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
class ParentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dob = $user->date_of_birth;

        return view('parent.dashboard',compact('user', 'dob'));
    }

    public function Countdown()
    {
        $user = Auth::user();
        $dob = $user->date_of_birth;

        return view('parent.Countdown.index',compact('user', 'dob'));
    }
}
