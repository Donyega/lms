@extends('layouts.menu')

@section('title-head', 'Dashboard')
@php
    $gs = App\Models\Profil::find(1);
@endphp
@section('content')
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
        <div class="row breadcrumbs-top">
          <div class="col-12">
            <h2 class="content-header-title float-left mb-0">Dashboard Pendidik</h2>
            <div class="breadcrumb-wrapper">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">LMS SLUA</a></li>
                <li class="breadcrumb-item active">Dahboard</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="content-body">
      <div class="row match-height">
        <div class="col-12">
          <div class="card card-congratulations">
            <div class="card-body text-center">
              <img src="{{asset('images/img-frame.png')}}" class="congratulations-img-left">
              <div class="avatar avatar-lg bg-light-info shadow mb-1">
                <div class="avatar-content"><i data-feather="heart"></i></div>
              </div>
              <h3 class="text-light">Halo, {{auth::user()->pegawai->panggilan}}</h3>
              Selamat Datang di Learning Management System, {{$gs->nama}} <br>
              <small>Silakan memilih Mata Pelajaran dan tekan tombol <b>Detail</b> untuk menuju halaman pembelajaran</small>
            </div>
          </div>
        </div>
        
        <div class="col-lg-6 col-md-6 col-12">
          <div class="card">
            <h4 class="card-header text-success">Jadwal</h4>
            <div class="table-responsive">
              <table class="table datatable-project">
                <thead>
                  <tr>
                    <th>Mata Pelajaran</th>
                    <th class="text-nowrap">Kelas</th>
                    <th>Hari</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($jadwal as $j)
                    <tr>
                      <td>{{$j->jadwal->mapel->nama}}</td>
                      <td>{{$j->jadwal->kelas->nama}}</td>
                      <td>{{$j->jadwal->hari->nama}}, @foreach ($j->jadwal->detil as $jdt) {{$jdt->jampelajaran->mulai}} s/d {{$jdt->jampelajaran->selesai}} @endforeach</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-6 col-12">
          <div class="card">
            <h4 class="card-header text-success">Upcoming</h4>
            <div class="table-responsive">
              <table class="table datatable-project">
                <thead>
                  <tr>
                    <th>Judul</th>
                    <th class="text-nowrap">Kelas</th>
                    <th>Tanggal</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($jadwal as $j)
                  @php
                      $penugasan = App\Models\LmsPenugasan::with(['jadwal'])->where('idjadwal', $j->id)
                      ->orderBy('batastgl')
                      ->get();
                  @endphp
                    @foreach ($penugasan as $p)
                      @if(!isset($akanDatang) && $p->batastgl > now())
                        <tr>
                          <td>{{$p->judul}}</td>
                          <td>{{$p->jadwal->kelas->nama}}</td>
                          <td>{{$p->batastgl}}</td>
                        </tr>
                      @endif
                    @endforeach
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-6 col-12">
          <div class="card">
            <h4 class="card-header text-success">Forum Diskusi</h4>

          </div>
        </div>

        <div class="col-lg-6 col-md-6 col-12">
          <div class="card">
            <h4 class="card-header text-success">Kalender</h4>
            <div class="app-calendar overflow-hidden">
              <div class="row g-0">
                <div class="col position-relative">
                  <div class="card shadow-none border-0 mb-0 rounded-0">
                    <div class="card-body pb-0">
                      <div id="calendar"></div>
                    </div>
                  </div>
                </div>
                <div class="body-content-overlay"></div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
@section('modal')

@endsection
@section('js')
<script>
  
</script>
@endsection
