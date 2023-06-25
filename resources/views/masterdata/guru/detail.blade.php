@extends('layouts.menu')

@section('title-head', 'Detail Guru')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Detail Guru
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('md.guru')}}">Master Data Guru</a></li>
              <li class="breadcrumb-item active">Detail</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="content-body">
    <div class="row">
      <div class="col-12">
        <div class="row match-height">
          <div class="col-lg-3">
            <div class="card">
              <div class="card-body text-center">
                <img src="{{$data->detil->photo == null ? asset('images/user-default.jpg') : asset($data->detil->photo)}}" class="rounded" width="100%" alt="Foto Pegawai">                
              </div>
            </div>
          </div>
          <div class="col-lg-9">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive-lg">
                  <table class="table table-striped">
                    <tr>
                      <td colspan="2"><h2 class="mb-0">{{$data->nama}}</h2></td>
                    </tr>
                    <tr>
                      <td style="width:30%">Panggilan</td>
                      <th>{{$data->panggilan}}</th>
                    </tr>
                    <tr>
                      <td>Tempat, Tanggal Lahir</td>
                      <th>{{$data->tplahir}}, {{ (new \App\Helper)->tanggal($data->tglahir) }}</th>
                    </tr>
                    <tr>
                      <td>Usia</td>
                      <th>{{ (new \App\Helper)->lamamengajar($data->tglahir) }}</th>
                    </tr>
                    <tr>
                      <td>Jenis Kelamin</td>
                      <th>{{$data->jk == 'L' ? 'Laki-laki' : 'Perempuan'}}</th>
                    </tr>
                    <tr>
                      <td>Agama</td>
                      <th>{{$data->agama->nama}}</th>
                    </tr>
                    <tr>
                      <td>Telepon</td>
                      <th>{{$data->nohp}}</th>
                    </tr> 
                    <tr>
                      <td>Status Kerja
                      <th>{{$data->status->nama}}</th>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <ul class="nav nav-pills">
              <li class="nav-item">
                <a class="nav-link active" id="dd-tab" data-toggle="pill" href="#dd" aria-expanded="true">Data Diri</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="kepegawaian-tab" data-toggle="pill" href="#kepegawaian" aria-expanded="true">Data Kepegawaian</a>
              </li>
              {{-- <li class="nav-item">
                <a class="nav-link" id="pendidikan-tab" data-toggle="pill" href="#pendidikan" aria-expanded="true">Riwayat Pendidikan</a>
              </li> --}}
              <li class="col-lg col-sm-12 px-0 text-lg-right text-center">
                @if(empty($data->user))
                  <button class="btn btn-danger mt-25 btn-js-val" type="button" data-toggle="modal" data-target="#modal-user" data-backdrop="static" data-keyboard="false"><i data-feather="user-plus"></i> Buat User</button>
                @else
                  <form action="{{route('md.user.delete')}}" method="post" onsubmit="return confirm('Lanjutkan proses hapus user {{$data->nama}}?')">
                    <input type="hidden" name="id" value="{{$data->user->id}}">
                    <button type="submit" class="btn btn-warning mt-25" name="button"><i data-feather="user-minus"></i> Hapus User</button>
                    {{ csrf_field() }}
                  </form>
                @endif
              </li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="dd" aria-labelledby="dd-tab" aria-expanded="true">
                <div class="card">
                  <div class="card-body">
                    <button type="button" class="btn btn-sm btn-outline-danger mb-2 btn-js-val" name="button"  data-toggle="modal" data-target="#modal-dd" data-backdrop="static" data-keyboard="false"><i data-feather="edit"></i> Ubah Data Diri</button>
                    <div class="table-responsive-lg">
                      <table class="table table-striped">
                        @if(count($riwayatpendidikan) > 0)
                          <tr>
                            <td style="width:30%">Pendidikan Terakhir</td>
                            <td><b>{{$riwayatpendidikan[0]->pendidikan->nama}}</b></td>
                          </tr>
                        @endif
                        <tr>
                          <td style="width:30%">Alamat</td>
                          <td><b>{{$data->alamat}}</b></td>
                        </tr>
                        <tr>
                          <td>Wilayah Alamat</td>
                          <td><b>{{$data->idkec == null ? '' : 'Kecamatan '.$data->kecamatan->nama.', '.$data->kecamatan->kabupaten->nama.', '.$data->kecamatan->kabupaten->provinsi->nama}}</b></td>
                        </tr>       
                        <tr>
                          <td>Email</td>
                          <td><b>{{$data->email}}</b></td>
                        </tr>
                      </table>
                      <hr class="m-0">
                    </div>
                  </div>
                </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="kepegawaian" aria-labelledby="kepegawaian-tab" aria-expanded="true">
                <div class="card">
                  <div class="card-body">
                    <button type="button" class="btn btn-sm btn-outline-danger mb-2 btn-js-val" name="button" data-toggle="modal" data-target="#modal-kepegawaian" data-backdrop="static" data-keyboard="false"><i data-feather="edit"></i> Ubah Data Kepegawaian</button>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <tr>
                          <td style="width:30%">PTK</td>
                          <th>{{$data->detil->idjenisptk == null ? '' : $data->detil->jenisptk->nama}}</th>
                        </tr>
                      </table>
                      <hr class="m-0">
                    </div>
                  </div>
                </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="pendidikan" aria-labelledby="pendidikan-tab" aria-expanded="true">
                <div class="card">                    
                  <div class="card-body">
                    @if(count($riwayatpendidikan) == 0)
                      <div class="alert alert-danger mb-0" role="alert">
                        <h4 class="alert-heading"><i data-feather="alert-circle" style="margin-top: -2px"></i> BELUM DILENGKAPI</h4>
                        <div class="alert-body">
                          {{$data->nama}} belum melengkapi riwayat pendidikan, penambahan riwayat pendidikan dapat dilakukan pada menu <b>Data Diri</b> akun yang bersangkutan.
                        </div>
                      </div>
                    @else                      
                      <ul class="timeline mt-1">
                        <?php $no = 0; ?>
                        @foreach($riwayatpendidikan as $rp)
                          <?php
                            $back ='secondary';
                            if ($no == 0) {
                              $back ='success';
                            }
                            $no++;
                          ?>
                          <li class="timeline-item">
                            <span class="timeline-point timeline-point-{{$back}} timeline-point-indicator"></span>
                            <div class="timeline-event">
                              <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                <h5 class="mb-50">{{$rp->pendidikan->nama}}</h5>
                                <span class="timeline-event-time">Terakhir Diubah {{ (new \App\Helper)->tanggal($rp->updated_at) }}</span>
                              </div>
                              <hr class="my-25">
                              <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                <div class="media align-items-center">
                                  <div class="media-body">
                                    <p class="mb-0">{{$rp->namakampus}}</p>
                                    @if($rp->prodi != null)
                                      <span class="text-muted">Program Studi {{$rp->prodi}}</span>
                                    @endif
                                    <p class="text-muted mb-25">Tanggal Lulus: {{ (new \App\Helper)->tanggal($rp->tgllulus) }}</p>
                                    @if($rp->dokijazah != null)
                                      <a href="{{asset($rp->dokijazah)}}" class="btn btn-sm btn-outline-primary"><i data-feather="file-text"></i> Dokumen Ijazah</a>
                                    @endif
                                    @if($rp->doktranskrip != null)
                                      <a href="{{asset($rp->doktranskrip)}}" class="btn btn-sm btn-outline-info"><i data-feather="file-text"></i> Dokumen Transkrip Nilai</a>
                                    @endif
                                  </div>
                                </div>
                                <div class="mt-sm-0 mt-50">
                                  <button class="btn btn-sm btn-outline-{{$back}}"><i data-feather="edit" style="margin-top: -3px"></i> Ubah</button>
                                </div>
                              </div>
                            </div>
                          </li>
                        @endforeach
                      </ul>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('modal')
