@extends('layouts.guru')

@section('page-title', $project->nama_project)
@section('page-header', $project->nama_project)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('guru-dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('guru-kelas-detail', $project->kelas->kode_kelas) }}">{{ $project->kelas->nama }}</a></li>
    <li class="breadcrumb-item active">{{ $project->nama_project }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            @foreach ($project->kelompok as $kelompok)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            Kelompok {{ $loop->iteration }}<br>
                            <ol>
                                @foreach ($kelompok->anggota() as $anggota)
                                <li>
                                    {{ $anggota->nama_lengkap }}
                                </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
   
@endsection