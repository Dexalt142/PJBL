@extends('layouts.guru')

@section('page-title', 'Project')
@section('page-header', 'Project')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('guru-dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Project</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            @foreach ($projects as $project)
                @component('component.guru.card-project')
                    @slot('id_project', $project->id)
                    @slot('nama_project', $project->nama_project)
                    @slot('nama_kelas', $project->kelas->nama)
                    @slot('tanggal_pembuatan', $project->created_at)
                    @slot('jumlah_kelompok', $project->kelompok->count())
                @endcomponent
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
   
@endsection
