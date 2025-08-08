@extends('admin.layouts.app')


@section('title', 'Resources Management System')


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-md-6">
                        <h3 class="m-0">Resources</h3>
                    </div><!-- /.col -->
                    <div class="col-md-6 text-end">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Resources Table</li>
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
                                    {{-- <h2>Users Management</h2> --}}
                                    {{-- @can('users-create') --}}
                                    <a class="btn btn-success btn-sm mb-2" href="{{ route('admin.resources.create') }}">
                                        <i class="fas fa-plus"></i> Upload Resource
                                    </a>
                                    {{-- @endcan --}}
                                </div>

                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                <table id="example" class="table table-striped" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Class</th>
                                            <th>Subject</th>
                                            <th>File</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($resources as $res)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $res->title }}</td>
                                                <td>{{ $res->schoolClass->name }}</td>
                                                <td>{{ $res->subject->name }}</td>
                                                <td>
                                                    <a class="btn btn-primary btn-sm mb-0" href="{{ asset('storage/' . $res->file_path) }}" target="_blank" class="text-blue-500">View</a>
                                                </td>
                                                <td>
                                                    <form method="POST" action="{{ route('admin.resources.destroy', $res->id) }}"
                                                        onsubmit="return confirm('Delete?')">
                                                        @csrf @method('DELETE')
                                                        <button class="btn btn-danger btn-sm mb-0 text-red-500">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
@endsection

