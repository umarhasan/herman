@extends('admin.layouts.app')


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Permissions</h1>
          </div>
          <div class="col-sm-6 text-end">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Permissions</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Permissions List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-header">
                @can('permission-create')
                <a class="btn btn-success" href="{{ route('admin.permission.create') }}"> Create New Permission</a>
                @endcan
                </div>
              <div class="card-body">
                <table id="example" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Permission</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @if($permissions)
                  @php
                  $id =1;
                  @endphp
                  @foreach($permissions as $key =>  $permission)
                  <tr>
                      <td>{{ $key+1 }}</td>
                      <td>{{ $permission->name }}</td>
                      <td>
                        {{-- @can('users-edit') --}}
                        <a class="btn btn-primary btn-sm mb-0"
                            href="{{ route('admin.permissions.edit', $permission->id) }}" title="Edit"><i
                                class="fas fa-pen"></i></a>
                        {{-- @endcan --}}
                        {{-- @can('users-delete') --}}
                        <form method="POST"
                            action="{{ route('admin.permissions.destroy', $permission->id) }}"
                            style="display:inline" id="delete-user-form-{{ $permission->id }}">
                            @csrf
                            @method('DELETE')

                            <button type="button" class="btn btn-danger btn-sm mb-0"
                                title="Delete" onclick="confirmUserDelete({{ $permission->id }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        {{-- @endcan --}}
                    </td>
                  </tr>
                  @endforeach
                  @endif
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>S.No</th>
                    <th>Roles</th>
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>


@endsection