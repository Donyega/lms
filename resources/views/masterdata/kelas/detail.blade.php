@extends('layouts.menu')

@section('title-head', 'Detail Kelas')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Detail Kelas
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('md.kelas')}}">Master Data Kelas</a></li>
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
        <div class="card">
          <div class="card-header border-bottom">
            <div class="head-label">
              <h4>Daftar Siswa <div class="badge badge-light-secondary">{{$data->nama}}</div> <div class="badge badge-light-primary">{{$data->jenis->nama}}</div></h4>
              <h6>Wali Kelas :
                @if($data->idwali == null)
                  <div class="badge badge-light-danger">Belum Ditentukan</div>
                @else
                  <b>{{$data->wali->nama}}</b>
                @endif
              </h6>
              <h6>Kurikulum : <b>{{$data->kurikulum->nama}}</b></h6>
            </div>
            <div class="dt-buttons d-flex-row">
              @if (count($siswa) > 0)
                <button type="button" class="btn btn-danger" name="button" data-toggle="modal" data-target="#modal-siswa" data-backdrop="static" data-keyboard="false"><i data-feather="plus"></i> Tambah Siswa</button>  
              @endif
              <button type="button" class="btn btn-outline-warning" name="button" data-toggle="modal" data-target="#modal-ubah" data-backdrop="static" data-keyboard="false"><i data-feather="edit"></i> Ubah Data Kelas</button>
              <button type="button" class="btn btn-outline-info" name="button" data-toggle="modal" data-target="#modal-wali" data-backdrop="static" data-keyboard="false"><i data-feather="user-check"></i> Tentukan Wali Kelas</button>
            </div>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-hover" id="tabelsiswa">
              <thead class="text-center">
                <tr>
                  <th>NIS</th>
                  <th>Nama Siswa</th>
                  <th>Jenis Kelamin</th>
                  <th>Agama</th>
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
<div class="modal fade" id="modal-ubah" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Ubah Data Kelas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="forms-sample" action="{{route('md.kelas.update')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="{{$data->id}}">
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Tingkat</b></label>
              <div class="col-sm-12">
                <select class="form-control show-tick ms select2" name="idtingkat" id="idtingkat" data-placeholder="Pilih" required>

                </select>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Peminatan</b></label>
              <div class="col-sm-12">
                <select class="form-control show-tick ms select2" name="idminat" data-placeholder="Pilih">
                  <option></option>
                  <option {{$data->idminat == 1 ? 'selected' : ''}} value="1">IPA</option>
                  <option {{$data->idminat == 2 ? 'selected' : ''}} value="2">IPS</option>
                </select>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Nama Kelas</b></label>
              <div class="col-sm-12">
                <input type="text" name="nama" class="form-control" value="{{$data->nama}}" autocomplete="off" required>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Jenis Kelas</b></label>
              <div class="col-sm-12">
                <select class="form-control show-tick ms select2" name="idjenis" data-placeholder="Pilih" required>
                  <option></option>
                  <option {{$data->idjenis == 1 ? 'selected' : ''}} value="1">Laboratorium</option>
                  <option {{$data->idjenis == 2 ? 'selected' : ''}} value="2">Reguler</option>
                </select>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Kurikulum</b></label>
              <div class="col-sm-12">
                <select class="form-control show-tick ms select2" name="idkurikulum" id="idkurikulum" data-placeholder="Pilih" required>

                </select>
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

<div class="modal fade" id="modal-wali" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Tentukan Wali Kelas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="jquery-val-form" class="forms-sample" action="{{route('md.kelas.updatewali')}}" method="post" enctype="multipart/form-data" id="formguru">
        <div class="modal-body">
          <input type="hidden" name="idkelas" value="{{$data->id}}">
          <div class="row">
            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Kelas</b></label>
              <div class="col-sm-12">
                <input type="text" class="form-control" value="{{$data->nama}} {{$data->jenis->nama}}" readonly>
              </div>
            </div>
            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Wali Kelas</b></label>
              <div class="col-sm-12">
                <select class="form-control show-tick ms select2" name="idwali" id="idwali" data-placeholder="Pilih">

                </select>
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

