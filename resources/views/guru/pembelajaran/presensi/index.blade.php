@extends('layouts.menu')

@section('title-head', 'Presensi '.$data->mapel->nama)

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
              <li class="breadcrumb-item">
                <a href="{{route('home')}}"><i data-feather="home"></i></a>
              </li>
              <li class="breadcrumb-item"><a href="{{route('pembelajaran',[$data->id,Session::get('idgambarglobal')])}}">Pembelajaran</a></li>
              <li class="breadcrumb-item active">{{$data->mapel->nama}}</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="content-body">
    <div class="row match-height">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
                <table class="table table-striped mb-0">
                  <tbody>
                    <tr>
                      <td>Mata Pelajaran</td>
                      <th>{{$data->mapel->nama}}</th>
                    </tr>
                    <tr>
                      <td>Guru</td>
                      <th>
                        @foreach($data->guru as $guru)
                          <span class="d-block">{{$guru->guru->nama}}
                            @if ($guru->jenis == 1)
                              <i data-feather="star" class="font-small-1 text-primary" style="margin-top:-5px"></i>
                            @endif
                          </span>
                        @endforeach
                      </th>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-lg-6">
                <table class="table table-striped mb-0">
                  <tbody>
                    <tr>
                      <td style="width: 30%">Kelas</td>
                      <th>{{$data->kelas->nama}}</th>
                    </tr>
                    <tr>
                      <td>Jadwal</td>
                      <th>
                        @if ($data->hari2 == null)
                          {{$data->hari->nama}}, @foreach ($data->detil as $jdt) {{$jdt->jampelajaran->mulai}} s/d {{$jdt->jampelajaran->selesai}} @endforeach
                        @else
                          <ul class="pl-1 mb-0">
                            <li>{{$data->hari->nama}}, {{$data->jam}}</li>
                            <li>{{$data->hari2}}, {{$data->jam2}}</li>
                            @if ($data->hari3 != null)
                              <li>{{$data->hari3}}, {{$data->jam3}}</li>
                            @endif
                            @if ($data->hari4 != null)
                              <li>{{$data->hari4}}, {{$data->jam4}}</li>
                            @endif
                          </ul>
                        @endif
                      </th>
                    </tr>
                    {{-- <tr>
                      <td>Ruang</td>
                      <th>{{$data->gedung}} - {{$data->ruang}}</th>
                    </tr> --}}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="text-center mb-1">
          <button class="btn btn-primary mb-25" type="button" data-toggle="modal" data-target="#modal-absen" data-backdrop="static" data-keyboard="false"><i data-feather="check-square"></i> Input Presensi</button>
          <a href="{{route('pembelajaran.presensi.detail',Session::get('idjadwalglobal'))}}" class="btn btn-info mb-25"><i data-feather="info"></i> Detail Kehadiran</a>
          <form class="d-inline" action="{{route('pembelajaran.presensi.rekap')}}" target="_blank" method="post">
            <input type="hidden" name="idjadwal" value="{{$data->id}}">
            <button type="submit" class="btn btn-success mb-25" name="button"><i data-feather="file-text"></i> Rekap Presensi</button>
            {{csrf_field()}}
          </form>
        </div>
      </div>

      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <table class="table table-bordered table-hover" id="tablesws">
              <thead class="text-center">
                <tr>
                  <th>NIS</th>
                  <th>Nama Siswa</th>
                  <th>Kelas</th>
                  <th>Hadir</th>
                  <th>Tidak Hadir</th>
                  <th>Persentase</th>
                </tr>
              </thead>
              <tbody>
                @foreach($siswa as $sws)
                  <?php
                    $hadir = 0;
                    foreach ($presensi->where('hadir',1)->where('nis',$sws->nis) as $jh) {
                      $hadir += 1;
                    }
                  ?>
                  <tr>
                    <td>{{$sws->nis}}</td>
                    <td>{{$sws->nama}}</td>
                    <td class="text-center">
                        {{$sws->kelas->nama}}
                    </td>
                    <td class="text-center">
                      {{$hadir}}
                    </td>
                    <td class="text-center">
                      {{count($pertemuanke) - $hadir}}
                    </td>
                    <td class="text-center">
                      @if(count($pertemuanke) == 0 || $hadir == 0)
                        0 %
                      @else
                        {{round($hadir/count($pertemuanke) * 100,2)}} %
                      @endif
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
<div class="modal fade" id="modal-absen" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Input Presensi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form_validation" class="forms-sample formsws2" action="{{route('pembelajaran.presensi.store')}}" method="post">
        <input type="hidden" name="idjadwal" value="{{$data->id}}">
        <input type="hidden" name="iduser" value="{{auth::user()->id}}">
        <input type="hidden" name="idguru" value="{{auth::user()->link}}">
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-lg-6">
              <label class="col-sm-12 col-form-label"><b>Mata Pelajaran</b></label>
              <div class="col-sm-12">
                <input type="text" class="form-control" value="{{$data->mapel->nama}}" readonly>
              </div>
            </div>
            <div class="form-group col-lg-6">
              <label class="col-sm-12 col-form-label"><b>Jadwal</b></label>
              <div class="col-sm-12">
                <input type="text" class="form-control" value="{{$data->hari->nama}}, @foreach ($data->detil as $jdt) {{$jdt->jampelajaran->mulai}} s/d {{$jdt->jampelajaran->selesai}} @endforeach" readonly>
              </div>
            </div>
            <div class="form-group col-lg-6">
              <label class="col-sm-12 col-form-label"><b>Pertemuan Ke</b></label>
              <div class="col-sm-12">
                <input type="text" name="pertemuan" class="form-control" value="{{count($pertemuanke)+1}}" readonly required>
              </div>
            </div>
            <div class="form-group col-lg-6">
              <label class="col-sm-12 col-form-label"><b>Tanggal</b></label>
              <div class="col-sm-12">
                <input type="text" name="tanggal" class="form-control flatpickr-basic" placeholder="Pilih" value="{{date('Y-m-d')}}" style="background-color: white" required>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Materi Pembelajaran</b></label>
            <div class="col-sm-12">
              <textarea name="materi" class="form-control" required rows="3" cols="80" required></textarea>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Tugas Pembelajaran</b></label>
            <div class="col-sm-12">
              <textarea name="tugas" class="form-control" rows="3" cols="80"></textarea>
              <small class="text-muted">* kosongkan jika tidak ada tugas</small>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Jenis Presensi</b></label>
            <div class="col-sm-12">
              <select class="form-control select2" name="jenis" id="jenis">
                <option value="1">Presensi Manual</option>
              </select>
            </div>
          </div>

          <div class="col-lg-12 pt-1 absenmanual">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="tableinput">
                <thead class="text-center">
                  <th>Nama Siswa</th>
                  <th>Kelas</th>
                  <th style="width: 1px">Kehadiran</th>
                  <th>Keterangan</th>
                </thead>
                <tbody>
                  <?php $ii = 0; ?>
                  @foreach($siswa as $sws)
                    <input type="hidden" name="sws[]" value="{{$sws->nis}}">
                    <input type="hidden" name="sws2[]" value="{{$ii}}">
                    <tr>
                      <td>
                        <span class="d-block font-small-3 text-muted">{{$sws->nama}}</span>
                      </td>
                      <td>
                        {{$sws->kelas->nama}}
                      </td>
                      <td style="padding-left: 42px">
                        <div class="custom-control custom-checkbox">
                          <input checked id="a{{$ii}}" value="1" name="a{{$ii}}" class="custom-control-input absendulu" type="checkbox">
                          <label class="custom-control-label" for="a{{$ii}}"></label>
                        </div>
                      </td>
                      <td>
                        <select class="form-control show-tick ms keterangan{{$ii}}" name="keterangan{{$ii}}" style="width:100%" data-placeholder="Hadir">
                          <option>Hadir</option>
                          <option value="Sakit">Sakit</option>
                          <option value="Izin">Izin</option>
                          <option value="Tanpa Keterangan">Tanpa Keterangan</option>
                        </select>
                      </td>
                    </tr>
                    <?php $ii++; ?>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
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
  $('.absenbarcode').hide()
  $('#jenis').on('change', function(){
    if ($(this).val() == 1) {
      $('.absenmanual').show()
      $('.absenbarcode').hide()
    }else {
      $('.absenmanual').hide()
      $('.absenbarcode').show()
    }
  })

  var tableswa = $('#tableswa').DataTable({
    paging: false,
    info: false,
    dom: '<"box-body"<"row"<"col-sm-3"l><"col-sm-5"<"toolbar">><"col-sm-4"f>>><"box-body table-responsive"tr><"box-body"<"row"><"row"<"col-sm-6"i><"col-sm-6"p>>>',
    order:[[0,"asc"]],
  });
});
</script>
@stop
