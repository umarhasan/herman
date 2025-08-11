<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\Admin\AdminPermissionController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\AdminSubjectController;

use App\Http\Controllers\Admin\AdminTimeTableController;
use App\Http\Controllers\Teacher\TeacherTimeTableController as TeacherTimeTableController;
use App\Http\Controllers\Admin\AdminAttendenceController;
use App\Http\Controllers\Admin\AdminResourceController;
use App\Http\Controllers\Admin\AdminTestController;
use App\Http\Controllers\Admin\AdminTestQuestionController;
use App\Http\Controllers\Admin\TeacherClassSubjectController;
use App\Http\Controllers\Admin\AdminEventController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\HebrewCalendarController as AdminHebrewCalendarController;
use App\Http\Controllers\Admin\FileUploadController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Teacher\TeacherDashboardController;
use App\Http\Controllers\Teacher\HebrewCalendarController as TeacherHebrewCalendarController;

use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\HebrewCalendarController as StudentHebrewCalendarController;

use App\Http\Controllers\Parent\ParentDashboardController;
use App\Http\Controllers\Parent\HebrewCalendarController as ParentHebrewCalendarController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\HebrewCalendarController as UserHebrewCalendarController;
// Frontend Routes
Route::get('/', [HomeController::class, 'Home'])->name(name: 'home');
Route::get('/about', [HomeController::class, 'About'])->name('about');
Route::get('/contact', [HomeController::class, 'Contact'])->name('contact');
Route::get('/products', [HomeController::class, 'Product'])->name('products');
Route::get('/blogs', [HomeController::class, 'Blogs'])->name('blogs');
Route::get('/teachers', [HomeController::class, 'Teachers'])->name('teachers');
// Route::get('/', function () {
//     return view('home');
// });



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Admin
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    //Users Management Routes
    Route::resource('users', AdminUserController::class)->names('admin.users');
    Route::patch('/teachers/{teacher}/status', [AdminUserController::class, 'updateStatus'])->name('admin.teachers.status');
    // Teacher-Class-Subject Assignment Routes
    Route::get('assign-teacher/{id}', [TeacherClassSubjectController::class, 'create'])->name('admin.assignments.create');
    Route::post('assign-teacher-subjects', [TeacherClassSubjectController::class, 'store'])->name('admin.assignments.store');

    //Roles Management Routes
    Route::resource('roles', AdminRoleController::class)->names('admin.roles');
    Route::resource('permissions', AdminPermissionController::class)->names('admin.permissions');
    Route::resource('files', FileUploadController::class)->names('admin.files');
    Route::resource('categories', CategoryController::class)->names('admin.categories');

    Route::post('/file/category/update', [FileUploadController::class, 'FileCatUpdate'])->name('admin.file.category.update');
    Route::get('/file/category/delete/{id}', [FileUploadController::class, 'FileCatDelete'])->name('admin.file.category.upload.delete');

    //Classes Management Routes
    Route::resource('classes', SchoolClassController::class)->names('admin.classes');
    // Class-Subject assignment routes
    Route::get('/classes/{class}/assign-subjects', [App\Http\Controllers\Admin\SchoolClassController::class, 'assignSubjects'])->name('admin.classes.assignSubjects');
    Route::post('/classes/{class}/assign-subjects', [App\Http\Controllers\Admin\SchoolClassController::class, 'storeSubjects'])->name('admin.classes.storeSubjects');
    //Subjects Management Routes
    Route::resource('subjects', AdminSubjectController::class)->names('admin.subjects');
    //Timetable Management Routes
    Route::resource('timetables', AdminTimeTableController::class)->names('admin.timetables');
    Route::get('/get-classes-subjects-by-teacher/{teacherId}', [AdminTimeTableController::class, 'getClassesSubjects']);
    //Attendance Management Routes
    Route::get('attendance-logs', [AdminAttendenceController::class, 'index'])->name('admin.attendances.index');
    // Test Management Routes
    Route::resource('tests', AdminTestController::class)->names('admin.tests');
    Route::get('tests/{test}/questions/create', [AdminTestQuestionController::class, 'create'])->name('admin.tests.questions.create');
    Route::post('tests/{test}/questions', [AdminTestQuestionController::class, 'store'])->name('admin.tests.questions.store');
    Route::get('/edit-questions/{test}', [AdminTestQuestionController::class, 'edit'])->name('admin.test.questions.edit');
    Route::put('/{test}/questions', [AdminTestQuestionController::class, 'update'])->name('admin.test.questions.update');

    // Resource Management Routes
    Route::resource('resources', AdminResourceController::class)->names('admin.resources');
    Route::resource('events', AdminEventController::class)->names('admin.events');
    // PDF Download Route
    Route::get('hebcalendar', [AdminHebrewCalendarController::class, 'index'])->name('admin.hebcalendar.index');
    //Route::post('hebcalendar', [AdminHebrewCalendarController::class, 'index']);
    Route::get('/countdown', [AdminDashboardController::class, 'countdown'])->name('admin.countdown');
    Route::get('/calendar/pdf', [AdminHebrewCalendarController::class, 'downloadPdf'])->name('admin.hebcalendar.pdf');

    Route::get('/converter', [AdminHebrewCalendarController::class, 'converter'])->name('admin.converter.page');
    Route::post('/convert-g2h', [AdminHebrewCalendarController::class, 'gregorianToHebrew'])->name('admin.converter.g2h');
    Route::post('/convert-h2g', [AdminHebrewCalendarController::class, 'hebrewToGregorian'])->name('admin.converter.h2g');
    Route::get('converter/month-list', [AdminHebrewCalendarController::class, 'calendarListView'])->name('admin.converter.monthlist');
});

