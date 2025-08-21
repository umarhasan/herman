<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $role = $request->role;

        if ($role === 'student') {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'date_of_birth' => 'required|date',
                'password' => 'required|confirmed|min:6',
                'parent_email' => 'required|email|unique:users,email',
                'parent_phone' => 'required',
            ]);

            // Parent create
            $parent = User::create([
                'name' => $request->name . ' Parent',
                'email' => $request->parent_email,
                'password' => Hash::make($request->password),
            ]);
            $parent->assignRole('parent');

            // Student create
            $student = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'date_of_birth' => $request->date_of_birth,
                'password' => Hash::make($request->password),
            ]);
            $student->assignRole('student');

            // ✅ Pivot relation create
            $parent->children()->attach($student->id);
        }

        elseif ($role === 'teacher') {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'experience' => 'required',
                'description' => 'required',
                'password' => 'required|confirmed|min:6',
            ]);

            $teacher = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'date_of_birth' => $request->date_of_birth,
                'experience' => $request->experience,
                'description' => $request->description,
                'password' => Hash::make($request->password),
            ]);
            $teacher->assignRole('teacher');
        }

        else { // Normal user
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'date_of_birth' => 'required|date',
                'password' => 'required|confirmed|min:6',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'date_of_birth' => $request->date_of_birth,
                'password' => Hash::make($request->password),
            ]);
            $user->assignRole('user');
        }

        return redirect()->route('login')->with('success', 'Registration successful!');
    }
}
