@extends('layouts.menu')

@section('title-head', 'Pengaturan Tahun Ajaran')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Pengaturan Tahun Ajaran</h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
              <li class="breadcrumb-item active">Tahun Ajaran</li>
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
              <button class="btn btn-danger" type="button"  data-toggle="modal" data-target="#modal-ta" data-backdrop="static" data-keyboard="false" id="btnta"><i data-feather="plus"></i> Tambah Tahun Ajaran</button>
            </div>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-hover" id="tabelta">
              <thead class="text-center">
                <tr>
                  <th></th>
                  <th>Tahun Ajaran</th>
                  <th>Semester</th>
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
<div class="modal fade" id="modal-ta" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Tambah Tahun Ajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="jquery-val-form" class="forms-sample" action="{{route('md.ta.store')}}" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Tahun Ajaran</b></label>
              <div class="col-sm-12">
                <input type="text" name="tahun" class="form-control" autocomplete="off" required>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>Semester</b></label>
              <div class="col-sm-12">
                <select class="form-control show-tick ms select2" name="semester" data-placeholder="Pilih" required>
                  <option></option>
                  <option value="1">Ganjil</option>
                  <option value="2">Genap</option>
                </select>
              </div>
            </div>

            <div class="form-group col-md-12">
              <label class="col-sm-12 col-form-label"><b>KKM</b></label>
              <div class="col-sm-12">
                <input type="number" name="kkm" class="form-control" autocomplete="off" required>
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

  });
</script>
@stop
