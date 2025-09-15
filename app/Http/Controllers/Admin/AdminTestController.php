<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class AdminTestController extends Controller
{
    public function index()
    {
        // get teacher ids where the student has bookings
        $teacherIds = Booking::pluck('teacher_id')->unique();
        $tests = Test::whereIn('teacher_id', $teacherIds)->with('questions.options')->get();
        return view('admin.tests.index', compact('tests'));
    }

    public function show(Test $test)
    {
        // ensure student belongs to teacher
        $teacherIds = Booking::pluck('teacher_id')->unique();
        abort_if(!$teacherIds->contains($test->teacher_id),403);
        $test->load('questions.options');
        return view('admin.tests.show', compact('test'));
    }

    public function download(Test $test)
    {
        $teacherIds = Booking::pluck('teacher_id')->unique();
        abort_if(!$teacherIds->contains($test->teacher_id),403);

        $test->load('questions.options');
        $pdf = Pdf::loadView('admin.tests.pdf', compact('test'));
        return $pdf->download(Str::slug($test->title ?: 'test').'.pdf');
    }
}
