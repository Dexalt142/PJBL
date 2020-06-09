@extends('layouts.app')

@section('page-title')
PJBL &middot; Login
@endsection

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-7 mb-4">
                <div class="text-center">
                    <img src="{{ asset('assets/img/illustration_1.png') }}" alt="Illustration 1" class="w-75">
                    <h1 class="f-w-700">Project Based Learning</h1>
                    <h6>Aplikasi pembelajaran project based learning berbasis web nomor.</h6>
                </div>
            </div>

            <div class="col-md-5 mb-4">
                <div class="card">
                    <div class="card-body py-5">
                        <h3 class="card-title text-center font-weight-bold">
                            Login
                        </h3>
                        <div class="mt-4">
                            <form action="{{ route('login-post') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" autofocus required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                                </div>
                                <div class="form-check form-group">
                                    <div class="row">
                                        
                                        <div class="col-6">
                                            <input class="form-check-input" type="checkbox" value="" name="remember" id="remember">
                                            <label class="form-check-label" for="remember">
                                                Remember me
                                            </label>
                                        </div>
                                        <div class="col-6 text-right">
                                            <a href="{{ url('forgetpassword') }}">Lupa password?</a><br>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-md btn-primary w-100" type="submit" id="loginButton">Login</button>
                                <hr>
                                <div class="text-center">
                                    Belum memiliki akun? <a href="{{ route('register') }}">Daftar sekarang</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        
    </script>
@endsection