@extends('layouts.menu')

@section('title-head', 'Pengaturan Jadwal Pelajaran')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Jadwal Pelajaran
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
              <li class="breadcrumb-item active">Jadwal Pelajaran</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="content-body">
    <div class="row">
      <div class="col-12">
        <ul class="nav nav-pills">
          <li class="nav-item">
            <a class="nav-link active" id="all-tab" data-toggle="pill" href="#all" aria-expanded="true">Semua Jadwal</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="nonhindu-tab" data-toggle="pill" href="#nonhindu" aria-expanded="true">Agama</a>
          </li>
        </ul>
        <div class="card">
          <div class="card-body">
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="all" aria-labelledby="all-tab" aria-expanded="true">
                <table class="table table-bordered table-hover" id="tabelkelas">
                  <thead class="text-center">
                    <tr>
                      <th>Tingkat</th>
                      <th>Kelas</th>
                      <th>Peminatan</th>
                      <th>Jumlah Siswa</th>
                      <th>Jumlah Jadwal</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
              <div role="tabpanel" class="tab-pane" id="nonhindu" aria-labelledby="nonhindu-tab" aria-expanded="true">
                <table class="table table-bordered table-hover" id="tabelnonhindu">
                  <thead class="text-center">
                    <tr>
                      <th>Tingkat Kelas</th>
                      <th>Jumlah Siswa</th>
                      <th>Jumlah Jadwal</th>
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
  </div>
</div>
@endsection

@section('modal')
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
      dom: '<"box-body"<"row"<"col-sm-3"l><"col-sm-5"<"toolbar">><"col-sm-4"f>>><"box-body table-responsive"tr><"box-body"<"row"><"row"<"col-sm-6"i><"col-sm-6"p>>>',
      ajax: '{!! route('md.jadwal.dt') !!}',
      columns: [
          { data: 'tingkat.nama', name: 'tingkat.nama', class: 'text-center'},
          { data: 'nama', name: 'nama', render: function(data, type, row){
            return data+' '+row.jenis.nama
          }},
          { data: 'minat.nama', name: 'minat.nama', class: 'text-center', render: function(data, type, row){
            if (row.idminat == 0) {
              return '-'
            }else {
              return data
            }
          }},
          { data: 'jumlah', name: 'jumlah', class: 'text-center'},
          { data: 'jadwal', name: 'jadwal', class: 'text-center'},
          { data: 'action', name: 'action', class: 'text-center'},
      ],
      order: [
          [0 , 'asc'],
          [1 , 'asc'],
      ],
  });

  var table = $('#tabelnonhindu').DataTable({
      processing: true,
      serverSide: true,
      autoWidth: false,
      "drawCallback": function( settings ) {
        feather.replace();
      },
      dom: '<"box-body"<"row"<"col-sm-3"l><"col-sm-5"<"toolbar">><"col-sm-4"f>>><"box-body table-responsive"tr><"box-body"<"row"><"row"<"col-sm-6"i><"col-sm-6"p>>>',
      ajax: '{!! route('md.jadwal.dtagama') !!}',
      columns: [
          { data: 'nama', name: 'nama', class: 'text-center'},
          { data: 'jumlah', name: 'jumlah', class: 'text-center'},
          { data: 'jadwal', name: 'jadwal', class: 'text-center'},
          { data: 'action', name: 'action', class: 'text-center'},
      ],
  });
});
</script>
@stop
