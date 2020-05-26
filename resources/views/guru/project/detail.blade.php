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
        <section class="section">
            <div class="section-header">
                <div class="section-title">
                    Kelompok
                </div>
                <div class="section-menu">
                    @if ($project->kelompok->count() == 0)
                        <button class="btn btn-primary" data-toggle="modal" data-target="#createKelompokModal">Buat kelompok</button>
                    @endif
                </div>
            </div>

            <div class="row">
                @if ($project->kelompok->count() > 0)    
                    @foreach ($project->kelompok as $kelompok)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    {{ $kelompok->nama_kelompok }}<br>
                                </div>
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
                @endif
            </div>
        </section>
    </div>

    @if ($project->kelompok->count() == 0)   
        <div class="modal fade" id="createKelompokModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Buat kelompok</h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url("/guru/project/$project->id/gen-kelompok") }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_project" value="{{ $project->id }}">
                            <div class="form-group">
                                <label for="jumlah_siswa">Jumlah siswa per kelompok</label>
                                <input type="number" min="1" jumlah-siswa="{{ $project->kelas->siswa->count() }}" class="form-control @error('jumlah_siswa') is-invalid @enderror" name="jumlah_siswa" placeholder="Jumlah siswa" value="{{ old('jumlah_siswa') }}" required>
                                @error('jumlah_siswa')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                
                                <div id="kelhint" class="mt-2"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Buat</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        console.log()
        $("input[name='jumlah_siswa']").on('input', function() {
            var hint = $("#kelhint");
            var jumlahSiswa = $(this).attr('jumlah-siswa');
            var curr = $(this).val();
            if(curr < 1 || curr > jumlahSiswa || curr == "") {
                hint.text("Jumlah kelompok: -");
            } else {
                hint.text("Jumlah kelompok: " + (jumlahSiswa / curr));
            }
        });
    </script>
@endsection