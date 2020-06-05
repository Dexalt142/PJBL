@extends('layouts.siswa')

@section('page-title', $fase->nama_fase)
@section('page-header', $fase->nama_fase)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('siswa-dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('siswa-kelas-detail', $fase->project->kelas->kode_kelas) }}">{{ $fase->project->kelas->nama }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('siswa-project-detail', [$fase->project->kelas->kode_kelas, $fase->project->id]) }}">{{ $fase->project->nama_project }}</a></li>
    <li class="breadcrumb-item active">{{ $fase->nama_fase }}</li>
@endsection

@section('content')
    <div class="container-fluid">

        <section class="section">
            <div class="section-header">
                <div class="section-title">
                    Detail fase
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {{ $fase->materi }}
                            <hr>
                            @php
                                $notdeadline = false;
                                $notdone = false;
                                $partiallydone = false;
                                if($fase->deadline->greaterThan(now())) {
                                    $notdeadline = true;
                                    if (empty($faseKelompok) || ($faseKelompok && $faseKelompok->status == 1)) {
                                        $notdone = true;
                                    }
                                    if(($faseKelompok && $faseKelompok->status == 1)) {
                                        $partiallydone = true;
                                    }
                                }
                            @endphp
                            @if ($notdeadline && $notdone)
                                <form action="{{ route('siswa-fase-answer', [$fase->project->kelas->kode_kelas, $fase->project->id, $fase->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="kelompok_id" value="{{ $kelompok->id }}">
                                    <input type="hidden" name="fase_id" value="{{ $fase->id }}">
                            @endif
                                @if (!$notdeadline)
                                    <div class="alert alert-danger">Masa pengerjaan sudah habis</div>
                                @endif
                                @if(Session::has('jawabanSuccess'))
                                    <div class="alert alert-success">Jawaban berhasil dikirim</div>
                                @endif

                                <div class="form-group">
                                    <label for="jawaban">Jawaban</label>
                                    <textarea name="jawaban" class="form-control" @if(!$notdeadline || !$notdone) disabled @endif >@if($faseKelompok) {{ $faseKelompok->jawaban }} @endif</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="jawaban_file">File Jawaban</label>
                                    @if ($notdeadline && $notdone)
                                        <input type="file" class="form-control @error('jawaban_file') is-invalid @enderror" name="jawaban_file">
                                        @error('jawaban_file')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>File yang dapat diupload hanya docx, doc, pptx, pdf, rar, zip.</strong>
                                            </span>
                                        @enderror
                                    @endif
                                    @if ($faseKelompok && $faseKelompok->jawaban_file)
                                        <div>
                                            <a href="{{ url(config('app.answer_files').$faseKelompok->jawaban_file) }}" class="btn btn-link" download>{{ $faseKelompok->jawaban_file }}</a>
                                        </div>
                                    @endif
                                </div>

                                @if ($notdeadline && $notdone)
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit">Kirim jawaban</button>
                                    </div>
                                </form>
                                @endif

                            @if ($faseKelompok && $faseKelompok->status == 2)
                                <hr>
                                <div class="form-group">
                                    <label for="nilai">Nilai</label>
                                    <input type="number" class="form-control" value="{{ $faseKelompok->nilai }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="evaluasi">Evaluasi</label>
                                    <textarea class="form-control" disabled>{{ $faseKelompok->evaluasi ? $faseKelompok->evaluasi : 'Tidak ada evaluasi' }}</textarea>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        
    </div>

@endsection


@section('scripts')
   
@endsection