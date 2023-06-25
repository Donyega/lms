@extends('layouts.menu')

@section('title-head', 'Profil Guru')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Profil Guru</h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{route('home')}}"><i data-feather="home"></i></a>
              </li>
              <li class="breadcrumb-item"><a href="#">Profil</a></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="content-body">
    <div class="row match-height">
      <div class="col-lg-7">
        <div class="row match-height">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <img src="{{auth::user()->pegawai->photo == null ? asset('images/user-default.jpg') : 'https://siakad.slua.sch.id/'.auth::user()->pegawai->photo}}" class="rounded" width="100%" alt="Foto Guru">
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <p class="text-primary mb-0">{{$data->nama}}</p>
                <div class="dropdown-divider"></div>
                <p class="mb-0 font-small-3">
                  <b>{{$data->detil->jenisptk->nama}}</b><br>
                </p>
                <div class="dropdown-divider"></div>
                <div class="d-flex align-items-center my-25">
                  <div class="avatar bg-light-primary text-left mr-75">
                    <div class="avatar-content">
                      <i data-feather="calendar"></i>
                    </div>
                  </div>
                  <span class="col px-0 font-small-3">{{count($jadwal)}} Jadwal</span>
                </div>
                <div class="dropdown-divider"></div>
                <div class="d-flex align-items-center my-25">
                  <div class="avatar bg-light-primary text-left mr-75">
                    <div class="avatar-content">
                      <i data-feather="file-text"></i>
                    </div>
                  </div>
                  <span class="col px-0 font-small-3">{{count($mapel)}} Mata Pelajaran</span>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-body">
                <h5>Kontak</h5>
                <div class="dropdown-divider"></div>
                <div class="d-flex align-items-center my-25">
                  <div class="avatar bg-light-danger text-left mr-75">
                    <div class="avatar-content">
                      <i data-feather="home"></i>
                    </div>
                  </div>
                  <span class="col px-0 font-small-3">{{$data->alamat}}</span>
                </div>
                <div class="dropdown-divider"></div>
                <div class="d-flex align-items-center my-25">
                  <div class="avatar bg-light-success text-left mr-75">
                    <div class="avatar-content">
                      <i data-feather="phone"></i>
                    </div>
                  </div>
                  <span class="col px-0 font-small-3">{{$data->nohp}}</span>
                </div>
                <div class="dropdown-divider"></div>
                <div class="d-flex align-items-center my-25">
                  <div class="avatar bg-light-primary text-left mr-75">
                    <div class="avatar-content">
                      <i data-feather="mail"></i>
                    </div>
                  </div>
                  <span class="col px-0 font-small-3">{{$data->email}}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="card">
          <div class="card-header border-bottom pb-75">
            <h5 class="mb-0">Statistik Penggunaan LMS</h5>
          </div>
          <div class="card-body mt-1">
            <div class="d-flex align-items-center">
              <div class="avatar bg-light-info p-75">
                <div class="avatar-content">
                  <i data-feather="video" class="font-medium-5"></i>
                </div>
              </div>
              <div class="col pr-0">
                <p class="card-text mb-0">Unggah Video Perkenalan</p>
                <h4 class="font-weight-bolder mb-50 text-info">
                  {{count($video)}} <small class="text-muted">dari {{count($jadwal)}} Jadwal Perkuliahan</small>
                </h4>
                <div class="progress progress-bar-info">
                  <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="{{count($video)}}" aria-valuemin="{{count($video)}}" aria-valuemax="{{count($jadwal)}}" style="width: {{round(count($video)/count($jadwal) * 100)}}%">{{round(count($video)/count($jadwal) * 100)}}%</div>
                </div>
              </div>
            </div>

            <div class="dropdown-divider my-1"></div>

            <div class="d-flex align-items-center">
              <div class="avatar bg-light-primary p-75">
                <div class="avatar-content">
                  <i data-feather="file-text" class="font-medium-5"></i>
                </div>
              </div>
              <div class="col pr-0">
                <p class="card-text mb-0">Unggah Materi</p>
                <h4 class="font-weight-bolder mb-50 text-primary">
                  {{count($unggahmateri)}} <small class="text-muted">dari {{count($jadwal)}} Jadwal Perkuliahan</small>
                </h4>
                <div class="progress progress-bar-primary">
                  <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="{{count($unggahmateri)}}" aria-valuemin="{{count($unggahmateri)}}" aria-valuemax="{{count($jadwal)}}" style="width: {{round(count($unggahmateri)/count($jadwal) * 100)}}%">{{round(count($unggahmateri)/count($jadwal) * 100)}}%</div>
                </div>
              </div>
            </div>

            <div class="dropdown-divider my-1"></div>

            <div class="d-flex align-items-center">
              <div class="avatar bg-light-danger p-75">
                <div class="avatar-content">
                  <i data-feather="edit-3" class="font-medium-5"></i>
                </div>
              </div>
              <div class="col pr-0">
                <p class="card-text mb-0">Penugasan</p>
                <h4 class="d-inline font-weight-bolder mb-50 text-danger">
                  <?php
                    $individu = 0;
                    $kelompok = 0;
                    if (count($penugasan) > 0) {
                      $individu = count($penugasan->where('idjenis',1));
                      $kelompok = count($penugasan->where('idjenis',2));
                    }
                  ?>
                  {{count($penugasan)}}
                </h4>    
                @if ($individu > 0)
                  <i data-feather="chevrons-right" class="text-muted"></i>
                  <span class="font-small-3 mx-25"><i data-feather="user" class="font-small-3" style="margin-top: -2px"></i> {{$individu}} Individu</span>
                @endif
                @if ($kelompok > 0)
                  <i data-feather="chevrons-right" class="text-muted"></i>
                  <span class="font-small-3 mx-25"><i data-feather="users" class="font-small-3" style="margin-top: -2px"></i> {{$kelompok}} Kelompok</span>
                @endif
              </div>
            </div>

            <div class="dropdown-divider my-1"></div>

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
$(document).ready(function() {

})
</script>
@stop
