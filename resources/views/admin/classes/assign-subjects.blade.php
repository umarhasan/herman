@extends('admin.layouts.app')


@section('title', 'Classes Management System')


@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0">Assign Subjects to {{ $class->name }}</h3>
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
        <!-- /.content-header -->

        <section class="content">
            <div class="usermanagesec">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3"> </div>
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

                                <form action="{{ route('admin.classes.storeSubjects', $class->id) }}" method="POST"
                                    class="space-y-4">
                                    @csrf

                                    <div class="form-group mb-3">
                                        <label class="block mb-2 font-semibold">Select Subjects:</label>
                                        <div class="grid grid-cols-2 gap-2">
                                            @foreach ($subjects as $subject)
                                                <label class="flex items-center space-x-2">
                                                    <input type="checkbox" name="subject_ids[]" value="{{ $subject->id }}"
                                                        {{ in_array($subject->id, $assignedSubjects) ? 'checked' : '' }}>
                                                    <span>{{ $subject->name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <button type="submit" class="btn btn-success btn-sm mb-2">Assign
                                            Subjects</button>
                                        <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary btn-sm mb-2">
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
