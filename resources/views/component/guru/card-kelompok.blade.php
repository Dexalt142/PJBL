<div class="col-md-6 mb-4">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                {{ $kelompok->nama_kelompok }}<br>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    Anggota: 
                    @foreach ($kelompok->anggota() as $anggota)
                    <div>
                        {{ $loop->iteration.". ".$anggota->nama_lengkap }}
                    </div>
                    @endforeach
                </div>

                <div class="col-md-6">
                    <div class="info-box">
                        <div class="icon">
                            <ion-icon name="stats-chart-outline"></ion-icon>
                        </div>
                        <div class="content">
                            <div class="title">
                                Progress
                            </div>
                            <div class="subtitle">
                                @php
                                    $prog = $kelompok->fase->sortByDesc('id')->first();
                                @endphp
                                @if ($prog)
                                    <a href="{{ route('guru-fase-detail', [$prog->project->kelas->kode_kelas, $prog->project_id, $prog->id]) }}">{{ $prog->nama_fase }}</a>
                                @else
                                    Belum mengerjakan
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <button class="btn btn-primary edit-kelompok" data-kelompok-id="{{ $kelompok->id }}">Edit</button>
                </div>
            </div>
        </div>
    </div>
</div>