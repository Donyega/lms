@extends('layouts.menu')

@section('title-head', 'Detail Siswa')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Detail Siswa
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('md.siswa')}}">Master Data Siswa</a></li>
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
              <div class="card-body text-center row mx-0 align-items-start justify-content-center">
                <img src="{{$data->detil->photo == null ? asset('images/user-default.jpg') : asset($data->detil->photo)}}" class="rounded" width="100%" alt="Foto Siswa">
                <a href="{{route('md.siswa')}}" class="btn btn-sm btn-outline-dark mt-75"><i data-feather="chevrons-left"></i> Kembali</a>               
              </div>
              
            </div>
          </div>
          <div class="col-lg-9">
            <div class="card">
              <div class="card-body">
                @include('layouts.ddsiswa')
              </div>
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
            <a class="nav-link" id="riwayatak-tab" data-toggle="pill" href="#riwayatak" aria-expanded="true">Riwayat Akademik</a>
          </li>
          <li class="col-lg col-sm-12 px-0 text-lg-right text-center">
              @if(empty($data->user))
                <button class="btn btn-danger mt-25" type="button" data-toggle="modal" data-target="#modal-user" data-backdrop="static" data-keyboard="false"><i data-feather="user-plus"></i> Buat User</button>
              @else
                <form class="d-inline" action="{{route('md.user.delete')}}" method="post" onsubmit="return confirm('Lanjutkan proses hapus user {{$data->nama}}?')">
                  <input type="hidden" name="id" value="{{$data->user->id}}">
                  <button type="submit" class="btn btn-warning mt-25 mb-0" name="button"><i data-feather="user-minus"></i> Hapus User</button>
                  {{ csrf_field() }}
                </form>
              @endif
              <a href="{{route('md.siswa.kartupelajar',$data->id)}}" class="btn btn-primary mt-25" target="_blank"><i data-feather="credit-card"></i> Cetak Kartu Pelajar</a>
          </li>
        </ul>
        <div class="card">
          <div class="card-body">
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="dd" aria-labelledby="dd-tab" aria-expanded="true">
                <button type="button" class="btn btn-sm btn-outline-danger mb-1" name="button"  data-toggle="modal" data-target="#modal-biodata" data-backdrop="static" data-keyboard="false"><i data-feather="edit"></i> Ubah Biodata</button>
                <div class="table-responsive">
                  <table class="table table-striped">
                    <tr>
                      <td style="width:30%">Tahun Masuk</td>
                      <td><b>{{$data->detil->thnmasuk == null ? '-' : $data->detil->thnmasuk}}</b></td>
                    </tr>
                    <tr>
                      <td>Alamat Email</td>
                      <td><b>{{$data->detil->email == null ? '-' : $data->detil->email}}</b></td>
                    </tr>
                    <tr>
                      <td>Alamat Tinggal</td>
                      <td><b>{{$data->alamat}}</b></td>
                    </tr>
                    <tr>
                      <td>Wilayah Alamat</td>
                      <td><b>{{$data->idkec == null ? '' : 'Kecamatan '.$data->kecamatan->nama.', '.$data->kecamatan->kabupaten->nama.', '.$data->kecamatan->kabupaten->provinsi->nama}}</b></td>
                    </tr>
                  </table>
                  <hr class="m-0">
                </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="riwayatak" aria-labelledby="riwayatak-tab" aria-expanded="true">
                <ul class="timeline mt-1">
                  <?php $no = 0; ?>
                  @foreach($riwayatakademik as $r)
                    <?php
                      $rk = $riwayatkelas->where('idta',$r->idta)->first();
                      $cekjadwal = $jadwal->where('idta',$r->idta)->first();
                      $color = 'success';
                        if ($r->idstatus != 1) {
                          $color = 'info';
                        }
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
                          <h5 class="mb-50">{{$r->ta->tahun}} {{$r->ta->semester == '1' ? 'Ganjil' : 'Genap'}}</h5>
                        </div>
                        <hr class="my-25">
                        <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                          <div class="media align-items-center">
                            <div class="media-body">
                              <p class="mb-25">Kelas : <b>{{$rk->kelas->nama}} {{$rk->kelas->jenis->nama}}</b></p>
                              <p class="text-muted mb-25">Wali : {{$rk->riwayatwali == null ? '' : $rk->riwayatwali->walikelas->nama}}</p>
                              <div class="badge badge-light-{{$color}} text-uppercase">{{$r->status->nama}}</div>
                            </div>
                          </div>
                          @if ($cekjadwal != null)
                            <div class="mt-sm-0 mt-50">
                              <form class="d-inline" action="{{route('nilairapor.cetak')}}" method="post" target="_blank">
                                <input type="hidden" name="idta" value="{{$r->idta}}">
                                <input type="hidden" name="nis" value="{{$r->nis}}">
                                <input type="hidden" name="idkurikulum" value="{{$rk->kelas->idkurikulum}}">
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i data-feather="file-text"></i> Cetak Rapor</button>
                                @csrf
                              </form>
                            </div>
                          @endif
                        </div>
                      </div>
                    </li>
                  @endforeach
                </ul>
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
<div class="modal fade" id="modal-biodata" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Ubah Biodata Siswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" action="{{route('md.siswa.update')}}" method="post" enctype="multipart/form-data" id="formguru">
          <input type="hidden" class="form-control" name="id" value="{{$data->id}}">
          <input type="hidden" class="form-control" name="nis" value="{{$data->nis}}">

          <div class="row">
            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Nama Siswa</b></label>
              <div class="col-sm-12">
                <input type="text" name="nama" class="form-control" value="{{$data->nama}}" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>NIS</b></label>
              <div class="col-sm-12">
                <input type="text" name="nis" class="form-control" value="{{$data->nis}}" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>NISN</b></label>
              <div class="col-sm-12">
                <input type="text" name="nisn" class="form-control" value="{{$data->nisn}}">
              </div>
            </div>
            
            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Tahun Masuk</b></label>
              <div class="col-sm-12">
                <input type="number" name="thnmasuk" class="form-control" value="{{$data->detil->thnmasuk}}">
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-4 col-form-label"><b>Agama</b></label>
              <div class="col-sm-12">
                <select class="form-control show-tick ms select2" name="idagama" id="idagama" data-placeholder="Pilih">

                </select>
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
                <input type="email" name="email" autocomplete="off"  class="form-control" id="email" value="{{$data->detil->email}}">
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-6 col-form-label"><b>Alamat Tinggal</b></label>
              <div class="col-sm-12">
                <input type="text" name="alamat" class="form-control" id="alamat" value="{{$data->alamat}}">
              </div>
            </div>
            
            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Kecamatan Tempat Tinggal</b></label>
              <div class="col-sm-12">
                <select class="form-control show-tick ms select2" id="idkec" name="idkec" required>

                </select>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-4 col-form-label"><b>Pas Foto</b></label>
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

<div class="modal fade" id="modal-user" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Buat User | {{$data->nama}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="forms-sample" action="{{route('md.user.store')}}" method="post" enctype="multipart/form-data" id="formguru">
        <div class="modal-body">
          <input type="hidden" name="link" value="{{$data->id}}">
          <input type="hidden" name="role" value="3">
          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Username</b></label>
            <div class="col-sm-12">
              <input type="text" name="username" class="form-control" readonly value="{{$data->nis}}">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Password</b></label>
            <div class="col-sm-12">
                <input type="text" name="password" required class="form-control">
            </div>
          </div>
          {{ csrf_field() }}
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="save"></i> Simpan</button>
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

  $("#idkec").append($("<option selected='selected'></option>").val('{{$data->idkec}}').text('{{$data->idkec == null ? "" : "Kecamatan ".$data->kecamatan->nama.", ".$data->kecamatan->kabupaten->nama}}')).trigger('change');

  $("#idagama").append($("<option selected='selected'></option>").val('{{$data->idagama}}').text('{{$data->idagama == null ? "" : $data->agama->nama}}')).trigger('change');
});
</script>
@stop
