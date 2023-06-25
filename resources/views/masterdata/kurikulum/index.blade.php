@extends('layouts.menu')

@section('title-head', 'Data Kurikulum')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Data Kurikulum</h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Master Data</a></li>
              <li class="breadcrumb-item active">Kurikulum</li>
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
              <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#modal-kurikulum" data-backdrop="static" data-keyboard="false" id="btnadd"><i data-feather="plus"></i> Tambah Kurikulum</button>
            </div>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-hover" id="tabelkurikulum">
              <thead class="text-center">
                <tr>
                  <th>Nama Kurikulum</th>
                  <th>Tahun</th>
                  <th>Deskripsi</th>
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
<div class="modal fade" id="modal-kurikulum" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="jquery-val-form" class="forms-sample formkurikulum" action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idkurikulum" id="idkurikulum" value="">
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Nama Kurikulum</b></label>
              <div class="col-sm-12">
                <input type="text" name="nama" id="nama" class="form-control" autocomplete="off" required>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Tahun</b></label>
              <div class="col-sm-12">
                <input type="number" name="tahun" id="tahun" class="form-control tahun" autocomplete="off" required>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Deskripsi</b></label>
              <div class="col-sm-12">
                <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="6" required></textarea>
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
    var table = $('#tabelkurikulum').DataTable({
      processing: true,
      serverSide: true,
      autoWidth: false,
      "drawCallback": function( settings ) {
        feather.replace();
      },
      dom: '<"box-body"<"row"<"col-sm-3"l><"col-sm-5"<"toolbar">><"col-sm-4"f>>><"box-body table-responsive"tr><"box-body"<"row"><"row"<"col-sm-6"i><"col-sm-6"p>>>',
      ajax: '{!! route('md.kurikulum.dt') !!}',
      columns: [
          { data: 'nama', name: 'nama'},
          { data: 'tahun', name: 'tahun'},
          { data: 'deskripsi', name: 'deskripsi'},
          { data: 'status', name: 'status', class: 'text-center', render: function(data) {
            if(data == 'Aktif') {
              return '<div class="badge badge-light-success">'+data+'</div>'
            }
            else {
              return '<div class="badge badge-light-secondary">'+data+'</div>'
            }
          }},
          { data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'},
      ],
      order: [[1,'desc']]
    });

    $('#tabelkurikulum tbody').on('click','.btnaktif', function(){
      var tr = $(this).closest('tr');
      var row = table.row(tr);
      var data = row.data()
      if (data.status == 'Aktif') {
        namaproses = 'menonaktifkan'
      }else {
        namaproses = 'mengaktifkan'
      }
      if( !confirm('Lanjutkan proses '+namaproses+' Kurikulum '+data.nama+' Tahun '+data.tahun+'?')){
          event.preventDefault();
      }
    })

    $('#tabelkurikulum tbody').on('click','#btnubah', function(){
      var tr = $(this).closest('tr');
      var row = table.row(tr);
      var data = row.data()
      $('#modal-kurikulum').modal('show')
      $('#modaltitle').text('Ubah Kurikulum')
      $('.formkurikulum').attr('action', "{{route('md.kurikulum.update')}}")
      $('#idkurikulum').val(data.id)
      $('#nama').val(data.nama)
      $('#tahun').val(data.tahun)
      $('#deskripsi').val(data.deskripsi)
    })

    $('#btnadd').on('click', function () {
      $('#modaltitle').text('Tambah Kurikulum Baru')
      $('.formkurikulum').attr('action', "{{route('md.kurikulum.store')}}")
      $('#idkurikulum').val('')
      $('#nama').val('')
      $('#tahun').val('')
      $('#deskripsi').val('')
    });

  });
</script>
@stop
