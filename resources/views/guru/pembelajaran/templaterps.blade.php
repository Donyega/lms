<!DOCTYPE html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Template RPS</title>
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
  <h5>Jenis Pertemuan</h5>
  <table>
    <tr>
      <th>ID Jenis Pertemuan</th>
      <th>Keterangan</th>
    </tr>
    @foreach($pertemuan as $p)
      <tr>
        <td>{{$p->id}}</td>
        <td>{{$p->nama}}</td>
      </tr>
    @endforeach

  </table>
  <br>
  <table>
    <tr>
      <th>ID RPS</th>
      <th>ID Jenis Pertemuan</th>
      <th>Materi</th>
      <th>Sub Capaian Pembelajaran (Sub-CPMK)</th>
    </tr>
    <tbody>
      @foreach($rps as $r)
        <tr>
          <td>{{$r->id}}</td>
          <td>{{$r->idjenis}}</td>
          <td>{{$r->materi}}</td>
          <td>{{$r->capaian}}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
