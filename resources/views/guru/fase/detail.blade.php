@extends('layouts.guru')

@section('page-title', $fase->nama_fase)
@section('page-header', $fase->nama_fase)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('guru-dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('guru-kelas-detail', $fase->project->kelas->kode_kelas) }}">{{ $fase->project->kelas->nama }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('guru-project-detail', $fase->project->id) }}">{{ $fase->project->nama_project }}</a></li>
    <li class="breadcrumb-item active">{{ $fase->nama_fase }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <section class="section">
            <div class="section-header">
                <div class="section-title">
                    Detail Fase
                </div>
                <div class="section-menu">
                    <button class="btn btn-primary" id="editFaseButton">Edit Fase</button>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('guru-fase-edit', [$fase->project->id, $fase->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $fase->id }}">
                                <div class="form-group">
                                    <label for="nama_fase">Nama fase</label>
                                    <input type="text" class="form-control" name="nama_fase" value="{{ $fase->nama_fase }}" disabled>
                                </div>      

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fase_type">Tipe fase</label>
                                            <select name="fase_type" class="form-control" disabled>
                                                <option value="materi" @if($fase->fase_type == "materi") {{ "selected" }} @endif>Materi</option>
                                                <option value="tes" @if($fase->fase_type == "tes") {{ "selected" }} @endif>Tes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_fase">Deadline</label>
                                            <input type="datetime-local" class="form-control" name="deadline" value="{{ \Carbon\Carbon::parse($fase->deadline)->format("Y-m-d\TH:i:s") }}" disabled> 
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" row="2" disabled>{{ $fase->deskripsi }}</textarea>
                                </div>

                                <div class="form-group" id="actionGroup" style="display: none">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-link" id="cancelButton">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="section-header">
                <div class="section-title">
                    Progress Kelompok
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @foreach ($fase->kelompok as $k)
                                {{ $k}}
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection

@section('scripts')
    <script>
        $("#editFaseButton").on('click', function() {
            $("input[name='nama_fase']").prop('disabled', false).focus();
            $("select[name='fase_type']").prop('disabled', false);
            $("input[name='deadline']").prop('disabled', false);
            $("textarea[name='deskripsi']").prop('disabled', false);
            $("#actionGroup").css('display', 'block');
        });

        $("#cancelButton").on('click', function() {
            $("input[name='nama_fase']").prop('disabled', true);
            $("select[name='fase_type']").prop('disabled', true);
            $("input[name='deadline']").prop('disabled', true);
            $("textarea[name='deskripsi']").prop('disabled', true);
            $("#actionGroup").css('display', 'none');
        });
    </script>
@endsection