@php
    $status = $fase->getStatus($kelompok->id);
    $s = '';
    if($status == 0)  {
        $s = 'locked';
    } else if($status == 2)  {
        $s = 'done';
    }

    $f = $fase->faseDetail($kelompok->id);
    $s2 = 'Terkunci';
    if($s == '') {
        $s2 = 'Tersedia';
        if($f && $f->status == 1) {
            $s2 = 'Telah dikerjakan';
        }
    } else {
        if($f) {
            if($f->status == 1) {
                $s2 = 'Telah dikerjakan';
            } else if($f->status == 2) {
                $s2 = 'Telah dinilai';
            }
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
                    <div class="col-md-8 mb-3">
                        <h4 class="m-0 f-w-700 mb-2">
                            {{ $fase->nama_fase }}
                        </h4>
                        <p>
                            @if ($s != 'locked')
                                {{ $fase->deskripsi }}
                            @endif
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
                            <ion-icon name="help-outline"></ion-icon> Status: {{ $s2 }}
                        </div>
                        @if ($s2 == 'Telah dinilai')
                            <div class="f-w-700">
                                <ion-icon name="analytics-outline"></ion-icon> Nilai: {{ $f->nilai }}
                            </div>
                        @endif
                    </div>
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