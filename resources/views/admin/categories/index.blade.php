@extends('admin.layouts.app')
@section('title', 'Categories')

@section('css')
@endsection

@section('content')
 <!-- content -->
 <div class="content ">

    <div class="mb-4">
        <div class="row">
            <div class="col-md-10">
                <h3>Categories</h3>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-success">Add Category</a>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-custom table-lg mb-0" id="ordersTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><img src="{{ $item->image }}" width="120" alt=""></td>
                        <td>{{ $item->name }}</td>
                        <td>
                            @if($item->status == 1)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-success">In Active</span>
                            @endif
                        </td>
                        <td><a href="{{ route('admin.categories.edit', $item->id)}}"><i class="fa fa-pencil"></i></a></td>
                    </tr>
                @empty
                    
                @endforelse
            </tbody>
        </table>
    </div>


</div>
@endsection