@extends('layouts.menu')

@section('title-head', 'Pengaturan Profil Sekolah')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Pengaturan Profil Sekolah</h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
              <li class="breadcrumb-item active">Profil Sekolah</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="content-body">
    <div class="row">
      <div class="col-6">
        <div class="card">
          <div class="card-body">
              <h4 class="card-title">Logo</h4>
          </div>
          <div class="text-center">
            <img class="img-fluid" src="{{asset($logo->logo)}}" alt="Card image cap" style="width: 15rem;" />
          </div>
          <div class="card-body text-center">
            <button class="btn btn-danger mt-25 mt-lg-0" data-toggle="modal" data-target="#modal-logo">Perbarui Logo</button>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
              <h4 class="card-title">Favicon</h4>
          </div>
          <div class="text-center">
            <img class="img-fluid" src="{{asset($favicon->favicon)}}" alt="Card image cap" style="width: 15rem;" />
          </div>
          <div class="card-body text-center">
            <button class="btn btn-danger mt-25 mt-lg-0" data-toggle="modal" data-target="#modal-favicon">Perbarui Favicon</button>
          </div>
        </div>
      </div>
      <div class="col-6">
        @if ($data == null)
          <div class="card">
            <div class="card-body">
              <div class="row align-items-center text-center text-lg-left">
                <div class="col-sm-1 p-0 text-center">
                  <div class="avatar bg-light-danger p-50 m-25">
                    <div class="avatar-content">
                      <i data-feather="info" class="font-medium-5"></i>
                    </div>
                  </div>
                </div>
                <div class="col-sm-9">
                  <h4 class="font-weight-bolder mb-0">PERHATIAN</h4>
                  <p class="card-text">Profil sekolah belum dilengkapi, silakan tekan tombol <b>Perbarui Profil</b> untuk melengkapi.</p>
                </div>
                <div class="col-sm-2 text-center text-lg-right">
                  <button class="btn btn-sm btn-outline-success mt-25 mt-lg-0" data-toggle="modal" data-target="#modal-profil"><i data-feather="home"></i> Perbarui Profil</button>
                </div>
              </div>
            </div>
          </div>
        @else
          <div class="text-center text-lg-left mb-1">
            <button class="btn btn-danger mt-25 mt-lg-0" data-toggle="modal" data-target="#modal-profil"><i data-feather="home"></i> Perbarui Profil</button>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped">
                  <tr>
                    <td style="width: 40%">Nama</td>
                    <td class="px-0" style="width: 1px">:</td>
                    <th>{{$data->nama}}</th>
                  </tr>
                  <tr>
                    <td>Alamat</td>
                    <td class="px-0" style="width: 1px">:</td>
                    <th>{{$data->alamat}}</th>
                  </tr>
                  <tr>
                    <td>Email</td>
                    <td class="px-0" style="width: 1px">:</td>
                    <th>{{$data->email}}</th>
                  </tr>
                  <tr>
                    <td>Telepon</td>
                    <td class="px-0" style="width: 1px">:</td>
                    <th>{{$data->telpon}}</th>
                  </tr>
                </table>
              </div>
              <hr class="m-0">
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@section('modal')
<div class="modal fade" id="modal-profil" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Perbarui Profil Sekolah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="jquery-val-form" class="forms-sample" action="{{route('profilsekolah.store')}}" method="post">
        <input type="hidden" name="id" value="1">
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Nama Sekolah</b></label>
              <div class="col-sm-12">
                <input type="text" name="nama" class="form-control" autocomplete="off" value="{{$data == null ? '' : $data->nama}}" required>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Badan Penyelenggara</b></label>
              <div class="col-sm-12">
                <input type="text" name="penyelenggara" class="form-control" autocomplete="off" value="{{$data == null ? '' : $data->penyelenggara}}" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Nomor Pokok Sekolah Nasional (NPSN)</b></label>
              <div class="col-sm-12">
                <input type="number" name="npsn" class="form-control" autocomplete="off" value="{{$data == null ? '' : $data->npsn}}" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Nomor Statistik Sekolah (NSS)</b></label>
              <div class="col-sm-12">
                <input type="number" name="nss" class="form-control" autocomplete="off" value="{{$data == null ? '' : $data->nss}}" required>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Alamat Sekolah</b></label>
              <div class="col-sm-12">
                <input type="text" name="alamat" class="form-control" autocomplete="off" value="{{$data == null ? '' : $data->alamat}}" required>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Wilayah Kelurahan</b></label>
              <div class="col-sm-12">
                <input type="text" name="kelurahan" class="form-control" autocomplete="off" value="{{$data == null ? '' : $data->kelurahan}}" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Kode Pos</b></label>
              <div class="col-sm-12">
                <input type="text" name="kodepos" class="form-control" autocomplete="off" value="{{$data == null ? '' : $data->kodepos}}" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Provinsi</b></label>
              <div class="col-sm-12">
                <select class="form-control select2" id="provinsi">

                </select>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Kabupaten / Kota</b></label>
              <div class="col-sm-12">
                <select class="form-control select2" id="kabupaten">
                  
                </select>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Kecamatan</b></label>
              <div class="col-sm-12">
                <select name="idkec" class="form-control select2" id="kecamatan" required>
                  
                </select>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Telepon</b></label>
              <div class="col-sm-12">
                <input type="text" name="telpon" class="form-control" autocomplete="off" value="{{$data == null ? '' : $data->telpon}}" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Fax</b></label>
              <div class="col-sm-12">
                <input type="text" name="fax" class="form-control" autocomplete="off" value="{{$data == null ? '' : $data->fax}}">
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Email</b></label>
              <div class="col-sm-12">
                <input type="email" name="email" class="form-control" autocomplete="off" value="{{$data == null ? '' : $data->email}}" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Website</b></label>
              <div class="col-sm-12">
                <input type="text" name="website" class="form-control" autocomplete="off" value="{{$data == null ? '' : $data->website}}">
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Status Akreditasi</b></label>
              <div class="col-sm-12">
                <input type="text" name="akreditasi" class="form-control" autocomplete="off" value="{{$data == null ? '' : $data->akreditasi}}" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Tanggal SK Akreditasi</b></label>
              <div class="col-sm-12">
                <input type="text" name="tglsk" class="form-control flatpickr-basic"  placeholder="Pilih" value="{{$data == null ? '' : $data->tglsk}}" style="background-color: white" required>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Nomor SK Akreditasi</b></label>
              <div class="col-sm-12">
                <input type="text" name="nosk" class="form-control" autocomplete="off" value="{{$data == null ? '' : $data->nosk}}" required>
              </div>
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
<div class="modal fade" id="modal-favicon" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Perbarui Favicon</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="jquery-val-form" class="forms-sample" action="{{route('profilsekolah.favicon')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="1">
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Favicon</b></label>
              <div class="col-sm-12">
                <input type="file" class="dropify" name="favicon" data-allowed-file-extensions="png"
                  data-max-file-size="1M"
                  @if ($favicon->favicon != null) data-default-file="{{ asset($favicon->favicon) }}" @endif>
                  <label class="col-form-label"><small>* format file <b>.png</b>, ukuran maksimal
                      1MB</small></label>
              </div>
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
<div class="modal fade" id="modal-logo" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Perbarui Logo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="jquery-val-form" class="forms-sample" action="{{route('profilsekolah.logo')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="1">
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Logo</b></label>
              <div class="col-sm-12">
                <input type="file" class="dropify" name="logo" data-allowed-file-extensions="png"
                  data-max-file-size="1M"
                  @if ($logo->logo != null) data-default-file="{{ asset($logo->logo) }}" @endif>
                  <label class="col-form-label"><small>* format file <b>.png</b>, ukuran maksimal
                      1MB</small></label>
              </div>
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
    var table = $('#tabelta').DataTable({
      processing: true,
      serverSide: true,
      autoWidth: false,
      "drawCallback": function( settings ) {
        feather.replace();
      },
      dom: '<"box-body"<"row"<"col-sm-3"l><"col-sm-5"<"toolbar">><"col-sm-4"f>>><"box-body table-responsive"tr><"box-body"<"row"><"row"<"col-sm-6"i><"col-sm-6"p>>>',
      ajax: '{!! route('md.ta.dt') !!}',
      columns: [
        { data: 'id', name: 'id'},
        { data: 'tahun', name: 'tahun', class: 'text-center'},
        { data: 'semester', name: 'semester', class: 'text-center', render: function(data) {
          if(data == 1) {
            return 'Ganjil'
          }
          else {
            return 'Genap'
          }
        }},
        { data: 'isAktif', name: 'isAktif', class: 'text-center', render: function(data) {
          if(data == 1) {
            return '<div class="badge badge-light-success">Aktif</div>'
          }
          else {
            return '<div class="badge badge-light-secondary">Tidak Aktif</div>'
          }
        }},
        { data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'},
      ],
      order: [[ 0, "desc" ]],
      columnDefs: [
        {
          "targets": [ 0 ],
          "visible": false,
          "searchable": false,
          "orderable": true
        },
      ],
    });

    $('#tabelta tbody').on('click', '#submit', function () {
      var tr = $(this).closest('tr');
      var row = table.row(tr);
      if (row.data().semester == 1) {
        var s = 'Ganjil';
      }else {
        var s = 'Genap';
      }
      var agree = confirm('Aktifkan tahun ajaran '+row.data().tahun+' '+s+'?');
      if (agree) {
        $("#loader").fadeIn(0);
      } else {
        e.preventDefault();
      }
    })

    $("#provinsi").select2({
      placeholder: "Pilih",
      ajax: {
          url: '{!!route("s2.provinsi")!!}',
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

    $("#kabupaten").select2({
      placeholder: "Pilih Provinsi Terlebih Dulu",
    });

    $("#kecamatan").select2({
      placeholder: "Pilih Kabupaten Terlebih Dulu",
    });

    $('#provinsi').on('change', function(){
      idprov = $(this).val()
      $('#kabupaten').val('');
      $('#kecamatan').val('').change();
      $("#kabupaten").select2({
        placeholder: "Pilih",
        ajax: {
            url: '{!!route("s2.kabupaten")!!}',
            dataType: 'json',
            data: function (params) {
                return {
                    q: $.trim(params.term),
                    idprov: idprov
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
    })

    $('#kabupaten').on('change', function(){
      idkab = $(this).val()
      $('#kecamatan').val('');
      $("#kecamatan").select2({
        placeholder: "Pilih",
        ajax: {
            url: '{!!route("s2.pilihkecamatan")!!}',
            dataType: 'json',
            data: function (params) {
                return {
                    q: $.trim(params.term),
                    idkab: idkab
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
    })

    $("#provinsi").append($("<option selected='selected'></option>").val('{{$data->idkec == null ? "" : $data->kecamatan->kabupaten->idprov}}').text('{{$data->idkec == null ? "" : $data->kecamatan->kabupaten->provinsi->nama}}')).trigger('change');

    $("#kabupaten").append($("<option selected='selected'></option>").val('{{$data->idkec == null ? "" : $data->kecamatan->idkab}}').text('{{$data->idkec == null ? "" : $data->kecamatan->kabupaten->nama}}')).trigger('change');

    $("#kecamatan").append($("<option selected='selected'></option>").val('{{$data->idkec}}').text('{{$data->idkec == null ? "" : $data->kecamatan->nama}}')).trigger('change');

  });
</script>
@stop
