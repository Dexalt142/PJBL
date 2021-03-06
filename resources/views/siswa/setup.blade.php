@extends('layouts.siswa')

@section('content')
    <div class="container my-5">
        <div class="col-md-8 mx-auto">
            <div class="card bg-light">
                <div class="card-body">
                    <h3 class="card-title font-weight-bold text-center">Lengkapi akun anda</h3>
                    <div class="text-center">Isi data diri anda sebagai siswa untuk melanjutkan.</div>

                    <form action="{{ route('profile-setup-post') }}" method="POST" class="mt-4">
                        @csrf
                        <div class="form-group">
                            <label for="nis">Nomor Induk Siswa</label>
                            <input type="number" min="0" class="form-control @error('nis') is-invalid @enderror" name="nis" value="{{ old('nis') }}" required>
                            @error('nis')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                            @error('nama_lengkap')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                            @error('tanggal_lahir')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                <option value="1" {{ (old("user_type") == "1" ? "selected":"") }}>Laki-laki</option>
                                <option value="2" {{ (old("user_type") == "2" ? "selected":"") }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Pilihan tidak ditemukan</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="5" value="{{ old('alamat') }}" required></textarea>
                            @error('alamat')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="agama">Agama</label>
                            <select name="agama" class="form-control @error('agama') is-invalid @enderror">
                                <option value="islam" {{ (old("user_type") == "islam" ? "selected":"") }}>Islam</option>
                                <option value="kristen" {{ (old("user_type") == "kristen" ? "selected":"") }}>Kristen</option>
                                <option value="katolik" {{ (old("user_type") == "katolik" ? "selected":"") }}>Katolik</option>
                                <option value="buddha" {{ (old("user_type") == "budhaa" ? "selected":"") }}>Buddha</option>
                                <option value="hindu" {{ (old("user_type") == "hindu" ? "selected":"") }}>Hindu</option>
                                <option value="konghucu" {{ (old("user_type") == "konghucu" ? "selected":"") }}>Kong Hu Cu</option>
                                <option value="lainnya" {{ (old("user_type") == "lainnya" ? "selected":"") }}>Lainnya</option>
                            </select>
                            @error('agama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Pilihan tidak ditemukan</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group text-center">
                            <button class="btn btn-md btn-primary w-25">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection