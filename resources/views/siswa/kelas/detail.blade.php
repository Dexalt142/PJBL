@extends('layouts.siswa')

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
            <button class="dropdown-item" href="#" data-toggle="modal" data-target="#keluarKelasModal">Keluar</button>
        </div>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('siswa-dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">{{ $kelas->nama }}</li>
@endsection

@section('content')
    <div class="container-fluid">

        <section class="section">
            <div class="section-header">
                <div class="section-title">
                    Project kelas
                </div>
            </div>
            <div class="row">
                @forelse ($kelas->project as $project)
                    @component('component.siswa.card-project')
                        @slot('project', $project)
                    @endcomponent
                @empty
                    <div class="col-12 mb-2">
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kelas->siswa as $siswa)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $siswa->nis }}</td>
                                                <td>{{ $siswa->nama_lengkap }}</td>
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

    <div class="modal fade" id="keluarKelasModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Keluar kelas</h5>
                </div>
                <div class="modal-body">
                    Apakah anda yakin akan keluar dari kelas ini?
                </div>
                
                <div class="modal-footer">
                    <form action="{{ route("siswa-kelas-leave") }}" method="POST">
                        @csrf
                        <input type="hidden" name="kode_kelas" value="{{ $kelas->kode_kelas }}">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    
@endsection