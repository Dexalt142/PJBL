<div class="fase">
    <div class="number">
        {{ $fase->fase_ke }}
    </div>
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <h4 class="m-0 f-w-700 mb-2">
                            {{ $fase->nama_fase }}
                        </h4>
                        <p>
                            {{ $fase->deskripsi }}
                        </p>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="f-w-700">
                            <ion-icon name="calendar-outline"></ion-icon> Deadline: {{ \Carbon\Carbon::parse($fase->deadline)->format("d M Y H:i:s") }}
                        </div>
                        <div class="f-w-700">
                            <ion-icon name="document-outline"></ion-icon> Tipe fase: {{ ucfirst($fase->fase_type) }}
                        </div>
                        <div class="f-w-700">
                            <ion-icon name="checkbox-outline"></ion-icon> Kelompok selesai: 0
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('guru-fase-detail', [$fase->project->id, $fase->id]) }}" class="btn btn-primary">Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>