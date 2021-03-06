<div class="col-12 mb-4">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h4 class="m-0 f-w-700">
                        <a href="{{ route("siswa-project-detail", [$project->kelas->kode_kelas, $project->id]) }}">{{ $project->nama_project }}</a>
                    </h4>
                    <span class="badge badge-pill badge-primary">
                        {{ $project->kelas->nama }}
                    </span>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="info-box p-0">
                        <div class="icon">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </div>
                        <div class="content">
                            <div class="title">
                                Tanggal Pembuatan
                            </div>
                            <div class="subtitle">
                                {{ Carbon\Carbon::parse($project->created_at)->format("d M Y H:i") }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="info-box p-0">
                        <div class="icon">
                            <ion-icon name="albums-outline"></ion-icon>
                        </div>
                        <div class="content">
                            <div class="title">
                                Jumlah Fase
                            </div>
                            <div class="subtitle">
                                {{ $project->fase->count() }} Fase
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>