<div class="modal fade" id="modal-siswa" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Tambah Siswa | {{$data->nama}} {{$data->jenis->nama}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="forms-sample" action="{{route('md.kelas.updatesiswa')}}" method="post" enctype="multipart/form-data" id="formguru">
        <div class="modal-body">
          <input type="hidden" name="idkelas" value="{{$data->id}}">
          <div class="row">
            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Pilih Siswa</b></label>
              <div class="col-sm-12">
                <select class="form-control show-tick ms select2" multiple name="nis[]" data-placeholder="Pilih">
                  @foreach ($siswa as $s)
                    <option value="{{$s->nis}}">{{$s->nis}} - {{$s->nama}}</option>
                  @endforeach
                </select>
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

<div class="modal fade" id="modal-pindah" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Pindah Kelas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formpindah" class="forms-sample" action="{{route('md.kelas.pindahkelas')}}" method="post" enctype="multipart/form-data" id="formguru">
        <div class="modal-body">
          <input type="hidden" name="nis2" id="nis2">
          <input type="hidden" name="idklsasal" id="idklsasal">
          <input type="hidden" name="idjenisasal" id="idjenisasal" value="{{$data->idjenis}}">
          <input type="hidden" id="presensi">
          <div class="row">
            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>NIS</b></label>
              <div class="col-sm-12">
                <input type="text" class="form-control" id="nissiswa" disabled>
              </div>
            </div>
            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Nama Siswa</b></label>
              <div class="col-sm-12">
                <input type="text" class="form-control" id="namasiswa" disabled>
              </div>
            </div>
            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Kelas Asal</b></label>
              <div class="col-sm-12">
                <input type="text" class="form-control" id="klsasal" disabled>
              </div>
            </div>
            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Kelas Tujuan</b></label>
              <div class="col-sm-12">
                <select class="form-control show-tick ms select2" name="idkelas2" id="idkelas" data-placeholder="Pilih" required>

                </select>
              </div>
            </div>
            <div class="form-group col-md-12 penyesuaian">
              <div class="col-12">
                <div class="alert alert-danger" role="alert">
                  <h4 class="alert-heading"><i data-feather="alert-circle" style="margin-top: -2px"></i> PERHATIAN</h4>
                  <div class="alert-body">
                    Jenis kelas tujuan <b>berbeda</b> dengan jenis kelas asal, silakan pilih bulan dimulainya penyesuaian tagihan SPP!
                  </div>
                </div>
              </div>
              <label class="col-sm-12 col-form-label"><b>Bulan Penyesuaian Tagihan</b></label>
              <div class="col-sm-12">
                <select class="form-control show-tick ms select2" name="bulanspp" id="bulanspp">

                </select>
              </div>
            </div>
          </div>
          {{ csrf_field() }}
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success btnsubmit"><i data-feather="repeat"></i> Pindahkan</button>
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
  var smt = '{{$ta->semester}}'
  var table = $('#tabelsiswa').DataTable({
      processing: true,
      serverSide: true,
      autoWidth: false,
      "drawCallback": function( settings ) {
        feather.replace();
      },
      dom: '<"box-body"<"row"<"col-sm-3"l><"col-sm-5"<"toolbar">><"col-sm-4"f>>><"box-body table-responsive"tr><"box-body"<"row"><"row"<"col-sm-6"i><"col-sm-6"p>>>',
      ajax: '{!! route('md.kelas.dtsiswa',$data->id) !!}',
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
          { data: 'agama.nama', name: 'agama.nama'},
          { data: 'action', name: 'action', class: 'text-center'},
      ],
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

  $("#idkurikulum").select2({
    placeholder: "Pilih",
    ajax: {
        url: '{!!route("s2.kurikulum")!!}',
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

  $("#idtingkat").append($("<option selected='selected'></option>").val('{{$data->idtingkat}}').text('{{$data->idtingkat == null ? "" : $data->tingkat->nama}}')).trigger('change');

  $("#idkurikulum").append($("<option selected='selected'></option>").val('{{$data->idkurikulum}}').text('{{$data->idkurikulum == null ? "" : $data->kurikulum->nama}}')).trigger('change');

  $("#idwali").select2({
    placeholder: "Pilih",
    ajax: {
        url: '{!!route("s2.guru")!!}',
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

  $("#bulanspp").select2({
    placeholder: "Pilih bulan dimulainya penyesuaian",
    ajax: {
        url: '{!!route("s2.bulanspp")!!}',
        dataType: 'json',
        data: function (params) {
            return {
                q: $.trim(params.term),
                semester : smt
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

  $('#tabelsiswa tbody').on('click', '#btnedit', function () {
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var data = row.data()
    var idtingkatkelas = '{{$data->idtingkat}}'
    $('.penyesuaian').hide()
    $('#namasiswa').val(data.nama)
    $('#nis2').val(data.nis)
    $('#nissiswa').val(data.nis)
    $('#idklsasal').val(data.idkelas)
    $('#presensi').val(data.presensi)
    $('#klsasal').val('{{$data->nama}} {{$data->jenis->nama}}')
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
  
  var jenisasal = '{{$data->idjenis}}'
  var jenistujuan;
  $('#idkelas').on('change', function(){
    idkelas = $(this).val()
    $.get('/masterdata/kelas/getjenis/'+idkelas, function(data){
        jenistujuan = data.idjenis
        if (jenisasal == jenistujuan) {
          $('.penyesuaian').hide()
          $('#bulanspp').prop('required', false);
        }else {
          $('.penyesuaian').show()
          $('#bulanspp').prop('required', true);
        }
    });
  })

  $("#idwali").append($("<option selected='selected'></option>").val('{{$data->idwali}}').text('{{$data->idwali == null ? "" : $data->wali->nama}}')).trigger('change');

  $('#formpindah').on('click', '.btnsubmit', function () {
    var namasiswa = $('#namasiswa').val()
    var namakls = $('#klsasal').val()
    var presensi = $('#presensi').val()
    if (presensi > 0) {
      if( !confirm('Siswa a/n '+namasiswa+' telah memiliki presensi kehadiran di kelas '+namakls+'. Anda yakin akan memindahkan siswa tersebut ke kelas lain? Data presensi siswa di kelas '+namakls+' akan dihapus setelah Anda melanjutkan proses pindah kelas.')){
          event.preventDefault();
      }
    }else {
      if( !confirm('Lanjutkan proses pemindahan Siswa a/n '+namasiswa+' dari kelas '+namakls+'?')){
          event.preventDefault();
      }
    }
  });

});
</script>
@stop
