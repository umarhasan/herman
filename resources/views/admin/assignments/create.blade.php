@extends('admin.layouts.app')

@section('title', 'Assign Subjects and Classes')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0">Assign Subjects & Classes Management</h3>
                    </div><!-- /.col -->
                    <div class="col-sm-6 text-end">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Classes Table</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="usermanagesec">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
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

                                @if (session('success'))
                                    <div class="bg-green-200 p-2 rounded text-green-800">{{ session('success') }}</div>
                                @endif

                                <form method="POST" action="{{ route('admin.assignments.store') }}" class="space-y-4">
                                    @csrf

                                    <div class="form-group mb-3">
                                        <label>Teacher:</label>
                                        <input type="text" class="form-control" value="{{ $teachers->name }}" readonly>
                                        <input type="hidden" name="teacher_id" class="form-control"
                                            value="{{ $teachers->id }}" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="block text-lg font-semibold text-gray-700 mb-4">Assign Subjects to
                                            Class</label>

                                        @foreach ($classSubjects as $className => $subjects)
                                            <div class="mb-6">
                                                <h4 class="text-md font-semibold text-indigo-700 mb-2">Class:
                                                    {{ $className }}</h4>

                                                <div class="flex flex-wrap gap-3">
                                                    @foreach ($subjects as $cs)
                                                        <label
                                                            class="flex items-center gap-2 px-3 py-2 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50">
                                                            <input type="checkbox" name="class_subject_ids[]"
                                                                value="{{ $cs->id }}"
                                                                class="h-4 w-4 text-blue-600 border-gray-300 rounded"
                                                                {{ in_array($cs->id, $assignedIds) ? 'checked' : '' }}>

                                                            <span
                                                                class="text-sm text-gray-800">{{ $cs->subject->name }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Buttons --}}
                                    <div class="form-group mb-3">
                                        <button type="submit" class="btn btn-success btn-sm mb-2">Assign Teacher</button>
                                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm mb-2">
                                            <i class="fas fa-arrow-left"></i> Back
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
