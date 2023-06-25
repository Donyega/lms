<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SLUA | Rekapitulasi Presensi - {{$data->mapel->nama}} ({{$data->kelas->nama}} {{$data->kelas->jenis->nama}})</title>
<style media="screen">
  table {
    border-collapse: collapse;
    width: 100%;
    font-family: "Times New Roman", Times, serif;
  }
  td{
    text-align:left;
    padding: 3px;
    vertical-align: top;
  }
  th{
    padding: 5px 1px !important;
    text-align:center;
  }
  ul {
    margin: 0px;
    padding-left: 13px;
    list-style-type: disc;
  }
  li {
    margin-bottom: 3px;
  }
  hr.noteline {
    border: 1px solid rgb(175, 175, 175) !important;
    margin-top: 0;
  }
  .note {
    color: rgb(125, 125, 125);
    font-size: 12px;
  }
  .header{
    margin-left: 15px;
    margin-right: 15px;
    margin-top: -160px !important;
    position: fixed;
  }
  main {
    font-size: 13px;
    margin-left: 15px !important;
    margin-right: 15px !important;
    margin-bottom: 5px;
  }
  footer {
    position: fixed;
    bottom: 40px; left: 25px; right: 25px;
    margin-top: 20px;
  }
  .date {
    
  }
  .page_break {
    page-break-after: always;
  }
  @page {
    margin-top: 190px;
  }
</style>

<div class="header">
  <?php
    $profil = App\Models\Profil::where('id',1)->first();
  ?>
  <img src="{{asset('images/slua.png')}}" width="140" style="position:absolute; left:-10; top:3">
  <div style="margin-bottom: -10px; text-align:center">
    <p style="font-weight: bold; font-size:12px !important; margin-bottom:10px; text-transform: uppercase">{{$profil->penyelenggara}}</p>
    <img src="{{asset('images/sluabali.jpg')}}" width="275">
    <p style="font-weight: bold; font-size:18px !important; margin-top:2px; font-family: Arial, Helvetica, sans-serif; text-transform: uppercase">{{$profil->nama}}</p>
    <p style="font-size:14px; margin-top:-15px; font-weight: bold; text-transform: uppercase">STATUS : TERAKREDITASI {{$profil->akreditasi}}</p>
    <p style="font-size:9px; margin-top:-10px;">Berdasarkan Ketetapan Badan SK BAP - Provinsi Bali No.{{$profil->nosk}}, Tanggal {{ (new \App\Helper)->tanggal($profil->tglsk) }}</p>
    <p style="font-size:9px; margin-top:-8px;">Alamat: {{$profil->alamat}} {{$profil->kodepos}}, Telp/Fax {{$profil->telpon}}</p>
    <p style="font-size:9px; margin-top:-9px;">website: {{$profil->website}} <span style="word-spacing: 20px;"> </span> e-mail: {{$profil->email}}</p>
  </div>
  <hr>
</div>

