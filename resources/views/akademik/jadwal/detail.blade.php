@extends('layouts.menu')

@section('title-head', 'Detail Jadwal Pelajaran')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Detail Jadwal Pelajaran
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('md.jadwal')}}">Pengaturan Jadwal</a></li>
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
          <div class="card-header">
            <div class="head-label">
              <h4>Jadwal Pelajaran <div class="badge badge-light-primary">{{$kelas->nama}}</div> <div class="badge badge-light-{{$kelas->idjenis == 1 ? 'dark' : 'secondary'}}">{{$kelas->jenis->nama}}</div></h4>             
            </div>
            <div class="dt-buttons d-flex-row">
              <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#modal-jadwal" data-backdrop="static" data-keyboard="false" id="btnadd"><i data-feather="plus"></i> Tambah Jadwal Pelajaran</button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead class="text-center">
                  <th style="width: 1px">Jam</th>
                  <th>Senin</th>
                  <th>Selasa</th>
                  <th>Rabu</th>
                  <th>Kamis</th>
                  <th>Jumat</th>
                  <th>Sabtu</th>
                </thead>
                <tbody>
                  @include('layouts.tabeljadwal')
                </tbody>
              </table>
            </div>
            
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

@section('modal')
<div class="modal fade" id="modal-jadwal" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Tambah Jadwal Pelajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="jquery-val-form" class="formjadwal" action="{{route('md.jadwal.store')}}" method="post">
        <input type="hidden" name="idkelas" value="{{$kelas->id}}">
        <div class="modal-body">
          <table class="table table-striped mb-0">
            <tr>
              <td style="width: 30%"><b>Kelas</b></td>
              <td>
                <input type="text" class="form-control" autocomplete="off" value="{{$kelas->nama}} {{$kelas->jenis->nama}}" readonly>
              </td>
            </tr>
            <tr>
              <td><b>Hari</b></td>
              <td>
                <select class="form-control show-tick ms select2" name="idhari" id="idhari" data-placeholder="Pilih" required>

                </select>
              </td>
            </tr>
            <tr>
              <td><b>Jam Pelajaran</b></td>
              <td>
                <div class="jam">

                </div>
              </td>
            </tr>
            <tr>
              <td><b>Mata Pelajaran</b></td>
              <td>
                <select class="form-control show-tick ms select2" name="idmaping" id="idmaping" data-placeholder="Pilih" required>
                  <option></option>
                  @foreach ($mapel->where('idtingkat',$kelas->idtingkat)->where('idminat',$kelas->idminat)->where('idjeniskelas',$kelas->idjenis) as $m)
                    <option value="{{$m->id}}">{{$m->mapel->nama}} ({{$m->jenismapel->nama}})</option>
                  @endforeach
                </select>
              </td>
            </tr>
            <tr>
              <td><b>Guru</b></td>
              <td>
                <select class="form-control select2" multiple name="idguru[]" id="idguru" data-placeholder="Pilih" required>
                  <option></option>
                  @foreach ($guru as $g)
                    <option value="{{$g->id}}">{{$g->nama}}</option>
                  @endforeach
                </select>
              </td>
            </tr>
          </table>
          <hr class="mt-0">
          {{ csrf_field() }}
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="save"></i> Simpan</button>
          <button class="btn btn-sm btn-outline-danger" data-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('jspage')
<script>
$(document).ready(function() {
  var kelas = '{{$kelas->id}}'
  var jadwalhari = ''

  $("#idhari").select2({
    placeholder: "Pilih",
    ajax: {
        url: '{!!route("s2.hari")!!}',
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

  $('#idhari').on('change', function(){
    jadwalhari = $(this).val()
    $.get('/select2/jampelajaran/'+jadwalhari+'/'+kelas,function(data){
      $('.jam').html(data)
    })
  })
  
});
</script>
@stop
