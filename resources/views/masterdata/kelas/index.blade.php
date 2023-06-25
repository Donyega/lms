@extends('layouts.menu')

@section('title-head', 'Data Kelas')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Data Kelas
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Master Data</a></li>
              <li class="breadcrumb-item active">Kelas</li>
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
            <div class="row mx-0">
              <button class="btn btn-danger mr-25" type="button"  data-toggle="modal" data-target="#modal-kelas" data-backdrop="static" data-keyboard="false" id="btnkelas"><i data-feather="plus"></i> Tambah Kelas</button>
              <form class="d-inline" action="{{route('md.kelas.resetwali')}}" method="post"  onsubmit="return confirm('Reset wali kelas akan mengosongkan seluruh wali kelas pada tahun ajaran berjalan, Anda yakin akan melanjutkan proses reset?')">
                <button type="submit" class="btn btn-warning" name="button" style="white-space: nowrap"><i data-feather="refresh-cw"></i> Reset Wali Kelas</button>
                {{csrf_field()}}
              </form>
            </div>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-hover" id="tabelkelas">
              <thead class="text-center">
                <tr>
                  <th>Tingkat</th>
                  <th>Nama Kelas</th>
                  <th>Jenis Kelas</th>
                  <th>Peminatan</th>
                  <th>Jumlah Siswa</th>
                  <th>Wali Kelas</th>
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
<div class="modal fade" id="modal-kelas" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Tambah Data Kelas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="jquery-val-form" class="forms-sample" action="{{route('md.kelas.store')}}" method="post" enctype="multipart/form-data" id="formguru">
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
                  <option value="1">IPA</option>
                  <option value="2">IPS</option>
                </select>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Nama Kelas</b></label>
              <div class="col-sm-12">
                <input type="text" name="nama" class="form-control" autocomplete="off" required>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Jenis Kelas</b></label>
              <div class="col-sm-12">
                <select class="form-control show-tick ms select2" name="idjenis" data-placeholder="Pilih" required>
                  <option></option>
                  <option value="1">Laboratorium</option>
                  <option value="2">Reguler</option>
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
@endsection

@section('jspage')
<script>
$(document).ready(function() {
  var table = $('#tabelkelas').DataTable({
      processing: true,
      serverSide: true,
      autoWidth: false,
      "drawCallback": function( settings ) {
        feather.replace();
      },
      dom: '<"box-body"<"row"<"col-sm-3"l><"col-sm-5"<"toolbarstatus">><"col-sm-4"f>>><"box-body table-responsive"tr><"box-body"<"row"><"row"<"col-sm-6"i><"col-sm-6"p>>>',
      ajax: '{!! route('md.kelas.dt',1) !!}',
      columns: [
          { data: 'tingkat.nama', name: 'tingkat.nama'},
          { data: 'nama', name: 'nama'},
          { data: 'jenis.nama', name: 'jenis.nama'},
          { data: 'minat.nama', name: 'minat.nama', class: 'text-center', render: function(data, type, row){
            if (row.idminat == 0) {
              return '-'
            }else {
              return data
            }
          }},
          { data: 'jumlah', name: 'jumlah', class: 'text-center'},
          { data: 'wali.nama', name: 'wali.nama', render: function(data, type, row){
            if (data == null) {
              return '<div class="badge badge-light-danger">Belum Ditentukan</div>'
            }else {
              return row.wali.nama
            }
          }},
          { data: 'action', name: 'action', class: 'text-center'},
      ],
      order: [
          [0 , 'asc'],
          [1 , 'asc'],
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

  $('div.toolbarstatus').html('<div class="text-center mt-25 mt-lg-1"><select class="form-control select2" id="idstatus" name="idstatus" data-placeholder="Pilih Status Kelas"><option></option><option value="1">Kelas Aktif</option><option value="0">Kelas Tidak Aktif</option></select></div>')

  $("#idstatus").select2({
    placeholder: "Pilih",
  });

  $('#idstatus').on('change', function(){
    var idstatus = $(this).val()
    table.ajax.url('/masterdata/kelas/dt/'+idstatus).load();
  })

  $('#tabelkelas tbody').on('click','.btnaktif', function(){
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var data = row.data()
    var namakelas = data.nama+' '+data.jenis.nama
    if (data.isaktif == 1) {
      status = 'menonaktifkan'
    }else {
      status = 'mengaktifkan'
    }
    if( !confirm('Lanjutkan proses '+status+' kelas '+namakelas+'?')){
        event.preventDefault();
    }
  })
});
</script>
@stop
