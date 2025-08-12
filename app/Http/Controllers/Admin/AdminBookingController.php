<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('student','teacher')->latest()->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function approve(Booking $booking)
    {
        $booking->update(['status' => 'payment_approved']);
        // TODO: notify teacher & student
        return back()->with('success','Booking approved.');
    }

    public function reject(Request $request, Booking $booking)
    {
        $booking->update(['status' => 'payment_proof_uploaded']);
        // TODO: notify student
        return back()->with('success','Booking rejected.');
    }
}
