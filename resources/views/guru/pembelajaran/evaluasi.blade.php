@extends('layouts.menu')

@section('title-head', 'Evaluasi '.$data->materi->materi)

@section('content')
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
        <div class="row breadcrumbs-top">
          <div class="col-12">
            <h2 class="content-header-title float-left mb-0">Evaluasi {{$data->jadwal->mapel->nama}}
            </h2>
            <div class="breadcrumb-wrapper">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="{{route('home')}}"><i data-feather="home"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="{{route('pembelajaran',[$data->materi->idjadwal,Session::get('idgambarglobal')])}}">Pembelajaran</a></li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="content-body">
      <div class="row match-height">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped">
                  <tr>
                    <td>Pertemuan</td>
                    <td class="px-0" style="width:1px">:</td>
                    <th>{{$data->materi->pertemuan}}</th>
                  </tr>
                  <tr>
                    <td>Materi</td>
                    <td class="px-0" style="width:1px">:</td>
                    <th>{{$data->materi->materi}}</th>
                  </tr>
                  <tr>
                    <td>Jenis Evaluasi</td>
                    <td class="px-0" style="width:1px">:</td>
                    <th>
                      <div class="badge badge-light-primary">{{$data->materi->jenis->alias}}</div>
                      {{$data->jenis->nama}}
                    </th>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-7">
          <div class="card">
            <div class="card-body text-center px-25">
              <div class="avatar bg-light-danger p-50 mb-50">
                <div class="avatar-content">
                  <i data-feather="calendar" class="font-medium-3"></i>
                </div>
              </div>
              <p class="card-text mb-25">Pelaksanaan</p>
              <h5 class="font-weight-bolder text-danger">{{(new \App\Helper)->tanggal($data->tgl)}}</h5>
              <p class="card-text">{{date('H:i',strtotime($data->mulai))}} s/d {{date('H:i',strtotime($data->berakhir))}}</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-5">
          <div class="card">
            <div class="card-body text-center px-25">
              <div class="avatar bg-light-success p-50 mb-50">
                <div class="avatar-content">
                  <i data-feather="file-text" class="font-medium-3"></i>
                </div>
              </div>
              <p class="card-text mb-25">Jumlah Soal</p>
              <h3 class="font-weight-bolder text-success">{{count($soal)}}</h3>
              @if ($data->jmlsoal != null)
                <div class="badge badge-light-success">Ditampilkan {{$data->jmlsoal}}</div>
              @endif
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="text-center mb-1">
            <button class="btn btn-primary mb-25" data-toggle="modal" data-target="#modal-evaluasi"><i data-feather="settings"></i> Ubah Pengaturan</button>
            <button class="btn btn-danger mb-25" data-toggle="modal" data-target="#modal-soal"><i data-feather="plus"></i> Tambah Soal</button>
            <button class="btn btn-success mb-25" data-toggle="modal" data-target="#modal-unggah"><i data-feather="upload"></i> Unggah Soal</button>
          </div>
        </div>
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <table class="table table-bordered table-hover" id="tabelsoal">
                <thead class="text-center">
                  <th>Kode</th>
                  <th>Soal</th>
                  <th>Aksi</th>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('modal')
