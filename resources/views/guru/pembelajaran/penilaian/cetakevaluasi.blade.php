<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SLUA | Laporan Nilai Evaluasi - {{$mapel->nama}} ({{$kelas->nama}})</title>
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
    /* position: fixed; */
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
  .data-siswa td {
    vertical-align: middle;
  }
  .page_break {
    page-break-after: always;
  }
  .column {
    float: left;
  }

  /* Clear floats after the columns */
  .row:after {
    content: "";
    display: table;
    clear: both;
  }
  @page {
    margin-top: 190px;
  }
</style>

<div class="header">
  <?php
    $profil = App\Models\Profil::where('id',1)->first();;
  ?>
  <img src="{{asset('images/slua.png')}}" width="140" style="position:absolute; left:-10; top: -130">
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

  <center>
    <h3 style="margin-bottom: 0px; text-decoration:underline">REKAPITULASI NILAI EVALUASI</h3>
    <h4 style="margin-top: 5px; margin-bottom: 15px;">Tahun Ajaran {{$ta->tahun}} {{$ta->semester == 1 ? 'Ganjil':'Genap'}}</h4>
  </center>

  <table>
    <tr>
      <td style="width: 20%;">Mata Pelajaran</td>
      <td style="width: 1px">:</td>
      <td style="width: 60%;">{{$mapel->nama}}</td>
    </tr>
    <tr>
      <td>Kelas</td>
      <td style="width: 1px">:</td>
      <td>{{$kelas->nama}}</td>
    </tr>
    <tr>
      <td>Bulan</td>
      <td style="width: 1px">:</td>
      <td>{{App\Helper::bulan($bulan->created_at)}}</td>
    </tr>
  </table>
  <br>
  <table border="1" class="data-siswa">
    <thead>
      <tr>
        <th>NIS</th>
        <th>Nama</th>
        @foreach ($materi->wherein('idjenis', [2,3,4]) as $m)
        <th>{{$m->materi}}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      @foreach($siswa as $s)
        <tr>
          <td style="text-align: center">{{$s->nis}}</td>
          <td style="white-space: nowrap">{{$s->nama}}</td>
          <td style="white-space: nowrap">
            @foreach ($materi->where('idjenis', 2) as $m)
            <?php $eva = App\Models\LmsEvaluasi::with('materi')->where('idmateri', $m->id)->get(); ?>
              @foreach ($eva as $e)
                <?php $nil = App\Models\LmsSiswaEvaluasi::where('idevaluasi', $e->id)->get(); ?>
                @foreach ($nil->where('nis', $s->nis) as $n)
                  {{$n->nilai}}
                @endforeach
              @endforeach
            @endforeach
          </td>
          <td style="white-space: nowrap">
            @foreach ($materi->where('idjenis', 3) as $m)
            <?php $eva = App\Models\LmsEvaluasi::with('materi')->where('idmateri', $m->id)->get(); ?>
              @foreach ($eva as $e)
                <?php $nil = App\Models\LmsSiswaEvaluasi::where('idevaluasi', $e->id)->get(); ?>
                @foreach ($nil->where('nis', $s->nis) as $n)
                  {{$n->nilai}}
                @endforeach
              @endforeach
            @endforeach
          </td>
          <td style="white-space: nowrap">
            @foreach ($materi->where('idjenis', 4) as $m)
            <?php $eva = App\Models\LmsEvaluasi::with('materi')->where('idmateri', $m->id)->get(); ?>
              @foreach ($eva as $e)
                <?php $nil = App\Models\LmsSiswaEvaluasi::where('idevaluasi', $e->id)->get(); ?>
                @foreach ($nil->where('nis', $s->nis) as $n)
                  {{$n->nilai}}
                @endforeach
              @endforeach
            @endforeach
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</main>
