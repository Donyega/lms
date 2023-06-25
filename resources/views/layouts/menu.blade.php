@extends('layouts.master')
@section('menu')
<?php
  $ta = (new \App\Helper)->ta();
  if(auth::user()->role == 2) {
    $jadwal = App\Models\JadwalPelajaran::with(['mapel','kelas', 'guru'])
            ->leftjoin('jadwal_pelajaran_gurus','jadwal_pelajaran_gurus.idjadwal','jadwal_pelajarans.id')
            ->leftjoin('md_mapels','md_mapels.id','jadwal_pelajarans.idmapel')
            ->where('idguru',auth::user()->pegawai->id)
            ->where('idta',$ta->id)
            ->select('jadwal_pelajarans.*')
            ->orderby('md_mapels.nama','asc')
            ->get();
  }else {
    $jadwal = App\Models\JadwalPelajaran::with(['mapel','kelas','guru'])
            ->leftjoin('md_mapels','md_mapels.id','jadwal_pelajarans.idmapel')
            ->leftjoin('jadwal_pelajaran_detils','jadwal_pelajaran_detils.idjadwal','jadwal_pelajarans.id')
            ->where('jadwal_pelajarans.idkelas', auth::user()->siswa->idkelas)
            ->where('jadwal_pelajarans.idta',$ta->id)
            ->select('jadwal_pelajarans.*')
            ->orderby('md_mapels.nama','asc')
            ->get();
  }
?>
{{-- menu --}}
<li class="{{ request()->is('home*') ? 'active' : '' }} nav-item"><a class="d-flex align-items-center" href="{{route('home')}}"><i data-feather="home"></i><span class="menu-title text-truncate">Dashboard</span></a></li>

@can('masterdata')
<li class="{{request()->is('masterdata*') ? 'active open' : ''}} nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="layers"></i><span class="menu-title text-truncate">Master Data</span></a>
  <ul class="menu-content">
    <li class="{{ request()->is('masterdata/siswa*') ? 'active' : '' }}">
      <a class="d-flex align-items-center" href="{{route('md.siswa')}}"><i data-feather="{{ request()->is('masterdata/siswa*') ? 'disc' : 'circle' }}"></i><span class="menu-item text-truncate">Peserta Didik</span></a>
    </li>
    <li class="{{ request()->is('masterdata/guru*') ? 'active' : '' }}">
      <a class="d-flex align-items-center" href="{{route('md.guru')}}"><i data-feather="{{ request()->is('masterdata/guru*') ? 'disc' : 'circle' }}"></i><span class="menu-item text-truncate">Pendidik</span></a>
    </li>
    {{-- <li class="{{ request()->is('masterdata/pegawai*') ? 'active' : '' }}">
      <a class="d-flex align-items-center" href="{{route('md.pegawai')}}"><i data-feather="{{ request()->is('masterdata/pegawai*') ? 'disc' : 'circle' }}"></i><span class="menu-item text-truncate">Pegawai</span></a>
    </li> --}}
    <li class="{{ request()->is('masterdata/ta*') ? 'active' : '' }}">
      <a class="d-flex align-items-center" href="{{route('md.ta')}}"><i data-feather="{{ request()->is('masterdata/ta*') ? 'disc' : 'circle' }}"></i><span class="menu-item text-truncate">Tahun Ajaran</span></a>
    </li>
    <li class="{{ request()->is('masterdata/matapelajaran*') ? 'active' : '' }}">
      <a class="d-flex align-items-center" href="{{route('md.mapel')}}"><i data-feather="{{ request()->is('masterdata/mapel*') ? 'disc' : 'circle' }}"></i><span class="menu-item text-truncate">Mata Pelajaran</span></a>
    </li>
    <li class="{{ request()->is('masterdata/kelas*') ? 'active' : '' }}">
      <a class="d-flex align-items-center" href="{{route('md.kelas')}}"><i data-feather="{{ request()->is('masterdata/kelas*') ? 'disc' : 'circle' }}"></i><span class="menu-item text-truncate">Kelas</span></a>
    </li>
    <li class="{{ request()->is('masterdata/kurikulum*') ? 'active' : '' }}">
      <a class="d-flex align-items-center" href="{{route('md.kurikulum')}}"><i data-feather="{{ request()->is('masterdata/kurikulum*') ? 'disc' : 'circle' }}"></i><span class="menu-item text-truncate">Kurikulum</span></a>
    </li>
    <li class="{{ request()->is('masterdata/jadwalpelajaran*') ? 'active' : '' }}">
      <a class="d-flex align-items-center" href="{{route('md.jadwal')}}"><i data-feather="{{ request()->is('masterdata/jadwalpelajaran*') ? 'disc' : 'circle' }}"></i><span class="menu-item text-truncate">Jadwal</span></a>
    </li>
  </ul>
