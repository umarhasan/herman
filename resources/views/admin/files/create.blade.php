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
            <li class="breadcrumb-item active">File Uploads</li>
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

                    <form action="{{ route('admin.files.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group">
                          <label for="title">Title:</label>
                          <input type="text" name="title" id="title" class="form-control">
                      </div>
                      <div class="form-group">
                          <label for="author">Issue:</label>
                          <textarea name="author" class="form-control" id="summernote"></textarea>
                      </div>

                      <div class="form-group">
                          <label for="description">Testified:</label>
                        <textarea name="testified" class="form-control" id="summernote1"></textarea>
                      </div>
                      <div class="form-group">
                          <label for="description">Description:</label>
                          <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                      </div>

                      <div class="form-group">
                          <label for="file">cover Image:</label>
                          <input type="file" name="cover_image" id="cover_image" class="form-control">
                      </div>

                      <!-- Data Table for Multiple Categories -->
                      <table class="table table-bordered" id="categories-table">
                          <thead>
                              <tr>
                                  <th>Category</th>
                                  <th>Amount</th>
                                  <th>File</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr class="category-input">
                                  <td>
                                      <select name="categories[]" class="form-control category-select">
                                          <option value="">-----Select Categories-----</option>
                                          @foreach($categories as $cat)
                                          <option value="{{$cat->id}}" data-amount="{{$cat->amount}}">{{$cat->name}}</option>
                                          @endforeach
                                      </select>
                                  </td>
                                  <td><input type="text" name="category_amounts[]" class="form-control category-amount" ></td>
                                  <td><input type="file" name="category_files[]" class="form-control"></td>
                                  <td><button type="button" class="btn btn-primary" id="add-category">Add More</button></td>
                              </tr>
                          </tbody>
                      </table>
                      <button type="submit" class="btn btn-primary">Upload</button>
                  </form>
                    </div>
                </div>
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
                <td><input type="text" name="category_amounts[]" class="form-control category-amount" ></td>
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

    var APP_URL = {!! json_encode(url('/')) !!}
</script>

@endsection
