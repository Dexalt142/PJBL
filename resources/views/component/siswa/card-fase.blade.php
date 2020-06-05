@php
    $status = $fase->getStatus($kelompok->id);
    $s = '';
    if($status == 0)  {
        $s = 'locked';
    } else if($status == 2)  {
        $s = 'done';
    }

    $f = $fase->faseDetail($kelompok->id);
    $s2 = 'Tersedia';
    
    if($f) {
        if($f->status == '1') {
            $s2 = 'Telah dikerjakan';
        } else if($f->status == '2') {
            $s = 'done';
            $s2 = 'Telah dinilai';
        }
    } else {
        if($s != '') {
            $s2 = 'Terkunci';
        }
    }
    
    
@endphp

<div class="fase {{ $s }}">
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
                            @if ($s != 'locked')
                                {{ $fase->materi }}
                            @endif
                        </p>
                    </div>

                    @if($s != 'locked')
                    <div class="col-md-12 mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="info-box">
                                    <div class="icon">
                                        <ion-icon name="calendar-outline"></ion-icon>
                                    </div>
                                    <div class="content">
                                        <div class="title">
                                            Status
                                        </div>
                                        <div class="subtitle">
                                            {{ \Carbon\Carbon::parse($fase->deadline)->format("d M Y H:i") }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
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

                            <div class="col-md-3">
                                <div class="info-box">
                                    <div class="icon">
                                        <ion-icon name="checkbox-outline"></ion-icon>
                                    </div>
                                    <div class="content">
                                        <div class="title">
                                            Status
                                        </div>
                                        <div class="subtitle">
                                            {{ $s2 }}
                                        </div>
                                    </div>
                                </div>  
                            </div>

                            @if ($s2 == 'Telah dinilai')
                            <div class="col-md-3">
                                <div class="info-box">
                                    <div class="icon">
                                        <ion-icon name="thumbs-up-outline"></ion-icon>
                                    </div>
                                    <div class="content">
                                        <div class="title">
                                            Status
                                        </div>
                                        <div class="subtitle">
                                            {{ $f->nilai }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                          @endif

                        </div>
                    </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-12">
                        @if ($status != 0)                        
                            <a href="{{ route('siswa-fase-detail', [$fase->project->kelas->kode_kelas, $fase->project->id, $fase->id]) }}" class="btn btn-primary">Detail</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>