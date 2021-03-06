@extends('layouts.guru')

@section('page-title', $fase->nama_fase)
@section('page-header', $fase->nama_fase)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('guru-dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('guru-kelas-detail', $fase->project->kelas->kode_kelas) }}">{{ $fase->project->kelas->nama }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('guru-project-detail', [$fase->project->kelas->kode_kelas, $fase->project->id]) }}">{{ $fase->project->nama_project }}</a></li>
    <li class="breadcrumb-item active">{{ $fase->nama_fase }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <section class="section">
            <div class="section-header">
                <div class="section-title">
                    Detail Fase
                </div>
                <div class="section-menu">
                    <button class="btn btn-primary" id="editFaseButton">Edit Fase</button>
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

                @error ('fileMateri.*')    
                    <div class="col-12">
                        @if (Str::contains($message, "must be a file of type"))
                            <div class="alert alert-danger">File yang dapat diupload hanya docx, doc, pptx, pdf, rar, zip.</div>
                        @elseif(Str::contains($message, "kilobytes"))
                            <div class="alert alert-danger">Ukuran file maksimal adalah 10MB.</div>
                        @endif
                    </div>
                @enderror
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('guru-fase-edit', [$fase->project->kelas->kode_kelas, $fase->project->id, $fase->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $fase->id }}">
                                <div class="form-group">
                                    <label for="nama_fase">Nama fase</label>
                                    <input type="text" class="form-control" name="nama_fase" value="{{ $fase->nama_fase }}" disabled>
                                </div>      


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fase_type">Tipe fase</label>
                                            <select name="fase_type" class="form-control" disabled>
                                                <option value="materi" @if($fase->fase_type == "materi") {{ "selected" }} @endif>Materi</option>
                                                <option value="tes" @if($fase->fase_type == "tes") {{ "selected" }} @endif>Tes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_fase">Deadline</label>
                                            <input type="datetime-local" class="form-control" name="deadline" value="{{ \Carbon\Carbon::parse($fase->deadline)->format("Y-m-d\TH:i:s") }}" disabled> 
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="materi">Materi</label>
                                    <textarea name="materi" class="form-control" row="2" disabled>{{ $fase->materi }}</textarea>
                                </div>
                                
                                @if ($fase->fileMateri->isNotEmpty())
                                    <hr>
                                    <div class="form-group">
                                        <label for="">File Materi</label>
                                        @foreach ($fase->fileMateri as $fileMateri)
                                            <div>
                                                {{ $loop->iteration.". " }}
                                                <a href="{{ url(config('app.materi').$fase->project->kelas->kode_kelas.'/'.$fileMateri->nama_file) }}" download>{{ $fileMateri->nama_file }}</a>
                                                <span class="badge badge-sm btn-danger hapusFileMateriButton" style="cursor: pointer; user-select: none; display: none;" data-idf="{{ $fileMateri->id }}">Hapus</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div id="uploadFileMateri" style="display: none">
                                    <hr>
                                    <div class="form-group mb-0">
                                        <label for="">Upload file materi (max. 10MB)</label>
                                    </div>

                                    <div class="form-group" id="fileMateri">
                                        <input type="file" name="fileMateri[]" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-info" id="tambahFileButton">Tambah file</button>
                                    </div>
                                </div>


                                <div class="form-group" id="actionGroup" style="display: none">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-link" id="cancelButton">Batal</button>
                                    <button type="button" class="btn btn-danger ml-auto" data-toggle="modal" data-target="#deleteFaseModal">Hapus</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="section-header">
                <div class="section-title">
                    Progress Kelompok
                </div>
            </div>

            <div class="row">
                @foreach ($fase->project->kelompok as $k)
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    {{ $k->nama_kelompok }}
                                </div>
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            @foreach ($k->anggota() as $anggota)
                                                <div>
                                                    {{ $loop->iteration.". ".$anggota->nama_lengkap }}
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-md-6">
                                            @php
                                                $pg = $k->fase->firstWhere('id', $fase->id);
                                            @endphp
                                            @if ($pg)
                                                <div class="info-box">
                                                    <div class="icon">
                                                        <ion-icon name="checkbox-outline"></ion-icon>
                                                    </div>
                                                    <div class="content">
                                                        <div class="title">
                                                            Status
                                                        </div>
                                                        <div class="subtitle">
                                                            @if($pg->pivot->status == '1') {{ "Sudah mengumpulkan" }} @else {{ "Sudah dinilai" }} @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                @if ($pg->pivot->status == "2")
                                                <div class="info-box">
                                                    <div class="icon">
                                                        <ion-icon name="thumbs-up-outline"></ion-icon>
                                                    </div>
                                                    <div class="content">
                                                        <div class="title">
                                                            Nilai
                                                        </div>
                                                        <div class="subtitle">
                                                            {{ $pg->pivot->nilai }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            @else
                                                <div class="info-box">
                                                    <div class="icon">
                                                        <ion-icon name="checkbox-outline"></ion-icon>
                                                    </div>
                                                    <div class="content">
                                                        <div class="title">
                                                            Status
                                                        </div>
                                                        <div class="subtitle">
                                                            Belum mengerjakan
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if ($pg)
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <button class="btn btn-primary detailFaseButton" data-answer="{{ $pg->pivot->id }}" data-kelompok="{{ $k->nama_kelompok }}">Detail</button>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

    </div>

    <div class="modal fade" id="deleteFaseModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus fase</h5>
                </div>
                <div class="modal-body">
                    Apakah anda yakin akan menghapus fase {{ $fase->nama_fase }}?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('guru-fase-hapus', [$fase->project->kelas->kode_kelas, $fase->project->id, $fase->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="fase" value="{{ $fase->id }}">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailFaseModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="jawaban">Jawaban</label>
                        <textarea name="jawaban" class="form-control" disabled></textarea>
                    </div>

                    <div class="form-group">
                        <label for="jawaban_file">File Jawaban</label><br>
                        <a class="btn btn-link" name="jawaban_file"></a>
                    </div>

                    <hr>
                    <form action="{{ route('guru-fase-nilai', [$fase->project->kelas->kode_kelas, $fase->project->id, $fase->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="fk_id">
                        <div class="form-group">
                            <label for="jawaban">Nilai</label>
                            <input type="number" min="0" max="100" class="form-control" name="nilai">
                        </div>

                        <div class="form-group">
                            <label for="evaluasi">Evaluasi</label>
                            <textarea name="evaluasi" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-secondary">Simpan nilai</button>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(".detailFaseButton").on('click', function() {
            var modal = $("#detailFaseModal");
            var kel = $(this).data('kelompok');
            $.ajax({
                url: '{{ route("api-fase-detail") }}',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "fase_id": $(this).data('answer'),
                },
                success: function(response) {
                    if(response.success) {
                        modal.find(".modal-title").html("{{ $fase->nama_fase }} - " + kel);
                        modal.find("textarea[name='jawaban']").html(response.data.jawaban);
                        if(response.data.jawaban_file) {
                            var fileName = response.data.jawaban_file;
                            if(fileName.length = 35) {
                                fileName = fileName.substr(0, 35) + "...";
                            }
                            modal.find("a[name='jawaban_file']").attr('href', "{{ url(config('app.answer_files')) }}/" + response.data.jawaban_file).html(fileName);
                        } else {
                            modal.find("a[name='jawaban_file']").attr('href', '#').html("Tidak ada file jawaban");
                        }
                        modal.find("input[name='nilai']").val(response.data.nilai);
                        modal.find("textarea[name='evaluasi']").val(response.data.evaluasi);
                        modal.find("input[name='fk_id']").val(response.data.id);
                        modal.modal('show');
                    }
                }
            });
        });

        $(".hapusFileMateriButton").on('click', function() {
            if(confirm("Apakah anda yakin akan menghapus file ini?")) {
                var btn = $(this);
                
                $.ajax({
                    url: "{{ route('guru-fase-hapusmateri', [$fase->project->kelas->kode_kelas, $fase->project->id, $fase->id]) }}",
                    method: "POST",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'idf': btn.data('idf')
                    },
                    success: function(response) {
                        if(response.success) {
                            btn.closest('div').fadeOut('normal', function() {
                                $(this).remove();
                            });
                        }
                    }
                });
            }
        });

        $("#tambahFileButton").on('click', function() {
            var inputFile = $("#fileMateri");
            inputFile.clone().insertAfter($("#fileMateri"));
        });

        $("#editFaseButton").on('click', function() {
            $("input[name='nama_fase']").prop('disabled', false).focus();
            $("select[name='fase_type']").prop('disabled', false);
            $("input[name='deadline']").prop('disabled', false);
            $("textarea[name='materi']").prop('disabled', false);
            $("#actionGroup").css('display', 'flex');
            $(".hapusFileMateriButton").css('display', '');
            $("#uploadFileMateri").css('display', 'block');
        });

        $("#cancelButton").on('click', function() {
            $("input[name='nama_fase']").prop('disabled', true);
            $("select[name='fase_type']").prop('disabled', true);
            $("input[name='deadline']").prop('disabled', true);
            $("textarea[name='materi']").prop('disabled', true);
            $("#actionGroup").css('display', 'none');
            $(".hapusFileMateriButton").css('display', 'none');
            $("#uploadFileMateri").css('display', 'none');
        });
    </script>
@endsection