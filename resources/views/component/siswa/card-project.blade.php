<div class="col-12 mb-4">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h4 class="m-0 f-w-700">
                        <a href="{{ route("siswa-project-detail", $project->id) }}">{{ $project->nama_project }}</a>
                    </h4>
                    <span class="badge badge-pill badge-primary">
                        {{ $project->kelas->nama }}
                    </span>
                </div>

                <div class="col-md-4 mb-4">
                    <h5><ion-icon name="calendar-outline"></ion-icon> Tanggal pembuatan</h5>
                    {{ Carbon\Carbon::parse($project->created_at)->format("d M Y H:i:s") }}
                </div>

                <div class="col-md-4 mb-4">
                    <h5><ion-icon name="albums-outline"></ion-icon> Jumlah Fase</h5>
                    {{ $project->fase->count() }}
                </div>
            </div>
        </div>
    </div>
</div>