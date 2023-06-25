@extends('layouts.menu')

@section('title-head', 'Detail Pengumpulan Tugas')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Detail Pengumpulan Tugas
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{route('home')}}"><i data-feather="home"></i></a>
              </li>
              <li class="breadcrumb-item"><a href="{{route('swa.penugasan')}}">Penugasan</a></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
    $sekarang = strtotime('now');
    $batas = $data->batastgl.' '.$data->batasjam;
    $batas = strtotime($batas);
    $kumpul = $data->tugassiswa->where('nis',auth::user()->siswa->nis)->first();
    if ($kumpul != null) {
      $tglkumpul = strtotime($kumpul->created_at);
    }
  ?>

  <div class="content-body">
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <span class="font-small-3 text-muted">{{$data->jadwal->mapel->nama}}</span>
                <h5 class="font-weight-bolder mb-25">
                  {{$data->judul}}
                </h5>
                <span class="font-small-3 text-muted">{{$data->user->pegawai->nama}}</span>
              </div>
              @if ($kumpul != null && $kumpul->nilai != null)
                <div class="avatar bg-light-primary text-right ml-25 p-50">
                  <div class="avatar-content font-medium-3">{{$kumpul->nilai}}</div>
                </div>
              @endif
            </div>
            <div class="mt-50 border-bottom-primary border-bottom-1 d-md-none"></div>
            <div class="row my-50">
              <div class="ml-1 border-left-primary border-left-3 d-none d-md-inline"></div>
              <div class="col">
                @if($data->idjenis == 1)
                  <div class="badge badge-light-info mb-50"><i data-feather="user"></i> Individu</div>
                @else
                  <div class="badge badge-light-info mb-50"><i data-feather="users"></i> Kelompok</div>
                @endif
                <p class="mb-50">{{$data->keterangan}}</p>
                <span class="d-block mb-25 font-small-3">
                  <i data-feather="calendar" style="margin-top:-2px"></i> {{(new \App\Helper)->tanggal($data->batastgl)}} | {{date('H:i',strtotime($data->batasjam))}} WITA
                </span>
                
                @if ($kumpul == null)
                  <div class="badge badge-light-danger mb-50 mb-lg-0"><i data-feather="edit-2"></i> Belum Dikumpulkan</div>
                @else
                  <footer class="blockquote-footer mb-25">
                    Dikumpulkan {{(new \App\Helper)->tanggal($kumpul->created_at)}}, {{date('H:i',strtotime($kumpul->created_at))}}

                    @if ($tglkumpul > $batas)
                      <div class="badge badge-light-danger mb-50 mb-lg-0">Terlambat</div>
                    @else
                      <div class="badge badge-light-success mb-50 mb-lg-0">Tepat Waktu</div>
                    @endif
                  </footer>
                  <hr>
                  
                  @if ($data->idjenis == 2)
                    <span class="mb-50">Anggota Kelompok</span>
                    @if($kumpul->iduser == auth::user()->id)
                      <button class="btn badge badge-light-warning" data-toggle="modal" data-target="#modal-anggota"><i data-feather="plus"></i> Tambah Anggota</button>
                    @endif
                    <div class="dropdown-divider"></div>
                    @foreach($kumpul->kelompok as $kelompok)
                      @if($kelompok->nis != auth::user()->siswa->nis)
                        <?php
                          $photo = asset('images/user-lms.png');
                          if ($kelompok->siswa == null) {
                            if ($kelompok->siswa->detil->photo != 'images/user-default.png') {
                              $photo = 'http://siakad.slua.ac.id/'.$kelompok->siswa->detil->photo;
                            }
                          }
                          $nama = $kelompok->siswa->nama;
                        ?>
                        <div class="d-flex align-items-center">
                          <div class="avatar-lecture">
                            <img src="{{$photo}}" width="100px">
                          </div>
                          <div class="col px-0">
                            <div class="d-flex justify-content-between align-items-center">
                              <div>
                                <span><b>{{$nama}}</b></span>
                                <span class="d-block font-small-2">{{$kelompok->nis}}</span>
                              </div>
                              @if($kelompok->iduser == auth::user()->id)
                                <form class="d-inline ml-25" method="post" action="{{route('swa.penugasan.deletkelompok')}}" onsubmit="return confirm('Lanjutkan proses hapus anggota {{$nama}}?')">
                                  <input type="hidden" name="idjenis" value="{{$data->idjenis}}">
                                  <button class="btn btn-sm btn-icon btn-outline-danger" name="id" value="{{$kelompok->id}}" title="Hapus Anggota"><i data-feather="user-x"></i></button>
                                  {{ csrf_field() }}
                                </form>
                              @endif
                            </div>
                          </div>
                        </div>
                        <div class="dropdown-divider"></div>
                      @endif
                    @endforeach
                  @endif
                @endif
              </div>
            </div>
          </div>
        </div>
        @if ($kumpul != null && $kumpul->nilai != null)
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Detail Penilaian</h5>
            </div>
            <div class="card-body">
              <div class="alert alert-primary mb-0" role="alert">
                <h4 class="alert-heading"><i data-feather="check-circle" style="margin-top: -2px"></i> CATATAN</h4>
                <div class="alert-body">
                  {{$kumpul->komentar}}
                </div>
              </div>
            </div>
          </div>
        @endif
      </div>
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">Pengumpulan</h5>
            @if ($kumpul == null && $sekarang > $batas)
              <div class="badge badge-light-danger">Terlewati</div>
            @elseif ($kumpul != null && $tglkumpul > $batas)
              <div class="badge badge-light-danger">Terlambat</div>
            @endif
          </div>
          <div class="card-body">
            <button class="btn btn-block btn-assignment" data-toggle="modal" data-target="#modal-dokumen"><i data-feather="plus"></i> Unggah Dokumen</button>
          </div>
        </div>
        <?php
        if ($kumpul != null) {
          if ($data->idjenis == 1) {
            $dokumen = $kumpul->dokumenindividu;
          }else {
            $dokumen = $kumpul->dokumenkelompok;
          }
        }else {
          $dokumen = array();
        }
        ?>
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">Dokumen Tugas</h5>
          </div>
          <div class="card-body">
            @if (count($dokumen) > 0)
              @foreach($dokumen as $d)
                <div class="card col border-secondary border-left-3 mb-75 py-50">
                  <div class="d-flex justify-content-between align-items-center">
                    <a href="{{asset($d->dokumen)}}">
                      <p class="font-small-2 mb-25" style="line-height: 1rem">
                        {{$d->nama}}
                      </p>
                      <footer class="blockquote-footer font-small-1">
                        {{(new \App\Helper)->tanggal($d->created_at)}}
                      </footer>
                    </a>
                    <form class="d-inline" method="post" action="{{route('swa.penugasan.deletedokumen')}}" onsubmit="return confirm('Lanjutkan proses hapus dokumen {{$d->nama}}?')">
                      <input type="hidden" name="idjenis" value="{{$data->idjenis}}">
                      <button class="btn btn-sm btn-icon btn-outline-danger" name="id" value="{{$data->idjenis == 1 ? $d->id:$d->idkelompok}}" title="Hapus Dokumen"><i data-feather="trash-2"></i></button>
                      {{ csrf_field() }}
                    </form>
                  </div>
                </div>
              @endforeach
            @else
              <div class="card col border-secondary mb-0 py-2">
                <div class="text-muted text-center">
                  <i data-feather="cloud-off"></i> Belum Diunggah
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('modal')
<div class="modal fade text-left" id="modal-dokumen" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title-dokumen">Tambah Dokumen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="forms-sample form-dokumen" action="{{route('swa.penugasan.store')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idjenis" value="{{$data->idjenis}}">
        <input type="hidden" name="idpenugasan" value="{{$data->id}}">
        <input type="hidden" name="idjadwal" value="{{$data->idjadwal}}">
        <input type="hidden" name="nis" value="{{auth::user()->siswa->nis}}">
        <div class="modal-body">
          <div class="row">
            @if($kumpul == null && $data->idjenis == 2)
              <div class="col-xl-12 mb-1">
                <div class="form-group">
                  <label><b>Pilih Kelompok</b></label>
                  <select class="form-control kelompok" multiple="true" name="kelompok[]" data-placehorder="Pilih" required>
                    <option></option>
                    @foreach($sws as $m)
                      <option value="{{$m->nis}}">{{$m->nis}} - {{$m->nama}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            @endif
            <div class="col-xl-12 mb-1">
              <div class="form-group">
                <label><b>Nama Dokumen</b></label>
                <input type="text" class="form-control" name="namadokumen" id="namadokumen" autocomplete="off" required>
              </div>
            </div>

            <div class="col-xl-12">
              <div class="form-group dokumen">
                <label><b>Pilih Dokumen</b></label>
                <input type="file" name="dokumen" class="dropify" id="dokumen" data-allowed-file-extensions="doc docx pdf ppt pptx zip" data-max-file-size="5M">
                <label>fomat file <b>.doc .docx .pdf .ppt .pptx</b> atau <b>.zip</b> ukuran maksimal <b>5MB</b></label>
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


<div class="modal fade text-left" id="modal-anggota" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title-dokumen">Tambah Anggota</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="forms-sample form-dokumen" action="{{route('swa.penugasan.storeanggota')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idjenis" value="{{$data->idjenis}}">
        <input type="hidden" name="idpenugasan" value="{{$data->id}}">
        <input type="hidden" name="idjadwal" value="{{$data->idjadwal}}">
        <input type="hidden" name="nis" value="{{auth::user()->siswa->nis}}">
        <div class="modal-body">
          <div class="row">
            <div class="col-xl-12 mb-1">
              <div class="form-group">
                <label><b>Pilih Kelompok</b></label>
                <select class="form-control kelompok" multiple="true" name="kelompok[]" data-placehorder="Pilih" required>
                  <option></option>
                  @foreach($sws as $m)
                    <option value="{{$m->nis}}">{{$m->nis}} - {{$m->nama}}</option>
                  @endforeach
                </select>
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

@endsection

@section('jspage')
<script>
$(document).ready(function() {
  $('.kelompok').select2({
    placeholder:"Pilih"
  })
});
</script>
@stop
