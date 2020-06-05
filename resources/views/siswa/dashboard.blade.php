@extends('layouts.siswa')

@section('page-title', 'Dashboard')
@section('page-header', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="container-fluid">
         <section class="section">
            <div class="section-header">
                <div class="section-title">
                    Kelas anda
                </div>
                <div class="section-menu">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#gabungKelasModal">Gabung kelas</button>
                </div>
            </div>
            <div class="row row-kelas">

                @forelse (auth()->user()->detail->kelas as $kelas)
                    @component('component.siswa.card-kelas')
                        @slot('kelas', $kelas)
                    @endcomponent
                @empty
                {{ "Anda belum memiliki kelas" }}
                @endforelse
                
            </div>
        </section>
    </div>

    <div class="modal fade" id="gabungKelasModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gabung ke dalam kelas</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('siswa-kelas-join') }}" method="POST">
                    @csrf
                    <input type="hidden" name="r" value="{{ route('siswa-dashboard') }}">
                    <div class="form-group">
                        <label for="kode_kelas">Kode kelas</label>
                        <input type="text" class="form-control @error('kode_kelas') is-invalid @enderror" name="kode_kelas" placeholder="Kode kelas" value="{{ old('kode_kelas') }}" required>
                        @error('kode_kelas')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Gabung</button>
                </form>
            </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @error('kode_kelas')
        <script>
            $("#gabungKelasModal").modal('show');
        </script>
    @enderror

    <script>
        $(".card-kelas").on('click', function() {
            var target = "{{ route('siswa-kelas-detail', '') }}";
            target = target + '/' + $(this).attr('kelas-target');
            window.location.href = target;
        });
    </script>
@endsection
