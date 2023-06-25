@extends('layouts.menu')

@section('title-head', 'Presensi')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Presensi
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Pengajaran</a></li>
              <li class="breadcrumb-item active">Presensi</li>
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
            <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#modal-absen" data-backdrop="static" data-keyboard="false"><i data-feather="printer"></i> Cetak Presensi</button>
          </div>
          <div class="card-body">
            <table class="dt-complex-header table table-bordered table-hover" id="tbjadwal">
              <thead class="text-center">
                <tr>
                  <th rowspan="2">Mata Pelajaran</th>
                  <th rowspan="2">Kelas</th>
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
                    <td>
                      {{$j->mapel->nama}}
                      {{-- @if ($j->jadwalguru[0]->rpp->israport == 0)
                        <div class="badge badge-light-primary">Pengayaan</div>
                      @endif --}}
                    </td>
                    <td>{{$j->kelas->nama}} {{$j->kelas->jenis->nama}}</td>
                    <td><span class="d-none">{{$j->idhari}}</span> {{$j->hari->nama}}</td>
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
                    <td>
                      @if (count($j->jadwalguru) == 1)
                        {{$j->jadwalguru[0]->guru->nama}}
                      @elseif (count($j->jadwalguru) > 1)
                      <ul class="pl-1 mb-0">
                        @foreach ($j->jadwalguru as $jg)
                          <li>{{$jg->guru->nama}}</li>
                        @endforeach
                      </ul>
                      @endif
                    </td>
                    <td class="text-center">
                      <a href="{{route('laporan.presensi.detail', $j->id)}}" class="btn btn-outline-info btn-sm waves-effect waves-float waves-light" style="white-space:nowrap"><i data-feather="check-square"></i> Presensi</a>
                    </td>
                  </tr>
                @endforeach

                {{-- @foreach ($jadwalagama as $ja)
                  <tr>
                    <td>
                      {{$ja->mapel->nama}}<br>
                      <div class="badge badge-light-secondary">Agama {{$ja->agama->nama}}</div>
                    </td>
                    <td>{{$ja->tingkatkelas->nama}}</td>
                    <td><span class="d-none">{{$ja->idhari}}</span> {{$ja->hari->nama}}</td>
                    <td>
                      <div style="white-space: nowrap">
                      @foreach ($ja->detil as $jad)
                      <small class="d-block">
                        <div class="badge badge-light-secondary my-25 mr-25" style="width: 25px">{{$jad->jampelajaran->nama}}</div>
                        {{$jad->jampelajaran->mulai}} - {{$jad->jampelajaran->selesai}}
                      </small>
                      @endforeach
                    </div>
                    </td>
                    <td>{{$ja->jadwalguru->guru->nama}}</td>
                    <td class="text-center">
                      <a href="{{route('laporan.presensi.detailagama', $ja->id)}}" class="btn btn-outline-info btn-sm waves-effect waves-float waves-light" style="white-space:nowrap"><i data-feather="check-square"></i> Presensi</a>
                    </td>
                  </tr>
                @endforeach --}}
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
<div class="modal fade" id="modal-absen" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Cetak Presensi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="jquery-val-form" class="forms-sample" action="{{route('laporan.presensi.cetak')}}" method="post" target="_blank">
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-lg-12">
              <label class="col-sm-12 col-form-label"><b>Pilih Kelas</b></label>
              <div class="col-sm-12">
                <select class="form-control select2" name="idkelas" id="idkelas" required>

                </select>
              </div>
            </div>
            <div class="form-group col-lg-12">
              <label class="col-sm-12 col-form-label"><b>Tanggal Presensi</b></label>
              <div class="col-sm-12">
                <input type="text" name="tgl" class="form-control flatpickr-basic" style="background-color: white" value="{{date('Y-m-d')}}" required>
              </div>
            </div>
          </div>
          {{ csrf_field() }}
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-danger"><i data-feather="printer"></i> Cetak</button>
          <button class="btn btn-sm btn-outline-dark" data-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('jspage')
<script>
$(document).ready(function() {
  var table = $('#tbjadwal').DataTable({
      autoWidth: false,
      "drawCallback": function( settings ) {
        feather.replace();
      },
      dom: '<"box-body"<"row"<"col-sm-3"l><"col-sm-5"<"toolbar">><"col-sm-4"f>>><"box-body table-responsive"tr><"box-body"<"row"><"row"<"col-sm-6"i><"col-sm-6"p>>>',
      order: [[2 , 'asc']],
  });

  $("#idkelas").select2({
    placeholder: "Pilih Kelas",
    ajax: {
        url: '{!!route("s2.semuakelas")!!}',
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

});
</script>
@stop
