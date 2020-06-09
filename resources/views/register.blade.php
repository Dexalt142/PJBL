@extends('layouts.app')

@section('page-title')
PJBL &middot; Register
@endsection

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-7">
                <div class="text-center">
                    <img src="{{ asset('assets/img/illustration_1.png') }}" alt="Illustration 1" class="w-75">
                    <h1 class="f-w-700">Project Based Learning</h1>
                    <h6>Aplikasi pembelajaran project based learning berbasis web nomor.</h6>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card bg-light">
                    <div class="card-body">
                        <h3 class="card-title text-center">
                            Project Based Learning
                        </h3>
                        <div class="text-center">
                            Selamat datang di Project Based Learning.
                        </div>

                        <div class="mt-4">
                            <form action="{{ route('register-post') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group" id="passRepeat">
                                    <label for="password-repeat">Ulangi Password</label>
                                    <input type="password" class="form-control" name="password-repeat" placeholder="Ulangi Password" required>
                                    <span class="invalid-feedback" role="alert" style="display: hidden">
                                        <strong>Password tidak sesuai</strong>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="password">Gunakan akun sebagai</label>
                                    <select name="user_type" class="form-control @error('user_type') is-invalid @enderror">
                                        <option value="siswa" {{ (old("user_type") == "siswa" ? "selected":"") }}>Siswa</option>
                                        <option value="guru" {{ (old("user_type") == "guru" ? "selected":"") }}>Guru</option>
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Pilihan tidak ditemukan</strong>
                                    </span>
                                </div>
                                <div class="form-check form-group">
                                    <input class="form-check-input" type="checkbox" value="" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Saya setuju dengan ...
                                    </label>
                                </div>
                                <button class="btn btn-md btn-primary w-100" type="submit" id="registerButton">Register</button>
                                <hr>
                                <div class="text-center">
                                    Sudah memiliki akun? <a href="{{ route('root') }}">Masuk sekarang</a>
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
        $("#registerButton").on('click', function(e) {
            var prcontainer = $("#passRepeat");
            var originalpass = $("input[name='password']").val();
            var repass = prcontainer.find("input[name='password-repeat']");
            if(repass.val() != originalpass) {
                repass.addClass('is-invalid');
                prcontainer.find(".invalid-feedback").css('display');
                e.preventDefault();
            }
        });
    </script>
@endsection