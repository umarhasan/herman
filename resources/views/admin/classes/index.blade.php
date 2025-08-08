@extends('admin.layouts.app')


@section('title', 'Classes Management System')


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-md-6">
                        <h3 class="m-0">Classes Management</h3>
                    </div><!-- /.col -->
                    <div class="col-md-6 text-end">
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

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    {{-- <h2>Users Management</h2> --}}
                                    {{-- @can('users-create') --}}
                                    <a class="btn btn-success btn-sm mb-2" href="{{ route('admin.classes.create') }}">
                                        <i class="fas fa-plus"></i> New Classes
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
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($classes as $class)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $class->name }}</td>
                                                <td>{{ $class->description }}</td>
                                                <td>
                                                    <a class="btn btn-primary btn-sm mb-0" href="{{ route('admin.classes.edit', $class->id) }}" title="Edit"><i class="fas fa-pen"></i></a>
                                                    <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?')"><i class="fa fa-trash"></i></button>
                                                    </form>

                                                    <a href="{{ route('admin.classes.assignSubjects', $class->id) }}" class="btn btn-success btn-sm mb-0 text-indigo-500">Assign Subjects</a>
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
