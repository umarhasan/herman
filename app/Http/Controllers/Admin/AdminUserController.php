<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentStudent;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->whereHas('roles', function ($q) {
            $q->whereIn('name', ['user','teacher', 'student', 'parent']);
        })->get();

        return view('admin.users.index', compact('users'));
    }
    public function create()
    {
        $roles = Role::whereIn('name', ['user','teacher', 'student', 'parent'])->get();
        $classes = SchoolClass::all();
        $students = User::role('student')->get(); // for parent-child assignment
        // $subjects = Subject::all();
        return view('admin.users.create', compact('roles', 'classes', 'students'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'date_of_birth' => 'nullable|date',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'class_id' => $request->class_id,
            'date_of_birth' => $request->date_of_birth,
            // 'main_subject_id' => $request->subject_ids, // Assuming this is for teachers
            'password' => Hash::make($request->password),
        ]);

        $RoleName = Role::find($request->role)?->name;
        $user->assignRole($RoleName);

        if ($RoleName == 'Parent' && $request->student_ids) {
            $user->children()->sync($request->student_ids);
        }

        if (strtolower($RoleName) === 'teacher') {
            Teacher::create([
                'user_id' => $user->id,
                'status' => 0 // Default inactive
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User created.');
    }
    public function show(string $id)
    {
        //Show user details
    }
    public function edit(string $id)
    {

        $user = User::findOrFail($id);
        $roles = Role::whereIn('name', ['user','teacher', 'student', 'parent'])->get();
        $classes = SchoolClass::all();
        $students = User::role('student')->get();
        $assignedChildren = $user->children->pluck('id')->toArray();

        $currentRole = $user->getRoleNames()->first(); // e.g. 'teacher'

        return view('admin.users.edit', compact('user', 'roles', 'classes', 'students', 'currentRole', 'assignedChildren'));
    }
    public function update(Request $request, User $user)
    {

        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'date_of_birth' => 'nullable|date',
            'roles'    => 'required|exists:roles,id',
            'class_id' => 'nullable|exists:school_classes,id',
            'password' => 'nullable|confirmed|min:6',
        ]);

        $roleName = Role::find($request->roles)?->name;

        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'class_id' => $request->class_id,
            'date_of_birth' => $request->date_of_birth,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
        ]);
        $user->syncRoles($roleName);
        if ($roleName === 'Parent') {
            $user->children()->sync($request->student_ids ?? []);
        }

        if (strtolower($roleName) === 'teacher') {
            if (!$user->teacher) {
                Teacher::create([
                    'user_id' => $user->id,
                    'status' => 0
                ]);
            }
        } else {
            $user->teacher()?->delete();
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }
    public function destroy(string $id)
    {
        $users = User::findOrFail($id);
        if ($users->id == auth()->user()->id) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }
        $users->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function updateStatus(Request $request, Teacher $teacher)
    {
        $request->validate([
            'status' => 'required|boolean',
        ]);

        $teacher->status = $request->status;
        $teacher->save();

        return back()->with('success', 'Teacher status updated successfully.');
    }
}
