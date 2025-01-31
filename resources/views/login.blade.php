<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Local Links | Admin Dashboard  </title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/fav-ic-n.png') }}"/>

    <!-- Themify icons -->
    <link rel="stylesheet" href="{{ asset('admin/dist/icons/themify-icons/themify-icons.css') }}" type="text/css">

    <!-- Main style file -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/app.min.css') }}" type="text/css">

</head>
<body class="auth">

<!-- begin::preloader-->
<div class="preloader">
    <div class="preloader-icon"></div>
</div>
<!-- end::preloader -->


    <div class="form-wrapper">
        <div class="container">
            <div class="card">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row g-0">
                    <div class="col">
                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <div class="d-block d-lg-none text-center text-lg-start">
                                    <img width="120" src="{{ asset('admin/logo.jpg')}}" alt="logo">
                                </div>
                                <div class="my-5 text-center text-lg-start">
                                    <h1 class="display-8">Sign In</h1>
                                    <p class="text-muted">Sign in to NASA Studios to continue</p>
                                </div>
                                <form class="mb-5" action="{{route('login')}}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="email" class="form-control" placeholder="Enter email" autofocus name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="password"  name="password" class="form-control" placeholder="Enter password"
                                               required>
                                    </div>
                                    <div class="text-center text-lg-start">
                                        {{-- <p class="small">Can't access your account? <a href="#">Reset your password now</a>.</p> --}}
                                        <button type="submit" class="btn btn-primary">Sign In</button>
                                    </div>
                                </form>
                               
                             
                            </div>
                        </div>
                    </div>
                    <div class="col d-none d-lg-flex border-start align-items-center justify-content-between flex-column text-center">
                        <div class="logo">
                            {{-- <img width="220" src="{{ asset('admin/logo.jpg')}}" alt="logo"> --}}
                        </div>
                        <div>
                            <h3 class="fw-bold">Welcome to Local Links</h3>
                          
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Bundle scripts -->
<script src="{{ asset('admin/libs/bundle.js') }}"></script>

<!-- Main Javascript file -->
<script src="{{ asset('admin/dist/js/app.min.js') }}"></script>
</body>
</html>
