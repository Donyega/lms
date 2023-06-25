<!DOCTYPE html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Template Soal</title>
  <style media="screen">
    table {
      border-collapse: collapse;
      width: 100%;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 12px;

    }
    td{
      text-align:left;
      padding: 10px;
    }

    .row {
      display: flex;
      margin-left:-5px;
      margin-right:-5px;
    }

  </style>
<div class="row">
  <table>
    <tr>
      <th>Mata Pelajaran</th>
      <td>: {{$evaluasi->jadwal->mapel->nama}}</td>
    </tr>

    <tr>
      <th>Materi</th>
      <td>: {{$evaluasi->materi->materi}}</td>
    </tr>

  </table>
  <br>
  <table>
    <tr>
      <th>Kode</th>
      <th>Soal</th>
    </tr>
    <tbody>
    </tbody>
  </table>
</div>
