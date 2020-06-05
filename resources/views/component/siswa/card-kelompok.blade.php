<div class="card">
    <div class="card-body">
        <div class="card-title">
            {{ $kelompok->nama_kelompok }}
        </div>
        <div>
            @foreach ($kelompok->anggota() as $anggota)
                <div>{{ $loop->iteration.". ".$anggota->nama_lengkap }}</div>
            @endforeach
        </div>
    </div>
</div>