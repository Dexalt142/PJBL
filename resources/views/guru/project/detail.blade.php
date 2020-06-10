@extends('layouts.guru')

@section('page-title', $project->nama_project)

@section('page-header')
    {{ $project->nama_project }}
    <div class="dropdown d-inline-block">
        <button class="btn btn-link dropdown-toggle" type="button" id="kelasMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Pengaturan
        </button>
        <div class="dropdown-menu" aria-labelledby="kelasMenuButton">
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editProjectModal">Edit</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteProjectModal">Hapus</a>
        </div>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('guru-dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('guru-kelas-detail', $project->kelas->kode_kelas) }}">{{ $project->kelas->nama }}</a></li>
    <li class="breadcrumb-item active">{{ $project->nama_project }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <section class="section">
            <div class="section-header">
                <div class="section-title">
                    Kelompok {{ ($noGroup->count() > 0) ? ("- ".$noGroup->count()." siswa belum memiliki kelompok") : '' }}
                </div>
                <div class="section-menu">
                    @if ($project->kelompok->count() == 0)
                        <button class="btn btn-primary" data-toggle="modal" data-target="#createKelompokModal">Buat kelompok</button>
                    @endif
                </div>
            </div>

            <div class="row">
                @forelse ($project->kelompok as $kelompok)
                    @component('component.guru.card-kelompok')
                        @slot('kelompok', $kelompok)
                    @endcomponent
                @empty
                <div class="col-12 mb-2">
                    Belum ada kelompok yang dibuat
                </div>
                @endforelse

            </div>
            @if ($noGroup->count() > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">Siswa yang belum memiliki kelompok</div>
                                @foreach ($noGroup as $siswa)
                                <div>
                                    {{ $loop->iteration.". ".$siswa->nama_lengkap }}
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section>

        <section class="section">
            <div class="section-header">
                <div class="section-title">
                    Fase
                </div>
                <div class="section-menu">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#createFaseModal">Buat fase</button>
                </div>
            </div>

            <div class="row">
                @if (Session::has('faseSuccess'))    
                    <div class="col-12">
                        <div class="alert alert-success">{{ Session::get('faseSuccess') }}</div>
                    </div>
                @endif

                @error ('faseFail')    
                    <div class="col-12">
                        <div class="alert alert-danger">{{ $message }}</div>
                    </div>
                @enderror

                @forelse ($project->fase->sortBy('fase_ke') as $fase)
                    @component('component.guru.card-fase')
                        @slot('fase', $fase)
                    @endcomponent
                @empty
                <div class="col-12 mb-2">
                    Belum ada fase yang dibuat 
                </div>
                @endforelse
            </div>
        </section>
    </div>

    @if ($project->kelompok->count() == 0)   
        <div class="modal fade" id="createKelompokModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Buat kelompok</h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route("guru-kelompok-generate", [$project->kelas->kode_kelas, $project->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_project" value="{{ $project->id }}">
                            <div class="form-group">
                                <label for="jumlah_siswa">Jumlah siswa per kelompok</label>
                                <input type="number" min="1" jumlah-siswa="{{ $project->kelas->siswa->count() }}" class="form-control @error('jumlah_siswa') is-invalid @enderror" name="jumlah_siswa" placeholder="Jumlah siswa" value="{{ old('jumlah_siswa') }}" required>
                                @error('jumlah_siswa')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                
                                <div id="kelhint" class="mt-2"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Buat</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($project->kelompok->count() > 0)   
        <div class="modal fade" id="editKelompokModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Kelompok</h5>
                    </div>
                    <div class="modal-body">
                        
                        <div>
                            <div class="form-group">
                                <label for="">Anggota</label>
                                <div class="list-anggota"></div>
                            </div>
                        </div>

                        @if ($noGroup->count() > 0)
                        <hr>
                        <form action="{{ route('guru-anggota-tambah', [$project->kelas->kode_kelas, $project->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="tambah_kel_id">
                            <div class="form-group">
                                <label for="tambah_anggota">Tambah Anggota</label>
                                <select name="siswa_id" class="form-control">
                                    @foreach ($noGroup as $siswa)
                                        <option value="{{ $siswa->pivot->id }}">{{ $siswa->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary">Tambah anggota</button>
                            </div>
                        </form>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="modal fade" id="editProjectModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit project</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route("guru-project-edit" , [$project->kelas->kode_kelas, $project->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="project" value="{{ $project->id }}">
                    <div class="form-group">
                        <label for="nama_project">Nama project</label>
                        <input type="text" class="form-control @error('nama_project') is-invalid @enderror" name="nama_project" placeholder="Nama project" value="{{ $project->nama_project }}" required>
                        @error('nama_project')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteProjectModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus project</h5>
                </div>
                <div class="modal-body">
                    Apakah anda yakin akan menghapus project ini?
                </div>
                
                <div class="modal-footer">
                    <form action="{{ route("guru-project-hapus" , [$project->kelas->kode_kelas, $project->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="project" value="{{ $project->id }}">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createFaseModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat fase baru</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('guru-fase-create', [$project->kelas->kode_kelas, $project->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="r" value="{{ route('guru-project-detail', [$project->kelas->kode_kelas, $project->id]) }}">
                        <div class="form-group">
                            <label for="nama_fase">Nama fase</label>
                            <input type="text" class="form-control @error('nama_fase') is-invalid @enderror" name="nama_fase" placeholder="Nama fase" value="{{ old('nama_fase') }}" required>
                            @error('nama_fase')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="materi">Materi</label>
                            <textarea name="materi" class="form-control @error('materi') is-invalid @enderror" required>{{ old('materi') }}</textarea>
                            @error('materi')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="fase_type">Tipe Fase</label>
                            <select name="fase_type" class="form-control @error('fase_type') is-invalid @enderror">
                                <option value="materi" @if(old('fase_type') == "materi") {{ "selected" }} @endif>Materi</option>
                                <option value="tes" @if(old('fase_type') == "tes") {{ "selected" }} @endif>Tes</option>
                            </select>
                            @error('fase_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="deadline">Deadline</label>
                            <input type="datetime-local" class="form-control @error('deadline') is-invalid @enderror" name="deadline" min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" placeholder="Deadline" value="{{ old('deadline') }}" required>
                            @error('deadline')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <hr>

                        <div class="form-group mb-0">
                            <label for="">File materi</label>
                        </div>

                        <div class="form-group" id="file-materi">
                            <input type="file" class="form-control @error('fileMateri.*') is-invalid @enderror" name="fileMateri[]">
                            @error('fileMateri.*')
                                <span class="invalid-feedback" role="alert">
                                    <strong>File yang dapat diupload hanya docx, doc, pptx, pdf, rar, zip.</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <button type="button" class="btn btn-sm btn-info" id="tambahFileButton">Tambah file</button>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Buat project</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
@endsection

@section('scripts')
    <script>
        @if($errors->has('fileMateri.*') || $errors->has('nama_fase') || $errors->has('materi') || $errors->has('fase_type') || $errors->has('deadline'))
            $("#createFaseModal").modal('show');
        @endif

        @error('nama_project')
            $("#editProjectModal").modal('show');
        @enderror

        var anggotaChanged = false;

        $("#tambahFileButton").on('click', function() {
            var inputFile = $("#file-materi");
            inputFile.clone().insertAfter($("#file-materi"));
        });

        $(".edit-kelompok").on('click', function() {
            var btn = $(this);
            $("input[name='tambah_kel_id']").val(btn.data('kelompok-id'));
            $.ajax({
                url: "{{ route('api-anggota') }}",
                method: "POST",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'kelompok_id': btn.data('kelompok-id')
                },
                success: function(response) {
                    if(response.success) {
                        var list = $(".list-anggota");
                        list.html("");
                        for(let i = 0; i < response.data.length; i++) {
                            let anggota = "<div class='mb-3 d-flex anggota-item'><span>" + ((i+1) + ". ") + response.data[i].nama_lengkap + "</span><span class='ml-auto'><button class='btn btn-sm btn-danger btn-hapus-anggota' data-kelid='" + btn.data('kelompok-id') + "' data-sisid='" + response.data[i].id + "'>Hapus</button></span></div>";
                            list.append(anggota);
                        }
                        $("#editKelompokModal").modal('show');
                    }
                }
            });
        });

        $(".list-anggota").on('click', '.btn-hapus-anggota', function() {
            if(confirm("Apakah anda yakin akan menghapus anggota ini?")) {
                var btn = $(this);
                $.ajax({
                    url: "{{ route('guru-anggota-hapus', [$project->kelas->kode_kelas, $project->id]) }}",
                    method: "POST",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'kelompok_id': btn.data('kelid'),
                        'siswa_id': btn.data('sisid')
                    },
                    success: function(response) {
                        if(response.success) {
                            btn.closest('.anggota-item').fadeOut('normal', function() {
                                $(this).remove();
                            });
                            anggotaChanged = true;
                        }
                    }
                });
            }
        });

        $('#editKelompokModal').on('hidden.bs.modal', function() {
            if(anggotaChanged) {
                location.reload();
            }
        });

        $("input[name='jumlah_siswa']").on('input', function() {
            var hint = $("#kelhint");
            var jumlahSiswa = $(this).attr('jumlah-siswa');
            var curr = $(this).val();
            if(curr < 1 || curr > jumlahSiswa || curr == "") {
                hint.text("Jumlah kelompok: -");
            } else {
                hint.text("Jumlah kelompok: " + (jumlahSiswa / curr));
            }
        });
    </script>
@endsection