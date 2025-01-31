@extends('admin.layouts.app')
@section('title', 'Users')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
@endsection

@section('content')
  <!-- content -->
  <div class="content ">

    <div class="mb-4">
        <div class="row">
            <div class="col-md-10">
                <h3>Users</h3>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-success">Add User</a>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-custom table-lg mb-0" id="ordersTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>{{ $item->role->name }}</td>
                        <td>
                            @if($item->status == 1)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-success">In Active</span>
                            @endif
                        </td>
                        <td><a href="{{ route('admin.users.edit', $item->id)}}"><i class="fa fa-pencil"></i></a></td>
                    </tr>
                @empty
                    
                @endforelse
            </tbody>
        </table>
    </div>


</div>
<!-- ./ content -->
@endsection

@section('js')
<script>
</script>
@endsection