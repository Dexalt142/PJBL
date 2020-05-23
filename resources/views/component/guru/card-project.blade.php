<div class="col-12 mb-4">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h4 class="m-0 f-w-700">
                        <a href="{{ url("guru/project/$id_project") }}">{{ $nama_project }}</a>
                    </h4>
                    <span class="badge badge-pill badge-primary">
                        {{ $nama_kelas }}
                    </span>
                </div>

                <div class="col-md-4 mb-4">
                    <h5>Tanggal pembuatan</h5>
                    {{ Carbon\Carbon::parse($tanggal_pembuatan)->format("d M Y H:i:s") }}
                </div>

                <div class="col-md-4 mb-4">
                    <h5>Jumlah Kelompok</h5>
                    {{ $jumlah_kelompok }}
                </div>
            </div>
        </div>
    </div>
</div>