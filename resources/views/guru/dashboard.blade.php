@extends('layouts.guru')

@section('page-title', 'Dashboard')
@section('page-header', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h1>{{ auth()->user()->detail->kelas->count() }}</h1>
                        <h5>Jumlah Kelas</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h1>3</h1>
                        <h5>Jumlah Siswa</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h1>0</h1>
                        <h5>Jumlah Proyek</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">A</div>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="section-header">
                <div class="section-title">
                    Kelas anda
                </div>
                <div class="section-menu">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#createKelasModal">Buat kelas</button>
                </div>
            </div>
            <div class="row row-kelas">

                @forelse (auth()->user()->detail->kelas as $kelas)
                    @component('component.guru.card-kelas')
                        @slot('kode_kelas', $kelas->kode_kelas)
                        @slot('nama_kelas', $kelas->nama)
                        @slot('jumlah_siswa', $kelas->siswa->count())
                        @slot('jumlah_project', $kelas->project->count())
                    @endcomponent
                @empty
                {{ "Anda belum memiliki kelas" }}
                @endforelse
                
            </div>
        </section>

        <section class="section">
            <div class="section-header">
                <div class="section-title">
                    Project
                </div>
                <div class="section-menu">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#createKelasModal">Buat project</button>
                </div>
            </div>

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
        </section>
    </div>

    <div class="modal fade" id="createKelasModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat kelas baru</h5>
            </div>
            <div class="modal-body">
                <form action="{{ url('/guru/kelas/buat') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama_kelas">Nama kelas</label>
                        <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" name="nama_kelas" placeholder="Nama kelas" value="{{ old('nama_kelas') }}" required>
                        @error('nama_kelas')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Buat Kelas</button>
                </form>
            </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @if ($errors->any())
        <script>
            $("#createKelasModal").modal('show');
        </script>
    @endif

    <script>
        $(".card-kelas").on('click', function() {
            var target = "{{ url('guru/kelas') }}";
            target = target + '/' + $(this).attr('kelas-target');
            window.location.href = target;
        });
    </script>
@endsection
