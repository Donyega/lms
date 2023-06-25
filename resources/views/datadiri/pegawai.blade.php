@extends('layouts.menu')

@section('title-head', 'Data Diri')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Data Diri
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">SLUA</a></li>
              <li class="breadcrumb-item active">Data Diri</li>
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
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="dd" aria-labelledby="dd-tab" aria-expanded="true">
                <div class="card">
                  <div class="card-body">
                    <button type="button" class="btn btn-sm btn-outline-danger mb-2" name="button"  data-toggle="modal" data-target="#modal-dd" data-backdrop="static" data-keyboard="false"><i data-feather="edit"></i> Ubah Data Diri</button>
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
                    </div>
                  </div>
                </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="kepegawaian" aria-labelledby="kepegawaian-tab" aria-expanded="true">
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive-lg">
                      <table class="table table-striped">
                        <tr>
                          <td style="width:30%">PTK</td>
                          <th>{{$data->detil->jenisptk->nama}}</th>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              {{-- <div role="tabpanel" class="tab-pane" id="pendidikan" aria-labelledby="pendidikan-tab" aria-expanded="true">
                <div class="card">                    
                  <div class="card-body">
                    <button type="button" class="btn btn-sm btn-outline-danger mb-2" name="button" data-toggle="modal" data-target="#modal-pendidikan" id="btntambahpendidikan" data-backdrop="static" data-keyboard="false"><i data-feather="plus"></i> Tambah Riwayat Pendidikan</button>
                    @if(count($riwayatpendidikan) == 0)
                      <div class="alert alert-danger mb-0" role="alert">
                        <h4 class="alert-heading"><i data-feather="alert-circle" style="margin-top: -2px"></i> BELUM DILENGKAPI</h4>
                        <div class="alert-body">
                          Anda belum melengkapi riwayat pendidikan, silakan klik tombol <b>Tambah Riwayat Pendidikan</b> untuk mulai mengisi.
                        </div>
                      </div>
                    @else                      
                      <ul class="timeline mt-1">
                        <?php $no = 0; ?>
                        @foreach($riwayatpendidikan as $rp)
                          <?php
                            $back ='secondary';
                            $warning = 'secondary';
                            if ($no == 0) {
                              $back ='success';
                              $warning = 'warning';
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
                                      <span class="d-block text-muted">Program Studi {{$rp->prodi}}</span>
                                    @endif
                                    <span class="text-muted mb-25">Tanggal Lulus: 
                                      @if ($rp->tgllulus != null)
                                        {{ (new \App\Helper)->tanggal($rp->tgllulus) }}
                                      @else
                                        <div class="badge badge-light-{{$warning}}">Belum Diisi</div>
                                      @endif
                                    </span>
                                    @if($rp->dokijazah != null)
                                      <a href="{{asset($rp->dokijazah)}}" class="btn btn-sm btn-outline-primary"><i data-feather="file-text"></i> Dokumen Ijazah</a>
                                    @endif
                                    @if($rp->doktranskrip != null)
                                      <a href="{{asset($rp->doktranskrip)}}" class="btn btn-sm btn-outline-info"><i data-feather="file-text"></i> Dokumen Transkrip Nilai</a>
                                    @endif
                                  </div>
                                </div>
                                <div class="mt-sm-0 mt-50">
                                  <button class="btn btn-sm btn-outline-{{$back}} btnubahpendidikan" data-toggle="modal" data-target="#modal-pendidikan" value="{{$rp->id}}"><i data-feather="edit" style="margin-top: -3px"></i> Ubah</button>
                                </div>
                              </div>
                            </div>
                          </li>
                        @endforeach
                      </ul>
                    @endif
                  </div>
                </div>
              </div> --}}
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
        <h5 class="modal-title" id="modaltitle">Ubah Data Diri</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" action="{{route('datadiri.update')}}" method="post" enctype="multipart/form-data" id="formdosen">
          <input type="hidden" name="jenis" value="1">
          <input type="hidden" name="idpegawai" value="{{auth::user()->link}}">
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
              <label class="col-sm-12 col-form-label"><b>NUPTK</b></label>
              <div class="col-sm-12">
                <input type="text" name="nuptk" class="form-control" value="{{$data->nuptk}}">
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>NIP</b></label>
              <div class="col-sm-12">
                <input type="text" name="nip" class="form-control" value="{{$data->nip}}">
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

            <div class="form-group col-md-12">
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

            <div class="form-group col-md-6">
              <label class="col-sm-4 col-form-label"><b>NIK</b></label>
              <div class="col-sm-12">
                <input type="text" name="nik" autocomplete="off"  class="form-control" value="{{$data->detil->nik}}">
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

{{-- <div class="modal fade" id="modal-pendidikan" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle-pendidikan"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formpendidikan" class="forms-sample" action="{{route('datadiri.storependidikan')}}" method="post" enctype="multipart/form-data" id="formdosen">
          <input type="hidden" name="idpegawai" value="{{auth::user()->link}}">
          <input type="hidden" name="id" id="idriwayat">
          <div class="row">
            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Jenjang Pendidikan</b></label>
              <div class="col-sm-12 idpendidikan">
                <select class="form-control show-tick ms select2" name="idpendidikan" data-placeholder="Pilih" required>
                  <option></option>
                  @foreach($pendidikan as $p)
                  <option value="{{$p->id}}">{{$p->nama}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Tahun Masuk</b></label>
              <div class="col-sm-12">
                <input type="text" class="form-control tahun" autocomplete="off" name="thnmasuk" id="thnmasuk" required>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Nama Sekolah / Kampus</b></label>
              <div class="col-sm-12">
                <input type="text" name="namakampus" id="namakampus" class="form-control" autocomplete="off" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Program Studi</b></label>
              <div class="col-sm-12">
                <input type="text" name="prodi" id="prodi" class="form-control" autocomplete="off">
                <label class="col-form-label"><small>* diisi untuk jenjang pendidikan tinggi</small></label>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Tanggal Lulus</b></label>
              <div class="col-sm-12">
                <input type="text" name="tgllulus" id="tgllulus" class="form-control flatpickr-basic"  placeholder="Pilih" style="background-color: white">
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Dokumen Ijazah</b></label>
              <div class="col-sm-12">
                <div class="body">
                  <input type="file" class="dropify" name="ijazah" data-allowed-file-extensions="pdf" data-max-file-size="1M">
                </div>
                <label class="col-form-label"><small>* format file <b>.pdf</b>, ukuran maksimal 1MB</small></label>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Dokumen Transkrip Nilai</b></label>
              <div class="col-sm-12">
                <div class="body">
                  <input type="file" class="dropify" name="transkrip" data-allowed-file-extensions="pdf" data-max-file-size="1M">
                </div>
                <label class="col-form-label"><small>* format file <b>.pdf</b>, ukuran maksimal 1MB</small></label>
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
</div> --}}
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

  $("#idagama").append($("<option selected='selected'></option>").val('{{$data->idagama}}').text('{{$data->idagama == null ? "" : $data->agama->nama}}')).trigger('change');

  $("#idkec").append($("<option selected='selected'></option>").val('{{$data->idkec}}').text('{{$data->idkec == null ? "" : "Kecamatan ".$data->kecamatan->nama.", ".$data->kecamatan->kabupaten->nama}}')).trigger('change');

  $('#btntambahpendidikan').on('click', function () {
    $('#modaltitle-pendidikan').text('Tambah Riwayat Pendidikan')
    $('#formpendidikan').attr('action', "{{route('datadiri.storependidikan')}}")
    $('#thnmasuk').val('')
    $('#namakampus').val('')
    $('#prodi').val('')
    $('#tgllulus').val('')
  });

  $('.btnubahpendidikan').on('click', function () {
    $('#modal-pendidikan').show()
    $('#modaltitle-pendidikan').text('Ubah Riwayat Pendidikan')
    $('#formpendidikan').attr('action', "{{route('datadiri.updatependidikan')}}")
    $('#idriwayat').val($(this).val())
    $.get('/datadiri/getriwayat/'+$(this).val(), function(data){
      $("div.idpendidikan select").val(data.idpendidikan).change()
      $('#thnmasuk').val(data.thnmasuk)
      $('#namakampus').val(data.namakampus)
      $('#prodi').val(data.prodi)
      $('#tgllulus').val(data.tgllulus)
    })
  });
  

});
</script>
@stop
