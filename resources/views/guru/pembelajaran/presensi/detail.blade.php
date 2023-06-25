@extends('layouts.menu')

@section('title-head', 'Detail Kehadiran '.$data->mapel->nama)

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Detail Kehadiran
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{route('home')}}"><i data-feather="home"></i></a>
              </li>
              <li class="breadcrumb-item"><a href="{{route('pembelajaran.presensi',Session::get('idjadwalglobal'))}}">Presensi</a></li>
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
                            <li>{{$data->hari}}, {{$data->jam}}</li>
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
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <table class="table dt-complex-header table-bordered table-hover" id="tabledetil">
              <thead class="text-center">
                <tr>
                  <th rowspan="2">Siswa</th>
                  <th colspan="{{count($pertemuanke)}}" class="p-25">Pertemuan</th>
                </tr>
                <tr>
                  @foreach($pertemuanke as  $p)
                    <th style="width: 5px !important;" class="text-center px-25">
                      <span class="d-block m-b--5">{{$p->pertemuan}}</span>
                      <button type="button" value="{{$p->pertemuan}}:{{$p->idjadwal}}:{{$p->tanggal}}" class="btn badge badge-light-primary tglabsen" name="button" title="Klik untuk mengubah">{{date('d/m/y',strtotime($p->tanggal))}}</button>
                    </th>
                  @endforeach
                </tr>
              </thead>
              <tbody>
                <?php $i=0; ?>
                @foreach($siswa as $sws)
                <tr>
                  <td style="white-space: nowrap;">
                    <span class="d-block font-small-3 text-muted"> {{$sws->nama}}</span>
                    <span class="d-block font-small-3 text-muted"> {{$sws->nis}}</span>
                  </td>
                  @foreach($pertemuanke as  $p)
                  <td class="text-center">
                    @foreach($presensi->where('nis',$sws->nis)->where('pertemuan',$p->pertemuan) as $a)
                      @if($a->hadir == 1)
                        <button value="{{$a->id}}" type="button" class="btn btn-sm btn-success btn-icon rounded-circle absen" id="idabsen" title="Klik untuk mengubah"><i data-feather="check"></i></button>
                      @else
                        <button value="{{$a->id}}"type="button" class="btn btn-sm btn-danger btn-icon rounded-circle absen" id="idabsen" title="Klik untuk mengubah"><i data-feather="x"></i></button>
                      @endif
                    @endforeach
                  </td>
                  @endforeach
                </tr>
                <?php $i++; ?>
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
      <div class="modal-body">
        <form action="{{route('pembelajaran.presensi.update')}}" method="post">
          <input type="hidden" name="id" id="idubahabsen">
            <table class="table table-striped mb-0">
              <tr>
                <td style="width: 40%">NIS</td>
                <td><b id="absennis"></b></td>
              </tr>
              <tr>
                <td>Nama Siswa</td>
                <td><b id="absennama"></b></td>
              </tr>
              <tr>
                <td>Pertemuan</td>
                <td><b id="absenpertemuan"></b></td>
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
                    <option value="Sakit">Sakit</option>
                    <option value="Izin">Izin</option>
                    <option value="Tanpa Keterangan">Tanpa Keterangan</option>
                  </select>
                </td>
              </tr>
            </table>
          <hr class="m-0">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="save"></i> Simpan</button>
          <button class="btn btn-sm btn-outline-danger" data-dismiss="modal">Batal</button>
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
          <table class="table table-striped mb-0">
            <tr>
              <td style="width: 30%">Mata Pelajaran</td>
              <td class="px-0" style="width: 1px">:</td>
              <td><b>{{$data->mapel->nama}}</b></td>
            </tr>
            <tr>
              <td>Kelas</td>
              <td class="px-0" style="width: 1px">:</td>
              <td><b>{{$data->kelas->nama}}</b></td>
            </tr>
            <tr>
              <td>Jadwal</td>
              <td class="px-0" style="width: 1px">:</td>
              <th>
                @if ($data->hari2 == null)
                {{$data->hari->nama}}, @foreach ($data->detil as $jdt) {{$jdt->jampelajaran->mulai}} s/d {{$jdt->jampelajaran->selesai}} @endforeach
                @else
                  <ul class="pl-1 mb-0">
                    <li>{{$data->hari}}, {{$data->jam}}</li>
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
          </table>
          <hr class="mt-0">
        </div>
        <form action="{{route('pembelajaran.presensi.updatetgl')}}" method="post">
          <input type="hidden" name="idjadwal" id="idjadwal">
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
            <label class="col-sm-12 col-form-label"><b>Materi Pelajaran</b></label>
            <div class="col-sm-12">
              <textarea id="materi" name="materi" class="form-control" required rows="3" cols="80" required></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Tugas Pelajaran</b></label>
            <div class="col-sm-12">
              <textarea name="tugas" class="form-control" rows="3" cols="80" id="tugas"></textarea>
              <small class="text-muted">* kosongkan jika tidak ada tugas</small>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="save"></i> Simpan</button>
          <button class="btn btn-sm btn-outline-danger" data-dismiss="modal">Batal</button>
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
  $('#tabledetil tbody').on('click', '#idabsen', function () {
    $.get('/pembelajaran/presensi/edit/'+$(this).val(), function(data){
      $('#modal-ubahabsen').modal('show');
      $('#absennama').text(data.siswa.nama)
      $('#absennis').text(data.nis)
      $('#absenpertemuan').text(data.pertemuan)
      var tgl = formattgl(data.tanggal)
      $('#absentgl').text(tgl)
      $('#idubahabsen').val(data.id)
      $('#gurudatang').text('')
      if (data.hadir == 1) {
        $('#absendatang').prop('checked', true);
        $('#absencatatan').append($("<option selected='selected'></option>").val('').text(''))
        $('#absencatatan').prop('disabled', true);
      }else {
        $('#absendatang').prop('checked', false);
        $('#absencatatan').append($("<option selected='selected'></option>").val(data.catatan).text(data.catatan))
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
        $.get('/pembelajaran/presensi/getmateri/'+data[1]+'/'+data[0], function(materi){
          $('#materi').val(materi.materi)
          $('#tugas').val(materi.tugas)
          if ('{{auth::user()->link}}' != materi.idguru && '{{auth::user()->role}}' != 1) {
            $('#materi').prop('readonly',true)
          }else {
            $('#materi').prop('readonly',false)
          }
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
        var date = day + "-" + month + "-" + year;

        return date;
      };

      var tabledetil = $('#tabledetil').DataTable({
        paging: false,
        info: false,
        autoWidth: false,
        "drawCallback": function( settings ) {
          feather.replace();
        },
        dom: '<"box-body"<"row"<"col-sm-3"l><"col-sm-5"<"toolbar">><"col-sm-4"f>>><"box-body table-responsive"tr><"box-body"<"row"><"row"<"col-sm-6"i><"col-sm-6"p>>>',
        order: false,
      });

      $(".formsws2").submit(function(){
        tabledetil.search('').draw();
        });
});
</script>
@stop
