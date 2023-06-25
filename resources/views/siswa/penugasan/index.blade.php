@extends('layouts.menu')

@section('title-head', 'Penugasan')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Penugasan
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{route('home')}}"><i data-feather="home"></i></a>
              </li>
              <li class="breadcrumb-item"><a href="#">Penugasan</a></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="content-body">
    <div class="row">
      <div class="col-lg-8 order-2 order-md-1 order-lg-1">
        <?php $jmlkumpul = 0; ?>
        @foreach ($data as $d)
          <?php
            $kumpul = $d->tugassiswa->where('nis',$nis)->first();
            if ($kumpul == null) {
              $filter = 'not-submitted';
            }else {
              $filter = 'submitted';
              $jmlkumpul++;
            }
          ?>
          <div class="card mb-75 {{$filter}}">
            <div class="card-body">
              <div class="row align-items-center text-center text-md-left text-lg-left">
                <div class="col-lg-10 col-md-9">
                  <span class="font-small-3 text-muted">{{$d->jadwal->mapel->nama}}</span>
                  <h5 class="font-weight-bolder mb-25">
                    {{$d->judul}}
                  </h5>
                  <span class="font-small-3 text-muted">{{$d->user->pegawai->nama}}</span>
                  <div class="row my-50">
                    <div class="ml-1 border-left-primary border-left-3 d-none d-md-inline"></div>
                    <div class="col">
                      @if($d->idjenis == 1)
                        <div class="badge badge-light-info mb-50"><i data-feather="user"></i> Individu</div>
                      @else
                        <div class="badge badge-light-info mb-50"><i data-feather="users"></i> Kelompok</div>
                      @endif
                      <p class="mb-50">{{$d->keterangan}}</p>
                      <span class="d-block mb-25 font-small-3">
                        <i data-feather="calendar" style="margin-top:-2px"></i> {{(new \App\Helper)->tanggal($d->batastgl)}} | {{date('H:i',strtotime($d->batasjam))}} WITA
                      </span>
                      @if ($kumpul == null)
                        <div class="badge badge-light-danger mb-50 mb-lg-0"><i data-feather="edit-2"></i> Belum Dikumpulkan</div>
                      @else
                        <footer class="blockquote-footer mb-25">
                          Dikumpulkan {{(new \App\Helper)->tanggal($kumpul->created_at)}}
                        </footer>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="col-lg-2 col-md-3 text-center text-md-right text-lg-right">
                  <div class="d-none d-lg-inline">
                    <a href="{{route('swa.penugasan.detil',$d->id)}}" class="btn btn-icon bg-gradient-primary" title="Detail Pengumpulan Tugas" value=""><i data-feather="file-text"></i></a>
                  </div>
                  <div class="d-lg-none">
                    <a href="{{route('swa.penugasan.detil',$d->id)}}" class="btn btn-sm bg-gradient-primary" title="Detail Pengumpulan Tugas" value=""><i data-feather="file-text"></i> Detail</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <div class="col-lg-4 order-1 order-md-2 order-lg-2">
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">Rekapitulasi</h5>
          </div>
          <div class="card-body">
            <div class="dropdown-divider mt-0"></div>
            <div class="d-flex align-items-center my-25">
              <span class="col px-0"><i data-feather="file-text" class="text-primary" style="margin-top: -2px"></i> Total Penugasan</span>
              <div class="avatar bg-primary text-right ml-50" id="filter">
                <div class="avatar-content">{{count($data)}}</div>
              </div>
            </div>
            <div class="dropdown-divider"></div>
            <div class="d-flex align-items-center my-25">
              <span class="col px-0"><i data-feather="user-check" class="text-success" style="margin-top: -2px"></i> Sudah Dikumpulkan</span>
              <div class="avatar bg-success text-right ml-50" id="filter-submit">
                <div class="avatar-content">{{$jmlkumpul}}</div>
              </div>
            </div>
            <div class="dropdown-divider"></div>
            <div class="d-flex align-items-center my-25">
              <span class="col px-0"><i data-feather="user-x" class="text-danger" style="margin-top: -2px"></i> Belum Dikumpulkan</span>
              <div class="avatar bg-danger text-right ml-50" id="filter-not-submit">
                <div class="avatar-content">{{count($data) - $jmlkumpul}}</div>
              </div>
            </div>
            <div class="dropdown-divider"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('modal')

@endsection

@section('jspage')
<script>
$(document).ready(function() {
  $('#filter').on('click',function(){
    $('.submitted').show();
    $('.not-submitted').show();
  });

  $('#filter-submit').on('click',function(){
    $('.submitted').show();
    $('.not-submitted').hide();
  });

  $('#filter-not-submit').on('click',function(){
    $('.submitted').hide();
    $('.not-submitted').show();
  });
});
</script>
@stop
