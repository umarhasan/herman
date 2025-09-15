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
use App\Http\Controllers\Admin\AdminInspectionController;
use App\Http\Controllers\Teacher\TeacherDashboardController;
use App\Http\Controllers\Teacher\HebrewCalendarController as TeacherHebrewCalendarController;

use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\HebrewCalendarController as StudentHebrewCalendarController;

use App\Http\Controllers\Parent\ParentDashboardController;
use App\Http\Controllers\Parent\HebrewCalendarController as ParentHebrewCalendarController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\HebrewCalendarController as UserHebrewCalendarController;

use App\Http\Controllers\BookingController;
use App\Http\Controllers\Teacher\TeacherBookingController;
use App\Http\Controllers\Admin\AdminBookingController;
// Tefillin Inspection Controllers
use App\Http\Controllers\Admin\AdminTefillinInspectionController as AdminTefillin;
use App\Http\Controllers\Admin\AdminMezuzaController as AdminMezuza;

use App\Http\Controllers\Student\StudentTefillinInspectionController as StudentCtrl;
use App\Http\Controllers\Teacher\TeacherTefillinInspectionController as TeacherCtrl;
use App\Http\Controllers\Parent\ParentTefillinInspectionController as ParentCtrl;
use App\Http\Controllers\User\UserTefillinInspectionController as UserCtrl;

use App\Http\Controllers\Admin\TefillinRecordController;
use App\Http\Controllers\Admin\MezuzaRecordController;
use App\Http\Controllers\Admin\RecordBookController;

use App\Http\Controllers\Teacher\TestController as TeacherTestController;
use App\Http\Controllers\Student\TestController as StudentTestController;