<div class="modal fade" id="modal-dd" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Ubah Biodata</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" action="{{route('md.pegawai.update')}}" method="post" enctype="multipart/form-data">
          <input type="hidden" name="idpegawai" value="{{$data->id}}">
          <input type="hidden" name="jenis" value="{{$data->jenis}}">
          <div class="row">
            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Nama</b></label>
              <div class="col-sm-12">
                <input type="text" name="nama" class="form-control" value="{{$data->nama}}" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Panggilan</b> <small>(maksimal 12 karakter)</small></label>
              <div class="col-sm-12">
                <input type="text" maxlength="12" name="panggilan" class="form-control" value="{{$data->panggilan}}" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Jenis Kelamin</b></label>
              <div class="col-sm-12">
                <div class="row mx-0">
                  <div class="custom-control custom-radio mr-2">
                    <input type="radio" id="jk" name="jk" value="L" class="custom-control-input" {{$data->jk == 'L' ? 'checked':''}}>
                    <label class="custom-control-label" for="jk">Laki-Laki</label>
                  </div>
                  <div class="custom-control custom-radio">
                    <input type="radio" id="jka" name="jk" value="P" class="custom-control-input" {{$data->jk == 'P' ? 'checked':''}}>
                    <label class="custom-control-label" for="jka">Perempuan</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-4 col-form-label"><b>Agama</b></label>
              <div class="col-sm-12">
                <select class="form-control show-tick ms select2" id="idagama" name="idagama" required>

                </select>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Tempat Lahir</b></label>
              <div class="col-sm-12">
                <input type="text" name="tplahir" class="form-control" value="{{$data->tplahir}}" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Tanggal Lahir</b></label>
              <div class="col-sm-12">
                <input type="text" name="tglahir" class="form-control flatpickr-basic"  placeholder="Pilih" value="{{$data->tglahir}}" style="background-color: white" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Nomor Telepon</b></label>
              <div class="col-sm-12">
                <input type="text" name="nohp" autocomplete="off"  class="form-control" id="nohp" value="{{$data->nohp}}">
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Email</b></label>
              <div class="col-sm-12">
                <input type="email" name="email" autocomplete="off"  class="form-control" id="email" value="{{$data->email}}">
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-6 col-form-label"><b>Alamat Tinggal</b></label>
              <div class="col-sm-12">
                <input type="text" name="alamat" class="form-control" id="alamat" value="{{$data->alamat}}">
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Kecamatan Tempat Tinggal</b></label>
              <div class="col-sm-12">
                <select class="form-control show-tick ms select2" id="idkec" name="idkec" required>

                </select>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-4 col-form-label"><b>Foto</b></label>
              <div class="col-sm-12">
                <div class="body">
                  @if($data->detil->photo == null)
                  <input type="file" class="dropify" name="photos" data-allowed-file-extensions="jpg jpeg" data-max-file-size="1M" required>
                  @else
                  <input type="file" class="dropify" data-default-file="{{asset($data->detil->photo)}}" name="photos" data-allowed-file-extensions="jpg jpeg" data-max-file-size="1M">
                  @endif
                </div>
                <label class="col-form-label"><small>* format file <b>.jpg</b> atau <b>.jpeg</b>, rasio <b>3x4</b> ukuran maksimal 1MB</small></label>
              </div>
            </div>
          </div>

          {{ csrf_field() }}

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-success"><i data-feather="save"></i> Simpan</button>
        <button class="btn btn-sm btn-outline-dark" data-dismiss="modal">Batal</button>
      </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-kepegawaian" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Ubah Data Kepegawaian | {{$data->nama}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" action="{{route('md.pegawai.updatekepegawaian')}}" method="post" enctype="multipart/form-data">
          <input type="hidden" name="idpegawai" value="{{$data->id}}">
          <div class="row">
            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>PTK</b></label>
              <div class="col-sm-12">
                <select class="form-control show-tick ms select2" id="idjenisptk" name="idjenisptk" required>

                </select>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Status Kerja</b></label>
              <div class="col-sm-12">
                <select class="form-control show-tick ms select2" id="idstatus" name="idstatus" required>

                </select>
              </div>
            </div>

          </div>

          {{ csrf_field() }}

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-success"><i data-feather="save"></i> Simpan</button>
        <button class="btn btn-sm btn-outline-dark" data-dismiss="modal">Batal</button>
      </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-user" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Buat User | {{$data->nama}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="forms-sample" action="{{route('md.user.store')}}" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          @if($data->email == null || $data->email == '')
            <div class="alert alert-danger mb-0" role="alert">
              <div class="alert-body">
                Tidak dapat menambahkan user baru untuk {{$data->nama}} karena <b>alamat email belum dilengkapi</b>. Silakan melengkapi alamat detail pada tab Data Diri.
              </div>
            </div>
          @else
            <input type="hidden" name="link" value="{{$data->id}}">
            <input type="hidden" name="role" value="2">
            <div class="form-group">
              <label class="col-sm-12 col-form-label"><b>Username</b></label>
              <div class="col-sm-12">
                <input type="text" name="username" class="form-control" readonly value="{{$data->email}}">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-12 col-form-label"><b>Password</b></label>
              <div class="col-sm-12">
                  <input type="text" name="password" required class="form-control">
              </div>
            </div>
          @endif
          {{ csrf_field() }}
        </div>
        <div class="modal-footer">
          @if($data->email != null)
            <button type="submit" class="btn btn-sm btn-success"><i data-feather="save"></i> Simpan</button>
          @endif
          <button class="btn btn-sm btn-outline-dark" data-dismiss="modal">Kembali</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('jspage')
