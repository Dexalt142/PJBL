@extends('layouts.siswa')

@section('page-title', 'Profile')
@section('page-header', 'Profile')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('siswa-dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Profile</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('profile-account') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <div class="profile-picture">
                                            <div id="profile-pics" class="wrapper mx-auto" style="background: url({{ ($user->profile_picture) ? asset('profile_pictures/'.$user->profile_picture) : asset('assets/img/profile_picture.png') }}) center / cover;">
                                                <div class="hint">Upload</div>
                                                <input type="file" name="profile_picture" class="upload-profile-pic">
                                            </div>
                                            @if($user->profile_picture)
                                                <div>
                                                    <button type="button" class="btn btn-link btn-sm" id="remove_profile_picture">Hapus gambar</button>
                                                </div>
                                            @endif
                                            @error('profile_picture')
                                                <span style="font-size: 80%; color: #dc3545" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    @if (Session::has('accountUpdate'))
                                        <div class="alert alert-success">{{ Session::get('accountUpdate') }}</div>
                                    @endif

                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}" required>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                         @enderror
                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <label for="">Password Lama</label>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small class="form-text text-muted">Kosongkan jika tidak akan diubah.</small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="">Password Baru</label>
                                        <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror">
                                        @error('new_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small class="form-text text-muted">Kosongkan jika tidak akan diubah.</small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="">Ulangi Password</label>
                                        <input type="password" name="new_password_confirmation" class="form-control @error('new_password') is-invalid @enderror">
                                        @error('new_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small class="form-text text-muted">Kosongkan jika tidak akan diubah.</small>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Biodata</div>
                        @if (Session::has('bioUpdate'))
                            <div class="alert alert-success">{{ Session::get('bioUpdate') }}</div>
                        @endif
                        <form action="{{ route('profile-bio') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <input type="number" name="nis" min="0" class="form-control @error('nis') is-invalid @enderror" value="{{ $userDetail->nis }}">
                                @error('nis')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="nama_lengkap">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ $userDetail->nama_lengkap }}">
                                @error('nama_lengkap')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ $userDetail->tanggal_lahir }}">
                                @error('tanggal_lahir')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                    <option value="1" {{ ($userDetail->jenis_kelamin == "1" ? "selected":"") }}>Laki-laki</option>
                                    <option value="2" {{ ($userDetail->jenis_kelamin == "2" ? "selected":"") }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Pilihan tidak ditemukan</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat">{{ $userDetail->alamat }}</textarea>
                                @error('alamat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Pilihan tidak ditemukan</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="agama">Agama</label>
                                <select name="agama" class="form-control @error('agama') is-invalid @enderror">
                                    <option value="islam" {{ ($userDetail->agama == "islam" ? "selected":"") }}>Islam</option>
                                    <option value="kristen" {{ ($userDetail->agama == "kristen" ? "selected":"") }}>Kristen</option>
                                    <option value="katolik" {{ ($userDetail->agama == "katolik" ? "selected":"") }}>Katolik</option>
                                    <option value="buddha" {{ ($userDetail->agama == "budhaa" ? "selected":"") }}>Buddha</option>
                                    <option value="hindu" {{ ($userDetail->agama == "hindu" ? "selected":"") }}>Hindu</option>
                                    <option value="konghucu" {{ ($userDetail->agama == "konghucu" ? "selected":"") }}>Kong Hu Cu</option>
                                    <option value="lainnya" {{ ($userDetail->agama == "lainnya" ? "selected":"") }}>Lainnya</option>
                                </select>
                                @error('agama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Pilihan tidak ditemukan</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if($user->profile_picture)
        <script>
            $("#remove_profile_picture").on('click', () => {
                if(confirm('Apakah anda yakin akan menghapus foto profil anda?')) {
                    $.ajax({
                        url: '{{ route("profile-account-removepropics") }}',
                        method: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "profile_picture": "{{ $user->profile_picture }}"
                        },
                        success: (response) => {
                            if(response.success) {
                                console.log('Sukses');
                                $("#remove_profile_picture").closest("div").remove();
                                $("#profile-pics").css('background', 'url({{ asset("assets/img/profile_picture.png") }}) center / cover');
                            } else {
                                alert("Gagal menghapus foto profil");
                            }
                        }
                    });
                }
            });
        </script>
    @endif
@endsection