<main>

  <?php
   if(count($pertemuanke) > 16) {
     $halaman2 = 1;
   }else {
     $halaman2 = 0;
   }
  ?>
  <center>
    <h3 style="margin-bottom: 0px; text-decoration:underline">REKAPITULASI PRESENSI</h3>
    <h4 style="margin-top: 5px; margin-bottom: 15px;">Tahun Ajaran {{$data->ta->tahun}} {{$data->ta->semester == 1 ? 'Ganjil':'Genap'}}</h4>
  </center>

  <table>
    <tr>
      <td style="width:60px;">Mata Pelajaran</td>
      <td style="width:330px;">: {{$data->mapel->nama}}</td>
      <td style="width:50px;">Kelas</td>
      <td style="width:80px;">: {{$data->kelas->nama}} {{$data->kelas->jenis->nama}}</td>
    </tr>
    <tr>
      <td>Jenis Mata Pelajaran</td>
      <td>: {{$data->jenismapel->nama}}</td>
      <td>Jumlah Siswa</td>
      <td>: {{count($siswa)}}</td>
    </tr>
    <tr>
      <td>Guru</td>
      <td>
        <ul>
          @foreach ($data->jadwalguru as $jg)
            <li>{{$jg->guru->nama}}</li>
          @endforeach
        </ul>
      </td>
      <td>Jadwal</td>
      <td>
        : Hari {{$data->hari->nama}},
        @foreach ($data->detil as $d)
          <span style="display: block; padding-left: 7px">
            Pk. {{$d->jampelajaran->mulai}} - {{$d->jampelajaran->selesai}}
          </span>
        @endforeach
      </td>
    </tr>
  </table>
  <br>

  <table border="1">
    <thead>
      <tr>
        <th rowspan="2" width="50px">NIS</th>
        <th rowspan="2" >Nama Siswa</th>
        <th colspan="{{$halaman2 == 1 ? '16' : count($pertemuanke)}}" class="py-1">Pertemuan</th>
      </tr>
      <tr>
        <?php $no = 1; ?>
        @foreach($pertemuanke as  $p)
          @if($no < 17)
            <td style="width: 5px !important; text-align: center; pading: 1px !important;">
              <span style="font-size: 12px;"><b>{{$p->pertemuan}}</b></span><br>
              <span style="font-size: 10px;">{{date('d/m/y',strtotime($p->tanggal))}}</span>
            </td>
          @endif
          <?php $no++; ?>
        @endforeach
      </tr>
    </thead>

    <tbody>
      <?php $i=0; ?>
      @foreach($siswa as $s)
      <tr>
        <td style="text-align: center">{{$s->nis}}</td>
        <td>{{$s->nama}}</td>
        <?php $no = 1; ?>
        @foreach($pertemuanke as  $p)
        @if($no < 17)
          <td style="vertical-align: middle; text-align: center;">
            @foreach($presensi as $a)
              @if($a->pertemuan == $p->pertemuan && $a->nis == $s->nis)
                @if($a->hadir == 1)
                <img src="{{asset('images/ok.png')}}" width="17px" alt="">
                @else
                <img src="{{asset('images/x.png')}}" width="8px" alt="">
                @endif
              @endif
            @endforeach
          </td>
        @endif
        <?php $no++; ?>
        @endforeach
      </tr>
      <?php $i++; ?>
      @endforeach
    </tbody>
  </table>

  @if($halaman2 == 1)
    <div class="page_break"></div>
    <table border="1">
      <thead>
        <tr>
          <th rowspan="2" width="75px";>NIS</th>
          <th rowspan="2" >Nama Siswa</th>
          <th colspan="{{count($pertemuanke) - 16}}" class="py-1">Pertemuan</th>
        </tr>
        <tr>
          @for($i = 16; $i < count($pertemuanke); $i++)
            <td style="width: 5px !important; text-align: center; pading: 1px !important;">
              <span style="font-size: 12px;"><b>{{$pertemuanke[$i]->pertemuan}}</b></span><br>
              <span style="font-size: 10px;">{{date('d/m/y',strtotime($pertemuanke[$i]->tanggal))}}</span>
            </td>
          @endfor
        </tr>
      </thead>

      <tbody>
        @foreach($siswa as $s)
        <tr>
          <td>{{$s->nis}}</td>
          <td>{{$s->nama}}</td>
          @for($i = 16; $i < count($pertemuanke); $i++)
            <td style="vertical-align: middle; text-align: center;">
              @foreach($presensi as $a)
                @if($a->pertemuan == $pertemuanke[$i]->pertemuan && $a->nis == $s->nis)
                  @if($a->hadir == 1)
                  <img src="{{asset('images/ok.png')}}" width="17px" alt="">
                  @else
                  <img src="{{asset('images/x.png')}}" width="8px" alt="">
                  @endif
                @endif
              @endforeach
            </td>
          @endfor
        </tr>
        @endforeach
      </tbody>
    </table>
  @endif

  <div class="page_break"></div>

  <center>
    <h3 style="margin-bottom: 0px;">REKAPITULASI KEHADIRAN</h3>
  </center>
  <br>
  <table border="1">
    <thead>
      <tr>
        <th width="50px";>NIS</th>
        <th>Nama Siswa</th>
        <th>Persentase</th>
        <th>Jumlah Hadir</th>
        <th>Jumlah<br>Tidak Hadir</th>
        <th>Sakit</th>
        <th>Izin</th>
        <th>Alpa</th>
      </tr>
    </thead>

    <tbody>
      @foreach($siswa as $s)
      <tr>
        <td style="text-align: center">{{$s->nis}}</td>
        <td style="white-space: nowrap;">{{$s->nama}}</td>
        <td style="text-align: center;">
          <?php
            $hadir = count($presensi->where('hadir',1)->where('nis',$s->nis));
            $sakit = count($presensi->where('hadir',0)->where('nis',$s->nis)->where('catatan','Sakit'));
            $izin = count($presensi->where('hadir',0)->where('nis',$s->nis)->where('catatan','Izin'));
            $alpa = count($presensi->where('hadir',0)->where('nis',$s->nis)->wherein('catatan',['Alpa','',null]));
          ?>
          @if(count($pertemuanke) == 0 || $hadir == 0)
            0 %
          @else
            {{round($hadir/count($pertemuanke) * 100,2)}} %
          @endif
        </td>
        <td style="text-align: center;">{{$hadir}}</td>
        <td style="text-align: center;">{{count($pertemuanke) - $hadir}}</td>
        <td style="text-align: center;">{{$sakit == 0 ? '-' : $sakit}}</td>
        <td style="text-align: center;">{{$izin == 0 ? '-' : $izin}}</td>
        <td style="text-align: center;">{{$alpa == 0 ? '-' : $alpa}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</main>
