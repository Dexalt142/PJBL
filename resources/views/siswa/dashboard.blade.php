@extends('layouts.siswa')

@section('content')
    <div class="container-fluid" style="height: 200vh">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            Kelas anda
                        </div>
                        <div class="row row-kelas">
                            @forelse (auth()->user()->detail->kelas as $kelas)
                            <div class="col-md-6 mb-4 card-wrapper">
                                <div class="card-kelas">
                                    <div class="card-face">
                                        <div class="card-title">
                                            {{ $kelas->nama }}
                                        </div>
                                    </div>

                                    <div class="card-content">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-4">Kode Kelas</div>
                                                <div class="col-md-8">: {{ $kelas->kode_kelas }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Nama Guru</div>
                                                <div class="col-md-8">: {{ $kelas->guru->nama_lengkap }}</div>
                                            </div>
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

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            Statistik
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection
