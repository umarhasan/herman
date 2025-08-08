<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $roles = ['Admin', 'Teacher', 'Student', 'Parent'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Create permissions
        $permissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        // Assign all permissions to Admin role
        $adminRole = Role::where('name', 'Admin')->first();
        $adminRole->syncPermissions(Permission::all());

        // Create admin user
        $admin = User::firstOrCreate([
            'email' => 'admin@gmail.com',
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('12345678'),
        ]);

        // Assign role
        $admin->assignRole($adminRole);

        // // Teacher
        // $teacher = User::firstOrCreate(
        //     ['email' => 'teacher@gmail.com'],
        //     ['name' => 'Teacher User', 'password' => Hash::make('12345678')]
        // );
        // $teacher->assignRole('Teacher');

        // // Student
        // $student = User::firstOrCreate(
        //     ['email' => 'student@gmail.com'],
        //     ['name' => 'Student User', 'password' => Hash::make('12345678')]
        // );
        // $student->assignRole('Student');

        // // Parent
        // $parent = User::firstOrCreate(
        //     ['email' => 'parent@gmail.com'],
        //     ['name' => 'Parent User', 'password' => Hash::make('12345678')]
        // );
        // $parent->assignRole('Parent');
    }
}
