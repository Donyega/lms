@extends('layouts.page')

@section('title-head', 'Pengisian Presensi')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Pengisian Presensi
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('presensi')}}">Presensi</a></li>
              <li class="breadcrumb-item active">Isi Presensi</li>
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
            <div class="row">
              <div class="col-lg-6 col-sm-12">
                <div class="table-responsive">
                  <table class="table table-striped">
                    <tr>
                      <td style="width: 32%">Tahun Ajaran</td>
                      <td><b>{{$data->ta->tahun}} {{$data->ta->semester == 1 ? 'Ganjil' : 'Genap'}}</b></td>
                    </tr>
                    <tr>
                      <td>Mata Pelajaran</td>
                      <td><b>{{$data->mapel->nama}}</b> ({{$data->agama->nama}})</td>
                    </tr>
                    <tr>
                      <td>Kelompok</td>
                      <td><b>{{$data->jenismapel->nama}}</b></td>
                    </tr>
                    <tr>
                      <td>Guru</td>
                      <td><b>{{$data->jadwalguru->guru->nama}}</b></td>
                    </tr>
                  </table>
                </div>
              </div>
              <div class="col-lg-6 col-sm-12">
                <div class="table-responsive-lg">
                  <table class="table table-striped">
                    <tr>
                      <td style="width: 32%">Jadwal</td>
                      <td>
                        <b>{{$data->hari->nama}}</b> |
                        <small>
                          Jam
                          @foreach ($data->detil as $dt)
                            <div class="badge badge-light-secondary" style="width: 25px">{{$dt->jampelajaran->nama}}</div>
                          @endforeach
                        </small>
                      </td>
                    </tr>
                    <tr>
                      <td>Kelas</td>
                      <td><b>{{$data->tingkatkelas->nama}}</b></td>
                    </tr>
                    <tr>
                      <td>Jenis Kelas</td>
                      <td><b>-</b></td>
                    </tr>
                    <tr>
                      <td>Jumlah Pertemuan</td>
                      <td><b>{{count($pertemuanke)}}</b></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="text-center text-lg-left mb-1">
          <button class="btn btn-danger my-25 my-lg-0" type="button" data-toggle="modal" data-target="#modal-absen" data-backdrop="static" data-keyboard="false"><i data-feather="user-check"></i> Isi Presensi</button>
          <a href="{{route('presensi.detailpresensi', [$data->id,1])}}" class="btn btn-outline-primary" style="white-space:nowrap" target="_blank"><i data-feather="check-square"></i> Detail Presensi</a>
          <div class="btn-group">
            <button type="button" class="btn btn-outline-success dropdown-toggle my-25 my-lg-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Rekapitulasi</button>
            <div class="dropdown-menu">
              <form class="dropdown-item" action="{{route('presensi.ba')}}" target="_blank" method="post">
                <input type="hidden" name="idjadwal" value="{{$data->id}}">
                <input type="hidden" name="isagama" value="1">
                <button type="submit" class="btn btn-flat p-0" name="button"><i data-feather="file-text" class="mr-25" style="margin-top:-2"></i> Berita Acara</button>
              {{csrf_field()}}
              </form>
              <div class="dropdown-divider"></div>
              <form class="dropdown-item" action="{{route('presensi.rekap')}}" target="_blank" method="post"><input type="hidden" name="idjadwal" value="{{$data->id}}">
                <button type="submit" class="btn btn-flat p-0" name="button"><i data-feather="users" class="mr-25" style="margin-top:-2"></i> Kehadiran</button>{{csrf_field()}}
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <table class="dt-complex-header table table-bordered table-hover" id="tabelsiswa">
              <thead class="text-center">
                <tr>
                  <th rowspan="2">No</th>
                  <th rowspan="2">NIS</th>
                  <th rowspan="2">Nama Siswa</th>
                  <th rowspan="2">Kelas</th>
                  <th rowspan="2">Jumlah Hadir</th>
                  <th colspan="4">Jumlah Tidak Hadir</th>
                  <th rowspan="2">Persentase</th>
                </tr>
                <tr>
                  <th>Dispensasi</th>
                  <th>Sakit</th>
                  <th>Izin</th>
                  <th>Alpa</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; ?>
                @foreach($siswa as $s)
                <?php
                  $hadir = count($presensi->where('hadir',1)->where('nis',$s->nis));
                  $dispensasi = count($presensi->where('hadir',1)->where('nis',$s->nis)->where('catatan','Dispensasi'));
                  $sakit = count($presensi->where('hadir',0)->where('nis',$s->nis)->where('catatan','Sakit'));
                  $izin = count($presensi->where('hadir',0)->where('nis',$s->nis)->where('catatan','Izin'));
                  $alpa = count($presensi->where('hadir',0)->where('nis',$s->nis)->wherein('catatan',['Alpa','',null]));
                ?>
                <tr>
                  <td class="text-center" style="width: 1px">{{$no}}</td>
                  <td>{{$s->nis}}</td>
                  <td>{{$s->nama}}</td>
                  <td>{{$s->kelas->nama}} {{$s->kelas->jenis->nama}}</td>
                  <td class="text-center">
                    @if ($dispensasi > 0)
                      {{$hadir - $dispensasi}}
                    @else
                      {{$hadir}}
                    @endif
                  </td>
                  <td class="text-center">{{$dispensasi == 0 ? '-' : $dispensasi}}</td>
                  <td class="text-center">{{$sakit == 0 ? '-' : $sakit}}</td>
                  <td class="text-center">{{$izin == 0 ? '-' : $izin}}</td>
                  <td class="text-center">{{$alpa == 0 ? '-' : $alpa}}</td>
                  <td class="text-center">
                    @if(count($pertemuanke) == 0 || $hadir == 0)
                      0 %
                    @else
                      {{round($hadir/count($pertemuanke) * 100,2)}} %
                    @endif
                  </td>
                </tr>
                <?php $no++; ?>
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
        <h5 class="modal-title" id="modaltitle">Pengisian Presensi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="jquery-val-form" class="forms-sample formsws2" action="{{route('presensi.store')}}" method="post">
        <div class="modal-body">
          <input type="hidden" name="idjadwal" value="{{$data->id}}">
          <input type="hidden" name="isagama" value="1">
          <div class="row">
            <div class="form-group col-lg-6">
              <label class="col-sm-12 col-form-label"><b>Mata Pelajaran</b></label>
              <div class="col-sm-12">
                <input type="text" class="form-control" value="{{$data->mapel->nama}} ({{$data->agama->nama}})" readonly>
              </div>
            </div>
            <div class="form-group col-lg-6">
              <label class="col-sm-12 col-form-label"><b>Kelompok Mata Pelajaran</b></label>
              <div class="col-sm-12">
                <input type="text" class="form-control" value="{{$data->jenismapel->nama}}" readonly>
              </div>
            </div>
            <div class="form-group col-lg-6">
              <label class="col-sm-12 col-form-label"><b>Kelas</b></label>
              <div class="col-sm-12">
                <input type="text" class="form-control" value="{{$data->tingkatkelas->nama}}" readonly>
              </div>
            </div>
            <div class="form-group col-lg-6">
              <label class="col-sm-12 col-form-label"><b>Jadwal</b></label>
              <div class="col-sm-12">
                <hr class="mt-0 mb-50">
                {{$data->hari->nama}} |
                Jam
                @foreach ($data->detil as $dt)
                  <div class="badge badge-light-secondary" style="width: 25px">{{$dt->jampelajaran->nama}}</div>
                @endforeach
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
                <input type="text" name="tanggal" class="form-control flatpickr-basic"  placeholder="Pilih" value="{{date('Y-m-d')}}" style="background-color: white" required>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Guru</b></label>
            <div class="col-sm-12">
              <select name="idguru" class="form-control select2" data-placeholder="Pilih" required>
                <option selected value="{{$data->jadwalguru->idguru}}">{{$data->jadwalguru->guru->nama}}</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Materi Pembelajaran</b></label>
            <div class="col-sm-12">
              <textarea name="materi" class="form-control" required rows="3" cols="80" required></textarea>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Penugasan</b></label>
            <div class="col-sm-12">
              <textarea name="tugas" class="form-control" rows="3" cols="80"></textarea>
              <small class="text-muted">* kosongkan jika tidak ada penugasan</small>
            </div>
          </div>

          <div class="col-lg-12 pt-1">
            <div class="table-responsive">
              <table class="table table-hover table-bordered" id="tableinput">
                <thead class="text-center">
                  <th>No</th>
                  <th>NIS</th>
                  <th>Nama Siswa</th>
                  <th>Kehadiran</th>
                  <th>Keterangan</th>
                </thead>
                <tbody>
                  <?php $ii = 0; $no = 1 ?>
                  @foreach($siswa as $s)
                  <input type="hidden" name="siswa[]" value="{{$s->nis}}">
                  <input type="hidden" name="siswa2[]" value="{{$ii}}">
                  <tr>
                    <td class="text-center" style="width: 1px">{{$no}}</td>
                    <td style="width: 1px">{{$s->nis}}</td>
                    <td>
                      {{$s->nama}}
                      <small class="d-block text-muted">{{$s->kelas->nama}} {{$s->kelas->jenis->nama}}</small>
                    </td>
                    <td style="width: 1px">
                      <div class="custom-control custom-checkbox text-center">
                        <input checked id="a{{$ii}}" value="{{$ii}}" name="a{{$ii}}" class="custom-control-input absendulu" type="checkbox">
                        <label class="custom-control-label" for="a{{$ii}}">Hadir</label>
                      </div>
                    </td>
                    <td>
                      <select class="form-control show-tick ms select2 keterangan{{$ii}} ali" disabled name="keterangan{{$ii}}" data-placeholder="Pilih">
                        <option></option>
                        <option value="Dispensasi">Dispensasi</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Izin">Izin</option>
                        <option value="Alpa">Alpa</option>
                      </select>
                    </td>
                  </tr>
                  <?php
                    $ii++; $no++
                  ?>
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
  var table = $('#tabelsiswa').DataTable({
      paging: false,
      info: false,
      autoWidth: false,
      "drawCallback": function( settings ) {
        feather.replace();
      },
      dom: '<"box-body"<"row"<"col-sm-6"<"toolbaraksi">><"col-sm-6"f>>><"box-body table-responsive"tr><"box-body"<"row"><"row"<"col-sm-6"i><"col-sm-6"p>>>',
      order: [[ 2, "asc" ]],
  });

  $('#tableinput tbody').on('click','.absendulu', function(){
    if($(this).is(':checked')){
      $('.keterangan'+$(this).val()).append($("<option selected='selected'></option>").val('').text(''))
      $('.keterangan'+$(this).val()).prop('disabled', 'disabled');
    }else{
      $('.keterangan'+$(this).val()).prop('disabled', false);
    }
  })

});
</script>
@stop
