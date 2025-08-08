@extends('admin.layouts.app')


@section('content')
<style>
  form {
    align-items: baseline;
    display: flex;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>File Uploads</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">File Uploads</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">File Uploads</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-header">
                <div class="row">
                  <div class="col-md-4">
                     <a href="{{ route('admin.files.create') }}" class="btn btn-success">Files Upload</a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <table id="example" class="table table-bordered table-striped">
                <!-- <table id="example" class="table table-striped nowrap" style="width:100%"> -->
                  <thead>
                  <tr>
                      <th>ID</th>
                      <th>Title</th>
                      <th>Cover Image</th>
					  <th>Created_at</th>
                      <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @if($files)

                    @foreach($files as $file)
                      <tr>
                          <td>{{ $file->id }}</td>
                          <td>{{ $file->title }}</td>

                          <td>
                            @if($file->cover_image)
                              <img src="{{ asset('storage/' . $file->cover_image) }}" alt="{{ $file->title }}" style="max-width: 100px; max-height: 100px;">
                            @else
                              <span>No Cover Image</span>
                            @endif
                          </td>
						  <td>{{ $file->created_at->format('Y-m-d') }}</td>
                          <td>
                              <!-- <a href="{{ route('admin.files.show', $file->id) }}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fa fa-eye"></i></a> -->
                              <a href="{{ route('admin.files.edit', $file->id) }}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fa fa-edit"></i></a>
                              <form action="{{ route('admin.files.destroy', $file->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fa fa-trash"></i></button>
                              </form>
                          </td>

                      </tr>
                    @endforeach
                  @endif
                  </tbody>

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
