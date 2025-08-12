<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    // Student: start booking (called from teacher list)
    public function start($teacherId, Request $request)
    {
        $user = $request->user();

        // prevent duplicate active booking
        $exists = Booking::where('teacher_id', $teacherId)
            ->where('student_id', $user->id)
            ->whereIn('status', ['awaiting_payment','payment_link_sent','payment_proof_uploaded','payment_approved','course_started'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'You already have an active booking with this teacher.');
        }

        Booking::create([
            'teacher_id' => $teacherId,
            'student_id' => $user->id,
            'topic' => $request->topic ?? null,
            'price' => $request->price ?? null,
            'status' => 'awaiting_payment'
        ]);

        return redirect()->route('student.bookings')->with('success', 'Booking created. Wait for teacher to send payment link.');
    }

    // Student: list bookings
    public function studentBookings(Request $request)
    {
        $bookings = Booking::with('teacher','recordings')
            ->where('student_id', $request->user()->id)
            ->latest()
            ->get();

        return view('student.bookings', compact('bookings'));
    }

    // Student: booking details and recordings
    public function show(Booking $booking)
    {
        // ensure student owns this booking
        if ($booking->student_id !== auth()->id()) abort(403);
        $booking->load('teacher','recordings');
        return view('student.booking_show', compact('booking'));
    }

    // Student: upload payment proof (image)
    public function uploadProof(Request $request, Booking $booking)
    {
        if ($booking->student_id !== $request->user()->id) abort(403);

        $request->validate(['proof' => 'required|image|max:5120']); // 5MB

        $path = $request->file('proof')->store('payment_proofs', 'public');

        $booking->update([
            'payment_proof' => $path,
            'status' => 'payment_proof_uploaded'
        ]);

        return back()->with('success','Payment proof uploaded.');
    }
}
