@extends('layouts.menu')

@section('title-head', 'Jadwal Pelajaran Agama')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Jadwal Pelajaran Agama
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('jadwal')}}">Jadwal Pelajaran</a></li>
              <li class="breadcrumb-item active">Agama Kelas {{$tingkat->nama}}</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="content-body">
    <div class="row">
      <div class="col-12 text-center text-lg-left mb-75">
        <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#modal-jadwal" data-backdrop="static" data-keyboard="false" id="btnadd"><i data-feather="plus"></i> Tambah Jadwal Agama</button>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <table class="dt-complex-header table table-bordered table-hover" id="tabeljadwal">
              <thead class="text-center">
                <tr>
                  <th rowspan="2">Kelas</th>
                  <th rowspan="2">Agama</th>
                  <th colspan="2">Jadwal</th>
                  <th rowspan="2">Guru</th>
                  <th rowspan="2">Aksi</th>
                </tr>
                <tr>
                  <th>Hari</th>
                  <th>Jam</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($jadwal as $j)
                  <tr>
                    <td class="text-center">{{$j->tingkatkelas->nama}}</td>
                    <td>{{$j->agama->nama}}</td>
                    <td>{{$j->hari->nama}}</td>
                    <td>
                      <div style="white-space: nowrap">
                      @foreach ($j->detil as $jd)
                      <small class="d-block">
                        <div class="badge badge-light-secondary my-25 mr-25" style="width: 25px">{{$jd->jampelajaran->nama}}</div>
                        {{$jd->jampelajaran->mulai}} - {{$jd->jampelajaran->selesai}}
                      </small>
                      @endforeach
                    </div>
                    </td>
                    <td>{{$j->jadwalguru->guru->nama}}</td>
                    <td class="text-center">
                      <form class="d-inline" action="{{route('md.jadwal.deleteagama')}}" method="post"  onsubmit="return confirm('Lanjutkan proses hapus jadwal Agama {{$j->agama->nama}}?')">
                        <input type="hidden" name="idjadwal" value="{{$j->id}}">
                        <input type="hidden" name="idguru" value="{{$j->jadwalguru->idguru}}">
                        <button type="submit" class="btn btn-sm btn-outline-danger" name="button"><i data-feather="trash-2"></i> Hapus</button>
                        {{csrf_field()}}
                      </form>
                    </td>
                  </tr>
                @endforeach
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
<div class="modal fade" id="modal-jadwal" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Tambah Jadwal Pelajaran Agama</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="jquery-val-form" class="formjadwal" action="{{route('jadwal.storeagama')}}" method="post">
        <input type="hidden" name="idtingkatkelas" value="{{$tingkat->id}}">
        <input type="hidden" name="idmaping" value="{{$mapel->id}}">
        <div class="modal-body">
          <table class="table table-striped mb-0">
            <tr>
              <td style="width: 30%"><b>Kelas</b></td>
              <td>
                <input type="text" class="form-control" autocomplete="off" value="{{$tingkat->nama}}" readonly>
              </td>
            </tr>
            <tr>
              <td><b>Agama</b></td>
              <td>
                <select class="form-control show-tick ms select2" name="idagama" id="idagama" data-placeholder="Pilih" required>

                </select>
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
              <td><b>Guru</b></td>
              <td>
                <select class="form-control select2" name="idguru" id="idguru" data-placeholder="Pilih" required>
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
  var tingkat = '{{$tingkat->id}}'

  var table = $('#tabeljadwal').DataTable({
      autoWidth: false,
      "drawCallback": function( settings ) {
        feather.replace();
      },
      dom: '<"box-body"<"row"<"col-sm-3"l><"col-sm-5"<"toolbar">><"col-sm-4"f>>><"box-body table-responsive"tr><"box-body"<"row"><"row"<"col-sm-6"i><"col-sm-6"p>>>',
      order: [[1,'asc']],
  });

  $("#idagama").select2({
    placeholder: "Pilih",
    ajax: {
        url: '{!!route("s2.jadwalagama")!!}',
        dataType: 'json',
        data: function (params) {
            return {
                q: $.trim(params.term),
                idtingkat: tingkat
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
    agama = $('#idagama').val()
    $.get('/select2/jampelajaranagama/'+jadwalhari+'/'+tingkat+'/'+agama,function(data){
      $('.jam').html(data)
    })
  })

});
</script>
@stop
