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
          <h2 class="content-header-title float-left mb-0">Dashboard Peserta Didik
          </h2>
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
            <h3 class="text-light">Halo, {{auth::user()->siswa->nama}}</h3>
            Selamat Datang di Learning Management System, {{$gs->nama}}.
          </div>
        </div>
      </div>
      @if(count($jadwal) > 0)
      <div class="col-lg-6 col-md-6 col-12">
        <div class="card">
          <h4 class="card-header text-success">Jadwal</h4>
          <div class="table-responsive">
            <table class="table datatable-project">
              <thead>
                <tr>
                  <th>Guru</th>
                  <th class="text-nowrap">Mata Pelajaran</th>
                  <th>Hari</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($jadwal as $j)
                @foreach ($j->jadwalguru as $jg)
                <tr>
                  <td><small>{{$jg->guru->nama}}</small></td>
                  <td><small>{{$j->mapel->nama}}</small></td>
                  <td><small>{{$j->hari->nama}}, @foreach ($j->detil as $jdt) {{$jdt->jampelajaran->mulai}} s/d {{$jdt->jampelajaran->selesai}} @endforeach</small></td>
                </tr>
                @endforeach
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
      
      @else
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row align-items-center text-center text-lg-left">
                <div class="col-sm-1 p-0 text-center">
                  <div class="avatar bg-light-danger p-50 m-25">
                    <div class="avatar-content">
                      <i data-feather="info" class="font-medium-5"></i>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <h4 class="font-weight-bolder mb-0">Jadwal Pelajaran Belum Ditentukan</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endif
    </div>
    <section>
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
    </section>
  </div>
</div>
@endsection
@section('modal')

@endsection
@section('js')
<script>
  
</script>
@endsection
