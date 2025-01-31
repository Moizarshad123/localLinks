@extends('admin.layouts.app')
@section('title', 'Add User')

@section('css')
@endsection

@section('content')
<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h3>Create User</h3>
    <form method="POST" action="{{ route('admin.users.store')}}">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Role<span style="color: red">*</span></label>
                    <select name="role_id" class="form-control" id="role_id" required>
                        <option value="">Select Role</option>
                        @foreach ($roles as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Name</label>
                   <input type="text" name="name" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Mobile</label>
                   <input type="text" name="phone" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email<span style="color: red">*</span></label>
                   <input type="email" name="email" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Password<span style="color: red">*</span></label>
                   <input type="password" name="password" class="form-control" required>
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
