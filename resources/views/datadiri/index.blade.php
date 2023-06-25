@extends('layouts.menu')
@section('content')
<div class="block-header">
  <div class="row">
    <div class="col-lg-7 col-md-6 col-sm-12">
      <h2>Data Diri</h2>
      <ul class="breadcrumb">
        <li class="breadcrumb-item">Guru</li>
        <li class="breadcrumb-item active">Detail</li>
      </ul>
      <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
    </div>
    <div class="col-lg-5 col-md-6 col-sm-12">
      <button class="btn btn-primary btn-sm float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
      <button type="submit" class="btn btn-warning btn-sm float-right" name="button" data-toggle="modal" data-target="#modal-password" data-backdrop="static" data-keyboard="false">Ubah Password</button>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row clearfix">
    <div class="col-lg-4 col-md-12">
      <div class="card mcard_3">
        <div class="body">
          <div class="author-box-center">
            <img alt="Rounded Image" class="rounded" width="80%" src="{{asset($data->photo)}}">
            <div class="clearfix"></div>
            <div class="author-box-name mt-2">
              <a href="#"><b>{{$data->nama}}</b></a>
            </div>
            <div class="author-box-job"><b>{{$data->bagian == ''? '':$data->bagian->nama}}</b></div>
            <div class="author-box-job">{{$data->subbagian == ''? '':$data->subbagian->jenjang.' '.$data->subbagian->nama}}</div>
            <div class="row justify-content-center">
              <div class="badge badge-success mt-2 mr-1">{{$data->skerja == ''? '':$data->skerja->nama}}</div>
              <div class="badge {{$data->serdos == 0? 'badge-warning':'badge-primary'}} mt-2">{{$data->serdos == 0? 'Belum Serdos':'Lulus Serdos'}}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="body">
          <h5 class="my-0"><strong>Kontak</strong></h5>
          <hr class="mb-2">
          <small class="text-muted">Alamat </small>
          <p class="mb-2">{{$data->alamat}}</p>
          <hr class="my-2">
          <small class="text-muted">Telepon </small>
          <p class="mb-2">{{$data->telp}}</p>
          <hr class="my-2">
          <small class="text-muted">Email </small>
          <p class="mb-2">{{$data->email}}</p>
          <hr class="mt-2 mb-0">
        </div>
      </div>
    </div>
    <div class="col-lg-8 col-md-12">
      <div class="card">
        <div class="body">
          <ul class="nav nav-tabs p-0 mb-3">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#biodata">Biodata</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pendidikan">Pendidikan</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#jafa">JAFA & Serdos</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pangkat">Kepangkatan</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tanggungan">Tanggungan</a></li>
          </ul>
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane in active" id="biodata">
              <div class="col-mm-12 text-right">
                <button type="button" class="btn btn-outline-warning mb-3" name="button" data-toggle="modal" data-target="#modal-guru" data-backdrop="static" data-keyboard="false" id="btnguru">Ubah Biodata</button>
              </div>
              <div class="table-responsive">
                <table class="table table-striped c_table">
                  <tr>
                    <td>Nama Panggilan</td>
                    <td class="text-muted">{{$data->panggilan}}</td>
                  </tr>
                  <tr>
                    <td>Tempat, Tanggal Lahir</td>
                    <td class="text-muted">{{$data->tempatlahir}}, {{ (new \App\Helper)->tanggal($data->tgllahir) }}</td>
                  </tr>
                  <tr>
                    <td>Usia</td>
                    <td class="text-muted">{{ (new \App\Helper)->lamamengajar($data->tgllahir) }}</td>
                  </tr>
                  <tr>
                    <td>Jenis Kelamin</td>
                    <td class="text-muted">{{$data->jk == 1 ? 'Laki-laki':'Perempuan'}}</td>
                  </tr>
                  <tr>
                    <td>Status Guru</td>
                    <td class="text-muted">{{$data->idstatusguru == ''? '':$data->statusguru->nama}}</td>
                  </tr>
                  <tr>
                    <td>NIP/NPK</td>
                    <td class="text-muted">{{$data->npk_nip}}</td>
                  </tr>
                  <tr>
                    <td>NIDN</td>
                    <td class="text-muted">{{$data->nidn}}</td>
                  </tr>
                  <tr>
                    <td>Pengangkatan</td>
                    <td class="text-muted">{{ $data->mulaimengajar ==''? '-':(new \App\Helper)->tanggal($data->tmtkerja) }}</td>
                  </tr>
                  <tr>
                    <td>Masa Kerja</td>
                    <td class="text-muted">{{$lama}}</td>
                  </tr>
                  <tr>
                    <td>Pendidikan Terakhir</td>
                    <td class="text-muted">{{$data->idpendidikan == '' ? '':$data->pendidikan->nama}}</td>
                  </tr>
                  <tr>
                    <td>Jabatan Fungsional</td>
                    <td class="text-muted">{{$data->jafung->nama}} ({{$data->jafung->kredit}})</td>
                  </tr>

                  <tr>
                    <td>Pangkat / Golongan</td>
                    <td class="text-muted">{{$data->idpangkat == '' ? '': $data->pangkat->pangkat." (".$data->pangkat->golongan."/".$data->pangkat->ruang.")"}}</td>

                  </tr>
                  <tr>
                    <td>Serdos</td>
                    <td class="text-muted">{{count($serdos) == 0 ? 'Belum Serdos':'Lulus '.$serdos[0]->thnlulus}}</td>
                  </tr>
                  <tr>
                    <td>NIK</td>
                    <td class="text-muted">{{$data->nik}}</td>
                  </tr>
                  <tr>
                    <td>Agama</td>
                    <td class="text-muted">{{$data->agama}}</td>
                  </tr>
                  <tr>
                    <td>Tanggal Pensiun</td>
                    <td class="text-muted">{{ (new \App\Helper)->tanggal($data->tglpensiun) }}</td>
                  </tr>
                </table>
              </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="pendidikan">
              <div class="col-mm-12 text-right">
                <button type="button" class="btn btn-outline-warning mb-3" name="button" data-toggle="modal" id="btnaddriwayatpendidikan" data-target="#modal-pendidikan" data-backdrop="static" data-keyboard="false">Tambah Riwayat Pendidikan</button>
              </div>

              <div class="card pt-5" style="background-color: #f5f5f5;">
                <div class="container-fluid">
                  <div class="row clearfix">
                    <div class="col-sm-12">
                      <ul class="cbp_tmtimeline">
                        <?php
                          $ip = 0;
                        ?>
                        @foreach($riwayatp as $pen)
                        <?php
                          $back ='bg-secondary';
                          if ($ip == 0) {
                            $back ='bg-primary';
                          }
                          $ip++;
                          $ija ='';
                          $tra ='';
                          $disablei ='';
                          $disablet ='';
                          if ($pen->dokijazah == null) {
                            $disablei = 'disabled';
                            $ija ='Belum Diunggah';
                          }

                          if ($pen->doktranskrip == null) {
                            $disablet = 'disabled';
                            $tra ='Belum Diunggah';
                          }
                        ?>
                        <li>
                          <div class="cbp_tmicon {{$back}}"><i class="zmdi zmdi-file-text"></i></div>
                          <div class="cbp_tmlabel">
                            <div class="cbp_tmtime">
                              <span>{{ (new \App\Helper)->tanggal($pen->updated_at) }}</span>
                            </div>
                            <h5><a href="#">{{$pen->pendidikan->nama}}</a> <span style="color: #9E9E9E;">({{$pen->asalkampus == 1 ? 'Dalam Negeri':'Luar Negeri'}})</span></h5>
                            <span><b>{{$pen->namakampus}}</b></span><br>
                            <span>{{$pen->prodi}}</span><br>
                            <span class="text-muted">Lulus {{ (new \App\Helper)->tanggal($pen->tgllulus) }}</span>
                            <div class="row mx-0">
                              <a href="{{asset($pen->dokijazah)}}" class="btn btn-sm btn-primary mr-1" target="_blank" {{$disablei}}>Ijazah {{$ija}}</a>
                              <a href="{{asset($pen->doktranskrip)}}" class="btn btn-sm btn-success" {{$disablet}} target="_blank" {{$disablei}}>Transkrip Nilai {{$tra}}</a>
                            </div>
                            <div class="row mx-0">
                              <button class="btn btn-outline-warning btn-sm btneditriwayatpendidikan" value="{{$pen->id}}" data-toggle="modal" data-target="#modal-pendidikan" data-backdrop="static" data-keyboard="false" type="button"><i class="zmdi zmdi-edit"></i> Ubah</button>
                              <form class="my-0" action="{{route('md.guru.riwayatpendidikan.delete')}}" onsubmit="return confirm('Lanjutkan proses HAPUS data pendidikan {{$pen->pendidikan->nama}}?');" method="post">
                                <input type="hidden" class="form-control" name="id" value="{{$pen->id}}">
                                <button type="submit" class="btn btn-outline-danger btn-sm ml-1"><i class="zmdi zmdi-delete"></i> Hapus</button>
                                {{ csrf_field() }}
                              </form>
                            </div>
                          </div>
                        </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="jafa">
              <div class="col-mm-12 text-right">
                <button type="button" class="btn btn-outline-warning mb-3" name="button" data-toggle="modal" data-target="#modal-jafa" data-backdrop="static" data-keyboard="false" id="btnriwayatjafa">Tambah Riwayat JAFA</button>
                @if(count($serdos) == 0)
                <button type="button" class="btn btn-outline-warning mb-3" name="button" data-toggle="modal" data-target="#modal-serdos" data-backdrop="static" data-keyboard="false" id="btnaddserdos">Tambah Data Serdos</button>
                @endif
              </div>

              @if(count($riwayatjafung) > 0)
              <div class="card pricing pricing-item">
                <div class="pricing-deco bg-indigo pt-3 pb-5">
                  <svg class="pricing-deco-img" enable-background="new 0 0 300 50" height="50px" id="Layer_1" preserveAspectRatio="none" version="1.1" viewBox="0 0 300 50" width="300px" x="0px" xml:space="preserve" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" y="0px">
                    <path class="deco-layer deco-layer--1" d="M30.913,43.944c0,0,42.911-34.464,87.51-14.191c77.31,35.14,113.304-1.952,146.638-4.729&#x000A; c48.654-4.056,69.94,16.218,69.94,16.218v54.396H30.913V43.944z" fill="#FFFFFF" opacity="0.6"></path>
                    <path class="deco-layer deco-layer--2" d="M-35.667,44.628c0,0,42.91-34.463,87.51-14.191c77.31,35.141,113.304-1.952,146.639-4.729&#x000A;  c48.653-4.055,69.939,16.218,69.939,16.218v54.396H-35.667V44.628z" fill="#FFFFFF" opacity="0.6"></path>
                    <path class="deco-layer deco-layer--3" d="M43.415,98.342c0,0,48.283-68.927,109.133-68.927c65.886,0,97.983,67.914,97.983,67.914v3.716&#x000A;  H42.401L43.415,98.342z" fill="#FFFFFF" opacity="0.7"></path>
                    <path class="deco-layer deco-layer--4" d="M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428&#x000A; c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z" fill="#FFFFFF"></path>
                  </svg>
                  <span class="pricing-title">{{$riwayatjafung[0]->jafung->nama}}</span>
                  <div class="pricing-price my-2">{{$riwayatjafung[0]->jafung->kredit}}</div>
                  <h3 class="pricing-title">{{ (new \App\Helper)->tanggal($riwayatjafung[0]->tmt) }}</h3>
                  <div class="btn {{$data->serdos == 0? 'btn-warning':'btn-secondary'}} mb-3">{{$data->serdos == 0? 'Belum Serdos':'Lulus Serdos'}}</div>
                </div>
              </div>
              <div class="card pt-5" style="background-color: #f5f5f5;">
                <div class="container-fluid">
                  <div class="row clearfix">
                    <div class="col-sm-12">
                      <ul class="cbp_tmtimeline">
                        @foreach($serdos as $ser)
                        <li>
                          <div class="cbp_tmicon bg-primary"><i class="zmdi zmdi-file-text"></i></div>
                          <div class="cbp_tmlabel">
                            <div class="cbp_tmtime">
                              <span>{{ (new \App\Helper)->tanggal($ser->updated_at) }}</span>
                            </div>
                            <h5><a href="#">Sertifikasi guru</a></h5>
                            <span>Nomor Sertifikat: {{$ser->noserdos}}</span><br>
                            <span class="text-muted">Lulus Tahun {{$ser->thnlulus}}</span>
                            <div class="row mx-0">
                              <?php
                                $dok ='';
                                $disable ='';
                                $ija='';

                                if ($ser->dok == null) {
                                  $disable = 'disabled';
                                  $ija ='Belum Diunggah';
                                }
                              ?>
                              <a href="{{asset($ser->dok)}}" class="btn btn-sm btn-primary mr-1" target="_blank" {{$disable}}>Sertifikat {{$ija}}</a>
                              <button class="btn btn-outline-warning btn-sm btneditserdos" value="{{$ser->id}}" data-toggle="modal" data-target="#modal-serdos" data-backdrop="static" data-keyboard="false" type="button"><i class="zmdi zmdi-edit"></i> Ubah</button>
                              <form class="my-0" action="{{route('md.guru.serdos.delete')}}" onsubmit="return confirm('Lanjutkan proses HAPUS data Sertifikasi guru?');" method="post">
                                <input type="hidden" class="form-control" name="id" value="{{$ser->id}}">
                                <button type="submit" class="btn btn-outline-danger btn-sm ml-1"><i class="zmdi zmdi-delete"></i> Hapus</button>
                                {{ csrf_field() }}
                              </form>
                            </div>
                          </div>
                        </li>
                        @endforeach
                        <?php
                          $ip = 0;
                        ?>
                        @foreach($riwayatjafung as $jaf)
                        <?php
                          $back ='bg-secondary';
                          if ($ip == 0) {
                            $back ='bg-purple';
                          }
                          $ip++;
                          $dok ='';
                          $disable ='';
                          $ija='';

                          if ($jaf->dok == null) {
                            $disable = 'disabled';
                            $ija ='Belum Diunggah';
                          }
                        ?>
                        <li>
                          <div class="cbp_tmicon {{$back}}"><i class="zmdi zmdi-label"></i></div>
                          <div class="cbp_tmlabel">
                            <div class="cbp_tmtime">
                              <span>{{ (new \App\Helper)->tanggal($jaf->updated_at) }}</span>
                            </div>
                            <h5><span>JAFA </span><a href="#" class="text-purple">{{$jaf->jafung->nama}} ({{$jaf->jafung->kredit}})</a></h5>
                            <span>Nomor SK: {{$jaf->nosk}}</span><br>
                            <span class="text-muted">TMT {{ (new \App\Helper)->tanggal($jaf->tmt) }}</span>
                            <div class="row mx-0">
                              <a href="{{asset($jaf->dok)}}" class="btn btn-sm btn-primary mr-1" target="_blank" {{$disable}}>Dokumen {{$ija}}</a>
                              <button class="btn btn-outline-warning btn-sm btneditriwayatjafa" value="{{$jaf->id}}" data-toggle="modal" data-target="#modal-jafa" data-backdrop="static" data-keyboard="false" type="button"><i class="zmdi zmdi-edit"></i> Ubah</button>
                              <form class="my-0" action="{{route('md.guru.riwayatjafa.delete')}}" onsubmit="return confirm('Lanjutkan proses HAPUS data riwayat JAFA {{$jaf->jafung->nama}} ({{$jaf->jafung->kredit}})?');" method="post">
                                <input type="hidden" class="form-control" name="id" value="{{$jaf->id}}">
                                <button type="submit" class="btn btn-outline-danger btn-sm ml-1"><i class="zmdi zmdi-delete"></i> Hapus</button>
                                {{ csrf_field() }}
                              </form>
                            </div>
                          </div>
                        </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              @else
              <div class="card pricing pricing-item">
                <div class="pricing-deco l-slategray pt-3 pb-5">
                  <svg class="pricing-deco-img" enable-background="new 0 0 300 50" height="50px" id="Layer_1" preserveAspectRatio="none" version="1.1" viewBox="0 0 300 50" width="300px" x="0px" xml:space="preserve" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" y="0px">
                    <path class="deco-layer deco-layer--1" d="M30.913,43.944c0,0,42.911-34.464,87.51-14.191c77.31,35.14,113.304-1.952,146.638-4.729&#x000A; c48.654-4.056,69.94,16.218,69.94,16.218v54.396H30.913V43.944z" fill="#FFFFFF" opacity="0.6"></path>
                    <path class="deco-layer deco-layer--2" d="M-35.667,44.628c0,0,42.91-34.463,87.51-14.191c77.31,35.141,113.304-1.952,146.639-4.729&#x000A;  c48.653-4.055,69.939,16.218,69.939,16.218v54.396H-35.667V44.628z" fill="#FFFFFF" opacity="0.6"></path>
                    <path class="deco-layer deco-layer--3" d="M43.415,98.342c0,0,48.283-68.927,109.133-68.927c65.886,0,97.983,67.914,97.983,67.914v3.716&#x000A;  H42.401L43.415,98.342z" fill="#FFFFFF" opacity="0.7"></path>
                    <path class="deco-layer deco-layer--4" d="M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428&#x000A; c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z" fill="#FFFFFF"></path>
                  </svg>
                  <span class="pricing-title">TENAGA PENGAJAR</span>
                  <div class="pricing-price my-2">0</div>
                  <div class="btn {{count($serdos) == ''? 'btn-warning':'btn-secondary'}} mb-3">{{count($serdos) == 0? 'Belum Serdos':'Lulus Serdos'}}</div>
                </div>
              </div>
              @endif
            </div>

            <div role="tabpanel" class="tab-pane" id="pangkat">
              <div class="col-mm-12 text-right">
                <button type="button" class="btn btn-outline-warning mb-3" name="button" data-toggle="modal" data-target="#modal-pangkat" data-backdrop="static" data-keyboard="false" id="btnnaddpangkat">Tambah Riwayat Kepangkatan</button>
              </div>
              <div class="card pt-5" style="background-color: #f5f5f5;">
                <div class="container-fluid">
                  <div class="row clearfix">
                    <div class="col-sm-12">
                      <ul class="cbp_tmtimeline">
                        <?php
                          $ip = 0;
                        ?>
                        @foreach($pangkat as $jaf)
                        <?php
                          $back ='bg-secondary';
                          if ($ip == 0) {
                            $back ='bg-primary';
                          }
                          $ip++;
                          $dok ='';
                          $disable ='';
                          $ija='';

                          if ($jaf->dok == null) {
                            $disable = 'disabled';
                            $ija ='Belum Diunggah';
                          }
                        ?>
                        <li>
                          <div class="cbp_tmicon {{$back}}"><i class="zmdi zmdi-file-text"></i></div>
                          <div class="cbp_tmlabel">
                            <div class="cbp_tmtime">
                              <span>{{ (new \App\Helper)->tanggal($jaf->updated_at) }}</span>
                            </div>
                            <h5><a href="#">{{$jaf->pangkat->pangkat}} </a><span style="color: #9E9E9E;">({{$jaf->pangkat->golongan}}/{{$jaf->pangkat->ruang}})</span></h5>
                            <span>Nomor SK: {{$jaf->nosk}}</span><br>
                            <span class="text-muted">TMT {{ (new \App\Helper)->tanggal($jaf->tmt) }}</span>
                            <div class="row mx-0">
                              <a href="{{asset($jaf->dok)}}" class="btn btn-sm btn-primary mr-1" target="_blank" {{$disable}}>Dokumen {{$ija}}</a>
                              <button class="btn btn-outline-warning btn-sm btneditpangkat" value="{{$jaf->id}}" data-toggle="modal" data-target="#modal-pangkat" data-backdrop="static" data-keyboard="false" type="button"><i class="zmdi zmdi-edit"></i> Ubah</button>
                              <form class="my-0" action="{{route('md.guru.pangkat.delete')}}" onsubmit="return confirm('Lanjutkan proses HAPUS data kepangkatan {{$jaf->pangkat->pangkat}} ({{$jaf->pangkat->golongan}}/{{$jaf->pangkat->ruang}})?');" method="post">
                                <input type="hidden" class="form-control" name="id" value="{{$jaf->id}}">
                                <button type="submit" class="btn btn-outline-danger btn-sm ml-1"><i class="zmdi zmdi-delete"></i> Hapus</button>
                                {{ csrf_field() }}
                              </form>
                            </div>
                          </div>
                        </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
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
<div class="modal fade" id="modal-guru" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">UBAH BIODATA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_validation" class="forms-sample" action="{{route('md.guru.update')}}" method="post" enctype="multipart/form-data" id="formguru">
          <input type="hidden" class="form-control" name="id" value="{{$data->id}}">
          <div class="form-group">
            <label class="col-sm-8 col-form-label"><b>Nama guru</b></label>
            <div class="col-sm-12">
              <input type="text" name="nama" class="form-control" autocomplete="off" required value="{{$data->nama}}">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-8 col-form-label"><b>Nama Panggilan</b> <small>(maksimal 10 karakter)</small></label>
            <div class="col-sm-12">
              <input type="text" name="panggilan" maxlength="10" class="form-control" autocomplete="off" required value="{{$data->panggilan}}">
            </div>
          </div>

          <div class="form-group npk">
            <label class="col-sm-8 col-form-label"><b>NPK/NIP</b></label>
            <div class="col-sm-12">
              <input type="text" name="npk_nip" autocomplete="off" class="form-control" id="npk_nip" value="{{$data->npk_nip}}">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4 col-form-label"><b>NIDN</b></label>
            <div class="col-sm-12">
              <input type="text" name="nidn" autocomplete="off" class="form-control" id="nidn" value="{{$data->nidn}}">
            </div>
          </div>

          <div class="row">
            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Nomor KTP / NIK</b></label>
              <div class="col-sm-12">
                <input type="text" name="nik" class="form-control" id="nik" value="{{$data->nik}}">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Tempat Lahir</b></label>
              <div class="col-sm-12">
                <input type="text" name="tempatlahir" class="form-control" id="tempatlahir" value="{{$data->tempatlahir}}">
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Tanggal Lahir</b></label>
              <div class="col-sm-12">
                <div class="input-group masked-input">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                    </div>
                    <input type="text" name="tgllahir" class="form-control datesingle" required value="{{$data->tgllahir}}">
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="form-group col-md-4">
              <label class="col-sm-12 col-form-label"><b>Jenis Kelamin</b></label>
              <div class="col-sm-12">
                <div class="radio mb-0">
                  <input id="jk" value="1" name="jk" type="radio" {{$data->jk == 1 ? 'checked':''}}>
                  <label for="jk">Laki-laki</label>
                </div>
                <div class="radio mb-0">
                  <input id="jka" value="2" name="jk" type="radio" {{$data->jk == 2 ? 'checked':''}}>
                  <label for="jka">Perempuan</label>
                </div>
              </div>
            </div>

            <div class="form-group col-md-4">
              <label class="col-sm-4 col-form-label"><b>Agama</b></label>
              <div class="col-sm-12">
                <select class="form-control show-tick ms select2" name="agama" style="width:100%" required data-placeholder="Select">
                    <option selected value="{{$data->agama}}">{{$data->agama == '' ? 'Pilih':$data->agama}}</option>
                    <option value="Islam">Islam</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Protestan">Protestan</option>
                    <option value="Budha">Budha</option>
                    <option value="Konghucu">Konghucu</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Email Afiliasi</b></label>
              <div class="col-sm-12">
                <input type="email" name="email" autocomplete="off"  class="form-control" required id="email" value="{{$data->email}}" disabled>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-12 col-form-label"><b>Nomor Telepon</b></label>
              <div class="col-sm-12">
                <input type="text" name="telp" autocomplete="off"  class="form-control" id="telepon" value="{{$data->telp}}">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-6 col-form-label"><b>Alamat Tinggal</b></label>
            <div class="col-sm-12">
              <input type="text" name="alamat" class="form-control" id="alamat" value="{{$data->alamat}}">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4 col-form-label"><b>Foto</b></label>
            <div class="col-sm-12">
              <div class="body">
                  <input type="file" class="dropify" data-default-file="{{asset($data->photo)}}" name="photos" data-allowed-file-extensions="jpg jpeg" data-max-file-size="1M">
              </div>
              <label class="col-form-label"><small>* format file <b>.jpg</b> atau <b>.jpeg</b>, ukuran maksimal 1MB</small></label>
            </div>
          </div>

          {{ csrf_field() }}
      </div>
      <div class="modal-footer btn-sm">
        <button type="submit" class="btn btn-warning">Simpan</button>
        <button class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
      </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-pendidikan" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitlependidikan">TAMBAH RIWAYAT PENDIDIKAN</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" action="#" id="formpendidikan" method="post" enctype="multipart/form-data">
          <input type="hidden" class="form-control" name="idpegawai" value="{{$data->id}}">
          <input type="hidden" class="form-control" name="jenispegawai" value="1">
          <input type="hidden" class="form-control" name="id" id="pendidikanid" value="">
          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Jenjang Pendidikan</b></label>
            <div class="col-sm-12">
              <select class="form-control show-tick ms" name="idpendidikan" id="pendidikanidpendidikan" style="width:100%" required data-placeholder="Select">
                @foreach($pendidikan as $p)
                  <option value="{{$p->id}}">{{$p->nama}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Asal Sekolah/Kampus</b></label>
            <div class="col-sm-12">
              <select class="form-control show-tick ms" name="asalkampus" id="pendidikanasalkampus" style="width:100%" required data-placeholder="Select">
                    <option value="1">Dalam Negeri</option>
                    <option value="2">Luar Negeri</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Nama Sekolah/Kampus</b></label>
            <div class="col-sm-12">
              <input type="text" name="namakampus" class="form-control" id="pendidikannamakampus" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Nama Program Studi</b></label>
            <div class="col-sm-12">
              <input type="text" name="prodi" class="form-control" id="pendidikanprodi">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4 col-form-label"><b>Tanggal Lulus</b></label>
            <div class="col-sm-12">
              <div class="input-group masked-input">
                  <div class="input-group-prepend">
                      <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                  </div>
                  <input type="text" name="tgllulus" class="form-control datesingle" id="pendidikantgllulus">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Dokumen Ijazah</b></label>
            <div class="col-sm-12">
              <div class="body">
                  <input type="file" class="dropify" name="ijazah"  data-allowed-file-extensions="pdf" data-max-file-size="2M">
              </div>
              <label class="col-form-label"><small>* format file <b>.pdf</b>, ukuran maksimal 2MB</small></label>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Dokumen Transkrip Nilai</b></label>
            <div class="col-sm-12">
              <div class="body">
                  <input type="file" class="dropify" name="transkrip" data-allowed-file-extensions="pdf" data-max-file-size="2M">
              </div>
              <label class="col-form-label"><small>* format file <b>.pdf</b>, ukuran maksimal 2MB</small></label>
            </div>
          </div>

          {{ csrf_field() }}
      </div>
      <div class="modal-footer btn-sm">
        <button type="submit" class="btn btn-warning">Simpan</button>
        <button class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
      </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-tanggungan" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">TAMBAH TANGGUNGAN</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_validation" class="forms-sample" action="{{route('md.guru.tanggungan.store')}}" method="post" enctype="multipart/form-data" id="formguru">
          <input type="hidden" class="form-control" name="idpegawai" value="{{$data->id}}">
          <input type="hidden" class="form-control" name="jenispegawai" value="1">
          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Jenis Tanggungan</b></label>
            <div class="col-sm-12">
              <select class="form-control show-tick ms select2" name="jenis" style="width:100%" required data-placeholder="Select">
                  <option selected disabled>Pilih</option>
                  <option value="1">{{$data->jk == 1 ? 'Istri':'Suami'}}</option>
                  <option value="2">Anak</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Nama</b></label>
            <div class="col-sm-12">
                <input type="text" name="nama" required class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Tanggal Lahir</b></label>
            <div class="col-sm-12">
              <div class="input-group masked-input">
                  <div class="input-group-prepend">
                      <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                  </div>
                  <input type="text" name="tgllahir" class="form-control datesingle">
              </div>
            </div>
          </div>
          {{ csrf_field() }}
      </div>
      <div class="modal-footer btn-sm">
        <button type="submit" class="btn btn-warning">Simpan</button>
        <button class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
      </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-user" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">TAMBAH USER</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_validation" class="forms-sample" action="{{route('md.user.store')}}" method="post" enctype="multipart/form-data" id="formguru">
          <input type="hidden" class="form-control" name="link" value="{{$data->id}}">
          <input type="hidden" class="form-control" name="role" value="2">
          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Username</b></label>
            <div class="col-sm-12">
              <input type="text" name="username" class="form-control" value="{{$data->email}}">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Password</b></label>
            <div class="col-sm-12">
                <input type="text" name="password" required class="form-control">
            </div>
          </div>
          {{ csrf_field() }}
      </div>
      <div class="modal-footer btn-sm">
        <button type="submit" class="btn btn-warning">Simpan</button>
        <button class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
      </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-jafa" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitlejafa">TAMBAH RIWAYAT PENDIDIKAN</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" action="#" id="formjafa" method="post" enctype="multipart/form-data">
          <input type="hidden" class="form-control" name="idguru" value="{{$data->id}}">
          <input type="hidden" class="form-control" name="id" id="jafaidjafung">

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Jabatan Fungsional</b></label>
            <div class="col-sm-12">
                <div class="disinijafung">

                </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Nomor SK Jabatan Fungsional</b></label>
            <div class="col-sm-12">
                <input type="text" name="nosk" id="jafanosk" class="form-control" value="">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>TMT Jabatan Fungsional</b></label>
            <div class="col-sm-12">
              <div class="input-group masked-input">
                  <div class="input-group-prepend">
                      <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                  </div>
                  <input type="text" name="tmt" class="form-control datesingle" id="jafatmt">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Dokumen Jabatan Fungsional</b></label>
            <div class="col-sm-12">
              <div class="body">
                  <input type="file" class="dropify" name="doks" data-allowed-file-extensions="pdf" data-max-file-size="2M">
              </div>
              <label class="col-form-label"><small>* format file <b>.pdf</b>, ukuran maksimal 2MB</small></label>
            </div>
          </div>

          {{ csrf_field() }}
      </div>
      <div class="modal-footer btn-sm">
        <button type="submit" class="btn btn-warning">Simpan</button>
        <button class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
      </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-serdos" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitleserdos">TAMBAH RIWAYAT PENDIDIKAN</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" action="#" id="formserdos" method="post" enctype="multipart/form-data">
          <input type="hidden" class="form-control" name="idguru" value="{{$data->id}}">
          <input type="hidden" class="form-control" name="id" id="serdosid">

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Nomor Sertifikat Serdos</b></label>
            <div class="col-sm-12">
              <input type="text" class="form-control" name="noserdos" id="serdosnomor" required value="">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4 col-form-label"><b>Tahun Lulus</b></label>
            <div class="col-sm-12">
              <div class="input-group masked-input">
                  <div class="input-group-prepend">
                      <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                  </div>
                  <input type="number" maxlength="4" name="thnlulus" class="form-control" id="serdosthnlulus">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Dokumen Sertifikat Serdos</b></label>
            <div class="col-sm-12">
              <div class="body">
                  <input type="file" class="dropify" name="doks" data-allowed-file-extensions="pdf" data-max-file-size="2M">
              </div>
              <label class="col-form-label"><small>* format file <b>.pdf</b>, ukuran maksimal 2MB</small></label>
            </div>
          </div>

          {{ csrf_field() }}
      </div>
      <div class="modal-footer btn-sm">
        <button type="submit" class="btn btn-warning">Simpan</button>
        <button class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
      </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-pangkat" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitlepangkat">TAMBAH RIWAYAT PENDIDIKAN</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" action="#" id="formpangkat" method="post" enctype="multipart/form-data">
          <input type="hidden" class="form-control" name="idpegawai" value="{{$data->id}}">
          <input type="hidden" class="form-control" name="jenispegawai" value="1">
          <input type="hidden" class="form-control" name="id" id="pangkatid">

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Pangkat</b></label>
            <div class="col-sm-12">
              <div class="pangkatpangkatdisini">

              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Nomor SK Inpassing</b></label>
            <div class="col-sm-12">
              <input type="text" name="nosk" value="" class="form-control" id="pangkatnosk">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4 col-form-label"><b>TMT Pangkat</b></label>
            <div class="col-sm-12">
              <div class="input-group masked-input">
                  <div class="input-group-prepend">
                      <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                  </div>
                  <input type="text" name="tmt" class="form-control datesingle" id="pangkattmt">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-12 col-form-label"><b>Dokumen SK Inpassing</b></label>
            <div class="col-sm-12">
              <div class="body">
                  <input type="file" class="dropify" name="doks" data-allowed-file-extensions="pdf" data-max-file-size="2M">
              </div>
              <label class="col-form-label"><small>* format file <b>.pdf</b>, ukuran maksimal 2MB</small></label>
            </div>
          </div>

          {{ csrf_field() }}
      </div>
      <div class="modal-footer btn-sm">
        <button type="submit" class="btn btn-warning">Simpan</button>
        <button class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
      </form>
      </div>
    </div>
  </div>
</div>


@endsection
@section('js')
<script>
$(document).ready(function() {
  $.get('{{route("s2.jafung")}}', function(data){
    $('.disinijafung').html(data);
  });

  $.get('{{route("s2.pangkat2")}}', function(data){
    $('.pangkatpangkatdisini').html(data);
  });


  $.get('{{route("s2.statusguru")}}', function(data){
    $('#idstatusgurudisini').html(data);
    $('#idstatusguru').val('{!!$data->idstatusguru!!}')
    $("#idstatusguru").select2({
      placeholder: "Pilih",
    });
  });

  $.get('{{route("s2.statuskerja")}}', function(data){
    $('#statuskerjadisini').html(data);
    $('#statuskerja').val('{!!$data->statuskerja!!}')
    $("#statuskerja").select2({
      placeholder: "Pilih",
    });
  });


  $('.btneditriwayatpendidikan').click(function(){
    var id = $(this).val();
    $('#modaltitlependidikan').text('UBAH RIWAYAT PENDIDIKAN')
    $.get('guru/riwayatpendidikan/edit/'+id, function(data){
      $('#pendidikanidpendidikan').val(data.idpendidikan)
      $('#pendidikanasalkampus').val(data.asalkampus)
      $('#pendidikannamakampus').val(data.namakampus)
      $('#pendidikanprodi').val(data.prodi)
      $('#pendidikantgllulus').val(data.tgllulus)
      $('#pendidikanid').val(data.id)
      $('#formpendidikan').prop('action','{{route("md.guru.riwayatpendidikan.update")}}')
    });
    // $('#pendidikanidpendidikan').select2()
    // $('#pendidikanasalkampus').select2()
  })

  $('#btnaddriwayatpendidikan').click(function(){
    $('#modaltitlependidikan').text('TAMBAH RIWAYAT PENDIDIKAN')
    $('#formpendidikan').prop('action','{{route("md.guru.riwayatpendidikan.store")}}')
  })

  $('#btnriwayatjafa').click(function(){
    $('#modaltitlejafa').text('TAMBAH JABATAN FUNGSIONAL')
    $('#formjafa').prop('action','{{route("md.guru.riwayatjafa.store")}}')
  })

  $('.btneditriwayatjafa').click(function(){
    var id = $(this).val();
    $('#modaltitlejafa').text('UBAH JABATAN FUNGSIONAL')
    $.get('guru/riwayatjafa/edit/'+id, function(data){
      $('#idjafung').val(data.idjafung)
      $('#jafatmt').val(data.tmt)
      $('#jafanosk').val(data.nosk)
      $('#jafaidjafung').val(data.id)
      $('#formjafa').prop('action','{{route("md.guru.riwayatjafa.update")}}')
    });
  })

  $('#btnaddserdos').click(function(){
    $('#modaltitleserdos').text('TAMBAH DATA SERDOS')
    $('#formserdos').prop('action','{{route("md.guru.serdos.store")}}')
  })

  $('.btneditserdos').click(function(){
    var id = $(this).val();
    $('#modaltitleserdos').text('UBAH DATA SERDOS')
    $.get('guru/serdos/edit/'+id, function(data){
      $('#serdosnomor').val(data.noserdos)
      $('#serdosthnlulus').val(data.thnlulus)
      $('#serdosid').val(data.id)
      $('#formserdos').prop('action','{{route("md.guru.serdos.update")}}')
    });
  })

  $('#btnnaddpangkat').click(function(){
    $('#modaltitlepangkat').text('TAMBAH KEPANGKATAN')
    $('#formpangkat').prop('action','{{route("md.guru.pangkat.store")}}')
  })

  $('.btneditpangkat').click(function(){
    var id = $(this).val();
    $('#modaltitlepangkat').text('UBAH KEPANGKATAN')
    $.get('guru/pangkat/edit/'+id, function(data){
      $('#idpangkat2').val(data.idpangkat)
      $('#pangkattmt').val(data.tmt)
      $('#pangkatid').val(data.id)
      $('#pangkatnosk').val(data.nosk)
      $('#formpangkat').prop('action','{{route("md.guru.pangkat.update")}}')
    });
  })

  tmt = '{{$data->tmtkerja}}';
  if (tmt == '') {
    $('#tmtkerja').val('')
  }
})
</script>
@stop
