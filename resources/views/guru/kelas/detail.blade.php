@extends('layouts.guru')

@section('page-title')
    {{ $kelas->nama }}
@endsection

@section('page-header')
    {{ $kelas->nama }}
    <div class="dropdown d-inline-block">
        <button class="btn btn-link dropdown-toggle" type="button" id="kelasMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Pengaturan
        </button>
        <div class="dropdown-menu" aria-labelledby="kelasMenuButton">
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editKelasModal">Edit</a>
            <a class="dropdown-item" href="#" id="generateKodeKelas">Generate Kode</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Hapus</a>
        </div>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('guru-dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Kelas</li>
@endsection

@section('content')
    <div class="container-fluid">

        <section class="section">
            <div class="section-header">
                <div class="section-title">
                    Project kelas
                </div>
                <div class="section-menu">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#createProjectModal">Buat project</button>
                </div>
            </div>
            <div class="row">
                @forelse ($kelas->project as $project)
                    @component('component.guru.card-project')
                        @slot('project', $project)
                    @endcomponent
                @empty
                    <div class="col-12">
                        Belum ada project saat ini.
                    </div>
                @endforelse
            </div>
        </section>

        <section class="section">
            <div class="section-header">
                <div class="section-title">
                    Daftar Siswa
                </div>
                <div class="section-menu">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#inviteStudentModal">Undang Siswa</button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIS</th>
                                            <th>Nama</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Jenis Kelamin</th>
                                            <th></th>
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
                                                <td><button class="btn btn-sm btn-danger">Hapus</button></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="createProjectModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat project baru</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('guru-project-create') }}" method="POST">
                    @csrf
                    <input type="hidden" name="r" value="{{ route('guru-kelas-detail', $kelas->kode_kelas) }}">
                    <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                    <div class="form-group">
                        <label for="nama_project">Nama project</label>
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

    <div class="modal fade" id="inviteStudentModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Undang siswa</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route("guru-kelas-invite", $kelas->kode_kelas) }}" method="POST">
                    @csrf
                    <input type="hidden" name="r" value="{{ route('guru-kelas-detail', $kelas->kode_kelas) }}">
                    <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                    <div class="form-group">
                        <label for="email_siswa">Email siswa</label>
                        <input type="email" class="form-control @error('undang_siswa') is-invalid @enderror" name="email_siswa" placeholder="Email siswa" value="{{ old('email_siswa') }}" required>
                        @error('undang_siswa')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Undang</button>
                </form>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editKelasModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit kelas</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route("guru-kelas-edit" , $kelas->kode_kelas) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama_kelas">Nama kelas</label>
                        <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" name="nama_kelas" placeholder="Nama kelas" value="{{ $kelas->nama }}" required>
                        @error('nama_kelas')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    @error('nama_kelas')
        <script>
            $("#editKelasModal").modal('show');
        </script>
    @enderror
    @error('nama_project')
        <script>
            $("#createProjectModal").modal('show');
        </script>
    @enderror
    @error('undang_siswa')
        <script>
            $("#inviteStudentModal").modal('show');
        </script>
    @enderror

    <script>
        $("#generateKodeKelas").on('click', function() {
            $.ajax({
                url: '{{ route("guru-kelas-gencode", $kelas->kode_kelas) }}',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "kode_kelas": '{{ $kelas->kode_kelas }}',
                },
                success: function(response) {
                    if(response.success == 'true') {
                        window.location.href = '{{ route("guru-kelas-detail", '') }}' + '/' + response.kode_kelas;
                    }
                }
            });
        });
    </script>
@endsection