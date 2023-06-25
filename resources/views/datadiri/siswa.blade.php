@extends('layouts.menu')

@section('title-head', 'Profil Siswa')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Profil Siswa</h2>
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
                <img class="rounded" width="100%" src="{{$data->detil->photo == null ? asset('images/user-default.jpg') : asset($data->detil->photo)}}">
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <p class="text-primary mb-0">{{$data->nama}}</p>
                <div class="dropdown-divider"></div>
                <p class="mb-0 font-small-3">
                  <b>{{$data->idkelas == '' ? '':$data->kelas->nama}}</b><br>
                  {{$data->idkelas == '' ? '': $data->kelas->jenis->nama.' '.$data->kelas->nama}}
                </p>
                <div class="dropdown-divider"></div>
                <div class="d-flex align-items-center my-25">
                  <div class="avatar bg-light-primary text-left mr-75">
                    <div class="avatar-content">
                      <i data-feather="calendar"></i>
                    </div>
                  </div>
                  {{-- <span class="col px-0 font-small-3">{{(count($mapel->detil->where('idjadwal','!=',null)))}} Jadwal</span> --}}
                </div>
                <div class="dropdown-divider"></div>
                <div class="d-flex align-items-center my-25">
                  <div class="avatar bg-light-primary text-left mr-75">
                    <div class="avatar-content">
                      <i data-feather="file-text"></i>
                    </div>
                  </div>
                  {{-- <span class="col px-0 font-small-3">{{$mapel->sks}} SKS</span> --}}
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
                  <span class="col px-0 font-small-3">{{$data->detil->email}}</span>
                </div>
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
$(document).ready(function() {

})
</script>
@stop
