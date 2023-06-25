@extends('layouts.page')

@section('title-head', 'Pengumuman Siswa')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Pengumuman Siswa
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Pengumuman</a></li>
              <li class="breadcrumb-item active">Untuk Siswa</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="content-body">
    <div class="row">
      <div class="col-12 text-center text-lg-left mb-75">
        <a href="{{route('akademik.pengumuman.create')}}" class="btn btn-danger"><i data-feather="plus"></i> Buat Pengumuman</a>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <table class="table table-bordered table-hover" id="tabelpengumuman">
              <thead class="text-center">
                <th></th>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Status</th>
                <th>Tanggal Publish</th>
                <th class="text-center">Dilihat</th>
                <th>Penulis</th>
                <th>Aksi</th>
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

@endsection

@section('jspage')
<script>
$(document).ready(function() {
  var table = $('#tabelpengumuman').DataTable({
    processing: true,
    serverSide: true,
    autoWidth: false,
    "drawCallback": function( settings ) {
      feather.replace();
    },
    dom: '<"box-body"<"row"<"col-sm-3"l><"col-sm-5"<"toolbarcreate">><"col-sm-4"f>>><"box-body table-responsive"tr><"box-body"<"row"><"row"<"col-sm-6"i><"col-sm-6"p>>>',
    ajax: '{!! route('akademik.pengumuman.dt') !!}',
    columns: [
      { data: 'tglpublish', name: 'tglpublish' },
      { data: 'gambar', name: 'gambar' , 'render': function(data, type, row){
        return '<img src="/../../'+data+'" height="50" class="rounded" alt="Gambar">';
      }},
      { data: 'judul', name: 'judul' },
      { data: 'status', name: 'status', class: 'text-center', 'render': function(data, type, row){
        if (data == 1) {
          return '<div class="badge badge-light-success">Publish</div>'
        }else {
          return '<div class="badge badge-light-danger">Draft</div>';
        }
      }},
      { data: 'tgl', name: 'tgl' , 'render': function(data, type, row){
        if (data == 'x') {
          return '<div class="badge badge-light-danger">Belum Ditentukan</div>'
        }else {
          return data;
        }
      }},
      { data: 'klik', name: 'klik', class: 'text-right' , render: $.fn.dataTable.render.number('.', ',', 0,)},
      { data: 'user.pegawai.panggilan', name: 'user.pegawai.panggilan' , 'render': function(data, type, row){
        if (data == null) {
          return ''
        }else {
          return data;
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

  $('#tabelpengumuman tbody').on('click','#btnhapus', function(){
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var data = row.data()
    if( !confirm('Lanjutkan proses hapus pengumuman '+data.judul+'?')){
        event.preventDefault();
    }
  })
});
</script>
@stop
