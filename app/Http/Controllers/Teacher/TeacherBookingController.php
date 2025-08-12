<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Recording;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeacherBookingController extends Controller
{
    // list pending bookings for teacher
    public function index(Request $request)
    {

        $teacherId = $request->user()->id;
        $bookings = Booking::with('student','recordings')
            ->where('teacher_id', $teacherId)
            ->latest()
            ->get();

        return view('teacher.bookings.index', compact('bookings'));
    }

    // send payment link to student (teacher action)
    public function sendPaymentLink(Request $request, Booking $booking)
    {
        if ($booking->teacher_id !== $request->user()->id) abort(403);

        $request->validate(['payment_link' => 'required|url']);
        $booking->update([
            'payment_link' => $request->payment_link,
            'status' => 'payment_link_sent'
        ]);

        // TODO: send notification/email to student

        return back()->with('success','Payment link saved and student notified.');
    }

    // show form to create meeting (store zoom join url)
    public function createMeetingForm(Booking $booking)
    {
        if ($booking->teacher_id !== auth()->id()) abort(403);
        return view('teacher.bookings.create_meeting', compact('booking'));
    }

    // store meeting info (teacher provides zoom join url manually)
    public function storeMeeting(Request $request, Booking $booking)
    {
        if ($booking->teacher_id !== $request->user()->id) abort(403);

        $request->validate([
            'join_url' => 'required|url',
            'zoom_meeting_id' => 'nullable|string'
        ]);

        $booking->update([
            'zoom_join_url' => $request->join_url,
            'zoom_meeting_id' => $request->zoom_meeting_id ?? null,
            'status' => 'course_started'
        ]);

        // TODO: notify student

        return redirect()->route('teacher.bookings.index')->with('success','Meeting created and join link saved.');
    }

    // teacher uploads the recorded video for the booking (manual)
    public function uploadRecording(Request $request, Booking $booking)
    {

        if ($booking->teacher_id !== $request->user()->id) abort(403);

        $request->validate([
            'recording' => 'required|mimetypes:video/mp4,video/quicktime,video/x-msvideo|max:512000', // up to ~500MB, adjust as needed
            'title' => 'nullable|string|max:255'
        ]);

        $path = $request->file('recording')->store('recordings', 'public');

        $rec = Recording::create([
            'booking_id' => $booking->id,
            'title' => $request->title ?? ('Recording ' . now()->format('Y-m-d H:i')),
            'file_url' => $path,
            'file_type' => 'local',
        ]);

        $booking->update(['status' => 'recording_uploaded']);

        // TODO: notify student

        return back()->with('success','Recording uploaded and available to students.');
    }

    // Optional: remove recording
    public function removeRecording(Request $request, Recording $recording)
    {
        $booking = $recording->booking;

        if ($booking->teacher_id !== $request->user()->id) abort(403);

        if (Storage::disk('public')->exists($recording->file_url)) {
            Storage::disk('public')->delete($recording->file_url);
        }
        $recording->delete();

        return back()->with('success','Recording removed.');
    }
}
