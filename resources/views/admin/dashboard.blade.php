@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('css')
@endsection

@section('content')
    {{-- <div class="row row-cols-1 g-4">
        <div class="col-md-3">
            <button class="btn btn-primary" id="tillOpenButton">Till Open</button>
        </div>
        <div class="col-md-3">
            @if($checkTillOpen != null)
                <button class="btn btn-primary " id="tillCloseButton">Till Close</button>
            @endif                
        </div>
        <div class="col-md-3">
            <button class="btn btn-success" data-toggle="modal" data-target="#tillCashIn">Cash In</button>
        </div>
        <div class="col-md-3">
            <button class="btn btn-info"  data-toggle="modal" data-target="#tillCashOut">Cash Out</button>
        </div>
        <div class="col">
            @if($checkTillOpen != null && $checkTillClose != null)
                <a class="btn btn-warning" target="blank" href="{{ route('admin.tillCloseReceipt') }}">Print Slip</a>
            @endif
        </div>
    </div> --}}
    
  
    <!-- Till open and Close Modal -->
    {{-- <div class="modal fade" id="tillOpenModal" tabindex="-1" role="dialog" aria-labelledby="tillOpenModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 170%;">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Till Open</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="tillForm">
                    @csrf
                    <div class="form-group">
                        <label for="">User</label>
                        <input type="text" class="form-control" readonly value="{{ auth()->user()->name }}">
                    </div>
                    <div class="form-group">
                        <label for="">Till Date</label>
                        <input type="text" readonly class="form-control" value="{{ date('d-m-Y') }}">
                    </div>
                    <div class="form-group">
                        <label for="">Amount</label>
                        <input type="number" class="form-control" name="amount" required>
                    </div>
                    <div class="form-group">
                        <label for="">Notes</label>
                        <textarea name="notes" id="" class="form-control" cols="30" rows="10"></textarea>
                    </div>
                    <table class="table">
                        <tr>
                            <td><input class="form-control" type="text" value="5000" readonly></td>
                            <td>x</td>
                            <td><input class="form-control" id="five_thousand" name="five_thousand" type="number" min="1" placeholder="0"></td>
                            <td>=</td>
                            <td><input class="form-control" type="text" id="five_thousand_result" value="0" readonly></td>
                        </tr>
                        <tr>
                            <td><input class="form-control" type="text" value="1000" readonly></td>
                            <td>x</td>
                            <td><input class="form-control" id="one_thousand" name="one_thousand" type="number" min="1" placeholder="0"></td>
                            <td>=</td>
                            <td><input class="form-control" type="text" id="one_thousand_result" value="0" readonly></td>
                        </tr>
                        <tr>
                            <td><input class="form-control" type="text" value="500" readonly></td>
                            <td>x</td>
                            <td><input class="form-control" id="five_hundred" name="five_hundred" type="number" min="1" placeholder="0"></td>
                            <td>=</td>
                            <td><input class="form-control" type="text" id="five_hundred_result" value="0" readonly></td>
                        </tr>
                        <tr>
                            <td><input class="form-control" type="text" value="100" readonly></td>
                            <td>x</td>
                            <td><input class="form-control" id="one_hundred" name="one_hundred" type="number" min="1" placeholder="0"></td>
                            <td>=</td>
                            <td><input class="form-control" type="text" id="one_hundred_result" value="0" readonly></td>
                        </tr>
                        <tr>
                            <td><input class="form-control" type="text" value="50" readonly></td>
                            <td>x</td>
                            <td><input class="form-control" id="fifty" name="fifty" type="number" min="1" placeholder="0"></td>
                            <td>=</td>
                            <td><input class="form-control" type="text" id="fifty_result" value="0" readonly></td>
                        </tr>
                        <tr>
                            <td><input class="form-control" type="text" value="20" readonly></td>
                            <td>x</td>
                            <td><input class="form-control" id="twenty" name="twenty" type="number" min="1" placeholder="0"></td>
                            <td>=</td>
                            <td><input class="form-control" type="text" id="twenty_result" value="0" readonly></td>
                        </tr>
                        <tr>
                            <td><input class="form-control" type="text" value="10" readonly></td>
                            <td>x</td>
                            <td><input class="form-control" id="ten" name="ten" type="number" min="1" placeholder="0"></td>
                            <td>=</td>
                            <td><input class="form-control" type="text" id="ten_result" value="0" readonly></td>
                        </tr>
                        <tr>
                            <td><input class="form-control" type="text" value="5" readonly></td>
                            <td>x</td>
                            <td><input class="form-control" id="five" name="five" type="number" min="1" placeholder="0"></td>
                            <td>=</td>
                            <td><input class="form-control" type="text" id="five_result" value="0" readonly></td>
                        </tr>
                        <tr>
                            <td><input class="form-control" type="text" value="2" readonly></td>
                            <td>x</td>
                            <td><input class="form-control" id="two" name="two" type="number" min="1" placeholder="0"></td>
                            <td>=</td>
                            <td><input class="form-control" type="text" id="two_result" value="0" readonly></td>
                        </tr>
                        <tr>
                            <td><input class="form-control" type="text" value="1" readonly></td>
                            <td>x</td>
                            <td><input class="form-control" id="one" name="one" type="number" min="1" placeholder="0"></td>
                            <td>=</td>
                            <td><input class="form-control" type="text" id="one_result" value="0" readonly></td>
                        </tr>
                    </table>
                    <div class="form-group">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
                
            </div>
            
        </div>
        </div>
    </div> --}}

    {{-- <!-- Cash IN Modal -->
    <div class="modal fade" id="tillCashIn" tabindex="-2" role="dialog" aria-labelledby="tillCloseModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content" style="    width: 170%;">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Till Cash In</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.cashIn') }}" method="POST" >
                    @csrf
                    <input type="hidden" name="type" value="cash_in">
                    <div class="form-group" style="margin-bottom: 10px">
                        <label for="">User</label>
                        <input type="text" class="form-control" readonly value="{{ auth()->user()->name }}">
                    </div>
                    <div class="form-group" style="margin-bottom: 10px">
                        <label for="">Cash In Date</label>
                        <input type="text" readonly class="form-control" value="{{ date('d-m-Y') }}">
                    </div>
                    <div class="form-group" style="margin-bottom: 10px">
                        <label for="">Cash In Amount</label>
                        <input type="number" class="form-control" name="amount" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 10px">
                        <label for="">Notes</label>
                        <textarea name="notes" id="" class="form-control" cols="30" rows="6"></textarea>
                    </div>
                  
                    <div class="form-group">
                        <button class="btn btn-primary">Cash In Submit</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>

    <!-- Cash Out Modal -->
    <div class="modal fade" id="tillCashOut" tabindex="-3" role="dialog" aria-labelledby="tillCloseModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 170%;">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Till Cash Out</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.cashIn') }}" method="POST" >
                    @csrf
                    <input type="hidden" name="type" value="cash_out">
                    <div class="form-group" style="margin-bottom: 10px">
                        <label for="">User</label>
                        <input type="text" class="form-control" readonly value="{{ auth()->user()->name }}">
                    </div>
                    <div class="form-group" style="margin-bottom: 10px">
                        <label for="">Cash Out Date</label>
                        <input type="text" readonly class="form-control" value="{{ date('d-m-Y') }}">
                    </div>
                    <div class="form-group" style="margin-bottom: 10px">
                        <label for="">Cash Out Amount</label>
                        <input type="number" class="form-control" name="amount" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 10px">
                        <label for="">Notes</label>
                        <textarea name="notes" id="" class="form-control" cols="30" rows="6"></textarea>
                    </div>
                  
                    <div class="form-group">
                        <button class="btn btn-primary">Cash Out Submit</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div> --}}
@endsection

@section('js')
<script src="{{ asset('admin/dist/js/popper.min.js') }}"  crossorigin="anonymous"></script>
<script src="{{ asset('admin/dist/js/bootstrap.min.js') }}" crossorigin="anonymous"></script>
<script>
  
    
</script>
@endsection