// Teacher
Route::middleware(['auth', 'role:Teacher'])->prefix('teacher')->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');
    Route::get('hebcalendar', [TeacherHebrewCalendarController::class, 'index'])->name('teacher.hebcalendar.index');
    // Teacher Profile Management
    Route::get('/profile', [TeacherDashboardController::class, 'edit'])->name('teacher.profile.edit');
    Route::post('/profile/update', [TeacherDashboardController::class, 'update'])->name('teacher.profile.update');
    //Route::post('hebcalendar', [TeacherHebrewCalendarController::class, 'index']);
    Route::get('/countdown', [TeacherDashboardController::class, 'countdown'])->name('teacher.countdown');
    Route::get('/calendar/pdf', [TeacherHebrewCalendarController::class, 'downloadPdf'])->name('teacher.hebcalendar.pdf');

    Route::get('/converter', [TeacherHebrewCalendarController::class, 'converter'])->name('teacher.converter.page');
    Route::post('/convert-g2h', [TeacherHebrewCalendarController::class, 'gregorianToHebrew'])->name('teacher.converter.g2h');
    Route::post('/convert-h2g', [TeacherHebrewCalendarController::class, 'hebrewToGregorian'])->name('teacher.converter.h2g');
    Route::get('converter/month-list', [TeacherHebrewCalendarController::class, 'calendarListView'])->name('teacher.converter.monthlist');

    Route::resource('timetables', TeacherTimeTableController::class)->names('teacher.timetables');
    Route::get('/teacher/get-subjects-by-class/{classId}', [TeacherTimeTableController::class, 'getSubjectsByClass'])->name('teacher.getSubjectsByClass');
    Route::delete('timetables/bulk-delete', [TeacherTimeTableController::class, 'destroy'])->name('teacher.timetables.bulkDelete');
});

// Student
Route::middleware(['auth', 'role:Student'])->prefix('student')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
	Route::get('hebcalendar', [StudentHebrewCalendarController::class, 'index'])->name('student.hebcalendar.index');
    //Route::post('hebcalendar', [StudentHebrewCalendarController::class, 'index']);
    Route::get('/countdown', [StudentDashboardController::class, 'countdown'])->name('student.countdown');
    Route::get('/calendar/pdf', [StudentHebrewCalendarController::class, 'downloadPdf'])->name('student.hebcalendar.pdf');

    Route::get('/converter', [StudentHebrewCalendarController::class, 'converter'])->name('student.converter.page');
    Route::post('/convert-g2h', [StudentHebrewCalendarController::class, 'gregorianToHebrew'])->name('student.converter.g2h');
    Route::post('/convert-h2g', [StudentHebrewCalendarController::class, 'hebrewToGregorian'])->name('student.converter.h2g');
    Route::get('converter/month-list', [StudentHebrewCalendarController::class, 'calendarListView'])->name('student.converter.monthlist');
});

// Parent
Route::middleware(['auth', 'role:Parent'])->prefix('parent')->group(function () {
    Route::get('/dashboard', [ParentDashboardController::class, 'index'])->name('parent.dashboard');
	Route::get('hebcalendar', [ParentHebrewCalendarController::class, 'index'])->name('parent.hebcalendar.index');
    //Route::post('hebcalendar', [ParentHebrewCalendarController::class, 'index']);
    Route::get('/countdown', [ParentDashboardController::class, 'countdown'])->name('parent.countdown');
    Route::get('/calendar/pdf', [ParentHebrewCalendarController::class, 'downloadPdf'])->name('parent.hebcalendar.pdf');

    Route::get('/converter', [ParentHebrewCalendarController::class, 'converter'])->name('parent.converter.page');
    Route::post('/convert-g2h', [ParentHebrewCalendarController::class, 'gregorianToHebrew'])->name('parent.converter.g2h');
    Route::post('/convert-h2g', [ParentHebrewCalendarController::class, 'hebrewToGregorian'])->name('parent.converter.h2g');
    Route::get('converter/month-list', [ParentHebrewCalendarController::class, 'calendarListView'])->name('parent.converter.monthlist');
});

// User
Route::middleware(['auth', 'role:User'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
	Route::get('hebcalendar', [UserHebrewCalendarController::class, 'index'])->name('user.hebcalendar.index');
    //Route::post('hebcalendar', [UserHebrewCalendarController::class, 'index']);
    Route::get('/countdown', [UserDashboardController::class, 'countdown'])->name('user.countdown');
    Route::get('/calendar/pdf', [UserHebrewCalendarController::class, 'downloadPdf'])->name('user.hebcalendar.pdf');

    Route::get('/converter', [UserHebrewCalendarController::class, 'converter'])->name('user.converter.page');
    Route::post('/convert-g2h', [UserHebrewCalendarController::class, 'gregorianToHebrew'])->name('user.converter.g2h');
    Route::post('/convert-h2g', [UserHebrewCalendarController::class, 'hebrewToGregorian'])->name('user.converter.h2g');
    Route::get('converter/month-list', [UserHebrewCalendarController::class, 'calendarListView'])->name('user.converter.monthlist');
});

require __DIR__ . '/auth.php';
