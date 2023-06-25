@extends('layouts.menu')

@section('title-head', 'Data Siswa')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Data Siswa Aktif
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Master Data</a></li>
              <li class="breadcrumb-item active">Siswa</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="content-body">
    <div class="row match-height">
      <div class="col-12 mb-75">
        <div class="text-center text-lg-left">
          <button class="btn btn-danger mb-25" type="button" data-toggle="modal" data-target="#modal-siswa" data-backdrop="static" data-keyboard="false" id="btnsiswa"><i data-feather="plus"></i> Tambah Siswa</button>
          <form class="d-inline" action="{{route('md.siswa.generateuser')}}" method="post">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-info mb-25" name="button" id="generate-user"><i data-feather="user-plus"></i> Generate User</button>
          </form>
          <button class="btn btn-outline-success mb-25" type="button" data-toggle="modal" data-target="#modal-export" data-backdrop="static" data-keyboard="false"><i data-feather="download"></i> Export Data</button>
        </div>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <table class="table table-bordered table-hover" id="tabelsiswa">
              <thead class="text-center">
                <tr>
                  <th>NIS</th>
                  <th>Nama</th>
                  <th>Jenis Kelamin</th>
                  <th>Kelas</th>
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
<div class="modal fade" id="modal-siswa" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Tambah Siswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="jquery-val-form" class="forms-sample" action="{{route('md.siswa.store')}}" method="post" enctype="multipart/form-data" id="formguru">
          <input type="hidden" name="idjenis" value="1">
          <div class="row">
            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Nama Siswa</b></label>
              <div class="col-sm-12">
                <input type="text" name="nama" class="form-control" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>NIS</b></label>
              <div class="col-sm-12">
                <input type="text" name="nis" class="form-control" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>NISN</b></label>
              <div class="col-sm-12">
                <input type="text" name="nisn" class="form-control" required>
              </div>
            </div>
            
            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Tahun Masuk</b></label>
              <div class="col-sm-12">
                <input type="number" name="thnmasuk" class="form-control tahun" autocomplete="off" required>
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
              <label class="col-sm-12 col-form-label"><b>Tempat Lahir</b></label>
              <div class="col-sm-12">
                <input type="text" name="tplahir" class="form-control" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Tanggal Lahir</b></label>
              <div class="col-sm-12">
                <input type="text" name="tglahir" class="form-control flatpickr-basic" placeholder="Pilih" style="background-color: white" required>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Nomor Telepon</b></label>
              <div class="col-sm-12">
                <input type="number" name="nohp" autocomplete="off"  class="form-control" id="nohp">
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Email</b></label>
              <div class="col-sm-12">
                <input type="email" name="email" autocomplete="off"  class="form-control">
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-6 col-form-label"><b>Alamat Tinggal</b></label>
              <div class="col-sm-12">
                <input type="text" name="alamat" class="form-control" id="alamat">
              </div>
            </div>

            <div class="form-group  col-md-6">
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
                  <input type="file" class="dropify" name="photos" data-allowed-file-extensions="jpg jpeg" data-max-file-size="1M">
                </div>
                <label class="col-form-label"><small>* format <b>.jpg</b> atau <b>.jpeg</b>, rasio <b>3x4</b> maksimal 1MB</small></label>
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

<div class="modal fade" id="modal-export" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Export Data Siswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="jquery-val-form" class="forms-sample" action="{{route('md.siswa.exportexcel')}}" method="post" enctype="multipart/form-data" id="formguru">
          <div class="row">
            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Pilih Tingkat</b></label>
              <div class="col-sm-12">
                <select class="form-control show-tick ms select2" name="idtingkat" id="idtingkat" data-placeholder="Semua Tingkat">

                </select>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Pilih Kelas</b></label>
              <div class="col-sm-12">
                <select class="form-control show-tick ms select2" name="idkelas" id="idkelas" data-placeholder="Semua Kelas">

                </select>
              </div>
            </div>

          {{ csrf_field() }}

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-success"><i data-feather="download"></i> Export</button>
        <button class="btn btn-sm btn-outline-dark" data-dismiss="modal">Batal</button>
      </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('jspage')