use App\Http\Controllers\ChatController;
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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/chat/unread/{id}', [ChatController::class, 'unreadCount']);            // GET unread count
    Route::post('/chat/mark-as-read/{id}', [ChatController::class, 'markAsRead']);     // POST mark as read
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
    Route::resource('tefillin_inspections', AdminTefillin::class)->names('admin.tefillin_inspections');
    Route::resource('mezuza_inspections', AdminMezuza::class)->names('admin.mezuza_inspections');

    // Inspection Management Routes
    Route::get('inspections', [AdminInspectionController::class, 'index'])->name('admin.inspections.index');
    Route::get('inspections/create', [AdminInspectionController::class, 'create'])->name('admin.inspections.create');
    Route::post('inspections', [AdminInspectionController::class, 'store'])->name('admin.inspections.store');
    Route::get('inspections/{inspection}', [AdminInspectionController::class, 'show'])->name('iadmin.nspections.show');
    Route::get('inspections/{inspection}/edit', [AdminInspectionController::class, 'edit'])->name('admin.inspections.edit');
    Route::put('inspections/{inspection}', [AdminInspectionController::class, 'update'])->name('admin.inspections.update');
    Route::delete('inspections/{inspection}', [AdminInspectionController::class, 'destroy'])->name('admin.inspections.destroy');

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

    Route::get('/bookings', [AdminBookingController::class,'index'])->name('admin.bookings.index');
    Route::post('/bookings/{booking}/approve', [AdminBookingController::class,'approve'])->name('admin.bookings.approve');
    Route::post('/bookings/{booking}/reject', [AdminBookingController::class,'reject'])->name('admin.bookings.reject');

    Route::get('/record-book', [RecordBookController::class,'recordBook'])->name('admin.recordbook.index');
    Route::resource('/tefillin-records', TefillinRecordController::class)->names('admin.tefillin-records');
    Route::resource('/mezuza-records', MezuzaRecordController::class)->names('admin.mezuza-records');

    Route::get('record-book/{user}', [RecordBookController::class,'show'])->name('admin.recordbook.show');
    Route::get('record-book/{user}/pdf', [RecordBookController::class,'pdf'])->name('admin.recordbook.pdf');
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

    Route::get('/bookings', [TeacherBookingController::class,'index'])->name('teacher.bookings.index');
    Route::post('/bookings/{booking}/send-link', [TeacherBookingController::class,'sendPaymentLink'])->name('teacher.bookings.sendLink');
    Route::get('/bookings/{booking}/meeting/create', [TeacherBookingController::class,'createMeetingForm'])->name('teacher.bookings.createMeeting');
    Route::post('/bookings/{booking}/meeting/store', [TeacherBookingController::class,'storeMeeting'])->name('teacher.bookings.storeMeeting');
    Route::post('/bookings/{booking}/upload-recording', [TeacherBookingController::class,'uploadRecording'])->name('teacher.bookings.uploadRecording');
    Route::post('/recordings/{recording}/remove', [TeacherBookingController::class,'removeRecording'])->name('teacher.recordings.remove');

    // Teacher Record Book
    Route::get('/record/books', [TeacherCtrl::class, 'recordBook'])->name('teacher.recordbooks');
    Route::get('record-book/{user}', [TeacherCtrl::class,'show'])->name('teacher.recordbook.show');
    Route::get('record-book/{user}/pdf', [TeacherCtrl::class,'pdf'])->name('teacher.recordbook.pdf');
    // Teacher chat endpoints
    Route::get('/chat', [ChatController::class, 'teacherIndex'])->name('teacher.chat.index');
    Route::get('/chat/{studentId}', [ChatController::class, 'fetchMessages'])->name('teacher.chat.fetch');
    Route::post('/chat/{studentId}', [ChatController::class, 'sendMessage'])->name('teacher.chat.send');

    Route::resource('tests', TeacherTestController::class)->names('teacher.tests');
    Route::post('tests/{test}/questions', [TeacherTestController::class,'storeQuestion'])->name('teacher.tests.questions.store');
    Route::delete('questions/{question}', [TeacherTestController::class,'destroyQuestion'])->name('teacher.questions.destroy');
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

    Route::post('/bookings/start/{teacherId}', [BookingController::class,'start'])->name('bookings.start');
    Route::get('/bookings', [BookingController::class,'studentBookings'])->name('student.bookings');
    Route::get('/bookings/{booking}', [BookingController::class,'show'])->name('student.bookings.show');
    Route::post('/bookings/{booking}/upload-proof', [BookingController::class,'uploadProof'])->name('student.bookings.uploadProof');
    // Student Record Book
    Route::get('/record/books', [StudentCtrl::class, 'recordBook'])->name('student.recordbooks');
    Route::get('record-book/{user}', [StudentCtrl::class,'show'])->name('student.recordbook.show');
    Route::get('record-book/{user}/pdf', [StudentCtrl::class,'pdf'])->name('student.recordbook.pdf');

    Route::get('/chat/{teacherId}', [ChatController::class, 'fetchMessages'])->name('student.chat.fetch');
    Route::post('/chat/{teacherId}', [ChatController::class, 'sendMessage'])->name('student.chat.send');

    Route::get('tests', [StudentTestController::class,'index'])->name('student.tests.index');
    Route::get('tests/{test}', [StudentTestController::class,'show'])->name('student.tests.show');
    Route::get('tests/{test}/download', [StudentTestController::class,'download'])->name('student.tests.download');
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
    // Parent Record Book
    Route::get('/record/books', [ParentCtrl::class, 'recordBook'])->name('parent.recordbooks');
    Route::get('record-book/{user}', [ParentCtrl::class,'show'])->name('parent.recordbook.show');
    Route::get('record-book/{user}/pdf', [ParentCtrl::class,'pdf'])->name('parent.recordbook.pdf');
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
    // User Record Book
    Route::get('/record/books', [UserCtrl::class, 'recordBook'])->name('user.recordbooks');
    Route::get('record-book/{user}', [UserCtrl::class,'show'])->name('user.recordbook.show');
    Route::get('record-book/{user}/pdf', [UserCtrl::class,'pdf'])->name('user.recordbook.pdf');
});

require __DIR__ . '/auth.php';
