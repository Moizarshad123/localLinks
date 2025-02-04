@extends('admin.layouts.app')
@section('title', 'Add Category')

@section('css')
@endsection

@section('content')
<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h3>Create Category</h3>
    <form method="POST" action="{{ route('admin.categories.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
     
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Name</label>
                   <input type="text" name="name" class="form-control">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Image</label>
                   <input type="file" name="image" class="form-control">
                </div>
            </div>

  
        </div>
    
        <button type="submit" class="btn btn-primary">Add</button>
    </form>

</div>
<!-- / Content -->
@endsection

@section('js')
<script>
</script>
@endsection
