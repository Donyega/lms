@extends('layouts.menu')

@section('title-head', 'Pembelajaran '.$data->mapel->nama)

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">{{$data->mapel->nama}}
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Pembelajaran</a>
              </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="content-body">
    <div class="row">
      <div class="col-lg-8 order-2 order-md-1 order-lg-1">
        <ul class="nav nav-pills">
          <li class="nav-item">
            <a class="nav-link {{Session::get('tabpengajaran') == 1 ? 'active':''}} {{Session::get('tabpengajaran') == null ? 'active':''}}" id="materi-tab" data-toggle="pill" href="#materi" aria-expanded="true">Materi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{Session::get('tabpengajaran') == 2 ? 'active':''}}" id="diskusi-tab" data-toggle="pill" href="#diskusi" aria-expanded="true">Diskusi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{Session::get('tabpengajaran') == 3 ? 'active':''}}" id="penugasan-tab" data-toggle="pill" href="#penugasan" aria-expanded="true">Penugasan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{Session::get('tabpengajaran') == 4 ? 'active':''}}" id="evaluasi-tab" data-toggle="pill" href="#evaluasi" aria-expanded="true">Evaluasi</a>
          </li>
        </ul>
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane {{Session::get('tabpengajaran') == 1 ? 'active':''}} {{Session::get('tabpengajaran') == null ? 'active':''}}" id="materi" aria-labelledby="materi-tab" aria-expanded="true">
            <div class="card mb-75">
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-1 col-md-1 text-center mb-25">
                    <div class="avatar bg-gradient-primary shadow p-25 m-25">
                      <div class="avatar-content">
                        <i data-feather="feather" class="font-medium-3"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-11 col-md-11">
                    <div class="row align-items-center text-center text-md-left text-lg-left">
                      <div class="col-lg-10 col-md-9">
                        <h5 class="font-weight-bolder mb-25">Kontrak Pembelajaran</h5>
                        <p class="card-text mb-25">Rencana Pembelajaran Semester dan Video Perkenalan Guru</p>
                        @if ($dokrps == null)
                          <div class="badge badge-light-danger mb-50 mb-lg-0">RPS Belum Diunggah</div>
                        @endif
                        <?php
                          $videoguru = count($video->where('idguru',auth::user()->link)->where('jenis',3));
                        ?>
                        @if (count($video->where('jenis',3)) == 0)
                          <div class="badge badge-light-danger mb-50 mb-lg-0">Video Belum Diunggah</div>
                        @endif
                      </div>
                      <div class="col-lg-2 col-md-3 text-center text-md-right text-lg-right">
                        @if ($dokrps != null || count($video) > 0)
                          <div class="d-none d-lg-inline">
                            <a href="#kontrak" class="btn btn-icon bg-gradient-primary" role="button" data-toggle="collapse" title="Dokumen RPS dan Video"><i data-feather="file-text"></i></a>
                          </div>
                          <a href="#kontrak" class="btn btn-sm bg-gradient-primary d-lg-none" role="button" data-toggle="collapse" title="Dokumen RPS dan Video"><i data-feather="file-text"></i> Dokumen</a>
                        @endif
                      </div>
                    </div>
                    <div class="collapse" id="kontrak">
                      <hr>
                      <ul class="timeline mt-1">
                        <li class="timeline-item">
                          <span class="timeline-point timeline-point-primary"><i data-feather="file-text"></i></span>
                          <div class="timeline-event">
                            <div class="d-flex justify-content-between flex-sm-row flex-column">
                              <span class="mb-50 mb-lg-25">Rencana Pembelajaran Semester</span>
                            </div>
                            <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                              <div class="media align-items-center">
                                <div class="media-body">
                                  <a href="{{asset('rps/'. $dokrps)}}" class="btn btn-sm btn-outline-info" title="Tampilkan Dokumen RPS" target="_blank"><i data-feather="file-text"></i> Tampilkan Dokumen</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        @if (count($video) > 0)
                          @foreach ($video as $v)
                            <?php
                              $icon = 'video';
                              if ($v->jenis == 1) {
                                $icon = 'file-text';
                              }elseif ($v->jenis == 2) {
                                $icon = 'globe';
                              }
                            ?>
                            <li class="timeline-item">
                              <span class="timeline-point timeline-point-primary"><i data-feather="{{$icon}}"></i></span>
                              <div class="timeline-event">
                                <div class="d-flex justify-content-between flex-sm-row flex-column">
                                  <span class="mb-50 mb-lg-25">
                                    @if ($v->jenis == 3)
                                      Perkenalanan {{$v->pegawai->nama}}
                                    @else
                                      {{$v->nama}}
                                    @endif
                                  </span>
                                </div>
                                <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                  <div class="media align-items-center">
                                    <div class="media-body">
                                      <a href="{{asset($v->file)}}" class="btn btn-sm btn-outline-info" title="{{$v->jenis == 3 ? 'Putar Video' : 'Buka Dokumen'}}" target="_blank"><i data-feather="{{$icon}}"></i> {{$v->jenis == 3 ? 'Putar Video' : 'Buka Dokumen'}}</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </li>
                          @endforeach
                        @endif
                      </ul>
                      <hr class="mb-0">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @if (count($data->materilms->where('publish',1)->where('tglpublish','<=',date('Y-m-d'))) == 0)
              <div class="alert alert-danger mb-0" role="alert">
                <h4 class="alert-heading"><i data-feather="alert-circle" style="margin-top: -2px"></i> INFORMASI</h4>
                <div class="alert-body">
                  Materi Pembalajaran mata Pelajaran {{$data->mapel->nama}} belum diunggah oleh guru pengampu, silakan kembali beberapa saat lagi untuk menampilkan materi pembelajaran.
                </div>
              </div>
            @else
              @foreach ($data->materilms->where('publish',1)->where('tglpublish','<=',date('Y-m-d')) as $rps)
                <div class="card mb-75">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-1 col-md-1 text-center mb-25">
                        <div class="avatar bg-gradient-primary shadow p-25 m-25">
                          <div class="avatar-content">
                            <span class="font-medium-3">{{$rps->pertemuan}}</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-11 col-md-11">
                        <div class="row align-items-center text-center text-md-left text-lg-left">
                          <div class="col-lg-10 col-md-9">
                            <h5 class="font-weight-bolder mb-25">{{$rps->materi}}</h5>
                            <p class="card-text mb-25">{{$rps->capaian}}</p>
                            <span class="d-block font-small-2 text-muted mb-25">{{$rps->user->pegawai->panggilan}} <i data-feather="chevrons-right"></i> {{ (new \App\Helper)->tanggal($rps->updated_at) }}</span>
                            @if ($rps->idjenis != 1)
                              @if ($rps->idjenis != null || $rps->idjenis <= 4)
                                <div class="badge badge-light-danger mb-50 mb-lg-0">{{$rps->jenis->alias}}</div>
                              @endif
                            @endif
                            @if (count($rps->detil) > 0)
                              <div class="badge badge-light-primary mb-50 mb-lg-0">{{count($rps->detil)}} Dokumen</div>
                            @endif
                          </div>
                          <div class="col-lg-2 col-md-3 text-center text-md-right text-lg-right">
                            @if (count($rps->detil) > 0)
                              <div class="d-none d-lg-inline">
                                <a href="#materi-{{$rps->id}}" class="btn btn-icon bg-gradient-primary" role="button" data-toggle="collapse" title="Dokumen Materi"><i data-feather="file-text"></i></a>
                              </div>
                              <a href="#materi-{{$rps->id}}" class="btn btn-sm bg-gradient-primary d-lg-none" role="button" data-toggle="collapse" title="Dokumen Materi"><i data-feather="file-text"></i> Dokumen</a>
                            @endif
                          </div>
                        </div>
                        <div class="collapse" id="materi-{{$rps->id}}">
                          <hr>
                          <ul class="timeline mt-1">
                            @foreach ($rps->detil as $d)
                              <li class="timeline-item">
                                <span class="timeline-point timeline-point-primary"><i data-feather="{{$d->idjenis == 1 ? 'file-text':'globe'}}"></i></span>
                                <div class="timeline-event">
                                  <div class="d-flex justify-content-between flex-sm-row flex-column">
                                    <span class="mb-25">{{$d->nama}}</span>
                                  </div>
                                  <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                    <div class="media align-items-center">
                                      <div class="media-body">
                                        <a href="{{$d->idjenis == 1 ? asset($d->dokumen) : $d->dokumen}}" class="btn btn-sm btn-outline-info" title="Tampilkan Dokumen" target="_blank"><i data-feather="{{$d->idjenis == 1 ? 'file-text':'globe'}}"></i> Tampilkan Dokumen</a>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </li>
                            @endforeach
                          </ul>
                          <hr class="mb-0">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            @endif
          </div>
          <div role="tabpanel" class="tab-pane {{Session::get('tabpengajaran') == 2 ? 'active':''}}" id="diskusi" aria-labelledby="diskusi-tab" aria-expanded="true">
            @if (count($data->topiklms) == 0)
              <div class="alert alert-danger mb-0" role="alert">
                <h4 class="alert-heading"><i data-feather="alert-circle" style="margin-top: -2px"></i> INFORMASI</h4>
                <div class="alert-body">
                  Guru pengampu belum menambahkan diskusi pada mata pelajaran {{$data->mapel->nama}}. Silakan kembali beberapa saat lagi untuk menampilkan diskusi.
                </div>
              </div>
            @else
              @php $no = 1; @endphp
              @foreach ($data->topiklms as $topik)
                <div class="card mb-75">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-1 col-md-1 text-center mb-25">
                        <div class="avatar bg-gradient-primary shadow p-25 m-25">
                          <div class="avatar-content">
                            <span class="font-medium-3">{{$no}}</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-11 col-md-11">
                        <div class="row align-items-center text-center text-md-left text-lg-left">
                          <div class="col-lg-10 col-md-9">
                            <h5 class="font-weight-bolder mb-25">{{$topik->judul}}</h5>
                            <div class="mb-25">
                              <span class="font-small-3">Pastisipasi Anda</span>
                              <div class="badge badge-light-primary">
                                <i data-feather="message-square"></i> 0 Percakapan
                              </div>
                            </div>
                            <span class="d-block font-small-2 text-muted mb-25">{{$topik->user->pegawai->panggilan}} <i data-feather="chevrons-right"></i> {{ (new \App\Helper)->tanggal($topik->updated_at) }}</span>
                          </div>
                          <div class="col-lg-2 col-md-3 text-center text-md-right text-lg-right">
                            <a class="btn btn-icon bg-gradient-primary" href="{{route('pembelajaran.diskusi',[Session::get('idjadwalglobal'),$topik->id])}}" title="Buka Percakapan"><i data-feather="twitch"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @php $no ++; @endphp
              @endforeach
            @endif
          </div>
          <div role="tabpanel" class="tab-pane {{Session::get('tabpengajaran') == 3 ? 'active':''}}" id="penugasan" aria-labelledby="penugasan-tab" aria-expanded="true">
            @if (count($data->penugasanlms) == 0)
              <div class="alert alert-danger mb-0" role="alert">
                <h4 class="alert-heading"><i data-feather="alert-circle" style="margin-top: -2px"></i> INFORMASI</h4>
                <div class="alert-body">
                  Guru pengampu belum menambahkan penugasan pada mata pelajaran {{$data->mapel->nama}}. Silakan kembali beberapa saat lagi untuk menampilkan daftar penugasan.
                </div>
              </div>
            @else
              <?php $no = 1; ?>
              @foreach ($data->penugasanlms as $tugas)
                <div class="card mb-75">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-1 col-md-1 text-center mb-25">
                        <div class="avatar bg-gradient-primary shadow p-25 m-25">
                          <div class="avatar-content">
                            <span class="font-medium-3">{{$no}}</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-11 col-md-11">
                        <div class="row align-items-center text-center text-md-left text-lg-left">
                          <div class="col-lg-10 col-md-9">
                            <h5 class="font-weight-bolder mb-25">{{$tugas->judul}}</h5>
                            <span class="d-block font-small-3 text-muted mb-50">{{$tugas->user->pegawai->nama}}</span>
                            @if($tugas->idjenis == 1)
                              <div class="badge badge-light-info mb-50"><i data-feather="user"></i> Individu</div>
                            @else
                              <div class="badge badge-light-info mb-50"><i data-feather="users"></i> Kelompok</div>
                            @endif
                            <p class="card-text mb-25">{{$tugas->keterangan}}</p>
                            <span class="d-block font-small-3 mb-25">Batas Pengumpulan : <b>{{ (new \App\Helper)->tanggal($tugas->batastgl) }}</b> | Jam : <b>{{date('H:i', strtotime($tugas->batasjam))}}</b> WITA</span>
                            @if ($tugas->dokumen != null)
                              <a href="{{asset($tugas->dokumen)}}" class="btn btn-sm btn-outline-info" title="Tampilkan Dokumen" target="_blank"><i data-feather="file-text"></i> Dokumen Pendukung</a>
                            @endif
                          </div>
                          <div class="col-lg-2 col-md-3 text-center text-md-right text-lg-right">
                            <div class="d-none d-lg-inline">
                              <a class="btn btn-icon bg-gradient-primary" href="{{route('swa.penugasan.detil',$tugas->id)}}" title="Detail Pengumpulan Tugas"><i data-feather="edit-3"></i></a>
                            </div>
                            <div class="d-inline d-lg-none">
                              <a class="btn btn-sm bg-gradient-primary" href="{{route('swa.penugasan.detil',$tugas->id)}}" title="Detail Pengumpulan Tugas"><i data-feather="edit-3"></i> Pengumpulan</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php $no++ ?>
              @endforeach
            @endif
          </div>
          <div role="tabpanel" class="tab-pane {{Session::get('tabpengajaran') == 4 ? 'active':''}}" id="evaluasi" aria-labelledby="evaluasi-tab" aria-expanded="true">
            @if (count($materi->where('idjenis','!=',1)) == 0)
              <div class="alert alert-danger mb-0" role="alert">
                <h4 class="alert-heading"><i data-feather="alert-circle" style="margin-top: -2px"></i> INFORMASI</h4>
                <div class="alert-body">
                  Guru pengampu belum menambahkan evaluasi pada mata kuliah {{$data->mapel->nama}}. Silakan kembali beberapa saat lagi untuk menampilkan evaluasi.
                </div>
              </div>
            @else
              @foreach ($materi->where('idjenis','!=',1) as $urut_tes => $tes)
                <div class="card mb-75">
                  <div class="card-body">
                    <div class="row text-center text-md-left text-lg-left">
                      <div class="col-12">
                        <h5 class="font-weight-bolder mb-25">
                          <div class="badge badge-light-primary">{{$tes->jenis->alias}}</div>
                          {{$tes->materi}}
                        </h5>
                        @if($tes->evaluasi != null)
                          <div class="row my-50 mr-0">
                            <div class="ml-1 border-left-primary border-left-3 d-none d-md-inline"></div>
                            <div class="col-lg-8">
                              <span class="d-block mb-25 font-small-3">
                                <i data-feather="calendar" style="margin-top:-2px"></i> {{(new \App\Helper)->tanggal($tes->evaluasi->tgl)}}
                              </span>
                              <span class="d-block mb-25 font-small-3">
                                <i data-feather="clock" style="margin-top:-2px"></i> {{date('H:i',strtotime($tes->evaluasi->mulai))}} s/d {{date('H:i',strtotime($tes->evaluasi->berakhir))}} WITA
                              </span>
                              <?php 
                                    $nis = App\Models\Siswa::where('id', Auth::user()->link)->first();
                                    $evaluasi = App\Models\LmsSiswaEvaluasi::where('idevaluasi',$tes->evaluasi->id)->where('nis', $nis->nis)->first(); 
                              ?>
                              @if($evaluasi == null)
                                <div class="badge badge-light-danger mb-50 mb-lg-0"><i data-feather="x"></i> Belum Diikuti</div>
                              @else
                                @if($evaluasi->idstatus == 1)
                                  <div class="badge badge-light-success mb-50 mb-lg-0"><i data-feather="check"></i> Sudah Diikuti</div>
                                @else
                                  <div class="badge badge-light-secondary mb-50 mb-lg-0"><i data-feather="loader"></i> Proses</div>
                                @endif
                              @endif
                              <footer class="blockquote-footer mb-25">
                                {{$tes->evaluasi->user->pegawai->panggilan}}
                              </footer>
                            </div>
                            <div class="col text-center text-lg-right">
                              @if($tes->evaluasi->tgl == date('Y-m-d'))
                                @if($tes->evaluasi->mulai <= date('H:m:s') && $tes->evaluasi->berakhir >= date('H:m:s'))
                                  @if($evaluasi == null)
                                    @if ($tes->evaluasi->idjenis == 1)
                                      {{-- <a href="#pilih_essay_{{ $urut_tes }}" data-toggle="modal" class="btn btn-outline-primary "><i data-feather="book-open" class="mb-25 font-medium-3"></i> <span class="d-block font-small-3">Mulai {{$tes->jenis->alias}}</span></a> --}}
                                      <a href="{{route('swa.evaluasi.create',$tes->evaluasi->id)}}" class="btn btn-outline-primary "><i data-feather="book-open" class="mb-25 font-medium-3"></i> <span class="d-block font-small-3">Mulai {{$tes->jenis->alias}}</span></a>
                                    @else
                                      <a href="{{route('swa.evaluasi.create',$tes->evaluasi->id)}}" class="btn btn-outline-primary "><i data-feather="user-check" class="mb-25 font-medium-3"></i> <span class="d-block font-small-3">Mulai {{$tes->jenis->alias}}</span></a>
                                    @endif
                                  @else
                                    @if($evaluasi->idstatus == 0)
                                      @if ($tes->evaluasi->idjenis == 1)
                                        {{-- <a href="#pilih_essay_{{ $urut_tes }}" data-toggle="modal" class="btn btn-outline-primary "><i data-feather="book-open" class="mb-25 font-medium-3"></i> <span class="d-block font-small-3">Lanjutkan {{$tes->jenis->alias}}</span></a> --}}
                                        <a href="{{route('swa.evaluasi.create',$tes->evaluasi->id)}}" class="btn btn-outline-primary "><i data-feather="book-open" class="mb-25 font-medium-3"></i> <span class="d-block font-small-3">Lanjutkan {{$tes->jenis->alias}}</span></a>
                                      @else
                                        <a href="{{route('swa.evaluasi.create',$tes->evaluasi->id)}}" class="btn btn-outline-primary "><i data-feather="user-check" class="mb-25 font-medium-3"></i> <span class="d-block font-small-3">Lanjutkan {{$tes->jenis->alias}}</span></a>
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
            @endif
          </div>
        </div>
      </div>
      <div class="col-lg-4 order-1 order-md-2 order-lg-2">
        <div class="blog-list-wrapper">
          <div class="card">
            <img class="card-img-top img-fluid" width="100%" src="{{asset('images/lms-bg-'.$img.'.jpg')}}">
            <div class="card-body">
              <div class="img-badge float-right">Kelas <b>{{$data->kelas->nama}}</b></div>
              <h5 class="media mb-25">
                <span class="blog-title-truncate text-body-heading"><b>{{$data->mapel->nama}}</b></span>
              </h5>
              <div class="media mb-25">
                <div class="media-body row m-0">
                  <div class="px-50 border-left-primary">
                    <small>{{$data->mapel->nama}} {{$data->kelas->nama}}</small>
                  </div>
                </div>
              </div>
              {{-- <div class="alert alert-dark mt-75 mb-0" role="alert">
                <div class="alert-body">
                  <div class="row m-0 justify-content-between align-items-center">
                    @if ($data->hari2 == null)
                      <span class="font-small-3">{{$data->hari}}, {{$data->jam}}</span>
                    @else
                      <ul class="font-small-3 pl-1 mb-0">
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
                    <div class="badge bg-gradient-info"><i data-feather="users" style="top: 0"></i> {{count($sws)}}</div>
                  </div>
                </div>
              </div> --}}
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header border-bottom pb-75">
            <h5 class="mb-0">Guru Pengampu</h5>
          </div>
          <div class="card-body pt-25">
            @foreach ($data->guru as $dd)
              <div class="row mx-0 my-50 align-items-center">
                <div class="avatar-lecture">
                  <img src="{{asset($dd->guru->detil->photo)}}" width="30px">
                </div>
                <div class="col pl-50 pr-0">
                  <span class="font-small-3">{{$dd->guru->nama}}</span>
                </div>
              </div>
            @endforeach
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
