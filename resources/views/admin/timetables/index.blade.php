@extends('admin.layouts.app')


@section('title', 'TimeTable Management System')


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0">TimeTable Management</h3>
                    </div><!-- /.col -->
                    <div class="col-sm-6 text-end">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">TimeTable Table</li>
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
                                    <a class="btn btn-success btn-sm mb-2" href="{{ route('admin.timetables.create') }}">
                                        <i class="fas fa-plus"></i> Add TimeTable
                                    </a>
                                    {{-- @endcan --}}
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

                                <table id="example" class="table table-striped" style="width: 100%">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="p-2"><b>N</b>o</th>
                                            <th class="p-2"><b>C</b>lass</th>
                                            <th class="p-2"><b>S</b>ubject</th>
                                            <th class="p-2"><b>T</b>eacher</th>
                                            <th class="p-2"><b>D</b>ay</th>
                                            <th class="p-2"><b>T</b>ime</th>
                                            <th class="p-2"><b>A</b>ctions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($timetables as $t)
                                            <tr>
                                                <td class="p-2">{{ $loop->iteration }}</td>
                                                <td class="p-2">{{ $t->teacher->name }}</td>
                                                <td class="p-2">{{ $t->schoolClass->name }}</td>
                                                <td class="p-2">{{ $t->subject->name }}</td>
                                                <td class="p-2">{{ $t->day }}</td>
                                                <td class="p-2">{{ $t->start_time }} - {{ $t->end_time }}</td>
                                                <td class="p-2">
                                                    {{-- @can('users-edit') --}}
                                                    <a class="btn btn-primary btn-sm mb-0"
                                                        href="{{ route('admin.timetables.edit', $t->id) }}"
                                                        title="Edit"><i class="fas fa-pen"></i></a>
                                                    {{-- @endcan --}}

                                                    {{-- @can('users-delete') --}}
                                                    <form method="POST"
                                                        action="{{ route('admin.timetables.destroy', $t->id) }}"
                                                        style="display:inline" id="delete-user-form-{{ $t->id }}">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="button" class="btn btn-danger btn-sm mb-0"
                                                            title="Delete"
                                                            onclick="confirmUserDelete({{ $t->id }})">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    {{-- @endcan --}}
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
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#timetableTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
            });
        });
    </script>
    <script>
        function confirmUserDelete(tId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This user will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-user-form-' + tId).submit();
                }
            });
        }
    </script>
@endsection
