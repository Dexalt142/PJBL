@extends('layouts.guru')

@section('page-title')
    {{ $kelas->nama }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Kelas</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <div class="card-title">Project Kelas</div>
                            <div class="card-menu">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#createProjectModal">Buat project</button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama project</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kelas->project as $project)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $project->nama_project }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Daftar Siswa</div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Jenis Kelamin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kelas->siswa as $siswa)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $siswa->nis }}</td>
                                            <td>{{ $siswa->nama_lengkap }}</td>
                                            <td>{{ Carbon\Carbon::parse($siswa->tanggal_lahir)->format("d M Y") }}</td>
                                            <td>{{ ($siswa->jenis_kelamin == 1) ? 'Laki-laki' : 'Perempuan' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createProjectModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat project baru</h5>
            </div>
            <div class="modal-body">
                <form action="{{ url('/guru/project/buat') }}" method="POST">
                    @csrf
                    <input type="hidden" name="r" value="{{ route('kelas-detail', $kelas->kode_kelas) }}">
                    <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                    <div class="form-group">
                        <label for="nama_kelas">Nama project</label>
                        <input type="text" class="form-control @error('nama_project') is-invalid @enderror" name="nama_project" placeholder="Nama project" value="{{ old('nama_project') }}" required>
                        @error('nama_project')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Buat project</button>
                </form>
            </div>
            </div>
        </div>
    </div>
@endsection