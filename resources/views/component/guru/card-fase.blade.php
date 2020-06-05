<div class="fase">
    <div class="number">
        {{ $fase->fase_ke }}
    </div>
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <h4 class="m-0 f-w-700 mb-2">
                            {{ $fase->nama_fase }}
                        </h4>
                        <p>
                            {{ $fase->materi }}
                        </p>
                    </div>
                    
                    <div class="col-md-12 mb-4">
                        <div class="row">              
                            <div class="col-md-4">
                                <div class="info-box">
                                    <div class="icon">
                                        <ion-icon name="calendar-outline"></ion-icon>
                                    </div>
                                    <div class="content">
                                        <div class="title">
                                            Deadline
                                        </div>
                                        <div class="subtitle">
                                            {{ \Carbon\Carbon::parse($fase->deadline)->format("d M Y H:i") }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col-md-4">
                                <div class="info-box">
                                    <div class="icon">
                                        <ion-icon name="document-outline"></ion-icon>
                                    </div>
                                    <div class="content">
                                        <div class="title">
                                            Tipe Fase
                                        </div>
                                        <div class="subtitle">
                                            {{ ucfirst($fase->fase_type) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col-md-4">
                                <div class="info-box">
                                    <div class="icon">
                                        <ion-icon name="people-outline"></ion-icon>
                                    </div>
                                    <div class="content">
                                        <div class="title">
                                            Kelompok Selesai
                                        </div>
                                        <div class="subtitle">
                                            0 Kelompok
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('guru-fase-detail', [$fase->project->kelas->kode_kelas, $fase->project->id, $fase->id]) }}" class="btn btn-primary">Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>