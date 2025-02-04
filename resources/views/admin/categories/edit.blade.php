@extends('admin.layouts.app')
@section('title', 'Edit Category')

@section('css')
@endsection

@section('content')
<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h3>Edit Category</h3>
    <form method="POST" action="{{ route('admin.categories.update', $category->id)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
     
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Name</label>
                   <input type="text" name="name" class="form-control" value="{{ $category->name }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="1" {{ $category->status == 1 ? "selected" : ""}}>Active</option>
                        <option value="0" {{ $category->status == 0 ? "selected" : ""}}>InActive</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Image</label>
                   <input type="file" name="image" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
               <img src="{{$category->image}}" alt="">
            </div>

  
        </div>
    
        <button type="submit" class="btn btn-primary">Update</button>
    </form>

</div>
<!-- / Content -->
@endsection

@section('js')
<script>
</script>
@endsection
