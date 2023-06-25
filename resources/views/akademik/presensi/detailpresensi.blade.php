@extends('layouts.menu')

@section('title-head', 'Detail Presensi')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Detail Presensi
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('laporan.presensi.detail', $data->id)}}">Presensi</a></li>
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
                      <td>
                        <b>{{$data->mapel->nama}}</b>
                        @if ($isagama == 1)
                          ({{$data->agama->nama}})
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td>Kelompok</td>
                      <td><b>{{$data->jenismapel->nama}}</b></td>
                    </tr>
                    <tr>
                      <td>Guru</td>
                      <td>
                        @if ($isagama == 0)
                          <b><ul class="pl-1 mb-0">
                            @foreach ($data->jadwalguru as $jg)
                              <li>{{$jg->guru->nama}}</li>
                            @endforeach
                          </ul></b>
                        @else
                          <b>{{$data->jadwalguru->guru->nama}}</b>
                        @endif
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
              <div class="col-lg-6 col-sm-12">
                <div class="table-responsive">
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
                      <td>
                        @if ($isagama == 0)
                          <b>{{$data->kelas->nama}}</b>
                        @else
                          <b>{{$data->tingkatkelas->nama}}</b>
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td>Jenis Kelas</td>
                      <td>
                        @if ($isagama == 0)
                          <b>{{$data->kelas->jenis->nama}}</b>
                        @else
                          -
                        @endif
                      </td>
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
        <div class="card">
          <div class="card-body">
            <?php
              $row = 1;
              $col = 1;
              if (count($pertemuanke) > 0) {
                $row = 2;
                $col = count($pertemuanke);
              }
            ?>
            <table class="table table-bordered table-hover" id="tabledetil">
              <thead class="text-center">
                <tr>
                  <th rowspan="{{$row}}" style="vertical-align: middle">No</th>
                  <th rowspan="{{$row}}" style="vertical-align: middle">NIS</th>
                  <th rowspan="{{$row}}" style="vertical-align: middle">Nama Siswa</th>
                  @if ($isagama == 1)
                    <th rowspan="{{$row}}" style="vertical-align: middle">Kelas</th>
                  @endif
                  <th colspan="{{$col}}" class="py-25">Pertemuan</th>
                </tr>
                @if (count($pertemuanke) > 0)
                  <tr>
                    @foreach($pertemuanke as  $p)
                      <th style="width: 1px;" class="text-center p-25">
                        <span class="d-block m-b--5">{{$p->pertemuan}}</span>
                        <button type="button" value="{{$p->pertemuan}}:{{$p->idjadwal}}:{{$p->tanggal}}" style="cursor: pointer;" class="btn badge badge-light-primary tglabsen p-25" name="button" title="Klik untuk mengubah">{{date('d/m/y',strtotime($p->tanggal))}}</button>
                      </th>
                    @endforeach
                  </tr>
                @endif
              </thead>
              <tbody>
                <?php $i=0; $no=1 ?>
                @foreach($siswa as $s)
                <tr>
                  <td class="text-center" style="width: 1px;">{{$no}}</td>
                  <td style="width: 1px;">{{$s->nis}}</td>
                  <td style="{{$isagama == 0 ? 'white-space: nowrap' : ''}}">{{$s->nama}}</td>
                  @if ($isagama == 1)
                    <td>{{$s->kelas->nama}} {{$s->kelas->jenis->nama}}</td>
                  @endif
                  @if (count($pertemuanke) == 0)
                    <td></td>
                  @else 
                    @foreach($pertemuanke as $p)
                      <td class="text-center">
                        @foreach($presensi as $a)
                          @if($a->pertemuan == $p->pertemuan && $a->nis == $s->nis)
                            @if($a->hadir == 1 && $a->catatan == 'Dispensasi')
                              <button value="{{$a->id}}"type="button" class="btn btn-sm btn-warning rounded-circle btn-icon absen" id="idabsen" title="Klik untuk mengubah"><i data-feather="check" class="font-medium"></i></button>
                            @elseif($a->hadir == 1)
                              <button value="{{$a->id}}"type="button" class="btn btn-sm btn-success rounded-circle btn-icon absen" id="idabsen" title="Klik untuk mengubah"><i data-feather="check" class="font-medium"></i></button>
                            @else
                              <button value="{{$a->id}}"type="button" class="btn btn-sm btn-danger rounded-circle btn-icon absen" id="idabsen" title="Klik untuk mengubah"><i data-feather="x" class="font-medium"></i></button>
                            @endif
                          @endif
                        @endforeach
                      </td>
                    @endforeach
                  @endif
                </tr>
                <?php $i++; $no++ ?>
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
<div class="modal fade" id="modal-ubahabsen" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Ubah Presensi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('laporan.presensi.update')}}" method="post">
        <input type="hidden" name="id" id="idubahabsen">
        <div class="modal-body">
          <div class="table-responsive-lg">
            <table class="table">
              <tr>
                <td>NIS</td>
                <td><b id="absennis"></b></td>
              </tr>
              <tr>
                <td>Nama Siswa</td>
                <td><b id="absennama"></b></td>
              </tr>
              <tr>
                <td>Tanggal</td>
                <td><b id="absentgl"></b></td>
              </tr>
              <tr>
                <td>Kehadiran</td>
                <td>
                  <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" id="absendatang" name="hadir" value="1" type="checkbox">
                    <label class="custom-control-label" for="absendatang">Hadir</label>
                  </div>
                </td>
              </tr>
              <tr id="tidakhadir">
                <td>Catatan</td>
                <td>
                  <select class="form-control show-tick ms select2" name="catatan" id="absencatatan" data-placeholder="Pilih">
                    <option></option>
                    <option value="Dispensasi">Dispensasi</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Izin">Izin</option>
                    <option value="Alpa">Alpa</option>
                  </select>
                </td>
              </tr>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="save"></i> Simpan</button>
          <button class="btn btn-sm btn-outline-dark" data-dismiss="modal">Batal</button>
        </div>
        @csrf
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-ubahtgl" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Ubah Detail Pertemuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-12">
          <table class="table table-striped">
            <tr>
              <td style="width: 30%">Mata Pelajaran</td>
              <td><b>{{$data->mapel->nama}}</b> {{$isagama == 1 ? '('.$data->agama->nama.')' : ''}}</td>
            </tr>
            <tr>
              <td>Kelas</td>
              <td>
                @if ($isagama == 0)
                  <b>{{$data->kelas->nama}} {{$data->kelas->jenis->nama}}</b>
                @else
                  <b>{{$data->tingkatkelas->nama}}</b>
                @endif
              </td>
            </tr>
            <tr>
              <td>Jadwal</td>
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
          </table>
        </div>
        <form action="{{route('laporan.presensi.updatetgl')}}" method="post">
          <input type="hidden" name="idjadwal" id="idjadwal">
          <input type="hidden" name="isagama" value="{{$isagama}}">
          <div class="row">
            <div class="form-group col-lg-6">
              <label class="col-sm-12 col-form-label"><b>Pertemuan Ke</b></label>
              <div class="col-sm-12">
                <input type="text" name="pertemuan" class="form-control pertemuanke" value="" readonly required>
              </div>
            </div>
            <div class="form-group col-lg-6">
              <label class="col-sm-12 col-form-label"><b>Tanggal</b></label>
              <div class="col-sm-12">
                <input type="text" name="tanggal" class="form-control flatpickr-basic tgllama"  style="background-color: white" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Materi Pembelajaran</b></label>
            <div class="col-sm-12">
              <textarea id="materi" name="materi" class="form-control" required rows="3" cols="80"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Penugasan</b></label>
            <div class="col-sm-12">
              <textarea name="tugas" class="form-control" rows="3" cols="80" id="tugas"></textarea>
              <small class="text-muted">* kosongkan jika tidak ada tugas</small>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="save"></i> Simpan</button>
          <button class="btn btn-sm btn-outline-dark" data-dismiss="modal">Batal</button>
        </div>
        @csrf
      </form>
    </div>
  </div>
