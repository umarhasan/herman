<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
class HomeController extends Controller
{
    /**
     * Show the application home page.
     *
     * @return \Illuminate\View\View
     */
    public function Home()
    {
        return view('home');
    }

    public function About()
    {
        return view('about');
    }

    public function Contact()
    {
        return view('contact');
    }

    public function Blogs()
    {
        return view('blog');
    }

    public function Product()
    {
        return view('products');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('dashboard');
    }

    public function Teachers()
    {
        $teachers = Teacher::with('user','timetables')->where('status', 1)->get();
        return view('teachers', compact('teachers'));
    }
}
