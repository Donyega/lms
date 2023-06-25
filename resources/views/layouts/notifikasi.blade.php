{{-- select data --}}
<?php
  $idta = App\Helper::idta();
  $hariini = date('Y-m-d');
  $periode = date('Y-m-d', strtotime('-31 days', strtotime($hariini)));

  if (auth::user()->role == 3) {
    $siswa = App\Models\Siswa::with('kelas')->where('id',auth::user()->link)->first();
    $data = App\Models\Pengumuman::where('idjenis',1)->where('status',1)->where('idta',$idta)
          ->leftjoin('pengumuman_siswas','pengumuman_siswas.idpengumuman','pengumumans.id')
          ->wherein('idtingkat',[0,$siswa->kelas->idtingkat])
          ->wherein('idkelas',[0,$siswa->idkelas])
          ->where('tglpublish','>',$periode)
          ->select('pengumumans.*')
          ->orderby('tglpublish','desc')
          ->get();
  }else {
    $data = App\Models\Pengumuman::where('idjenis',2)->where('status',1)
          ->leftjoin('pengumuman_pegawais','pengumuman_pegawais.idpengumuman','pengumumans.id')
          ->wherein('jenis',[auth::user()->pegawai->jenis,3])
          ->wherein('idpegawai',[0,auth::user()->link])
          ->where('tglpublish','>',$periode)
          ->select('pengumumans.*')
          ->orderby('tglpublish','desc')
          ->get();
  }
?>

{{-- view data pengumuman --}}
<li class="nav-item dropdown dropdown-notification mr-25 mr-lg-1 mr-md-1">
  <a class="nav-link" data-toggle="dropdown">
    <i class="ficon" data-feather="bell"></i>
    @if (count($data) > 0)
      <span class="badge badge-pill badge-danger badge-up">{{count($data)}}</span>
    @endif
  </a>
  <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right mt-75 mt-lg-25">
    <li class="dropdown-menu-header">
      <div class="dropdown-header d-flex">
        <h4 class="notification-title mb-0 mr-auto">Pengumuman</h4>
        @if (count($data) > 0)
          <div class="badge badge-pill badge-light-primary">{{count($data)}} Pengumuman</div>
        @else
          <div class="badge badge-pill badge-light-dark">Belum Ada Pengumuman</div>
        @endif
      </div>
      <small class="text-muted d-block pb-50" style="margin-top: -17px; padding-left: 20px"><i>* dalam 1 bulan terakhir</i></small>
    </li>
    @if (count($data) > 0)
      <li class="scrollable-container media-list">
        @foreach ($data as $d)
          <a class="d-flex" href="{{ route('arsip.pengumuman.detil', $d->id) }}">
            <div class="media d-flex align-items-start">
              <div class="media-left">
                <div class="avatar">
                  <img src="{{asset($d->gambar)}}" width="32" height="32">
                </div>
              </div>
              <div class="media-body">
                @php
                  $strlenitem = Str::length($d->judul);
                  if ($strlenitem > 40) {
                    $judul_cut = substr($d->judul, 0, 40);
                    if ($judul_cut[39] != ' ') {
                      $new_pos = strrpos($judul_cut, ' ');
                      $judul_cut = substr($d->judul, 0, $new_pos);
                      $judul_cut = $judul_cut.'...';
                    }else {
                      $judul_cut = substr($d->judul, 0, 39);
                      $judul_cut = $judul_cut.'...';
                    }
                  }else {
                    $judul_cut = $d->judul;
                  }
                @endphp
                <p class="media-heading">
                  <span class="font-weight-bolder">{{$judul_cut}}
                </p>
                <small class="notification-text">{{(new \App\Helper)->tanggal($d->tglpublish)}}</small>
              </div>
            </div>
          </a>
        @endforeach
      </li>
      <li class="dropdown-menu-footer">
        <a class="btn btn-success btn-block" href="{{route('arsip.pengumuman')}}"><i data-feather="info"></i> Tampilkan Semua Pengumuman</a>
      </li>
    @endif
  </ul>
</li>