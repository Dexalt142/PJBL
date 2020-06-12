@extends('layouts.guru')

@section('page-title', 'Kelas')
@section('page-header', 'Kelas')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('guru-dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Kelas</li>
@endsection

@section('content')
    <div class="container-fluid">
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

                @forelse ($listKelas as $kelas)
                    @component('component.guru.card-kelas')
                        @slot('kelas', $kelas)
                    @endcomponent
                @empty
                {{ "Anda belum memiliki kelas" }}
                @endforelse
                
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
