@extends('layouts.menu')

@section('title-head', 'Data Pegawai')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Data Pegawai</h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Master Data</a></li>
              <li class="breadcrumb-item active">Pegawai</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="content-body">
    <div class="row match-height">
      @php
        $no = 4;
        $mb = 2;
        if (count($data) == 2) {
          $no = 6;
        }elseif (count($data) > 3) {
          $no = 3;
          $mb = 1;
        }
      @endphp
      @if(count($data) > 0)
        @foreach($data as $d)
          <div class="col-lg-{{$no}}">
            <div class="card mb-{{$mb}}">
              <div class="card-body row mx-0">
                <div class="avatar bg-light-success p-50 mr-1">
                  <div class="avatar-content">
                    <i data-feather="users" class="font-medium-5"></i>
                  </div>
                </div>
                <div>
                  <p class="card-text mb-0">{{$d->nama}}</p>
                  <h4 class="font-weight-bolder mb-0 text-success">{{$d->jumlah}}</h4>
                </div>
              </div>
            </div>
          </div>
        @endforeach  
      @endif
      <div class="col-12 mb-75">
        <div class="text-center text-lg-left">
          <button class="btn btn-danger mb-25" type="button"  data-toggle="modal" data-target="#modal-pegawai" data-backdrop="static" data-keyboard="false" id="btnsiswa"><i data-feather="plus"></i> Tambah Pegawai</button>
          <form class="d-inline" action="{{route('md.pegawai.generateuser')}}" method="post" onsubmit="return confirm('Lanjutkan proses pembuatan user baru untuk semua pegawai aktif yang belum memiliki user?')">
            <input type="hidden" name="role" value="1">
            <input type="hidden" name="jenispegawai" value="2">
            <button type="submit" class="btn btn-info mb-25" name="button"><i data-feather="user-plus"></i> Generate User</button>
            {{ csrf_field() }}
          </form>
          <button class="btn btn-outline-success mb-25" type="button"  data-toggle="modal" data-target="#modal-export" data-backdrop="static" data-keyboard="false" id="btnsiswa"><i data-feather="download"></i> Export Data</button>
        </div>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <table class="table table-bordered" id="tabelpegawai">
              <thead class="text-center">
                <tr>
                  <th>Nama</th>
                  <th>Jenis Kelamin</th>
                  <th>PTK</th>
                  <th>Status Kepegawaian</th>
                  <th>Aksi</th>
                </tr>
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
<div class="modal fade" id="modal-pegawai" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Tambah Data Pegawai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="jquery-val-form" class="forms-sample" action="{{route('md.pegawai.store')}}" method="post" enctype="multipart/form-data" id="formguru">
          <input type="hidden" name="jenis" value="2">
          <div class="row">
            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Nama Pegawai</b></label>
              <div class="col-sm-12">
                <input type="text" name="nama" class="form-control" autocomplete="off" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Panggilan</b> <small>(maksimal 12 karakter)</small></label>
              <div class="col-sm-12">
                <input type="text" maxlength="12" name="panggilan" class="form-control" autocomplete="off" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Tempat Lahir</b></label>
              <div class="col-sm-12">
                <input type="text" name="tplahir" class="form-control" autocomplete="off" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Tanggal Lahir</b></label>
              <div class="col-sm-12">
                <input type="text" name="tglahir" class="form-control flatpickr-basic" autocomplete="off" placeholder="Pilih" style="background-color: white" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Jenis Kelamin</b></label>
              <div class="col-sm-12">
                <div class="row mx-0">
                  <div class="custom-control custom-radio mr-2">
                    <input type="radio" id="jk" name="jk" value="L" class="custom-control-input" required>
                    <label class="custom-control-label" for="jk">Laki-Laki</label>
                  </div>
                  <div class="custom-control custom-radio">
                    <input type="radio" id="jka" name="jk" value="P" class="custom-control-input">
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
                <input type="text" name="alamat" class="form-control" id="alamat" autocomplete="off" required>
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
                <input type="text" name="nik" autocomplete="off" class="form-control" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Nomor Telepon</b></label>
              <div class="col-sm-12">
                <input type="text" name="nohp" autocomplete="off"  class="form-control" id="nohp" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Email</b></label>
              <div class="col-sm-12">
                <input type="email" name="email" autocomplete="off"  class="form-control" id="email" required>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-4 col-form-label"><b>Foto</b></label>
              <div class="col-sm-12">
                <div class="body">
                  <input type="file" class="dropify" name="photos" data-allowed-file-extensions="jpg jpeg" data-max-file-size="1M" required>
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
        <h5 class="modal-title" id="modaltitleuser">Buat User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="forms-sample" action="#" method="post" enctype="multipart/form-data" id="formuser">
        <input type="hidden" name="role" value="1">
        <input type="hidden" name="link" id="link">
        <div class="modal-body">
          <div class="alert alert-danger mb-0" role="alert">
            <div class="alert-body">
              Tidak dapat menambahkan user baru karena <b>alamat email belum dilengkapi</b>. Silakan melengkapi alamat email pada halaman Detail.
            </div>
          </div>

          <div class="isian">
            <div class="form-group">
              <label class="col-sm-12 col-form-label"><b>Username</b></label>
              <div class="col-sm-12">
                <input type="text" name="username" id="username" class="form-control" readonly value="">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-12 col-form-label"><b>Password</b></label>
              <div class="col-sm-12">
                  <input type="text" name="password" id="password" required class="form-control">
              </div>
            </div>
          </div>
          
          {{ csrf_field() }}
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success simpan"><i data-feather="save"></i> Simpan</button>
          <button class="btn btn-sm btn-outline-dark" data-dismiss="modal">Kembali</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-export" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Export Data Pegawai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="forms-sample" action="{{route('md.pegawai.exportexcel')}}" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <input type="hidden" name="jenispegawai" value="2">
          <div class="row">
            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Pilih Status Pegawai</b></label>
              <div class="col-sm-12">
                <select class="form-control show-tick ms select2" id="idstatus" name="idstatus">

                </select>
              </div>
            </div>
          </div>
          {{ csrf_field() }}
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="download"></i> Export</button>
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
  var table = $('#tabelpegawai').DataTable({
      processing: true,
      serverSide: true,
      autoWidth: false,
      "drawCallback": function( settings ) {
        feather.replace();
      },
      dom: '<"box-body"<"row"<"col-sm-3"l><"col-sm-5"<"toolbarstatus">><"col-sm-4"f>>><"box-body table-responsive"tr><"box-body"<"row"><"row"<"col-sm-6"i><"col-sm-6"p>>>',
      ajax: '{!! route('md.pegawai.dt',0) !!}',
      columns: [
          { data: 'nama', name: 'nama'},
          { data: 'jk', name: 'jk', render: function(data, type, row){
            if (data == 'L') {
              return 'Laki-laki'
            }else if (data == 'P') {
              return 'Perempuan'
            }else {
              return ''
            }
          }},
          { data: 'detil.jenisptk.nama', name: 'detil.jenisptk.nama', render: function(data, type, row){
            if (row.detil.idjenisptk == null) {
              return '<div class="badge badge-light-danger">Belum Ditentukan</div>'
            }else {
              return data
            }
          }},
          { data: 'action', name: 'action', class: 'text-center'},
      ],
  });
  $.fn.DataTable.ext.pager.numbers_length = 5;

  $('div.toolbarstatus').html('<div class="text-center mt-25 mt-lg-1"><select class="form-control show-tick ms select2" id="idstatus2" name="idstatus"></select></div>')

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

  $("#idstatus").select2({
    placeholder: "Semua Status",
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

  $("#idstatus2").select2({
    placeholder: "Pilih Status Pegawai",
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

  $('#idstatus2').on('change', function(){
    var idstatusguru = $(this).val()
    table.ajax.url('/masterdata/pegawai/dt/'+idstatusguru).load();
  })

  $('#tabelpegawai tbody').on('click', '#btnuser', function () {
      $('#formuser').attr('action', '{{route("md.user.store")}}');
      var tr = $(this).closest('tr');
      var row = table.row(tr);
      if (row.data().email == null) {
        $('.alert').show();
        $('.isian').hide();
        $('.simpan').hide();
      }else {
        $('.alert').hide();
        $('.isian').show();
        $('.simpan').show();
      }
      $('#username').val(row.data().email)
      $('#username').prop('readonly', true);

      $('#link').val(row.data().id)
      $('#modaltitleuser').text('Buat User | '+row.data().nama)
  });
});
</script>
@stop
