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
                        <h1>{{ $jumlahSiswa }}</h1>
                        <h5>Jumlah Siswa</h5>
                    </div>
                </div>
            </div>
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
                        <h1>{{ $projects->count() }}</h1>
                        <h5>Jumlah Project</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h1>{{ $jumlahFase }}</h1>
                        <h5>Jumlah Fase</h5>
                    </div>
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
                        @slot('kelas', $kelas)
                    @endcomponent
                @empty
                {{ "Anda belum memiliki kelas" }}
                @endforelse
                
            </div>
        </section>

        <section class="section">
            <div class="section-header">
                <div class="section-title">
                    Project terbaru
                </div>
            </div>

            <div class="row">
                @foreach ($projects->sortByDesc('created_at')->take(3) as $project)
                    @component('component.guru.card-project')
                        @slot('project', $project)
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
                <form action="{{ route('guru-kelas-create') }}" method="POST">
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
    @error('nama_kelas')
        <script>
            $("#createKelasModal").modal('show');
        </script>
    @enderror

    <script>
        $(".card-kelas").on('click', function() {
            var target = "{{ route('guru-kelas-detail', '') }}";
            target = target + '/' + $(this).attr('kelas-target');
            window.location.href = target;
        });
    </script>
@endsection
