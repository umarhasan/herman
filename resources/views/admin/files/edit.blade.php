@extends('admin.layouts.app')
@section('content')

<style>

  .form-check-input{
    border-radius: 0 !important;
    height: 20px;
    width: 20px;
    margin:0;
  }

  .form-group strong{
    margin: 0 0 10px;
    width: fit-content;
    display: block;
  }

  .my-txt-box{
    padding: 0 0 10px;
  }

  .my-label{
    padding-left: 30px;
    text-transform:capitalize;
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
            <li class="breadcrumb-item active">Update Files</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
      <div class="container-fluid">

          <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">

                    <form action="{{ route('admin.files.update', $file->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ $file->title }}">
                    </div>


                    <div class="form-group">
                          <label for="author">Issue:</label>
                          <textarea name="author" class="form-control" id="summernote" >{{ $file->author }}</textarea>
                      </div>

                      <div class="form-group">
                          <label for="description">Testified:</label>
                        <textarea name="testified" class="form-control" id="summernote1" >{{ $file->testified }}</textarea>
                      </div>


                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" class="form-control" rows="3">{{ $file->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="current_cover_image">Current Cover Image:</label>
                        @if ($file->cover_image)
                            <img src="{{ asset('storage/' . $file->cover_image) }}" alt="{{ $file->title }}" style="max-width: 200px; max-height: 200px; margin-bottom: 10px;">
                        @else
                            <span>No Cover Image</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="cover_image">Choose New Cover Image (JPEG, PNG, JPG, GIF, SVG, or PDF):</label>
                        <input type="file" name="cover_image" id="cover_image" class="form-control">
                    </div>


                      <!-- Data Table for Multiple Categories -->
                      <table class="table table-bordered" id="categories-table">
                        <thead>
                            <tr>
                                <th style="width:25%">Category</th>
                                <th style="width:25%">Amount</th>
                                <th style="width:30%">File</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <button  class="btn btn-primary" id="add-category">Add More</button><br/> -->
                            <button  type="button" class="btn btn-primary btn-sm float-right" style="margin:5px" id="add-category" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fa fa-plus"></i> Add More</button><br/>

                            @foreach($file->FileCategory as $fileCategory)
                            <tr class="category-input" data-id="{{ $fileCategory->id }}">
                                <td>
                                    <select  class="form-control category-select" disabled>
                                        @foreach($categories as $cat)
                                            <option value="{{$cat->id}}" {{$fileCategory->file_category_id == $cat->id ? 'selected' : ''}}>{{$cat->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" class="form-control category-amount" value="{{ $fileCategory->amount }}" ></td>
                                <td>
                                    <input type="file" class="form-control" disabled>
                                    @if($fileCategory->file_path)
                                        <a href="{{ asset('storage/' . $fileCategory->file_path) }}" target="_blank">Current File</a>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-primary edit-btn">Edit</a>
                                    {{-- <a href="{{ route('admin.file.category.upload.delete', $fileCategory->id) }}"  class="btn btn-danger btn-sm dltBtn">Delete</a> --}}
                                </td>
                            </tr>
                        @endforeach

                        </tbody>

                    </table>
                        <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
                    </div>
                </div>
            </div>
          </div>
      </div>

      <!-- Model  -->

      <!-- Modal for editing -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.file.category.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="editId" name="id">
                    <div class="form-group">
                        <label for="editCategory">Category:</label>
                        <select id="editCategory" name="categories" class="form-control">
                            <option value="">-----Select Category-----</option>
                            @foreach($categories as $cat)
                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editAmount">Amount:</label>
                        <input type="text" id="editAmount" name="amount" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="editFile">File:</label>
                        <input type="file" id="editFile" name="category_files" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
  </section>
</div>


<script type="text/javascript">
     document.addEventListener('DOMContentLoaded', function() {
        const categorySelects = document.querySelectorAll('.category-select');

        categorySelects.forEach(function(select) {
            select.addEventListener('change', function() {
                const selectedOption = select.selectedOptions[0];
                const selectedAmount = selectedOption.dataset.amount;
                const amountField = select.closest('tr').querySelector('.category-amount');
                amountField.value = selectedAmount;
            });
        });

        const addCategoryButton = document.getElementById('add-category');
        addCategoryButton.addEventListener('click', function() {
            const tbody = document.querySelector('#categories-table tbody');
            const newRow = document.createElement('tr');
            newRow.classList.add('category-input');
            newRow.innerHTML = `
                <td>
                    <select name="categories[]" class="form-control category-select">
                        <option value="">-----Select Categories-----</option>
                        @foreach($categories as $cat)
                        <option value="{{$cat->id}}" data-amount="{{$cat->amount}}">{{$cat->name}}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" name="category_amounts[]" class="form-control category-amount"></td>
                <td><input type="file" name="category_files[]" class="form-control"></td>
                <td><button type="button" class="btn btn-danger remove-category">Remove</button></td>
            `;
            tbody.appendChild(newRow);

            const newSelect = newRow.querySelector('.category-select');
            const newAmountField = newRow.querySelector('.category-amount');

            newSelect.addEventListener('change', function() {
                const selectedOption = newSelect.selectedOptions[0];
                const selectedAmount = selectedOption.dataset.amount;
                newAmountField.value = selectedAmount;
            });

            const removeButton = newRow.querySelector('.remove-category');
            removeButton.addEventListener('click', function() {
                newRow.remove();
            });
        });
    });



     // Event listener for edit buttons
     document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('.category-input');
            const id = row.getAttribute('data-id');
            const category = row.querySelector('.category-select').value;
            const amount = row.querySelector('.category-amount').value;

            // Populate the modal with data
            document.getElementById('editId').value = id;
            document.getElementById('editCategory').value = category;
            document.getElementById('editAmount').value = amount;

            // Open the modal
            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        });
    });

    // Event listener for form submission within the modal
    document.getElementById('editForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch(`/file/category/update/${formData.get('editId')}`, {
        method: 'post',
        body: formData,
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        // Handle success response, if needed
        console.log(data);

        // Close the modal
        const editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.hide();

        // Update the corresponding row in the table if needed
        // You may need to handle this part separately as per your requirement
        // You can update the row without reloading the page using JavaScript
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
    var APP_URL = {!! json_encode(url('/')) !!}


</script>

@endsection