<script>
$(document).ready(function() {
  $("#idagama").select2({
    placeholder: "Pilih",
    ajax: {
        url: '{!!route("s2.agama")!!}',
        dataType: 'json',
        data: function (params) {
            return {
                q: $.trim(params.term)
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

  $("#idkec").select2({
    placeholder: "Pilih",
    ajax: {
        url: '{!!route("s2.kecamatan")!!}',
        dataType: 'json',
        data: function (params) {
            return {
                q: $.trim(params.term)
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

  $("#idjenisptk").select2({
    placeholder: "Pilih",
    ajax: {
        url: '{!!route("s2.jenisptk")!!}',
        dataType: 'json',
        data: function (params) {
            return {
                q: $.trim(params.term)
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

  $("#idpangkat").select2({
    placeholder: "Pilih",
    ajax: {
        url: '{!!route("s2.pangkat")!!}',
        dataType: 'json',
        data: function (params) {
            return {
                q: $.trim(params.term)
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

  $("#idstatus").select2({
    placeholder: "Pilih",
    ajax: {
        url: '{!!route("s2.statuskerja")!!}',
        dataType: 'json',
        data: function (params) {
            return {
                q: $.trim(params.term)
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

  $("#idagama").append($("<option selected='selected'></option>").val('{{$data->idagama}}').text('{{$data->idagama == null ? "" : $data->agama->nama}}')).trigger('change');

  $("#idkec").append($("<option selected='selected'></option>").val('{{$data->idkec}}').text('{{$data->idkec == null ? "" : "Kecamatan ".$data->kecamatan->nama.", ".$data->kecamatan->kabupaten->nama}}')).trigger('change');

  $("#idjenisptk").append($("<option selected='selected'></option>").val('{{$data->detil->idjenisptk}}').text('{{$data->detil->idjenisptk == null ? "" : $data->detil->jenisptk->nama}}')).trigger('change');

  $("#idpangkat").append($("<option selected='selected'></option>").val('{{$data->detil->idpangkat}}').text('{{$data->detil->idpangkat == null ? "" : $data->detil->pangkat->pangkat." (".$data->detil->pangkat->golongan."/".$data->detil->pangkat->ruang.")"}}')).trigger('change');

  $("#idstatus").append($("<option selected='selected'></option>").val('{{$data->idstatus}}').text('{{$data->idstatus == null ? "" : $data->status->nama}}')).trigger('change');

});
</script>
@stop
