<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SLUA | Kartu Pelajar - {{$data->nama}}</title>
<style media="screen">
  @page {
    padding: 0px;
    margin: 0px;
  }
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  p {
    margin: 0;
  }
  small {
    font-size: 80%;
    margin: 0 0 1px 0;
  }
  table {
    border-collapse: collapse;
    font-size: 7px;
    font-weight: bold;
  }
  td{
    text-align:left;
    padding: 1px 2px;
    vertical-align: top;
  }
  th{
    padding: 5px 1px !important;
    text-align:center;
  }
  hr.noteline {
    border: 1px solid rgb(175, 175, 175) !important;
    margin-bottom: 3px;
  }
  .cardtitle {
    position: absolute;
    width: 120px;
    text-align: left;
    font-size: 12px;
    font-weight: bold;
    left: 130;
    top: 25;
    z-index: 1;
    color: #fff;
  }

  .namasekolah {
    position: absolute;
    width: 195px;
    text-align: left;
    font-size: 8.5px;
    left: 30;
    top: 11;
    line-height: 1em;
    z-index: 1;
    color: #000;
  }
  .nama {
    position: absolute;
    width: 115px;
    left: 5;
    top: 95;
    z-index: 1;
    font-size: 8px;
    text-align: center;
    color: #088241;
    text-transform: uppercase;
    line-height: 1em;
  }
  .bio {
    position: absolute;
    width: 135px;
    text-align: left;
    font-size: 8px;
    left: 117;
    top: 50;
    z-index: 1;
    color: #fff;
  }
  .backid {
    padding: 1px 11px;
    background-repeat: no-repeat;
    background-size: 90px 10px;
  }
  .picture {
    position: absolute;
    text-align: center;
    vertical-align: center;
    width: 34;
    height: 46;
    left: 30;
    top: 40;
    z-index: 5;
    overflow: hidden !important;
    padding: 1px;
    border: 2px solid #088241 ;
    border-radius: 7px;
  }
  .info p {
    margin: 0;
  }
  .status {
    position: absolute;
    text-align: right;
    font-size: 5px;
    padding: 1px;
    width: 85px;
    left: 155;
    top: 120;
    z-index: 1;
    color: #fff;
  }
</style>

<img src="{{asset('images/card-back.jpg')}}" width="100%" style="position: absolute; z-index: -1; left:0; top:0">

<img src="{{asset('images/slua.png')}}" width="25" style="position: absolute; z-index: 1; left:8; top:8">

<div class="namasekolah">
  SMA (SLUA) Saraswati 1<br>
  Denpasar
</div>

<div class="picture">
  <img alt="Foto" width="100%" src="{{$data->detil->photo == null ? asset('images/user-default.jpg') : asset($data->detil->photo)}}" style="border-radius: 6px; z-index:2">
</div>

<div class="cardtitle">
  KARTU PELAJAR
</div>

<div class="nama">
  <b>{{$data->nama}}</b><br><br>
  <span style="color: #000"><b>{{$data->nis}}</b></span>
</div>

<div class="bio">
  <table>
    <tr>
      <td style="width: 50px;">NISN</td>
      <td style="width: 1px; padding-right:0px;">:</td>
      <td>{{$data->nisn}}</td>
    </tr>
    <tr>
      <td style="white-space:nowrap">Tempat/Tgl Lahir</td>
      <td>:</td>
      <td>{{$data->tplahir}} /<br> {{(new \App\Helper)->tanggal($data->tglahir)}}</td>
    </tr>
    <tr>
      <td>Jenis Kelamin</td>
      <td>:</td>
      <td>{{$data->jk == 'L' ? 'Laki-laki' : 'Perempuan'}}</td>
    </tr>
    <tr>
      <td>Agama</td>
      <td>:</td>
      <td>{{$data->agama->nama}}</td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td>:</td>
      <td style="white-space: normal">{{$data->alamat}}</td>
    </tr>
  </table>
</div>

<div class="status">
  Berlaku selama menjadi siswa<br>
  SMA (SLUA) Saraswati 1 Denpasar
</div>

