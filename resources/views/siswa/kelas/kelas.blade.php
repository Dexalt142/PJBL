@extends('layouts.siswa')

@section('page-title', 'Kelas')
@section('page-header', 'Kelas')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('siswa-dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Kelas</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row row-kelas">
            @foreach ($listKelas as $kelas)
                @component('component.siswa.card-kelas')
                    @slot('kelas', $kelas)
                @endcomponent
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
   <script>
        $(".card-kelas").on('click', function() {
            var target = "{{ route('siswa-kelas-detail', '') }}";
            target = target + '/' + $(this).attr('kelas-target');
            window.location.href = target;
        });
    </script>
@endsection
