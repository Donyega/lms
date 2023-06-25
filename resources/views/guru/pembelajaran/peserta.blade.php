@extends('layouts.menu')

@section('title-head', 'Peserta Evaluasi '.$data[0]->evaluasi->materi->materi)

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Peserta Evaluasi {{$data[0]->evaluasi->jadwal->mapel->nama}}
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{route('home')}}"><i data-feather="home"></i></a>
              </li>
              <li class="breadcrumb-item"><a href="{{route('pembelajaran',[$data[0]->evaluasi->materi->idjadwal,$img])}}">Pembelajaran</a></li>
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
              <table class="table table-striped">
                <tr>
                  <td>Pertemuan</td>
                  <td class="px-0" style="width:1px">:</td>
                  <th>{{$data[0]->evaluasi->materi->pertemuan}}</th>
                </tr>
                <tr>
                  <td>Materi</td>
                  <td class="px-0" style="width:1px">:</td>
                  <th>{{$data[0]->evaluasi->materi->materi}}</th>
                </tr>
                <tr>
                  <td>Jenis Evaluasi</td>
                  <td class="px-0" style="width:1px">:</td>
                  <th>
                    <div class="badge badge-light-primary">{{$data[0]->evaluasi->materi->jenis->alias}}</div>
                    {{$data[0]->evaluasi->jenis->nama}}</th>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="card">
          <div class="card-body text-center px-25">
            <div class="avatar bg-light-danger p-50 mb-50">
              <div class="avatar-content">
                <i data-feather="calendar" class="font-medium-3"></i>
              </div>
            </div>
            <p class="card-text mb-25">Pelaksanaan Evaluasi</p>
            <h5 class="font-weight-bolder text-danger">{{(new \App\Helper)->tanggal($data[0]->evaluasi->tgl)}}</h5>
            <p class="card-text">{{date('H:i',strtotime($data[0]->evaluasi->mulai))}} s/d {{date('H:i',strtotime($data[0]->evaluasi->berakhir))}}</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="card">
          <div class="card-body text-center px-25">
            <div class="avatar bg-light-success p-50 mb-50">
              <div class="avatar-content">
                <i data-feather="file-text" class="font-medium-3"></i>
              </div>
            </div>
            <p class="card-text mb-25">Peserta Evaluasi</p>
            <h3 class="font-weight-bolder text-success">{{$data->count()}} {{Session::get('jumlahswa')}}</h3>
            {{-- <h3 class="font-weight-bolder text-success"> yang kumpul dari yang ikut{{$data->where('idstatus', 1)->count()}}/{{$data->count()}}</h3> --}}
            {{-- <span class="mt-50">{{round($data->count() / Session::get('jumlahswa') * 100, 2)}}%</span>
            <div class="col mt-1">
              <div class="progress progress-bar-success mb-50">
                <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="40" aria-valuemax="100" style="width: {{$data->count()/Session::get('jumlahswa')*100}}%"></div>
              </div>
            </div> --}}
            {{-- <h3 class="font-weight-bolder text-success">{{count($data->soal)}}</h3> --}}
          </div>
        </div>
      </div>
      {{-- <div class="col-12">
        <div class="text-center mb-1">
          <button class="btn btn-primary mb-25" data-toggle="modal" data-target="#modal-evaluasi"><i data-feather="settings"></i> Ubah Pengaturan</button>
          <button class="btn btn-danger mb-25"><i data-feather="plus"></i> Tambah Soal</button>
          <button class="btn btn-success mb-25" data-toggle="modal" data-target="#modal-unggah"><i data-feather="upload"></i> Unggah Soal</button>
        </div>
      </div> --}}
      {{-- <div class="col-12">
        <div class="card">
          <div class="card-body">
            <table class="table table-bordered table-hover" id="tabelsoal">
              <thead class="text-center">
                <th>Soal</th>
                <th>Aksi</th>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div> --}}


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
      <div class="col-12 swadisiini">

      </div>
    </div>
  </div>
</div>
@endsection

@section('modal')
@endsection

@section('jspage')
<script>
  daftarswa('')

  $('#cari').on('keyup', function(){
    term = $(this).val();
    daftarswa(term)
  })

  function daftarswa(term){
    $.get('/pembelajaran/peserta/searching/{{ $data[0]->evaluasi->idjadwal }}/{{ $data[0]->evaluasi->id }}/'+term, function(data){
      $('.swadisiini').html(data)
      feather.replace()
    })
  }
</script>
@stop
