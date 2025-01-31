@extends('admin.layouts.app')
@section('title', 'Site Setting')

@section('css')
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h3 class="card-title">Site Settings</h3>
        <br>
        <form class="category-form" method="post" action="{{ route('admin.settings') }}" >
            @csrf
            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">Urgent Amount Order (Big)</label>
                        <input type="number" class="form-control" name="urgent_amount_big" id="urgent_amount_big" value="{{ $content->urgent_amount_big ?? '' }}" required>
                    </div>
                </div>
                <div class="col-md-4">

                    <div class="form-group">
                        <label for="name">Expose Amount Order (Big)</label>
                        <input type="number" class="form-control" name="expose_amount_big" id="expose_amount_big"
                                value="{{ $content->expose_amount_big ?? '' }}" required>
                    </div>
                </div>
                <div class="col-md-4">

                    <div class="form-group">
                        <label for="name">Media Amount Order (Big)</label>
                        <input type="number" class="form-control" name="media_amount_big" id="media_amount_big"
                            value="{{ $content->media_amount_big ?? '' }}" required>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">Urgent Amount Order (Small)</label>
                        <input type="number" class="form-control" name="urgent_amount_small" id="urgent_amount_small"
                                value="{{ $content->urgent_amount_small ?? '' }}" required>
                    </div>
                </div>
                <div class="col-md-4">

                    <div class="form-group">
                        <label for="name">Expose Amount Order (Small)</label>
                        <input type="number" class="form-control" name="expose_amount_small" id="expose_amount_small"
                                value="{{ $content->expose_amount_small ?? '' }}" required>
                    </div>
                </div>
                <div class="col-md-4">

                    <div class="form-group">
                        <label for="name">Media Amount Order (Small)</label>
                        <input type="number" class="form-control" name="media_amount_small" id="media_amount_small"
                            value="{{ $content->media_amount_small ?? '' }}" required>
                    </div>
                </div>

              

            </div>
            <div class="row" style="margin-top: 20px">
                <div class="col">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update Setting</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('js')
@endsection

