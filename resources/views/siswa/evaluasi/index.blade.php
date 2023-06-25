@extends('layouts.menu')

@section('title-head', 'Evaluasi')

@section('content')
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
        <div class="row breadcrumbs-top">
          <div class="col-12">
            <h2 class="content-header-title float-left mb-0">Evaluasi
            </h2>
            <div class="breadcrumb-wrapper">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="{{route('home')}}"><i data-feather="home"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="#">Evaluasi</a></li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="content-body">
      <div class="row">
        <div class="col-lg-8 order-2 order-md-1 order-lg-1">
          @foreach ($data as $d)
            <div class="card mb-75">
              <div class="card-body">
                <div class="row align-items-center text-center text-md-left text-lg-left">
                  <div class="col-12">
                    <h5 class="font-weight-bolder mb-25">
                      <div class="badge badge-light-primary">{{$d->materi->jenis->alias}}</div> {{$d->jadwal->mapel->nama}}
                    </h5>
                    <span class="font-small-3">{{$d->user->pegawai->nama}}</span>
                    @if($d != null)
                      <div class="row my-50">
                        <div class="ml-1 border-left-primary border-left-3 d-none d-md-inline"></div>
                        <div class="col-lg-8">
                          @if($d->idjenis == 1)
                            <div class="badge badge-light-info mb-50"><i data-feather="edit-3"></i> Essay</div>
                          @else
                            <div class="badge badge-light-info mb-50"><i data-feather="check-square"></i> Pilihan Ganda</div>
                          @endif
                          <span class="d-block mb-25 font-small-3">
                            <i data-feather="calendar" style="margin-top:-2px"></i> {{(new \App\Helper)->tanggal($d->tgl)}}
                          </span>
                          <span class="d-block mb-25 font-small-3">
                            <i data-feather="clock" style="margin-top:-2px"></i> {{date('H:i',strtotime($d->mulai))}} s/d {{date('H:i',strtotime($d->berakhir))}} WITA
                          </span>
                          <?php $tes = App\Models\LmsSiswaEvaluasi::where('idevaluasi',$d->id)->first(); ?>
                          @if($tes == null)
                            <div class="badge badge-light-danger mb-50 mb-lg-0"><i data-feather="x"></i> Belum Diikuti</div>
                          @else
                            @if($tes->idstatus == 1)
                              <div class="badge badge-light-success mb-50 mb-lg-0"><i data-feather="check"></i> Sudah Diikuti</div>
                            @else
                              <div class="badge badge-light-secondary mb-50 mb-lg-0"><i data-feather="oader"></i> Proses</div>
                            @endif
                          @endif
                        </div>
                        <div class="col text-center text-lg-right">
                           {{-- @if($d->tgl == date('Y-m-d'))
                            @if($d->mulai <= date('H:m:s') && $d->berakhir >= date('H:m:s'))
                              <a href="{{route('swa.evaluasi.create',$d->id)}}" class="btn btn-outline-primary "><i data-feather="user-check" class="mb-25 font-medium-3"></i> <span class="d-block font-small-3">Mulai {{$d->materi->jenis->alias}}</span></a>
                            @endif
                          @endif  --}}

                          @if($d->tgl == date('Y-m-d'))
                            @if($d->mulai <= date('H:m:s') && $d->berakhir >= date('H:m:s'))
                              @if($tes == null)
                                @if ($d->idjenis == 1)
                                  <a href="{{route('swa.evaluasi.create',$d->id)}}" class="btn btn-outline-primary "><i data-feather="book-open" class="mb-25 font-medium-3"></i> <span class="d-block font-small-3">Mulai {{$d->materi->jenis->alias}}</span></a>
                                @else
                                  <a href="{{route('swa.evaluasi.create',$d->id)}}" class="btn btn-outline-primary "><i data-feather="user-check" class="mb-25 font-medium-3"></i> <span class="d-block font-small-3">Mulai {{$d->materi->jenis->alias}}</span></a>
                                @endif
                              @else
                                @if($tes->idstatus == 0)
                                  @if ($d->idjenis == 1)
                                    <a href="{{route('swa.evaluasi.create',$d->id)}}" class="btn btn-outline-primary "><i data-feather="book-open" class="mb-25 font-medium-3"></i> <span class="d-block font-small-3">Lanjutkan {{$d->materi->jenis->alias}}</span></a>
                                  @else
                                    <a href="{{route('swa.evaluasi.create',$d->id)}}" class="btn btn-outline-primary "><i data-feather="user-check" class="mb-25 font-medium-3"></i> <span class="d-block font-small-3">Lanjutkan {{$d->materi->jenis->alias}}</span></a>
                                  @endif
                                @else
                                  Ujian Telah Diterima
                                @endif
                              @endif
                            @else
                              Ujian Telah Berakhir
                            @endif
                          @else
                          Ujian Telah Berakhir 
                          @endif
                        </div>
                      </div>
                    @else
                      <div class="badge badge-light-danger mb-50 mb-lg-0"><i data-feather="settings"></i> Pelaksanaan Belum Diatur</div>
                    @endif
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
                <span class="col px-0"><i data-feather="edit-3" class="text-primary" style="margin-top: -2px"></i> Total Evaluasi</span>
                <div class="avatar bg-primary text-right ml-50" id="filter">
                  <div class="avatar-content">{{count($data)}}</div>
                </div>
              </div>
              <div class="dropdown-divider"></div>
              <div class="d-flex align-items-center my-25">
                <span class="col px-0"><i data-feather="user" class="text-info" style="margin-top: -2px"></i> Belum Diikuti</span>
                <div class="avatar bg-info text-right ml-50" id="filter-not-submit">
                  <div class="avatar-content">0</div>
                </div>
              </div>
              <div class="dropdown-divider"></div>
              <div class="d-flex align-items-center my-25">
                <span class="col px-0"><i data-feather="user-check" class="text-success" style="margin-top: -2px"></i> Sudah Diikuti</span>
                <div class="avatar bg-success text-right ml-50" id="filter-submit">
                  <div class="avatar-content">0</div>
                </div>
              </div>
              <div class="dropdown-divider"></div>
              <div class="d-flex align-items-center my-25">
                <span class="col px-0"><i data-feather="user-x" class="text-danger" style="margin-top: -2px"></i> Terlewati</span>
                <div class="avatar bg-danger text-right ml-50" id="filter-late">
                  <div class="avatar-content">0</div>
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

});
</script>
@stop
