@extends('admin.layouts.app')
@section('title', 'Attendance Logs')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0">Attendance Management</h3>
                    </div><!-- /.col -->
                    <div class="col-sm-6 text-end">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Attendance Logs</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <section class="content">
            <div class="usermanagesec">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">

                                    {{-- <a class="btn btn-success btn-sm mb-2" href="{{ route('admin.users.create') }}">
                                        <i class="fas fa-plus"></i> Invite New User
                                    </a> --}}

                                </div>
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                <form method="GET" action="{{ route('admin.attendances.index') }}"
                                    class="grid grid-cols-5 gap-4 mb-6">
                                    <select name="class_id" class="border p-2 rounded">
                                        <option value="">All Classes</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}"
                                                {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <select name="subject_id" class="border p-2 rounded">
                                        <option value="">All Subjects</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}"
                                                {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                                {{ $subject->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <select name="student_id" class="border p-2 rounded">
                                        <option value="">All Students</option>
                                        @foreach ($students as $student)
                                            <option value="{{ $student->id }}"
                                                {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                                {{ $student->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <select name="status" class="border p-2 rounded">
                                        <option value="">Any Status</option>
                                        <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>
                                            Present</option>
                                        <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent
                                        </option>
                                        <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Late
                                        </option>
                                    </select>

                                    <input type="date" name="date" value="{{ request('date') }}"
                                        class="border p-2 rounded">
                                    <button class="col-span-5 bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
                                </form>

                                <table class="w-full bg-white rounded shadow">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="p-2">Date</th>
                                            <th class="p-2">Student</th>
                                            <th class="p-2">Class</th>
                                            <th class="p-2">Subject</th>
                                            <th class="p-2">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($attendances as $att)
                                            <tr>
                                                <td class="p-2">{{ $att->date }}</td>
                                                <td class="p-2">{{ $att->student->name }}</td>
                                                <td class="p-2">{{ $att->class->name }}</td>
                                                <td class="p-2">{{ $att->subject->name }}</td>
                                                <td class="p-2 capitalize">{{ $att->status }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="p-4 text-center text-gray-500">No records found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="mt-4">
                                    {{ $attendances->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
