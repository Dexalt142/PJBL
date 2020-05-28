<div class="col-12 mb-4">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h4 class="m-0 f-w-700">
                        {{ $fase->nama_fase }}
                    </h4>
                </div>

                <div class="col-md-4 mb-4">
                    <h5><ion-icon name="calendar-outline"></ion-icon> Deadline</h5>
                    {{ \Carbon\Carbon::parse($fase->deadline)->format("d M Y H:i:s") }}
                </div>

                <div class="col-md-4 mb-4">
                    <h5><ion-icon name="people-outline"></ion-icon> Kelompok selesai</h5>
                    
                </div>
            </div>
        </div>
    </div>
</div>