</div>
@endsection

@section('jspage')
<script>
$(document).ready(function() {
  var isagama = '{{$isagama}}'

  var table = $('#tabledetil').DataTable({
      paging: false,
      info: false,
      autoWidth: false,
      "drawCallback": function( settings ) {
        feather.replace();
      },
      dom: '<"box-body"<"row"<"col-sm-6"<"toolbaraksi">><"col-sm-6"f>>><"box-body table-responsive"tr><"box-body"<"row"><"row"<"col-sm-6"i><"col-sm-6"p>>>',
      order: [[ 2, "asc" ]],
  });

  $('#tabledetil tbody').on('click', '#idabsen', function () {
    $.get('/laporan/presensi/edit/'+$(this).val()+'/'+isagama, function(data){
      $('#modal-ubahabsen').modal('show');
      $('#absennama').text(data.siswa.nama)
      $('#absennis').text(data.nis)
      var tgl = formattgl(data.tanggal)
      $('#absentgl').text(tgl)
      $('#idubahabsen').val(data.id)
      $('#absencatatan').append($("<option selected='selected'></option>").val(data.catatan).text(data.catatan))
      if (data.hadir == 1 && data.catatan == 'Dispensasi') {
        $('#absendatang').prop('checked', false);
        $('#absencatatan').append($("<option selected='selected'></option>").val(data.catatan).text(data.catatan))
        $('#absencatatan').prop('disabled', false);
      }else if (data.hadir == 1) {
        $('#absendatang').prop('checked', true);
        $('#absencatatan').append($("<option selected='selected'></option>").val('').text(''))
        $('#absencatatan').prop('disabled', 'disabled');
      }else {
        $('#absendatang').prop('checked', false);
        $('#absencatatan').prop('disabled', false);
      }
    })
  })

  $('#absendatang').on('click', function(){
    if($(this).is(':checked')){
      $('#absencatatan').append($("<option selected='selected'></option>").val('').text(''))
      $('#absencatatan').prop('disabled', 'disabled');
    }else{
      $('#absencatatan').prop('disabled', false);
    }
  });

  $('.tglabsen').on('click', function(){
    var data = $(this).val()
    data = data.split(':')
    $.get('/laporan/presensi/getmateri/'+data[1]+'/'+isagama+'/'+data[0], function(materi){
      $('#materi').val(materi.materi)
      $('#tugas').val(materi.tugas)
    });
    $('#modal-ubahtgl').modal('show');
    $('.pertemuanke').val(data[0])
    $('.tgllama').val(data[2])
    $('#idjadwal').val(data[1])
  })

  function formattgl (tgl) {
    var d = new Date(tgl);
    var day = d.getDate();
    var month = d.getMonth() + 1;
    var year = d.getFullYear();
    if (day < 10) {
      day = "0" + day;
    }
    if (month < 10) {
      month = "0" + month;
    }
    var date = day + "/" + month + "/" + year;
    return date;
  };

});
</script>
@stop