<div class="modal fade text-left" id="modal-evaluasi" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title-evaluasi">Ubah Pengaturan Evaluasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="forms-sample" action="{{route('pembelajaran.setevaluasi')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idjadwal" value="{{$data->idjadwal}}">
        <input type="hidden" name="idmateri" value="{{$data->idmateri}}">
        <input type="hidden" name="iduser" value="{{auth::user()->id}}">
        <div class="modal-body">
          <div class="row">
            <div class="col-xl-6 mb-1">
              <div class="form-group">
                <label><b>Materi Pembelajaran</b></label>
                <input type="text" class="form-control" value="{{$data->materi->materi}}" disabled>
              </div>
            </div>
            <div class="col-xl-6 mb-1">
              <div class="form-group">
                <label><b>Tanggal Pelaksanaan</b></label>
                <input type="text" name="tgl" class="form-control flatpickr-basic" style="background-color: white" value="{{$data->tgl}}" required>
              </div>
            </div>
            <div class="col-xl-6 mb-1">
              <div class="form-group">
                <label><b>Jam Mulai</b></label>
                <input type="text" name="mulai" class="form-control flatpickr-time text-left" style="background-color: white" value="{{date('H:i',strtotime($data->mulai))}}" required>
              </div>
            </div>
            <div class="col-xl-6 mb-1">
              <div class="form-group">
                <label><b>Jam Berakhir</b></label>
                <input type="text" name="berakhir" class="form-control flatpickr-time text-left" style="background-color: white" value="{{date('H:i',strtotime($data->berakhir))}}" required>
              </div>
            </div>
            <div class="col-xl-6 mb-1">
              <div class="form-group">
                <label><b>Jenis Evaluasi</b></label>
                <select class="form-control select2" name="idjenis" id="idjenisevaluasi" data-placehorder="Pilih" required>

                </select>
              </div>
            </div>
            <div class="col-xl-6">
              <div class="form-group">
                <label><b>Jumlah Soal</b></label>
                <input type="number" name="jmlsoal" value="{{$data->jmlsoal}}" class="form-control">
                <label class="mt-50">
                  <ul class="pl-1 mb-0">
                    <li>Isian jumlah soal jika Anda ingin membatasi soal yang tampil saat evaluasi (soal akan diacak sejumlah isian dari total soal yang telah Anda unggah)</li>
                    <li>Kosongkan jika Anda ingin menampilkan semua soal</li>
                  </ul>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="save"></i> Simpan</button>
        </div>
        {{ csrf_field() }}
      </form>
    </div>
  </div>
</div>

<div class="modal fade text-left" id="modal-unggah" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title-dokumen">Unggah Soal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-xl-12 mb-1">
              <div class="alert alert-dark mb-0" role="alert">
                <h4 class="alert-heading"><i data-feather="info" style="margin-top: -2px"></i> INFORMASI</h4>
                <div class="alert-body">
                  <small>
                    Silakan <b>Unduh Template</b> Soal {{$data->idjenis == 2 ? 'dan Jawaban' : ''}} dalam format Ms.Excel dan melengkapi isian, kemudian pilih file yang telah diisi dan tekan tombol Unggah untuk menyimpan.
                  </small>
                  <div class="text-center mt-50">
                    <form class="d-inline" action="{{route('pembelajaran.evaluasi.unduhtemplate')}}" method="post">
                      <input type="hidden" name="idevaluasi" value="{{$data->id}}">
                      <input type="hidden" name="idjenis" value="1">
                      <input type="hidden" name="idevaluasi" value="{{$data->id}}">
                      <button type="submit" class="btn btn-sm btn-outline-success mb-25"><i data-feather="download" style="top: 0"></i> Unduh Template Soal</button>
                      @csrf
                    </form>
                    @if($data->idjenis == 2)
                    <form class="d-inline" action="{{route('pembelajaran.evaluasi.unduhtemplate')}}" method="post">
                      <input type="hidden" name="idevaluasi" value="{{$data->id}}">
                      <input type="hidden" name="idjenis" value="2">
                      <button type="submit" class="btn btn-sm btn-outline-success mb-25"><i data-feather="download" style="top: 0"></i> Unduh Template Jawaban</button>
                      @csrf
                    </form>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
          <form class="forms-sample form-dokumen" action="{{route('pembelajaran.evaluasi.unggahsoaljawaban')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="idevaluasi" value="{{$data->id}}">
            <input type="hidden" name="idjenis" value="{{$data->idjenis}}">
            <input type="hidden" name="idmapel" value="{{$data->jadwal->idmapel}}">
            <div class="row">
              <div class="col-xl-12 mb-1">
                <div class="form-group">
                  <label><b>Pilih Dokumen Soal</b></label>
                  <input type="file" name="doksoal" class="dropify" data-allowed-file-extensions="xlsx" data-max-file-size="1M">
                  <label>fomat file <b>.xlsx</b> ukuran maksimal <b>1MB</b></label>
                </div>
              </div>

              @if($data->idjenis == 2)
              <div class="col-xl-12">
                <div class="form-group">
                  <label><b>Pilih Dokumen Jawaban</b></label>
                  <input type="file" name="dokjawaban" class="dropify" data-allowed-file-extensions="xlsx" data-max-file-size="1M">
                  <label>fomat file <b>.xlsx</b> ukuran maksimal <b>1MB</b></label>
                </div>
              </div>
              @endif
            </div>
            {{ csrf_field() }}
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="upload"></i> Unggah</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade text-left" id="modal-soal" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title-dokumen">Tambah Soal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form class="forms-sample form-dokumen" action="{{route('pembelajaran.evaluasi.storesoal')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="idjenis" value="{{$data->idjenis}}">
            <input type="hidden" name="idmapel" value="{{$data->jadwal->idmapel}}">
            <input type="hidden" name="idguru" value="{{auth::user()->link}}">
            <input type="hidden" name="idjenisevaluasi" value="{{$data->materi->idjenis}}">
            <input type="hidden" name="idevaluasi" value="{{$data->id}}">
            <div class="row">
              <div class="col-xl-12 mb-1">
                <div class="form-group">
                  <label><b>Kode Soal</b></label>
                  <input type="text" class="form-control" name="kode" required value="{{Str::random(4)}}">
                </div>
              </div>

              <div class="col-xl-12 mb-1">
                <div class="form-group">
                  <label><b>Soal</b></label>
                  <textarea name="soal" required class="form-control" rows="4" cols="80"></textarea>
                </div>
              </div>

              @if($data->idjenis == 1)
              <div class="col-xl-12 mb-1">
                <div class="form-group">
                  <label><b>File</b></label>
                  <input type="file" class="dropify" name="files" data-allowed-file-extensions="pdf" data-max-file-size="5M" value="">
                </div>
                <label class="col-form-label"><small>* format file <b>.pdf</b>, ukuran maksimal 5MB</small></label>
              </div>
              @endif

              @if($data->idjenis == 2)
                <div class="col-xl-12 mb-1">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                      <thead class="text-center">
                        <th>Pilihan Jawaban</th>
                        <th class="px-50" style="width: 1px">Benar</th>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <div class="row align-items-center">
                              <div class="pl-1"><b>1</b></div>
                              <div class="col">
                                <input type="text" class="form-control" name="jawab[]" required value="">
                              </div>
                            </div>
                          </td>
                          <td class="text-center">
                            <div class="custom-control custom-control-inline custom-radio ml-50 mr-0">
                              <input type="radio" name="jawaban" class="custom-control-input" checked value="1" id="jawabana">
                              <label class="custom-control-label" for="jawabana"></label>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="row align-items-center">
                              <div class="pl-1"><b>2</b></div>
                              <div class="col">
                                <input type="text" class="form-control" name="jawab[]" required value="">
                              </div>
                            </div>
                          </td>
                          <td class="text-center">
                            <div class="custom-control custom-control-inline custom-radio ml-50 mr-0">
                              <input type="radio" name="jawaban" class="custom-control-input" value="2" id="jawabanb">
                              <label class="custom-control-label" for="jawabanb"></label>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="row align-items-center">
                              <div class="pl-1"><b>3</b></div>
                              <div class="col">
                                <input type="text" class="form-control" name="jawab[]" required value="">
                              </div>
                            </div>
                          </td>
                          <td class="text-center">
                            <div class="custom-control custom-control-inline custom-radio ml-50 mr-0">
                              <input type="radio" name="jawaban" class="custom-control-input" value="3" id="jawabanc">
                              <label class="custom-control-label" for="jawabanc"></label>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="row align-items-center">
                              <div class="pl-1"><b>4</b></div>
                              <div class="col">
                                <input type="text" class="form-control" name="jawab[]" required value="">
                              </div>
                            </div>
                          </td>
                          <td class="text-center">
                            <div class="custom-control custom-control-inline custom-radio ml-50 mr-0">
                              <input type="radio" name="jawaban" class="custom-control-input" value="4" id="jawaband">
                              <label class="custom-control-label" for="jawaband"></label>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              @endif
            </div>
            {{ csrf_field() }}
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="plus"></i> Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('jspage')
<script>
$(document).ready(function() {
  var table = $('#tabelsoal').DataTable({
    processing: true,
    serverSide: true,
    autoWidth: false,
    "drawCallback": function( settings ) {
      feather.replace();
    },
    dom: '<"box-body"<"row"<"col-sm-3"l><"col-sm-5"<"toolbar">><"col-sm-4"f>>><"box-body table-responsive"tr><"box-body"<"row"><"row"<"col-sm-6"i><"col-sm-6"p>>>',
    ajax: '{!! route('pembelajaran.evaluasi.dt',[$data->id,$data->jadwal->idmapel,$data->idjenis]) !!}',
    columns: [
        { data: 'kode', name: 'kode', class:'text-center'},
        { data: 'soal', name: 'soal','render': function(data, type, row){
          if (row.file == null) {
            return data

          }else {
            return data+' <a href="/'+row.file+'" class="btn btn-sm btn-outline-info ml-1" target="_blank"><i data-feather="file-text"></i></a>'
          }
        }},
        { data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'},
    ],
  });

  $("#idjenisevaluasi").select2({
    placeholder: "Pilih",
    ajax: {
        url: '{!!route("s2.jenisevaluasi")!!}',
        dataType: 'json',
        data: function (params) {
            return {
                q: $.trim(params.term),
            };
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
    },
  });

  $("#idjenisevaluasi").append($("<option selected='selected'></option>").val('{{$data->idjenis}}').text('{{$data->jenis->nama}}'));
});
</script>
@stop
