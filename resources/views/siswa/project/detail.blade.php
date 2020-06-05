@extends('layouts.siswa')

@section('page-title', $project->nama_project)
@section('page-header', $project->nama_project)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('siswa-dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('siswa-kelas-detail', $project->kelas->kode_kelas) }}">{{ $project->kelas->nama }}</a></li>
    <li class="breadcrumb-item active">{{ $project->nama_project }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <section class="section">
            <div class="section-header">
                <div class="section-title">
                    Kelompok anda
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    @if ($kelompok)
                        @component('component.siswa.card-kelompok')
                            @slot('kelompok', $kelompok)
                        @endcomponent
                    
                        @else
                        Anda belum memiliki kelompok
                    @endif
                </div>
            </div>
        </section>

        <section class="section">
            <div class="section-header">
                <div class="section-title">
                    Fase
                </div>
            </div>

            <div class="row">
                @if ($kelompok)
                @foreach ($project->fase->sortBy('fase_ke') as $fase)
                    @component('component.siswa.card-fase')
                    @slot('fase', $fase)
                    @slot('kelompok', $kelompok)
                    @endcomponent
                @endforeach
                @endif
            </div>
        </section>
    </div>
@endsection

@section('scripts')

@endsection