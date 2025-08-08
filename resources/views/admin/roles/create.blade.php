@extends('admin.layouts.app')


@section('title', 'Create Roles')


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0">Roles Management</h3>
                    </div><!-- /.col -->
                    <div class="col-sm-6 text-end">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">New Role</li>
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

                                <form action="{{ route('admin.roles.store') }}" method="POST">
                                    @csrf

                                    <div class="form-group mb-3">
                                        <label>Role Name</label>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Enter Role Name" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Permissions</label>
                                        <div class="row">
                                            @foreach ($permissions->chunk(ceil($permissions->count() / 2)) as $chunk)
                                                <div class="col-md-6">
                                                    @foreach ($chunk as $permission)
                                                        <div class="form-check">
                                                            <input type="checkbox" name="permissions[]"
                                                                value="{{ $permission->id }}" dwclass="form-check-input"
                                                                id="perm_{{ $permission->id }}"
                                                                {{ isset($rolePermissions) && in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>

                                                            <label class="form-check-label"
                                                                for="perm_{{ $permission->id }}">
                                                                {{ $permission->name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <button type="submit" class="btn btn-success btn-sm mb-2">Create Role</button>
                                        <a class="btn btn-secondary btn-sm mb-2" href="{{ route('admin.roles.index') }}"><i
                                                class="fas fa-arrow-left"></i> Back</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.usermanagesec -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
