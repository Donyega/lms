<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SLUA | Presensi - {{$kelas->nama}} {{$kelas->jenis->nama}}</title>
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
    border: 1px solid rgb(165, 165, 165) !important;
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
    font-size: 12px;
    margin-left: 15px;
    margin-right: 15px;
    margin-bottom: 15px;
  }
  footer {
    position: fixed;
    bottom: 40px; left: 25px; right: 25px;
    margin-top: 20px;
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
  <center>
    <h3 style="margin-bottom: 0px; text-decoration:underline">PRESENSI</h3>
    <h4 style="margin-top: 5px; margin-bottom: 15px;">Tahun Ajaran {{$ta->tahun}} {{$ta->semester == 1 ? 'Ganjil':'Genap'}}</h4>
  </center>

  <table>
    <tr>
      <td style="width:60px;">Kelas</td>
      <td style="width:270px;">: {{$kelas->nama}} {{$kelas->jenis->nama}}</td>
      <td style="width:60px;">Peminatan</td>
      <td style="width:60px;">: {{$kelas->idminat == 0 ? '-' : $kelas->minat->nama}}</td>
    </tr>
    <tr>
      <td>Wali Kelas</td>
      <td>: {{$kelas->wali->nama}}</td>
      <td>Jumlah Siswa</td>
      <td>: {{count($data)}}</td>
    </tr>
    <tr>
      <td>Hari / Tanggal</td>
      <td>: {{$tgl}}</td>
    </tr>
  </table>
  <br>
  <table border="1">
    <thead>
      <tr>
        <th>No</th>
        <th>NIS</th>
        <th>Nama Siswa</th>
        <th>Jenis Kelamin</th>
        <th colspan="5" style="width:200px;">Keterangan</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; ?>
      @foreach($data as $d)
        <tr>
          <td style="text-align: center">{{$no}}</td>
          <td style="text-align: center">{{$d->nis}}</td>
          <td>{{$d->nama}}</td>
          <td style="text-align: center">{{$d->jk == 'L' ? 'Laki-laki' : 'Perempuan'}}</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <?php $no++; ?>
      @endforeach
    </tbody>
  </table>

</main>
