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
          <li class="nav-item">
            {{-- <a class="nav-link" id="siswa-tab" data-toggle="pill" href="#siswa" aria-expanded="true">Siswa</a> --}}
            <a class="nav-link" href="{{route('pembelajaran.presensi',Session::get('idjadwalglobal'))}}" aria-expanded="true">Laporan</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{route('pembelajaran.penilaian',Session::get('idjadwalglobal'))}}" aria-expanded="true">Nilai</a>
          </li>
        </ul>
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane {{Session::get('tabpengajaran') == 1 ? 'active':''}} {{Session::get('tabpengajaran') == null ? 'active':''}}" id="materi" aria-labelledby="materi-tab" aria-expanded="true">
            <div class="card mb-75">
              <div class="card-body">
                <div class="text-center">
                  <button class="btn btn-sm btn-outline-danger my-25" id="btntambahmateri" data-toggle="modal" data-target="#modal-materi"><i data-feather="plus"></i> Tambah Materi Pembelajaran</button>
                  <button class="btn btn-sm btn-outline-success my-25" data-toggle="modal" data-target="#modal-rps"><i data-feather="upload"></i> Unggah Materi</button>
                  @if (count($jadwalsalin) > 0)
                    <button class="btn btn-sm btn-outline-warning my-25" id="btnsalinmateri" data-toggle="modal" data-target="#modal-salinmateri"><i data-feather="copy"></i> Salin Materi</button>
                  @endif
                  {{-- <a href="{{route('pembelajaran.presensi',Session::get('idjadwalglobal'))}}" target="_blank" class="btn btn-sm btn-outline-primary my-25"><i data-feather="user-check"></i> Absensi</a> --}}
                </div>
              </div>
            </div>
            <div class="card mb-75">
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-1 col-md-1 text-center mb-25">
                    <div class="avatar bg-gradient-success shadow p-25 m-25">
                      <div class="avatar-content">
                        <i data-feather="feather" class="font-medium-3"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-11 col-md-11">
                    <div class="row align-items-center text-center text-md-left text-lg-left">
                      <div class="col-lg-9 col-md-7">
                        <h5 class="font-weight-bolder mb-25">Kontrak Pembelajaran</h5>
                        <p class="card-text mb-25">Rencana Pembelajaran Semester dan Video Perkenalan Guru</p>
                        @if ($dokrps == null)
                          <div class="badge badge-light-danger mb-50 mb-lg-0">RPS Belum Diunggah</div>
                        @endif
                        <?php
                          $videoguru = count($video->where('idguru',auth::user()->link)->where('jenis',3));
                        ?>
                        @if (count($video) == 0 || $videoguru == 0)
                          <div class="badge badge-light-danger mb-50 mb-lg-0">Video Belum Diunggah</div>
                        @endif
                      </div>
                      <div class="col-lg-3 col-md-5 text-center text-md-right text-lg-right">
                        @if (count($video) == 0 || $videoguru == 0)
                          <button class="btn btn-icon bg-gradient-success btnvideo" data-toggle="modal" data-target="#modal-video" title="Unggah Video Perkenalan"><i data-feather="upload"></i> <i data-feather="video"></i></button>
                        @endif
                        @if ($dokrps != null || count($video) > 0)
                          <a href="#kontrak" class="btn btn-icon bg-gradient-success" role="button" data-toggle="collapse" title="Dokumen RPS dan Video"><i data-feather="file-text"></i></a>
                        @endif
                      </div>
                    </div>
                    <div class="collapse" id="kontrak">
                      <hr>
                      <ul class="timeline mt-1">
                        @if ($dokrps != null)
                          <li class="timeline-item">
                            <span class="timeline-point timeline-point-primary"><i data-feather="file-text"></i></span>
                            <div class="timeline-event">
                              <div class="d-flex justify-content-between flex-sm-row flex-column">
                                <span class="mb-50 mb-lg-25">Rencana Pembelajaran Semester</span>
                              </div>
                              <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                <div class="media align-items-center">
                                  <div class="media-body">
                                    <a href="{{'http://siakad.slua.sch.id/'.$dokrps}}" class="btn btn-sm btn-icon btn-outline-info" title="Tampilkan Dokumen RPS" target="_blank"><i data-feather="file-text"></i></a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </li>
                        @endif
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
                                  <span class="timeline-event-time mb-50 mb-lg-25">
                                    @if ($v->jenis != 3)
                                      {{$v->pegawai->panggilan}}
                                    @endif
                                    <i data-feather="chevrons-right"></i> {{ (new \App\Helper)->tanggal($v->updated_at) }}
                                  </span>
                                </div>
                                <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                  <div class="media align-items-center">
                                    <div class="media-body">
                                      <a href="{{asset($v->file)}}" class="btn btn-sm btn-icon btn-outline-info" title="{{$v->jenis == 3 ? 'Putar Video' : 'Buka Dokumen'}}" target="_blank"><i data-feather="{{$icon}}"></i></a>
                                      @if ($v->idguru == auth::user()->link)
                                        @if ($v->jenis == 3)
                                          <button class="btn btn-sm btn-icon btn-outline-warning btnubahvideo"  data-toggle="modal" data-target="#modal-video" value="{{$v->id}}" title="Ubah Video"><i data-feather="edit"></i></button>
                                        @else
                                          <button class="btn btn-sm btn-icon btn-outline-warning btnubahkontrak" value="{{$v->id}}" data-dokumen="{{$v->nama}}" title="Ubah Dokumen"><i data-feather="edit"></i></button>
                                        @endif
                                        <form class="d-inline" method="post" action="{{route('pembelajaran.deletevideo')}}" onsubmit="return confirm('Lanjutkan proses hapus {{$v->jenis == 3 ? 'video perkenalan' : 'dokumen'}}?')">
                                          <input type="hidden" name="idvideo" value="{{$v->id}}">
                                          <button class="btn btn-sm btn-icon btn-outline-danger" title="{{$v->jenis == 3 ? 'Hapus Video' : 'Hapus Dokumen'}}"><i data-feather="trash-2"></i></button>
                                          {{ csrf_field() }}
                                        </form>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </li>
                          @endforeach
                        @endif
                        <li class="timeline-item">
                          <span class="timeline-point timeline-point-danger"><i data-feather="plus"></i></span>
                          <div class="timeline-event">
                            @if ($videoguru == 0)
                              <button class="btn badge badge-light-danger btnvideo" data-toggle="modal" data-target="#modal-video">Unggah Video</button>
                            @endif
                            <button class="btn badge badge-light-danger btntambahkontrak">Tambah Dokumen</button>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @if (count($data->materilms) == 0)
              <div class="alert alert-danger mb-0" role="alert">
                <h4 class="alert-heading"><i data-feather="alert-circle" style="margin-top: -2px"></i> PERHATIAN</h4>
                <div class="alert-body">
                  Anda belum @if (count($video) == 0) mengunggah <b>Video Perkenalan</b> dan @endif melengkapi <b>Materi Pembelajaran</b>.
                </div>
              </div>
            @else
              @foreach ($data->materilms as $rps)
                <div class="card mb-75">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-1 col-md-1 text-center mb-25">
                        <div class="avatar bg-{{$rps->publish == 0 ? 'light-secondary' : 'gradient-primary'}} shadow p-25 m-25">
                          <div class="avatar-content">
                            <span class="font-medium-3">{{$rps->pertemuan}}</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-11 col-md-11">
                        <div class="row align-items-center text-center text-md-left text-lg-left">
                          <div class="col-lg-9 col-md-7">
                            @if ($rps->publish == 0)
                              <button class="btn badge badge-light-secondary mb-25 btnpublish" value="{{$rps->id}}" data-toggle="modal" data-target="#modal-publish" title="Ubah Status Publish"><i data-feather="volume-x"></i> DRAFT</button>
                            @else
                              <button class="btn badge badge-light-primary mb-25 btnpublish" value="{{$rps->id}}" data-toggle="modal" data-target="#modal-publish" title="Ubah Status Draft"><i data-feather="volume-2"></i> PUBLISH</button>
                              <div class="badge badge-light-primary mb-25">{{ (new \App\Helper)->tanggal($rps->tglpublish) }}</div>
                            @endif
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
                          <div class="col-lg-3 col-md-5 text-center text-md-right text-lg-right">
                            <form class="d-inline" method="post" action="{{route('pembelajaran.deletemateri')}}" onsubmit="return confirm('Lanjutkan proses hapus materi {{$rps->materi}}? Semua dokumen {{$rps->idjenis != 1 ? 'dan pengaturan evaluasi' : ''}} pada materi ini juga akan dihapus.')">
                              <input type="hidden" name="idjadwal" value="{{$data->id}}">
                              <input type="hidden" name="idmateri" value="{{$rps->id}}">
                              <button class="btn btn-icon btn-gradient-danger" title="Hapus Materi"><i data-feather="trash-2"></i></button>
                              {{ csrf_field() }}
                            </form>
                            <button class="btn btn-icon bg-gradient-warning btnubahmateri" title="Ubah" value="{{$rps->id}}"><i data-feather="edit"></i></button>
                            <a href="#materi-{{$rps->id}}" class="btn btn-icon bg-gradient-success" role="button" data-toggle="collapse" title="Dokumen Materi"><i data-feather="file-text"></i></a>
                          </div>
                        </div>
                        <div class="collapse" id="materi-{{$rps->id}}">
                          @if (count($rps->detil) == 0)
                            <div class="alert alert-info mb-0 mt-1" role="alert">
                              <div class="alert-heading d-flex justify-content-between align-items-center">
                                <div><i data-feather="file-text" style="margin-top: -2px"></i> DOKUMEN MATERI</div>
                                <button class="btn btn-sm btn-flat-primary btntambahdokumen" data-toggle="modal" data-target="#modal-dokumen" data-idmateri="{{$rps->id}}" data-materi="{{$rps->materi}}" title="Tambah Dokumen"><i data-feather="plus"></i></button>
                              </div>
                              <div class="alert-body">
                                Materi <b>{{$rps->materi}}</b> belum memiliki dokumen pendukung. Anda dapat menambahkan dokumen dengan menekan tombol Plus ( <i data-feather="plus"></i> ).
                              </div>
                            </div>
                          @else
                            <hr>
                            <ul class="timeline mt-1">
                              @foreach ($rps->detil as $d)
                                <li class="timeline-item">
                                  <span class="timeline-point timeline-point-primary"><i data-feather="{{$d->idjenis == 1 ? 'file-text':'globe'}}"></i></span>
                                  <div class="timeline-event">
                                    <div class="d-flex justify-content-between flex-sm-row flex-column">
                                      <span class="mb-25">{{$d->nama}}</span>
                                      <span class="timeline-event-time mb-50 mb-lg-25">{{$d->user->pegawai->panggilan}} <i data-feather="chevrons-right"></i> {{ (new \App\Helper)->tanggal($d->updated_at) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                      <div class="media align-items-center">
                                        <div class="media-body">
                                          <a href="{{$d->idjenis == 1 ? asset($d->dokumen):$d->dokumen}}" class="btn btn-sm btn-icon btn-outline-info" title="Tampilkan Dokumen" target="_blank"><i data-feather="{{$d->idjenis == 1 ? 'file-text':'globe'}}"></i></a>
                                          <button class="btn btn-sm btn-icon btn-outline-warning btnubahdokumen" value="{{$d->id}}" data-idmateri="{{$rps->id}}" data-materi="{{$rps->materi}}" title="Ubah Dokumen"><i data-feather="edit"></i></button>
                                          <form class="d-inline" method="post" action="{{route('pembelajaran.deletedokumen')}}" onsubmit="return confirm('Lanjutkan proses hapus dokumen {{$d->nama}} pada materi {{$rps->materi}}?')">
                                            <input type="hidden" name="iddokumen" value="{{$d->id}}">
                                            <button class="btn btn-sm btn-icon btn-outline-danger" title="Hapus Dokumen"><i data-feather="trash-2"></i></button>
                                            {{ csrf_field() }}
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </li>
                              @endforeach
                              <li class="timeline-item">
                                <span class="timeline-point timeline-point-danger"><i data-feather="plus"></i></span>
                                <div class="timeline-event">
                                  <button class="btn badge badge-light-danger btntambahdokumen" data-toggle="modal" data-target="#modal-dokumen" data-idmateri="{{$rps->id}}" data-materi="{{$rps->materi}}">Tambah Dokumen</button>
                                </div>
                              </li>
                            </ul>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            @endif
          </div>
          <div role="tabpanel" class="tab-pane {{Session::get('tabpengajaran') == 2 ? 'active':''}}" id="diskusi" aria-labelledby="diskusi-tab" aria-expanded="true">
            <div class="card mb-75">
              <div class="card-body">
                <div class="text-center">
                  <button class="btn btn-sm btn-outline-danger my-25" id="btntambahtopik" data-toggle="modal" data-target="#modal-topik"><i data-feather="plus"></i> Tambah Topik Diskusi</button>
                </div>
              </div>
            </div>
            @if (count($data->topiklms) == 0)
              <div class="alert alert-danger mb-0" role="alert">
                <h4 class="alert-heading"><i data-feather="alert-circle" style="margin-top: -2px"></i> PERHATIAN</h4>
                <div class="alert-body">
                  Anda belum membuat topik diskusi
                </div>
              </div>
            @else
              @php $no = 1; @endphp
              @foreach ($data->topiklms as $topik)
                <div class="card mb-75">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-1 col-md-1 text-center mb-25">
                        <div class="avatar bg-gradient-success shadow p-25 m-25">
                          <div class="avatar-content">
                            <span class="font-medium-3">{{$no}}</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-11 col-md-11">
                        <div class="row align-items-center text-center text-md-left text-lg-left">
                          <div class="col-lg-9 col-md-7">
                            <h5 class="font-weight-bolder mb-25">{{$topik->judul}}</h5>
                            <div class="mb-25">
                              <span class="font-small-3">Pastisipasi Siswa</span>
                              <div class="badge badge-light-primary">
                                <i data-feather="users"></i> 0
                              </div>
                            </div>
                            <span class="d-block font-small-2 text-muted mb-25">{{$topik->user->pegawai->panggilan}} <i data-feather="chevrons-right"></i> {{ (new \App\Helper)->tanggal($topik->updated_at) }}</span>
                          </div>
                          <div class="col-lg-3 col-md-5 text-center text-md-right text-lg-right">
                            <a class="btn btn-icon bg-gradient-info" href="{{route('pembelajaran.diskusi',[Session::get('idjadwalglobal'),$topik->id])}}"><i data-feather="info"></i></a>
                            <button class="btn btn-icon bg-gradient-warning btnubahtopik" value="{{$topik->id}}"><i data-feather="edit"></i></button>
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
            <div class="card mb-75">
              <div class="card-body">
                <div class="text-center">
                  <button class="btn btn-sm btn-outline-danger my-25" id="btntambahtugas" data-toggle="modal" data-target="#modal-tugas"><i data-feather="plus"></i> Tambah Penugasan</button>
                </div>
              </div>
            </div>
            @if (count($data->penugasanlms) == 0)
              <div class="alert alert-danger mb-0" role="alert">
                <h4 class="alert-heading"><i data-feather="alert-circle" style="margin-top: -2px"></i> PERHATIAN</h4>
                <div class="alert-body">
                  Anda belum membuat penugasan.
                </div>
              </div>
            @else
              <?php $no = 1; ?>
              @foreach ($data->penugasanlms as $tugas)
                <div class="card mb-75">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-1 col-md-1 text-center mb-25">
                        <div class="avatar bg-gradient-success shadow p-25 m-25">
                          <div class="avatar-content">
                            <span class="font-medium-3">{{$no}}</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-11 col-md-11">
                        <div class="row align-items-center text-center text-md-left text-lg-left">
                          <div class="col-lg-9 col-md-7">
                            <h5 class="font-weight-bolder mb-25">{{$tugas->judul}}</h5>
                            <p class="card-text mb-25">{{$tugas->keterangan}}</p>
                            <span class="d-block font-small-2 text-muted mb-25">Batas Pengumpulan : {{ (new \App\Helper)->tanggal($tugas->batastgl) }} Jam : {{$tugas->batasjam}}</span>
                            <span class="d-block">
                              <div class="badge badge-light-info mb-25">{{$tugas->idmetode == 1 ? 'Submit Dokumen':'Oral Presntation'}}</div>
                              <div class="badge badge-light-primary mb-25"><i data-feather="{{$tugas->idjenis == 1 ? 'user':'users'}}"></i> Tugas {{$tugas->idjenis == 1 ? 'Individu':'Kelompok'}}</div>
                              <div class="badge badge-light-success mb-25"><i data-feather="user-check"></i> {{count($tugas->kumpul)}} Pengumpulan</div>
                            </span>
                            
                            @if(count($tugas->rubrik) > 0)
                              <span class="d-block mb-25">
                                <div class="badge badge-light-warning mb-25">Dengan Rubrik Penilaian</div>
                                @if($tugas->rubrik->sum('bobot') < 100)
                                  <div class="badge badge-light-danger mb-25">Bobot Penilaian < 100 %</div>
                                @endif
                              </span>
                            @endif

                            @if ($tugas->dokumen != null)
                              <div class="mb-50 mb-lg-0">
                                <a href="{{asset($tugas->dokumen)}}" class="btn btn-sm btn-outline-info" title="Tampilkan Dokumen" target="_blank"><i data-feather="file-text"></i> Dokumen Pendukung</a>
                              </div>
                            @endif
                          </div>
                          <div class="col-lg-3 col-md-5 text-center text-md-right text-lg-right">
                            <a href="{{route('pembelajaran.penugasan.detail',[Session::get('idjadwalglobal'),$tugas->id])}}" class="btn btn-icon bg-gradient-success" title="Halaman Pengumpulan Tugas"><i data-feather="users"></i></a>
                            <button class="btn btn-icon bg-gradient-warning btnubahtugas" title="Ubah" value="{{$tugas->id}}"><i data-feather="edit"></i></button>
                            <a href="#rubrik-{{$tugas->id}}" class="btn btn-icon bg-gradient-success" role="button" data-toggle="collapse" title="Rubrik Penilaian"><i data-feather="server"></i></a>
                          </div>
                        </div>
                        <div class="collapse" id="rubrik-{{$tugas->id}}">
                          @if (count($tugas->rubrik) == 0)
                            <div class="alert alert-info mb-0 mt-1" role="alert">
                              <div class="alert-heading d-flex justify-content-between align-items-center">
                                <div><i data-feather="file-text" style="margin-top: -2px"></i> RUBRIK PENILAIAN</div>
                                <button class="btn btn-sm btn-flat-primary btntambahrubrik" data-toggle="modal" data-target="#modal-rubrik" data-idtugas="{{$tugas->id}}" title="Tambah Rubrik Penilaian"><i data-feather="plus"></i></button>
                              </div>
                              <div class="alert-body">
                                Penugasan <b>{{$tugas->judul}}</b> belum memiliki rubrik penilaian. Anda dapat menambahkan rubrik penilaian dengan menekan tombol Plus ( <i data-feather="plus"></i> ).
                              </div>
                            </div>
                          @else
                            @if($tugas->rubrik->sum('bobot') < 100)
                              <hr>
                              <div class="text-right">
                                <button class="btn badge badge-light-danger btntambahrubrik" data-toggle="modal" data-target="#modal-rubrik" data-idtugas="{{$tugas->id}}"><i data-feather="plus"></i> Tambah Komponen</button>
                              </div>
                            @endif
                            @foreach ($tugas->rubrik as $rubrik)
                              <hr class="my-50">
                              <div class="d-flex justify-content-between">
                                <div class="col row align-items-center">
                                  <span class="col-lg-8 px-0">{{$rubrik->nama}}</span>
                                  <div class="badge badge-light-warning">{{$rubrik->bobot}} %</div>
                                </div>
                                <form class="d-inline" onsubmit="return confirm('Lanjutkan proses hapus komponen penilaian {{$rubrik->nama}} ?')" action="{{route('pembelajaran.penugasan.rubrik.delete')}}" method="post">
                                  <button class="btn btn-sm btn-icon btn-outline-danger" name="id" value="{{$rubrik->id}}" title="Hapus Komponen"><i data-feather="trash-2"></i></button>
                                  @csrf
                                </form>
                              </div>
                            @endforeach
                            <hr class="mt-50 my-0">
                          @endif
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
                <h4 class="alert-heading"><i data-feather="info" style="margin-top: -2px"></i> INFORMASI</h4>
                <div class="alert-body">
                  Anda belum menambahkan pertemuan atau materi pembelajaran berjenis evaluasi (Quiz, UTS, atau UAS). Silakan menambahkan pertemuan berjenis evaluasi untuk dapat melakukan pengaturan evaluasi.
                </div>
              </div>
            @else
              @foreach ($materi->where('idjenis','!=',1) as $tes)
                <div class="card mb-75">
                  <div class="card-body">
                    <div class="row align-items-center text-center text-md-left text-lg-left">
                      <div class="col-lg-9 col-md-7">
                        <h5 class="font-weight-bolder mb-25">
                          <div class="badge badge-light-primary">{{$tes->jenis->alias}}</div>
                          {{$tes->materi}}
                        </h5>
                        @if($tes->evaluasi != null)
                          <div class="row my-50">
                            <div class="ml-1 border-left-primary border-left-3 d-none d-md-inline"></div>
                            <div class="col">
                              <span class="d-block mb-25 font-small-3">
                                @if($tes->evaluasi->idjenis == 1)
                                  <i data-feather="edit-3" style="margin-top:-2px"></i>
                                @else
                                  <i data-feather="check-square" style="margin-top:-2px"></i>
                                @endif
                                {{$tes->evaluasi->jenis->nama}}
                              </span>
                              <span class="d-block mb-25 font-small-3">
                                <i data-feather="calendar" style="margin-top:-2px"></i> {{(new \App\Helper)->tanggal($tes->evaluasi->tgl)}}, {{date('H:i',strtotime($tes->evaluasi->mulai))}} s/d {{date('H:i',strtotime($tes->evaluasi->berakhir))}} WITA
                              </span>
                              @if(count($soal) == 0)
                                <div class="badge badge-light-danger mb-50 mb-lg-0"><i data-feather="file-text"></i> Soal Belum Diunggah</div>
                              @else
                              @if ($tes->evaluasi->jmlsoal != null && count($soal) >= $tes->evaluasi->jmlsoal)
                                <div class="badge badge-light-success mb-50 mb-lg-0"><i data-feather="file-text"></i> Ditampilkan {{$tes->evaluasi->jmlsoal}}</div>
                              @endif
                              @endif
                              <footer class="blockquote-footer mb-25">
                                {{$tes->evaluasi->user->pegawai->panggilan}}
                              </footer>
                            </div>
                          </div>
                        @else
                          <div class="badge badge-light-danger mb-50 mb-lg-0"><i data-feather="settings"></i> Pelaksanaan Belum Diatur</div>
                        @endif
                      </div>
                      <div class="col-lg-3 col-md-5 text-center text-md-right text-lg-right">
                        <button class="btn btn-icon bg-gradient-info btnubahevaluasi" title="Pengaturan Evaluasi" value="{{$tes->id}}" data-materi="{{$tes->materi}}" data-toggle="modal" data-target="#modal-evaluasi"><i data-feather="settings"></i></button>
                        @if($tes->evaluasi != null)
                          <a href="{{route('pembelajaran.evaluasi',[Session::get('idjadwalglobal'),$tes->id,$tes->evaluasi->id])}}" class="btn btn-icon bg-gradient-success" title="Halaman Pengaturan Soal" value="{{$tes->id}}"><i data-feather="file-text"></i></a>
                          <a href="{{route('pembelajaran.evaluasi.peserta',[$data->id,$tes->id,$tes->evaluasi->id,$img])}}" class="btn btn-icon bg-gradient-success" title="Pelaksanaan Evaluasi" value="{{$tes->id}}"><i data-feather="user-check"></i></a>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            @endif
          </div>
          <div role="tabpanel" class="tab-pane" id="siswa" aria-labelledby="siswa-tab" aria-expanded="true">
            <div class="card">
              <div class="card-body">
                <div class="card card-congratulations mb-50">
                  <div class="card-body text-center">
                    <img src="{{asset('images/img-frame.png')}}" class="congratulations-img-left">
                    <div class="avatar avatar-lg bg-light-info shadow mb-50">
                      <div class="avatar-content"><i data-feather="users"></i></div>
                    </div>
                    <h5 class="text-light mb-0">{{$data->mapel->nama}} {{$data->kelas->nama}}</h5>
                    <span class="d-block">Jumlah Siswa : <b>{{count($siswa)}}</b></span>
                  </div>
                </div>
                <div class="dropdown-divider"></div>
                @foreach ($siswa as $s)
                  <?php
                    $photo = 'http://siakad.slua.sch.id/'.$s->detil->photo;
                    if ($s->detil->photo == 'images/user-default.png') {
                      $photo = asset('images/user-lms.png');
                    }
                    $text = '';
                  ?>
                  <div class="d-flex align-items-center">
                    <div class="avatar-lecture">
                      <img src="{{$photo}}" width="100%">
                    </div>
                    <div class="col">
                      <div class="row justify-content-between align-items-center">
                        <div class="col-lg-9 {{$text}}">
                          <span><b>{{$s->nama}}</b></span>
                          <span class="d-block font-small-2">{{$s->nis}}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="dropdown-divider"></div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 order-1 order-md-2 order-lg-2">
        <div class="blog-list-wrapper">
          <div class="card">
            {{-- <button class="btn btn-icon btn-gradient-dark rounded-circle" style="position: absolute; top: 5px; right: 5px;" title="Ubah Gambar Kelas"><i data-feather="edit"></i></button> --}}
            <img class="card-img-top img-fluid" width="100%" src="{{asset('images/lms-bg-'.$img.'.jpg')}}">
            <div class="card-body">
              <div class="img-badge float-right">Kelas <b>{{$data->kelas->nama}}</b></div>
              <h5 class="media mb-25">
                <span class="blog-title-truncate text-body-heading"><b>{{$data->mapel->nama}}</b></span>
              </h5>
              <div class="media mb-25">
                <div class="media-body row m-0">
                  {{-- <div class="pr-50"><small>{{$data->mapel->kodemk}}</small></div> --}}
                  <div class="px-50 border-left-primary">
                    <small>{{$data->mapel->nama}} {{$data->kelas->nama}}</small>
                  </div>
                  @if ($data->pendek == 1)
                    <div class="pl-50 border-left-primary">
                      <div class="badge badge-light-warning">Antara</div>
                    </div>
                  @endif
                </div>
              </div>
              {{-- <div class="alert alert-dark mt-75 mb-0" role="alert">
                <div class="alert-body">
                  <div class="row m-0 justify-content-between align-items-center">
                    @if ($data->hari2 == null)
                      {{$data->hari->nama}}, @foreach ($data->detil as $jdt) {{$jdt->jampelajaran->mulai}} s/d {{$jdt->jampelajaran->selesai}} @endforeach
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
                    <div class="badge bg-gradient-info"><i data-feather="users" style="top: 0"></i> {{count($siswa)}}</div>
                  </div>
                </div>
              </div> --}}
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header border-bottom pb-75">
            <h5 class="mb-0">Guru Pengajar</h5>
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
<div class="modal fade text-left" id="modal-materi" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title-materi">Tambah Materi Pembelajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="forms-sample form-materi" action="#" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idjadwal" value="{{$data->id}}">
        <input type="hidden" name="idmateri" id="idmateri">
        <input type="hidden" name="pertemuan" class="pertemuan">
        <div class="modal-body">
          <div class="row">
            <div class="col-xl-12 mb-1">
              <div class="form-group">
                <label><b>Pertemuan Ke</b></label>
                <input type="number" class="form-control pertemuan" name="pertemuan" value="{{$pertemuan + 1}}" autocomplete="off" disabled>
              </div>
            </div>
            <div class="col-xl-12 mb-1">
              <div class="form-group">
                <label><b>Jenis Pertemuan</b></label>
                <select class="form-control select2" name="idjenis" id="idjenis" data-placehorder="Pilih" required>

                </select>
              </div>
            </div>
            <div class="col-xl-12 mb-1">
              <div class="form-group">
                <label><b>Nama Materi Pembelajaran</b></label>
                <input type="text" class="form-control" name="namamateri" id="namamateri" autocomplete="off" required>
              </div>
            </div>
            <div class="col-xl-12">
              <div class="form-group">
                <label><b>Sub Capaian Pembelajaran (Sub-CPMK)</b></label>
                <textarea class="form-control" name="capaian" id="capaian" cols="30" rows="3" required></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="save"></i> Simpan</button>
        </div>
        {{ csrf_field() }}
      </form>
    </div>
  </div>
</div>

<div class="modal fade text-left" id="modal-rps" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title">Unggah Materi Pembelajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-xl-12 mb-1">
              <div class="alert alert-dark mb-0" role="alert">
                <h4 class="alert-heading"><i data-feather="info" style="margin-top: -2px"></i> INFORMASI</h4>
                <div class="alert-body">
                  <small>
                    Silakan <b>Unduh Template</b> Materi Pembelajaran dalam format Ms.Excel dan melengkapi isian, kemudian pilih file yang telah diisi dan tekan tombol Unggah untuk menyimpan.
                  </small>
                  <div class="text-center text-lg-left mt-50">
                    <form class="" action="{{route('pembelajaran.materi.unduhtemplate')}}" method="post">
                      <button type="submit" class="btn btn-sm btn-outline-success" name="idjadwal" value="{{$data->id}}"><i data-feather="download" style="top: 0"></i> Unduh Template</button>
                      @csrf
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <form class="forms-sample" action="{{route('pembelajaran.materi.unggahtemplate')}}" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label><b>Pilih Dokumen</b></label>
              <input type="hidden" name="idjadwal" value="{{$data->id}}">
              <input type="file" name="dokrps" class="dropify" data-allowed-file-extensions="xlsx" data-max-file-size="1M" required>
              <label>fomat file <b>.xlsx</b> ukuran maksimal <b>1MB</b></label>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="upload"></i> Unggah</button>
        </div>
        {{ csrf_field() }}
      </form>
    </div>
  </div>
</div>

<div class="modal fade text-left" id="modal-publish" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title-publish">Ubah Status Materi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <form class="forms-sample" action="{{route('pembelajaran.publishmateri')}}" method="post">
            <input type="hidden" name="idmateri" id="idpublish">
            <div class="row">
              <div class="col-xl-12 mb-1">
                <div class="form-group">
                  <label><b>Pertemuan</b></label>
                  <input type="text" class="form-control" id="pertemuanpublish" disabled>
                </div>
              </div>
              <div class="col-xl-12 mb-1">
                <div class="form-group">
                  <label><b>Materi</b></label>
                  <input type="text" class="form-control" id="materipublish" disabled>
                </div>
              </div>
              <div class="col-xl-12">
                <div class="form-group">
                  <label><b>Status</b></label>
                  <select class="form-control select2" name="statuspublish" id="statuspublish" data-placeholder="Pilih" required>
                    <option></option>
                  </select>
                </div>
              </div>
              <div class="col-xl-12 mt-1 tglpublish">
                <div class="form-group">
                  <label><b>Tanggal Publish</b></label>
                  <input type="text" class="form-control flatpickr-basic" name="tglpublish" style="background-color: white" placeholder="Pilih" id="tglpublish" required>
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="check-square"></i> Ubah Status</button>
        </div>
        {{ csrf_field() }}
      </form>
    </div>
  </div>
</div>

<div class="modal fade text-left" id="modal-salinmateri" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title-salinmateri">Salin Materi Pembelajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="forms-sample form-topik" action="{{route('pembelajaran.storesalinmateri')}}" method="post">
        <input type="hidden" name="idjadwal" value="{{$data->id}}">
        <div class="modal-body">
          <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading"><i data-feather="alert-circle" style="margin-top: -2px"></i> PERHATIAN</h4>
            <div class="alert-body">
              Anda dapat menyalin materi mata pelajaran <b>{{$data->mapel->nama}}</b> dari kelas yang lain.<br>
              Mohon diperhatikan saat Anda menggunakan fitur salin, materi yang telah Anda isi atau unggah di kelas ini (Kelas {{$data->kelas->nama}}) akan <b>diganti seluruhnya</b> (termasuk dokumen terkait) dengan materi dari kelas yang disalin.
            </div>
          </div>
          <div class="row">
            <div class="col-xl-12">
              <div class="form-group">
                <label><b>Pilih Materi Untuk Disalin</b></label>
                <select class="form-control select2" name="idjadwalsalin" id="jadwalsalin" data-placeholder="Pilih" required>
                  <option></option>
                  @foreach ($jadwalsalin as $js)
                    <option value="{{$js->id}}">
                      {{$js->mapel->nama}} | Kelas {{$js->kelas->nama}}
                    </option>  
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-xl-12 materisalin">
              
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-warning"><i data-feather="copy"></i> Salin</button>
        </div>
        {{ csrf_field() }}
      </form>
    </div>
  </div>
</div>

<div class="modal fade text-left" id="modal-video" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title-video"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="forms-sample form-video" action="#" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idjadwal" value="{{$data->id}}">
        <input type="hidden" name="idmapel" value="{{$data->idmapel}}">
        <input type="hidden" name="idguru" value="{{auth::user()->link}}">
        <input type="hidden" name="idvideo" id="idvideo">
        <div class="modal-body">
          <div class="row">
            <div class="col-xl-12 mb-1">
              <div class="form-group">
                <label><b>Perkenalan Guru</b></label>
                <input type="text" class="form-control" value="{{auth::user()->pegawai->nama}}" disabled>
              </div>
            </div>

            <div class="col-xl-12 mb-1">
              <div class="form-group">
                <label><b>Mata Pelajaran</b></label>
                <input type="text" class="form-control" value="{{$data->mapel->nama}}" disabled>
              </div>
            </div>

            <div class="col-xl-12 mb-1">
              <div class="form-group">
                <label><b>Kelas</b></label>
                <input type="text" class="form-control" value="{{$data->kelas->nama}}" disabled>
              </div>
            </div>

            <div class="col-xl-12">
              <div class="form-group">
                <label><b>File Video</b></label>
                <input type="file" name="videos" class="dropify" data-allowed-file-extensions="mp4" data-max-file-size="20M">
                <label>fomat file <b>.mp4</b> ukuran maksimal <b>20MB</b></label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="save"></i> Simpan</button>
        </div>
        {{ csrf_field() }}
      </form>
    </div>
  </div>
</div>

<div class="modal fade text-left" id="modal-dokumen" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title-dokumen">Tambah Dokumen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="forms-sample form-dokumen" action="#" method="post" enctype="multipart/form-data">
        <input type="hidden" name="iddokumen" id="iddokumen">
        <input type="hidden" name="idmateri" id="idmateridokumen">
        <input type="hidden" name="idjadwal" value="{{$data->id}}">
        <input type="hidden" name="idmapel" value="{{$data->idmapel}}">
        <input type="hidden" name="idguru" value="{{auth::user()->link}}">
        <input type="hidden" name="idkontrak" id="idkontrak">
        <div class="modal-body">
          <div class="row">
            <div class="col-xl-12 mb-1 course">
              <div class="form-group">
                <label><b>Nama Materi Pembelajaran</b></label>
                <input type="text" class="form-control" id="materidokumen" disabled>
              </div>
            </div>
            <div class="col-xl-12 mb-1">
              <div class="form-group">
                <label><b>Nama Dokumen</b></label>
                <input type="text" class="form-control" name="namadokumen" id="namadokumen" autocomplete="off" required>
              </div>
            </div>

            <div class="col-xl-12 mb-1">
              <div class="form-group">
                <label><b>Jenis Dokumen</b></label>
                <select class="form-control" name="idjenis" id="idjenisdokumen" data-placehorder="Pilih" required>
                  <option></option>
                  <option value="1">File / Berkas</option>
                  <option value="2">Link</option>
                </select>
              </div>
            </div>

            <div class="col-xl-12">
              <div class="form-group dokumen">
                <label><b>Pilih Dokumen</b></label>
                <input type="file" name="dokumen" class="dropify" id="dokumen" data-allowed-file-extensions="doc docx pdf ppt pptx zip" data-max-file-size="5M">
                <label>fomat file <b>.doc .docx .pdf .ppt .pptx</b> atau <b>.zip</b> ukuran maksimal <b>5MB</b></label>
              </div>

              <div class="form-group link">
                <label><b>Link</b></label>
                <input type="text" name="dokumen" class="form-control" id="linkdokumen">
              </div>
            </div>
          </div>
        </div>
        {{ csrf_field() }}
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="save"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade text-left" id="modal-rubrik" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title-rubrik">Tambah Rubrik Penilaian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="forms-sample form-rubrik" action="#" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idpenugasan" id="idpenugasan">
        <input type="hidden" name="iduser" value="{{auth::user()->id}}">
        <div class="modal-body">
          <div class="row">
            <div class="col-xl-12 mb-1 course">
              <div class="form-group">
                <label><b>Judul Penugasan</b></label>
                <input type="text" class="form-control" id="rubrikpenugasan" disabled>
              </div>
            </div>
            <div class="col-xl-12 mb-1">
              <div class="form-group">
                <label><b>Nama Komponen Penilaian</b></label>
                <input type="text" class="form-control" name="nama" id="rubriknama" autocomplete="off" required>
              </div>
            </div>

            <div class="col-xl-12 mb-1">
              <div class="form-group">
                <label><b>Bobot (%)</b></label>
                <input type="number" step="0.1" class="form-control" name="bobot" id="rubrikbobot" autocomplete="off" required>
              </div>
            </div>
          </div>
        </div>
        {{ csrf_field() }}
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="save"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade text-left" id="modal-topik" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title-topik">Tambah Topik Diskusi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="forms-sample form-topik" action="#" method="post">
        <input type="hidden" name="idjadwal" value="{{$data->id}}">
        <input type="hidden" name="idtopik" id="idtopik">
        <input type="hidden" name="iduser" id="iduser" value="{{auth::user()->id}}">
        <div class="modal-body">
          <div class="row">
            <div class="col-xl-12">
              <div class="form-group">
                <label><b>Topik Diskusi</b></label>
                <input type="text" class="form-control" name="judul" id="judul" autocomplete="off" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="save"></i> Simpan</button>
        </div>
        {{ csrf_field() }}
      </form>
    </div>
  </div>
</div>

<div class="modal fade text-left" id="modal-evaluasi" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title-evaluasi">Pengaturan Evaluasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="forms-sample" action="{{route('pembelajaran.setevaluasi')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idjadwal" value="{{$data->id}}">
        <input type="hidden" name="iduser" value="{{auth::user()->id}}">
        <input type="hidden" name="idmateri" class="idmateri">
        <div class="modal-body">
          <div class="row">
            <div class="col-xl-6 mb-1">
              <div class="form-group">
                <label><b>Materi Pembelajaran</b></label>
                <input type="text" class="form-control" id="materievaluasi" disabled>
              </div>
            </div>
            <div class="col-xl-6 mb-1">
              <div class="form-group">
                <label><b>Tanggal Pelaksanaan</b></label>
                <input type="text" name="tgl" id="tglevaluasi" class="form-control flatpickr-basic" style="background-color: white" placeholder="Pilih" required>
              </div>
            </div>
            <div class="col-xl-6 mb-1">
              <div class="form-group">
                <label><b>Jam Mulai</b></label>
                <input type="text" name="mulai" id="mulaievaluasi" class="form-control flatpickr-time text-left" style="background-color: white" placeholder="Pilih" required>
              </div>
            </div>
            <div class="col-xl-6 mb-1">
              <div class="form-group">
                <label><b>Jam Berakhir</b></label>
                <input type="text" name="berakhir" id="akhirevaluasi" class="form-control flatpickr-time text-left" style="background-color: white" placeholder="Pilih" required>
              </div>
            </div>
            <div class="col-xl-6 mb-1">
              <div class="form-group">
                <label><b>Jenis Evaluasi</b></label>
                <select class="form-control select2" name="idjenis" id="idjenisevaluasi" data-placehorder="Pilih" required>

                </select>
              </div>
            </div>
            <div class="col-xl-6">
              <div class="form-group">
                <label><b>Jumlah Soal</b></label>
                <input type="number" name="jmlsoal" id="jmlsoal" class="form-control">
                <label class="mt-50">
                  <ul class="pl-1 mb-0">
                    <li>Isian jumlah soal jika Anda ingin membatasi soal yang tampil saat evaluasi (soal akan diacak sejumlah isian dari total soal yang telah Anda unggah)</li>
                    <li>Kosongkan jika Anda ingin menampilkan semua soal</li>
                  </ul>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="save"></i> Simpan</button>
        </div>
        {{ csrf_field() }}
      </form>
    </div>
  </div>
</div>

<div class="modal fade text-left" id="modal-tugas" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title-tugas">Tambah Penugasan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="forms-sample form-tugas" action="{{route('pembelajaran.penugasan.store')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idjadwal" value="{{$data->id}}">
        <input type="hidden" name="iduser" value="{{auth::user()->id}}">
        <input type="hidden" name="idtugas" id="idtugas">
        <div class="modal-body">
          <div class="row">
            <div class="col-xl-12 mb-1">
              <div class="form-group">
                <label><b>Judul Penugasan</b></label>
                <input type="text" class="form-control" name="judul" id="judultugas">
              </div>
            </div>

            <div class="col-xl-6 mb-1">
              <div class="form-group">
                <label><b>Jenis Penugasan</b></label>
                <select class="form-control select2 idjenispenugasan" name="idjenis" data-placehorder="Pilih" required>
                  <option></option>
                  <option value="1">Individu</option>
                  <option value="2">Kelompok</option>
                </select>
              </div>
            </div>

            <div class="col-xl-6 mb-1">
              <div class="form-group">
                <label><b>Metode Pengumpulan</b></label>
                <select class="form-control select2" name="idmetode" id="idmetode" data-placehorder="Pilih" required>
                  <option></option>
                  <option value="1">Submit Dokumen</option>
                  <option value="2">Oral Presentation</option>
                </select>
              </div>
            </div>

            <div class="col-xl-12 mb-1">
              <div class="form-group">
                <label><b>Deskripsi / Keterangan / Spesifikasi</b></label>
                <textarea class="form-control" name="keterangan" id="keterangantugas" rows="3" cols="80"></textarea>
              </div>
            </div>

            <div class="col-xl-6 mb-1">
              <div class="form-group">
                <label><b>Tanggal Pengumpulan</b></label>
                <input type="text" name="batastgl" id="batastgl" class="form-control flatpickr-basic" style="background-color: white" placeholder="Pilih" required>
              </div>
            </div>
            <div class="col-xl-6 mb-1">
              <div class="form-group">
                <label><b>Jam Pengumpulan</b></label>
                <input type="text" name="batasjam" id="batasjam" class="form-control flatpickr-time text-left" style="background-color: white" placeholder="Pilih" required>
              </div>
            </div>

            <div class="col-xl-12">
              <div class="form-group">
                <label><b>Dokumen Pendukung</b> <span class="text-muted">(Opsional)</span></label>
                <input type="file" name="doktugas" class="dropify" data-allowed-file-extensions="doc docx pdf" data-max-file-size="5M" >
                <label>format file <b>.doc .docx</b> atau <b>.pdf</b> ukuran maksimal <b>5MB</b></label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="save"></i> Simpan</button>
        </div>
        {{ csrf_field() }}
      </form>
    </div>
  </div>
</div>
@endsection

@section('jspage')
<script>
$(document).ready(function() {
  $("#idjenisevaluasi").select2({
    placeholder: "Pilih",
    ajax: {
        url: '{!!route("s2.jenisevaluasi")!!}',
        dataType: 'json',
        data: function (params) {
            return {
                q: $.trim(params.term),
            };
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
    },
  });
  $('.link').hide();
  $("#idjenisdokumen").select2({
    placeholder: "Pilih",
  });

  $("#idjenisdokumen").change(function(){
    if ($(this).val() == 1) {
      $('.dokumen').show();
      $('.link').hide();
      $('#dokumen').prop('required', true);
      $('#linkdokumen').prop('required', false);
    }else {
      $('.link').show();
      $('.dokumen').hide();
      $('#dokumen').prop('required', false);
      $('#linkdokumen').prop('required', true);
    }
  })

  $("#idjenis").select2({
    placeholder: "Pilih",
    ajax: {
        url: '{!!route("s2.jenispertemuan")!!}',
        dataType: 'json',
        data: function (params) {
            return {
                q: $.trim(params.term),
            };
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
    },
  });

  $('.btnvideo').on('click',function(){
    $('#modal-title-video').text('Unggah Video Perkenalan')
    $('.form-video').attr('action', "{{route('pembelajaran.storevideo')}}")
  });

  $('.btnubahvideo').on('click',function(){
    idvideo = $(this).val()
    $('#modal-title-video').text('Ubah Video Perkenalan')
    $('.form-video').attr('action', "{{route('pembelajaran.updatevideo')}}")
    $("#idvideo").val(idvideo)
  });

  $('.btntambahkontrak').on('click',function(){
    $('#modal-dokumen').modal('show')
    $('#modal-title-dokumen').text('Tambah Dokumen')
    $('.form-dokumen').attr('action', "{{route('pembelajaran.storekontrak')}}")
    $('.course').hide();
    $("#namadokumen").val('')
    $('#dokumen').prop('required', true);
  });

  $('.btnubahkontrak').on('click',function(){
    idkontrak = $(this).val()
    namadokumen = $(this).data('dokumen')
    $('#modal-dokumen').modal('show')
    $('#modal-title-dokumen').text('Ubah Dokumen')
    $('.form-dokumen').attr('action', "{{route('pembelajaran.updatekontrak')}}")
    $('.course').hide();
    $("#namadokumen").val(namadokumen)
    $("#idkontrak").val(idkontrak)
  });

  $('#btntambahmateri').on('click',function(){
    var pertemuan = '{{$pertemuan + 1}}'
    $('#modal-materi').modal('show')
    $('#modal-title-materi').text('Tambah Materi Pembelajaran')
    $('.form-materi').attr('action', "{{route('pembelajaran.storemateri')}}")
    $(".pertemuan").val(pertemuan)
    $("#idmmateri").val('')
    $("#namamateri").val('')
    $("#capaian").text('')
    $("#idjenis").append($("<option selected='selected'></option>").val('').text(''));
  });

  $('.btnubahmateri').on('click',function(){
    idmateri = $(this).val()
    $('#modal-materi').modal('show')
    $('#modal-title-materi').text('Ubah Materi Pembelajaran')
    $('.form-materi').attr('action', "{{route('pembelajaran.updatemateri')}}")
    $("#idmateri").val(idmateri)
    $.get('/pembelajaran/materi/getmateri/'+idmateri, function(data){
      $(".pertemuan").val(data.pertemuan)
      $("#namamateri").val(data.materi)
      $("#capaian").text(data.capaian)
      $("#idjenis").append($("<option selected='selected'></option>").val(data.idjenis).text(data.jenis.nama));
    })
  });

  $('.btnpublish').on('click',function(){
    idmateri = $(this).val()
    $("#idpublish").val(idmateri)
    $("#statuspublish option").each(function() {
      $(this).remove();
    });
    $.get('/pembelajaran/materi/getmateri/'+idmateri, function(data){
      $("#pertemuanpublish").val(data.pertemuan)
      $("#materipublish").val(data.materi)
      if (data.publish == 0) {
        $("#statuspublish").append($("<option selected='selected'></option>").val('0').text('Draft'));
        $("#statuspublish").append($("<option></option>").val('1').text('Publish'));
        $(".tglpublish").hide()
      }else {
        $("#statuspublish").append($("<option></option>").val('0').text('Draft'));
        $("#statuspublish").append($("<option selected='selected'></option>").val('1').text('Publish'));
        $(".tglpublish").show()
        $("#tglpublish").val(data.tglpublish)
      }
      $('#statuspublish').on('change', function(){
        if ($(this).val() == 0) {
          $(".tglpublish").hide()
        }else {
          $(".tglpublish").show()
          $("#tglpublish").val(data.tglpublish)
        }
      })
    })
  });

  $('.btntambahdokumen').on('click',function(){
    idmateridokumen = $(this).data('idmateri')
    materidokumen = $(this).data('materi')
    $('#modal-dokumen').modal('show')
    $('#modal-title-dokumen').text('Tambah Dokumen Materi')
    $('.form-dokumen').attr('action', "{{route('pembelajaran.storedokumen')}}")
    $('.course').show();
    $("#idmateridokumen").val(idmateridokumen)
    $("#materidokumen").val(materidokumen)
    $("#namadokumen").val('')
    $('#dokumen').prop('required', true);
  });

  $('.btnubahdokumen').on('click',function(){
    iddokumen = $(this).val()
    idmateridokumen = $(this).data('idmateri')
    materidokumen = $(this).data('materi')
    $('#modal-dokumen').modal('show')
    $('#modal-title-dokumen').text('Ubah Dokumen Materi')
    $('.form-dokumen').attr('action', "{{route('pembelajaran.updatedokumen')}}")
    $('.course').show();
    $("#iddokumen").val(iddokumen)
    $("#idmateridokumen").val(idmateridokumen)
    $("#materidokumen").val(materidokumen)
    $.get('/pembelajaran/dokumen/getdokumen/'+iddokumen, function(data){
      $("#namadokumen").val(data.nama)
      if (data.idjenis == 1) {
        $('.dokumen').show();
        $('.link').hide();
        $('#dokumen').prop('required', true);
        $('#linkdokumen').prop('required', false);
      }else {
        $('.link').show();
        $('.dokumen').hide();
        $('#dokumen').prop('required', false);
        $('#linkdokumen').prop('required', true);
      }
      $("#idjenisdokumen").select2('destroy');
      $("#idjenisdokumen option[value='" + data.idjenis + "']").prop("selected", true);
      $("#idjenisdokumen").select2({
        placeholder: "Pilih",
      });
    })
    $('#dokumen').prop('required', false);
  });

  $('#btntambahtopik').on('click',function(){
    $('#modal-topik').modal('show')
    $('#modal-title-materi').text('Tambah Topik Diskusi')
    $('.form-topik').attr('action', "{{route('pembelajaran.storetopikdiskusi')}}")
    $("#idtopik").val('')
  });

  $('#btntambahtugas').on('click',function(){
    $(".idjenispenugasan").select2({
      placeholder: "Pilih",
    });

    $("#idmetode").select2({
      placeholder: "Pilih",
    });
    $('#modal-title-tugas').text('Tambah Penugasan')
    $('.form-materi').attr('action', "{{route('pembelajaran.penugasan.store')}}")
  });

  $('.btntambahrubrik').on('click',function(){
    idtugas = $(this).data('idtugas')
    console.log(idtugas);
    $('#idpenugasan').val(idtugas)
    $('#modal-title-rubrik').text('Tambah Rubtik Penugasan')
    $.get('/pembelajaran/tugas/gettugas/'+idtugas, function(data){
      $("#rubrikpenugasan").val(data.judul)
    })
    $('.form-rubrik').attr('action', "{{route('pembelajaran.penugasan.rubrik.store')}}")
  });


  $('.btnubahtugas').on('click',function(){
    idtugas = $(this).val()
    $('#modal-tugas').modal('show')
    $('#modal-title-materi').text('Ubah Penugasan')
    $('.form-tugas').attr('action', "{{route('pembelajaran.penugasan.update')}}")
    $("#idtugas").val(idtugas)
    $(".idjenispenugasan").select2('destroy');

    $("#idmetode").select2('destroy');
    $.get('/pembelajaran/tugas/gettugas/'+idtugas, function(data){
      $("#judultugas").val(data.judul)
      $("#keterangantugas").val(data.keterangan)
      $("#batasjam").val(data.batasjam)
      $("#batastgl").val(data.batastgl)
      $("#idmetode").val(data.idmetode)
      $(".idjenispenugasan").val(data.idjenis)
      $(".idjenispenugasan").select2({
        placeholder: "Pilih",
      });

      $("#idmetode").select2({
        placeholder: "Pilih",
      });
    })
  });

  $('.btnubahtopik').on('click',function(){
    idtopik = $(this).val()
    $('#modal-topik').modal('show')
    $('#modal-title-materi').text('Ubah Topik Diskusi')
    $('.form-topik').attr('action', "{{route('pembelajaran.updatetopikdiskusi')}}")
    $("#idtopik").val(idtopik)
    $.get('/pembelajaran/diskusi/gettopikdiskusi/'+idtopik, function(data){
      $("#judul").val(data.judul)
    })
  });

  $('.btnubahevaluasi').on('click',function(){
    idmateri = $(this).val()
    materievaluasi = $(this).data('materi')
    $(".idmateri").val(idmateri)
    $("#materievaluasi").val(materievaluasi)
    $.get('/pembelajaran/evaluasi/getevaluasi/'+idmateri, function(data){
      if (data == null) {
        $("#tglevaluasi").val('')
        $("#mulaievaluasi").val('')
        $("#akhirevaluasi").val('')
        $("#jmlsoal").val('')
        $("#idjenisevaluasi").append($("<option selected='selected'></option>").val('').text(''));
      }else {
        $("#tglevaluasi").val(data.tgl)
        $("#mulaievaluasi").val(data.mulai)
        $("#akhirevaluasi").val(data.berakhir)
        $("#jmlsoal").val(data.jmlsoal)
        $("#idjenisevaluasi").append($("<option selected='selected'></option>").val(data.idjenis).text(data.jenis.nama));
      }
    })
  });

  $('#btnsalinmateri').on('click',function(){
    $("#jadwalsalin").append($("<option selected='selected'></option>").val('').text('')).trigger('change');
    $('.materisalin').hide()
    $('#jadwalsalin').prop('required', true);
  });

  $('#jadwalsalin').on('change', function(){
    $.get('/pembelajaran/materi/getmaterisalin/'+$(this).val(), function(data){
      $('.materisalin').show()
      $('.materisalin').html(data)
    })
  })
});
</script>
@stop
