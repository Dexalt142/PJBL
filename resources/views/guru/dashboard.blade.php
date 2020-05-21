@extends('layouts.guru')

@section('page-title', 'Dashboard')

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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <div class="card-title">
                                Kelas anda
                            </div>
                            <div class="card-menu">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#createKelasModal">Buat kelas</button>
                            </div>
                        </div>
                        <div class="row row-kelas">

                            @forelse (auth()->user()->detail->kelas as $kelas)
                            <div class="col-md-6 col-lg-4 mb-4 card-wrapper">
                                <div class="card-kelas" kelas-target="{{ $kelas->kode_kelas }}">
                                    <div class="card-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-4">Kode Kelas</div>
                                                <div class="col-md-8">: <span class=" f-w-700">{{ $kelas->kode_kelas }}</span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Jumlah Siswa</div>
                                                <div class="col-md-8">: <span class=" f-w-700">{{ $kelas->siswa->count() }}</span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Jumlah Proyek</div>
                                                <div class="col-md-8">: <span class=" f-w-700">{{ $kelas->project->count() }}</span></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <div class="card-title">
                                            {{ $kelas->nama }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            {{ "Anda belum memiliki kelas" }}
                            @endforelse
                            
                        </div>

                    </div>
                </div>
            </div>
        </div>
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
