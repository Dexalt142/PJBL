<div class="col-md-6 col-lg-4 mb-4 card-wrapper">
    <div class="card-kelas" kelas-target="{{ $kode_kelas }}">
        <div class="card-body">
            <div class="container">
                <div class="f-w-400">
                    {{ $kode_kelas }}
                </div>
                <div class="f-w-700" style="font-size: 1.25rem">
                    {{ $nama_kelas }}
                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-6">
                    <div class="card-information">
                        <div class="title">
                            {{ $jumlah_siswa }}
                        </div>
                        <div class="subtitle">
                            Siswa
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card-information">
                        <div class="title">
                            {{ $jumlah_project }}
                        </div>
                        <div class="subtitle">
                            Project
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>