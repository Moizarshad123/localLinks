@extends('admin.layouts.app')
@section('title', 'Send Emails')

@section('css')
@endsection

@section('content')
  <!-- content -->
  <div class="content ">

    <div class="mb-4">
        <div class="row">
            <div class="col">
                <h3>Send Emails</h3>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-custom table-lg mb-0" id="ordersTable">
            <thead>
                <tr>
                    <th>Order#</th>
                    <th>Customer Name</th>
                    <th>Customer Mobile</th>
                    <th>Emails</th>
                    <th>Order Creating Date</th>
                    <th>Order Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $item)
                    <tr>
                        <td>{{ $item->order_number}}</td>
                        <td>{{ $item->customer_name}}</td>
                        <td>{{ $item->phone}}</td>
                        <td>{{ $item->emails}}</td>
                        <td>{{ date('d-m-Y', strtotime($item->creating_date))}}</td>
                        <td>{{ $item->status}}</td>
                        <td>
                            <a href="{{route('admin.markDone', $item->id)}}" class="btn btn-sm btn-success">Mark as Send</a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <h4 class="text-center">No Email Found</h4>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


</div>
<!-- ./ content -->
@endsection

@section('js')

@endsection