</li>
@endcan
@can('adminakademik')
  <li class="{{request()->is('laporan*') ? 'active open' : ''}} nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file"></i><span class="menu-title text-truncate">Laporan</span></a>
    <ul class="menu-content">
      <li class="{{ request()->is('laporan/presensi*') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{route('laporan.presensi')}}"><i data-feather="{{ request()->is('laporan/presensi*') ? 'disc' : 'circle' }}"></i><span class="menu-item text-truncate">Presensi</span></a>
      </li>
      <li class="{{ request()->is('laporan/penilaian*') ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{route('laporan.penilaian')}}"><i data-feather="{{ request()->is('laporan.penilaian') ? 'disc' : 'circle' }}"></i><span class="menu-item text-truncate">Nilai</span></a>
      </li>
    </ul>
  </li>
@endcan
@can('adminakademik')
<li class="{{request()->is('pengaturan*') ? 'active open' : ''}} nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="settings"></i><span class="menu-title text-truncate">Pengaturan</span></a>
  <ul class="menu-content">
    <li class="{{request()->is('pengaturan/profilsekolah*') ? 'active' : ''}}">
      <a class="d-flex align-items-center" href="{{route('profilsekolah')}}"><i data-feather="{{ request()->is('pengaturan/profilsekolah*') ? 'disc' : 'circle' }}"></i><span class="menu-item text-truncate">Tampilan</span></a>
    </li>
  </ul>
</li>
@endcan
@if (count($jadwal) > 0)
  <li class="{{ request()->is('pembelajaran*') ? 'active open' : '' }} nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="book-open"></i><span class="menu-title text-truncate">Pembelajaran</span></a>
    <ul class="menu-content">
      <?php $i = 1; ?>
      @foreach ($jadwal as $j)
        @if (Auth::user()->role == 2)
          <li class="{{ request()->is('pembelajaran/'.$j->id.'*') ? 'active' : '' }} {{ request()->is('pembelajaran/evaluasi/'.$j->id.'*') ? 'active' : '' }} {{ request()->is('pembelajaran/evaluasi/peserta/'.$j->id.'*') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{route('pembelajaran',[$j->id,$i])}}" title="{{$j->mapel->nama.' - '.$j->kelas->nama}}"><i data-feather="{{ request()->is('pembelajaran/'.$j->id.'/'.$i.'*') ? 'disc' : 'circle' }}"></i><span class="menu-item text-truncate">{{$j->mapel->nama}} <small class="text-muted"><i data-feather="chevrons-right" class="mr-0"></i> {{$j->kelas->nama}}</small></span></a>
          </li>
        @else
          <li class="{{ request()->is('siswa/pembelajaran/'.$j->id.'*') ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{route('swa.pembelajaran',[$j->id,$i])}}"><i data-feather="{{ request()->is('pembelajaran/'.$j->id.'/'.$i.'*') ? 'disc' : 'circle' }}"></i><span class="menu-item text-truncate">{{$j->mapel->nama}}</a>
          </li>
        @endif
        <?php $i++; ?>
      @endforeach
    </ul>
  </li>
@endif
<li class="{{ request()->is('datadiri*') ? 'active' : '' }} nav-item"><a class="d-flex align-items-center" href="{{route('datadiri')}}"><i data-feather="user"></i><span class="menu-title text-truncate">Profil</span></a></li>

{{-- <li class="nav-item mb-3"><a class="d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i data-feather="power"></i><span class="menu-title text-truncate">Logout</span></a></li> --}}

@endsection
