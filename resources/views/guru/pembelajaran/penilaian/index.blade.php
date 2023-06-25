@extends('layouts.menu')

@section('title-head', 'Penilaian')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Penilaian
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Pengajaran</a></li>
              <li class="breadcrumb-item active">Penilaian</li>
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
          <div class="card-body">
            <table class="dt-complex-header table table-bordered table-hover" id="tabeljadwal">
              <thead class="text-center">
                <tr>
                  <th>Mata Pelajaran</th>
                  <th>Kelas</th>
                  <th>Guru</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $d)
                  @php
                    $idjadwal = App\Models\JadwalPelajaran::where('idta',$idta)->where('idmapel',$d->idmapel)
                          ->where('idkelas',$d->idkelas)->select('id');
                    $guru = App\Models\JadwalPelajaranGuru::with('guru')->wherein('idjadwal',$idjadwal)
                          ->where('isagama',0)->groupby('idguru')->get();
                  @endphp
                  <tr>
                    <td>
                      {{$d->mapel->nama}}
                      @if ($d->idkurikulum == 1)
                        <small class="d-block text-muted">{{$d->jenismapel->jenis}}</small>
                      @endif
                    </td>
                    <td>{{$d->kelas->nama}}</td>
                    <td>
                      @if (count($guru) == 1)
                        {{$guru[0]->guru->nama}}
                      @elseif (count($guru) > 1)
                      <ul class="pl-1 mb-0">
                        @foreach ($guru as $jg)
                          <li>{{$jg->guru->nama}}</li>
                        @endforeach
                      </ul>
                      @endif
                    </td>
                    <td class="text-center">
                      <a href="{{route('laporan.penilaian.detail', [$d->idkelas,$d->idmapel,$d->idjenismapel,$d->mapel->agama])}}" class="btn btn-outline-info btn-sm waves-effect waves-float waves-light" style="white-space:nowrap"><i data-feather="edit-3"></i> Penilaian Tugas</a>
                      <a href="{{route('laporan.penilaian.detailquiz', [$d->idkelas,$d->idmapel,$d->idjenismapel,$d->mapel->agama])}}" class="btn btn-outline-warning btn-sm waves-effect waves-float waves-light" style="white-space:nowrap"><i data-feather="edit-3"></i> Penilaian Quiz</a>
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
@endsection

@section('jspage')
<script>
$(document).ready(function() {
  var table = $('#tabeljadwal').DataTable({
      autoWidth: false,
      "drawCallback": function( settings ) {
        feather.replace();
      },
      dom: '<"box-body"<"row"<"col-sm-3"l><"col-sm-5"<"toolbar">><"col-sm-4"f>>><"box-body table-responsive"tr><"box-body"<"row"><"row"<"col-sm-6"i><"col-sm-6"p>>>',
      order: [[1,'asc']],
  });

  $.fn.DataTable.ext.pager.numbers_length = 5;
});
</script>
@stop