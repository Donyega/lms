@extends('layouts.page')

@section('title-head', 'Data Peringkat Nilai')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Data Peringkat Nilai
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Master Data</a></li>
              <li class="breadcrumb-item active">Peringkat Nilai</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="content-body">
    <div class="row">
      <div class="col-12 text-center text-lg-left mb-75">
        <button class="btn btn-danger mr-25" type="button" data-toggle="modal" data-target="#modal-nilai" data-backdrop="static" data-keyboard="false" id="btnadd"><i data-feather="plus"></i> Tambah Peringkat Nilai</button>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <table class="table table-bordered table-hover" id="tabelperingkat">
              <thead class="text-center">
                <tr>
                  <th>Peringkat / Grade</th>
                  <th>Batas Bawah</th>
                  <th>Batas Atas</th>
                  <th>Status</th>
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
<div class="modal fade" id="modal-nilai" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Tambah Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="jquery-val-form" class="forms-sample formekskul" action="#" method="post">
        <input type="hidden" name="idnilai" id="idnilai">
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Peringkat</b></label>
              <div class="col-sm-12">
                <input type="text" name="huruf" id="huruf" class="form-control" autocomplete="off" required>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Batas Bawah</b></label>
              <div class="col-sm-12">
                <input type="nilai" name="dari" id="dari" class="form-control" autocomplete="off" required>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Batas Atas</b></label>
              <div class="col-sm-12">
                <input type="nilai" name="sampai" id="sampai" class="form-control" autocomplete="off" required>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Status</b></label>
              <div class="col-sm-12">
                <select class="form-control select2" name="status" id="status" data-placeholder="Pilih">
                  <option value="1">Aktif</option>
                  <option value="0">Tidak Aktif</option>
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
  var table = $('#tabelperingkat').DataTable({
    processing: true,
    serverSide: true,
    autoWidth: false,
    "drawCallback": function( settings ) {
      feather.replace();
    },
    dom: '<"box-body"<"row"<"col-sm-3"l><"col-sm-5"<"toolbar">><"col-sm-4"f>>><"box-body table-responsive"tr><"box-body"<"row"><"row"<"col-sm-6"i><"col-sm-6"p>>>',
    ajax: '{!! route('md.nilai.dt') !!}',
    columns: [
      { data: 'huruf', name: 'huruf', class: 'text-center' },
      { data: 'dari', name: 'dari', class: 'text-center' },
      { data: 'sampai', name: 'sampai', class: 'text-center' },
      { data: 'status', name: 'status', class: 'text-center', render: function(data, type, row){
        if (data == 0) {
          return '<div class="badge badge-light-secondary">Tidak Aktif</div>'
        }else {
          return '<div class="badge badge-light-success">Aktif</div>'
        }
      }},
      { data: 'action', name: 'action', class: 'text-center' },
    ],
  });

  $('#tabelperingkat tbody').on('click', '#btnedit', function () {
      $('#modaltitle').text('Ubah Data Peringkat Nilai')
      $('.formekskul').attr('action', "{{route('md.nilai.update')}}")
      var tr = $(this).closest('tr');
      var row = table.row(tr);
      var data = row.data()
      $('#idnilai').val(data.id)
      $('#huruf').val(data.huruf)
      $('#dari').val(data.dari)
      $('#sampai').val(data.sampai)
      $('#status').val(data.status).change()
  });

  $('#btnadd').on('click', function () {
      $('#modaltitle').text('Tambah Data Peringkat Nilai')
      $('.formekskul').attr('action', "{{route('md.nilai.store')}}")
      $('#idnilai').val('')
      $('#huruf').val('')
      $('#dari').val('')
      $('#sampai').val('')
      $('#status').val(1).change()
  });

});
</script>
@stop
