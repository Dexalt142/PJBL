@extends('layouts.guru')

@section('page-title', 'Profile')
@section('page-header', 'Profile')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('guru-dashboard') }}">Dashboard</a></li>
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
                                <form action="">
                                    <div class="form-group">
                                        <div class="profile-picture">
                                            <div class="wrapper mx-auto" style="background: url({{ asset('assets/img/profile_picture.png') }}); background-size: cover">
                                                <div class="hint">Ganti</div>
                                                <input type="file" name="profile_picture" class="upload-profile-pic">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <label for="">Password Lama</label>
                                        <input type="password" name="password" class="form-control">
                                        <small class="form-text text-muted">Kosongkan jika tidak akan diubah.</small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="">Password Baru</label>
                                        <input type="password" name="new_password" class="form-control">
                                        <small class="form-text text-muted">Kosongkan jika tidak akan diubah.</small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="">Ulangi Password</label>
                                        <input type="password" name="repeat_password" class="form-control">
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
                        <form action="">
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input type="text" class="form-control" value="{{ $userDetail->nip }}">
                            </div>

                            <div class="form-group">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" class="form-control" value="{{ $userDetail->nama_lengkap }}">
                            </div>

                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="text" class="form-control" value="{{ $userDetail->tanggal_lahir }}">
                            </div>

                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <input type="text" class="form-control" value="{{ $userDetail->jenis_kelamin }}">
                            </div>

                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control">{{ $userDetail->alamat }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="agama">Agama</label>
                                <input type="text" class="form-control" value="{{ $userDetail->agama }}">
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
    
@endsection