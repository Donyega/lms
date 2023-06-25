@extends('layouts.menu')

@section('title-head', 'Data Mata Pelajaran')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Data Mata Pelajaran
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Master Data</a></li>
              <li class="breadcrumb-item active">Mata Pelajaran</li>
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
              <button class="btn btn-danger mr-25" type="button"  data-toggle="modal" data-target="#modal-mapel" data-backdrop="static" data-keyboard="false" id="btntambah"><i data-feather="plus"></i> Tambah Mata Pelajaran</button>
              {{-- <button class="btn btn-outline-success mr-25" type="button"  data-toggle="modal" data-target="#modal-siswa" data-backdrop="static" data-keyboard="false" id="btnsiswa"><i data-feather="download"></i> Export Data</button> --}}
            </div>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-hover" id="tabelmapel">
              <thead class="text-center">
                <tr>
                  <th>Nama Mata Pelajaran</th>
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
<div class="modal fade" id="modal-mapel" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="jquery-val-form" class="forms-sample formmapel" action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idmapel" id="idmapel">
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Nama Mata Pelajaran</b></label>
              <div class="col-sm-12">
                <input type="text" name="nama" id="nama" class="form-control" autocomplete="off" required>
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
  var table = $('#tabelmapel').DataTable({
      processing: true,
      serverSide: true,
      autoWidth: false,
      "drawCallback": function( settings ) {
        feather.replace();
      },
      dom: '<"box-body"<"row"<"col-sm-3"l><"col-sm-5"<"toolbar">><"col-sm-4"f>>><"box-body table-responsive"tr><"box-body"<"row"><"row"<"col-sm-6"i><"col-sm-6"p>>>',
      ajax: '{!! route('md.mapel.dt') !!}',
      columns: [
          { data: 'nama', name: 'nama'},
          { data: 'action', name: 'action', class: 'text-center'},
      ],
  });
  $.fn.DataTable.ext.pager.numbers_length = 5;

  $('#tabelmapel tbody').on('click', '#btnedit', function () {
      $('#modaltitle').text('Ubah Mata Pelajaran')
      $('.formmapel').attr('action', "{{route('md.mapel.update')}}")
      var tr = $(this).closest('tr');
      var row = table.row(tr);
      var data = row.data()
      $('#idmapel').val(data.id)
      $('#nama').val(data.nama)
  });

  $('#btntambah').on('click', function () {
      $('#modaltitle').text('Tambah Mata Pelajaran Baru')
      $('.formmapel').attr('action', "{{route('md.mapel.store')}}")
      $('#nama').val('')
  });
});
</script>
@stop
