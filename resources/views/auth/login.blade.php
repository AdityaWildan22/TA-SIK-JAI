@extends('layouts.template_login')
@section('content')
    <style>
        body {
            overflow: hidden;
        }

        .col-lg-6 img {
            max-width: 100%;
            max-height: 100%;
            display: block;
            margin: auto;
        }

        .login-page {
            overflow: hidden;
            background-image: url('{{ asset('img/login.jpg') }}');
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            background-size: cover;
            padding: 10px;
        }
    </style>
    <div class="login-page">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-md-8">
                <div class="card o-hidden border-0 shadow-lg my-5" style="background-color:rgba(255, 255, 255, 0.6)">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card-body p-0">
                        <div class="teks">
                            <h5
                                style="text-align: center; margin-top:10px; font-family: Verdana, Geneva, Tahoma, sans-serif">
                                Sistem Manajemen Karyawan <br> PT. JAI</h5>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 d-flex justify-content-center align-items-center">
                                <img src="{{ asset('img/logo.png') }}" alt="">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input id="username" type="text"
                                                class="form-control @error('username') is-invalid @enderror" name="username"
                                                value="{{ old('username') }}" required autocomplete="username" autofocus
                                                placeholder="Username">

                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                required autocomplete="current-password" placeholder="Password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block"
                                            style="font-size: 17px">
                                            {{ __('Login') }}
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
