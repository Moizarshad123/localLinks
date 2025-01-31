@extends('admin.layouts.app')
@section('title', 'Edit User')

@section('css')
@endsection

@section('content')
<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h3>Edit User</h3>
    <form method="POST" action="{{ route('admin.users.update', $user->id)}}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Role<span style="color: red">*</span></label>
                    <select name="role_id" class="form-control" id="role_id" required>
                        <option value="">Select Role</option>
                        @foreach ($roles as $item)
                            <option value="{{ $item->id }}" {{ $user->role_id == $item->id ? "selected" : ""}}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Name</label>
                   <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Mobile</label>
                   <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email<span style="color: red">*</span></label>
                   <input type="email" name="email" class="form-control" required value="{{ $user->email }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Status</label>
                    <select name="status" class="form-control" id="status">
                      <option value="1" {{ $user->status == 1 ? "selected" : ""}}>Active</option>
                      <option value="0" {{ $user->status == 0 ? "selected" : ""}}>In-Active</option>

                    </select>
                </div>
            </div>
        </div>
    
        <button type="submit" class="btn btn-primary">Edit</button>
    </form>

</div>
<!-- / Content -->
@endsection

@section('js')

<script>

</script>
@endsection
