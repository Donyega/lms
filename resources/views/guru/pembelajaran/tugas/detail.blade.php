@extends('layouts.menu')

@section('title-head', 'Penugasan '.$data->judul)

@section('content')
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
        <div class="row breadcrumbs-top">
          <div class="col-12">
            <h2 class="content-header-title float-left mb-0">Detail Penugasan</h2>
            <div class="breadcrumb-wrapper">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="{{route('home')}}"><i data-feather="home"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="{{route('pembelajaran',[Session::get('idjadwalglobal'),Session::get('idgambarglobal')])}}">Pembelajaran</a></li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="content-body">
      <div class="row match-height">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped mb-0">
                  <tr>
                    <td colspan="3" class="text-center text-lg-left">
                      <b class="text-primary">{{$data->judul}}</b>
                      <span class="d-block font-small-3">{{$data->jadwal->mapel->nama}} | {{$data->jadwal->kelas->nama}}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>Jenis Tugas</td>
                    <td class="px-0" style="width:1px">:</td>
                    <th>{{$data->idjenis == 1 ? 'Individu':'Kelompok'}}</th>
                  </tr>
                  <tr>
                    <td>Metode Pengumpulan</td>
                    <td class="px-0" style="width:1px">:</td>
                    <th>{{$data->idmetode == 1 ? 'Submit Dokumen' : 'Oral Presentation'}}</th>
                  </tr>
                  <tr>
                    <td>Penilaian</td>
                    <td class="px-0" style="width:1px">:</td>
                    <th>
                      {{$rubrik == 1 ? 'Dengan Rubrik' : 'Nilai Akhir'}}
                    </th>
                  </tr>
                </table>
                <hr class="my-0">
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="card">
            <div class="card-body text-center px-25">
              <div class="avatar bg-light-danger p-50 mb-50">
                <div class="avatar-content">
                  <i data-feather="calendar" class="font-medium-3"></i>
                </div>
              </div>
              <p class="card-text mb-25">Batas Pengumpulan</p>
              <h5 class="font-weight-bolder text-danger">{{(new \App\Helper)->tanggal($data->batastgl)}}</h5>
              <p class="card-text">{{date('H:i',strtotime($data->batasjam))}} WITA</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="card">
            <div class="card-body text-center px-25">
              <div class="avatar bg-light-success p-50 mb-50">
                <div class="avatar-content">
                  <i data-feather="user-check" class="font-medium-3"></i>
                </div>
              </div>
              <p class="card-text mb-25">Pengumpulan</p>
              <h3 class="font-weight-bolder text-success">{{count($data->kumpul)}}/{{session::get('jumlahsws')}}</h3>
              {{-- <span class="mt-50">{{round(count($data->kumpul)/session::get('jumlahsws')*100,2)}}%</span> --}}
              <div class="col mt-1">
                <div class="progress progress-bar-success mb-50">
                  {{-- <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="40" aria-valuemax="100" style="width: {{count($data->kumpul)/session::get('jumlahsws')*100}}%"></div> --}}
                </div>
              </div>
            </div>
          </div>
        </div>

        @if($data->idmetode == 2)
          <div class="col-12">
            <div class="text-center mb-1">
              <button class="btn btn-danger mb-25" data-toggle="modal" data-target="#modal-sws"><i data-feather="plus"></i> Tambah Nilai</button>
            </div>
          </div>
        @endif

        <div class="col-12">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <div class="text-center text-lg-left">
                <h4 class="mb-25">Daftar Siswa</h4>
                <h6 class="text-muted mb-1">Diurutkan berdasarkan waktu pengumpulan</h6>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group input-group input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i data-feather="search"></i></span>
                </div>
                <input type="text" class="form-control" id="cari" placeholder="Cari Siswa...">
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 swsdisiini">

        </div>
      </div>
    </div>
  </div>
@endsection

