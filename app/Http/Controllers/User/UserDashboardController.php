<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dob = $user->date_of_birth;

        return view('user.dashboard',compact('user', 'dob'));
    }

    public function Countdown()
    {
        $user = Auth::user();
        $dob = $user->date_of_birth;

        return view('user.Countdown.index',compact('user', 'dob'));
    }
}