<script>
$(document).ready(function() {
  var idtingkatkelas = ''
  var table = $('#tabelsiswa').DataTable({
      processing: true,
      serverSide: true,
      autoWidth: false,
      "drawCallback": function( settings ) {
        feather.replace();
      },
      dom: '<"box-body"<"row"<"col-sm-3"l><"col-sm-5 px-3 px-md-1"<"toolbarjenis">><"col-sm-4"f>>><"box-body table-responsive"tr><"box-body"<"row"><"row"<"col-sm-6"i><"col-sm-6"p>>>',
      ajax: '{!! route('md.siswa.dt',[0,0]) !!}',
      columns: [
          { data: 'nis', name: 'nis'},          
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
          // { data: 'agama.nama', name: 'agama.nama'},
          { data: 'kelas', name: 'kelas'},
          // { data: 'idjenis', name: 'idjenis', class: 'text-center', render: function(data, type, row){
          //   if (data == 1) {
          //     return '<div class="badge badge-light-info">'+row.jenis.nama+'</div>'
          //   }else if (data == 2) {
          //     return '<div class="badge badge-light-danger">'+row.jenis.nama+'</div>'
          //   }else if (data == 3) {
          //     return '<div class="badge badge-light-secondary">'+row.jenis.nama+'</div>'
          //   }
          // }},
          { data: 'action', name: 'action', class: 'text-center'},
      ],
  });

  // $('div.toolbarjenis').html('<div class="row mt-25 mt-lg-1"><div class="col-lg-6 text-center"><select class="form-control select2" id="idkelas2" name="idkelas"></select></div><div class="col-lg-6 mt-1 mt-md-0 text-center"><select class="form-control select2" id="idjenis2" name="idjenis"></select></div></div>')
  
  $("#idkelas2").select2({
    placeholder: "Pilih Kelas",
    ajax: {
        url: '{!!route("s2.semuakelas")!!}',
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

  $("#idjenis2").select2({
    placeholder: "Pilih Jenis Siswa",
    ajax: {
        url: '{!!route("s2.jenissiswa")!!}',
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

  $('#idkelas2').on('change', function(){
    idkelas = $(this).val()
    idjenissiswa = $('#idjenis2').val()
    if (idjenissiswa == null) {
      idjenissiswa = 0
    }
    table.ajax.url('/masterdata/siswa/dt/'+idkelas+'/'+idjenissiswa).load();
  })

  $('#idjenis2').on('change', function(){
    idkelas = $('#idkelas2').val()
    if (idkelas == null) {
      idkelas = 0
    }
    idjenissiswa = $(this).val()
    table.ajax.url('/masterdata/siswa/dt/'+idkelas+'/'+idjenissiswa).load();
  })

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

  $("#provsekolah").select2({
    placeholder: "Pilih",
    ajax: {
        url: '{!!route("s2.sekolahprovinsi")!!}',
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

  $('#provsekolah').on('change', function(){
    idprovsekolah = $(this).val()
    idasalsekolah = ''
    $("#idasalsekolah").val('');
    $("#idasalsekolah").select2({
      placeholder: "Pilih",
      ajax: {
          url: '{!!route("s2.sekolah")!!}',
          dataType: 'json',
          data: function (params) {
              return {
                  q: $.trim(params.term),
                  idprov:idprovsekolah
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

  $("#idtingkat").select2({
    placeholder: "Pilih",
    ajax: {
        url: '{!!route("s2.tingkatkelas")!!}',
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


  $('#idtingkat').on('change', function(){
    idtingkatkelas = $(this).val()
    $("#idkelas").val('');
    $("#idkelas").select2({
      placeholder: "Pilih",
      ajax: {
          url: '{!!route("s2.kelas")!!}',
          dataType: 'json',
          data: function (params) {
              return {
                  q: $.trim(params.term),
                  idtingkat:idtingkatkelas
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
  });

  $("#generate-user").click(function(e) {
      var agree = confirm('Lanjutkan proses pembuatan user baru untuk semua siswa aktif yang belum memiliki user?');
      if (agree) {
        $("#loader").fadeIn(0);
      } else {
        e.preventDefault();
      }
  });

});
</script>
@stop