@section('modal')
<div class="modal fade text-left" id="modal-sws" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title-dokumen">Penilaian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form class="forms-sample form-dokumen" action="{{route('pembelajaran.penugasan.nilai.store')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="idpenugasan" value="{{$data->id}}">
            <input type="hidden" name="rubrik" value="{{count($data->rubrik)}}">
            <input type="hidden" name="idjadwal" value="{{session::get('idjadwalglobal')}}">
            <input type="hidden" name="iduser" value="{{auth::user()->id}}">

            <div class="row">
              <div class="col-xl-12 mb-1">
                <div class="form-group">
                  <label><b>Siswa</b></label>
                  <select class="form-control select2" name="nis" id="sws" data-placehorder="Pilih" required>

                  </select>
                </div>
              </div>

              @if(count($data->rubrik) > 0)
                <div class="col-xl-12 mb-1">
                  <table class="table table-bordered table-hover">
                    <thead class="text-center">
                      <th>Penilaian</th>
                      <th>Bobot</th>
                      <th style="width: 1px">Nilai</th>
                    </thead>
                    <tbody>
                      @foreach($data->rubrik as $r)
                        <tr>
                          <td>{{$r->nama}}</td>
                          <td class="text-center">{{$r->bobot}} %</td>
                          <td style="width: 90px">
                            <input type="number" step="0.1" class="form-control" name="nilai-{{$r->id}}" required value="">
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @else
                <div class="col-xl-12 mb-1">
                  <div class="form-group">
                    <label><b>Nilai</b></label>
                    <input type="number" step="0.1" name="nilai" class="form-control" required value="">
                  </div>
                </div>
              @endif

              <div class="col-xl-12 mb-1">
                <div class="form-group">
                  <label><b>Komentar</b></label>
                  <textarea name="komentar" required class="form-control" rows="4" cols="80"></textarea>
                </div>
              </div>
            </div>
            {{ csrf_field() }}
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="save"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade text-left" id="modal-nilai" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title-dokumen">Penilaian {{$data->judul}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form class="forms-sample form-dokumen" action="{{route('pembelajaran.penugasan.nilai.update')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="idpenugasan" value="{{$data->id}}">
            <input type="hidden" name="rubrik" value="{{count($data->rubrik)}}">
            <input type="hidden" name="idjadwal" value="{{session::get('idjadwalglobal')}}">
            <input type="hidden" name="iduser" value="{{auth::user()->id}}">
            <input type="hidden" name="id" id="nilaiid" value="">

            <div class="row">
              <div class="col-xl-12 mb-1">
                <div class="form-group">
                  <label><b>NIS</b></label>
                  <input type="text" class="form-control" id="nilainis" name="nis" readonly>
                </div>
              </div>
              <div class="col-xl-12 mb-1">
                <div class="form-group">
                  <label><b>Nama</b></label>
                  <input type="text" class="form-control" id="nilainama" readonly>
                </div>
              </div>

              @if(count($data->rubrik) > 0)
              <div class="col-xl-12 mb-1">
                <table class="table table-bordered table-hover">
                  <thead class="text-center">
                    <th>Komponen</th>
                    <th>Bobot</th>
                    <th>Nilai</th>
                  </thead>
                  <tbody>
                    @foreach($data->rubrik as $r)
                      <tr>
                        <td>{{$r->nama}}</td>
                        <td class="text-center">{{$r->bobot}}%</td>
                        <td style="width: 90px">
                          <input type="number" step="0.1" class="form-control" name="nilai-{{$r->id}}" id="nilai-{{$r->id}}" required value="">
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              @else
              <div class="col-xl-12 mb-1">
                <div class="form-group">
                  <label><b>Nilai</b></label>
                  <input type="number" step="0.1" name="nilai" id="nilai" class="form-control" required value="">
                </div>
              </div>
              @endif

              <div class="col-xl-12 mb-1">
                <div class="form-group">
                  <label><b>Komentar</b></label>
                  <textarea name="komentar" required class="form-control" id="nilaikomentar" rows="4" cols="80"></textarea>
                </div>
              </div>
            </div>
            {{ csrf_field() }}
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="save"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade text-left" id="modal-nilaiklp" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title-dokumen">Pengisian Nilai Penugasan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form class="forms-sample form-dokumen" action="{{route('pembelajaran.penugasan.nilai.updatekelompok')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="idpenugasan" value="{{$data->id}}">
            <input type="hidden" name="rubrik" value="{{count($data->rubrik)}}">
            <input type="hidden" name="idjadwal" value="{{session::get('idjadwalglobal')}}">
            <input type="hidden" name="iduser" value="{{auth::user()->id}}">

            <h5 class="text-center mb-1 text-primary">{{$data->judul}}</h5>
            <hr>

            <div class="nilaidisini">

            </div>

            {{ csrf_field() }}
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="save"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('jspage')
<script>
$(document).ready(function() {

  daftarsws('')

  $('#cari').on('keyup', function(){
    term = $(this).val();
    daftarsws(term)
  })

  function daftarsws(term){
    $.get('/pembelajaran/{{$data->idjadwal}}/tugas/searching/{{$data->id}}/'+term, function(data){
      $('.swsdisiini').html(data)
      feather.replace()
      $('.btnnilai').on('click', function(){
        idtugas = $(this).val();
        $.get('/pembelajaran/tugas/nilai/gettugas/'+idtugas, function(data){
          nama = data.siswa.nama
          $('#nilainis').val(data.nis)
          $('#nilaiid').val(idtugas)
          $('#nilainama').val(nama)
          $('#nilaikomentar').val(data.komentar)

          if ('{{count($data->rubrik)}} > 0') {
            $.each(data.detilnilai, function(i,e){
              $('#nilai-'+e.idrubrik).val(e.nilai)
            });
          }else {
            $('#nilai').val(data.nilai)
          }
        });
      })
      $('.btnnilaiklp').on('click', function(){
        idkelompok = $(this).val();
        $.get('/pembelajaran/tugas/nilai/getkelompok/'+idkelompok, function(data){
          $('.nilaidisini').html(data)
        });
      })
    })
  }

});
</script>
@stop
