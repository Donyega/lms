<!DOCTYPE html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Data Siswa</title>
  <style media="screen">
    table {
      border-collapse: collapse;
      width: 100%;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 12px;
    }
    td {
      text-align:left;
      padding: 10px;
    }
  </style>
  <table>
    <tr>
      <th><b>No</b></th>
      <th><b>NIS</b></th>
      <th><b>NISN</b></th>
      <th><b>Nama Siswa</b></th>
      <th><b>Jenis Kelamin</b></th>
      <th><b>Tempat, Tanggal Lahir</b></th>
      <th><b>Jenis Siswa</b></th>
      <th><b>Tahun Masuk</b></th>
      <th><b>Kelas</b></th>
      <th><b>Status</b></th>
      <th><b>Alamat Tinggal</b></th>
      <th><b>Wilayah Alamat</b></th>
      <th><b>Email</b></th>
      <th><b>Telepon</b></th>
      <th><b>Agama</b></th>
    </tr>
    <tbody>
      <?php $no = 1; ?>
      @foreach($data as $d)
        <tr>
          <td>{{$no}}</td>
          <td>{{$d->nis}}</td>
          <td>{{$d->nisn}}</td>
          <td>{{$d->nama}}</td>
          <td>{{$d->jk == 'L' ? 'Laki-laki' : 'Perempuan'}}</td>
          <td>{{$d->tplahir}}, {{ (new \App\Helper)->tanggal($d->tglahir) }}</td>
          <td>{{$d->jenis->nama}}</td>
          <td>{{$d->detil->thnmasuk}}</td>
          <td>{{$d->kelas->nama}} {{$d->kelas->jenis->nama}}</td>
          <td>{{$d->status->nama}}</td>
          <td>{{$d->detil->idasalsekolah == null ? '-' : $d->detil->asalsekolah->nama}}</td>
          <td>{{$d->alamat}}</td>
          <td>{{$d->idkec == null ? '' : 'Kecamatan '.$d->kecamatan->nama.', '.$d->kecamatan->kabupaten->nama.', '.$d->kecamatan->kabupaten->provinsi->nama}}</td>
          <td>{{$d->detil->email}}</td>
          <td>{{$d->nohp}}</td>
          <td>{{$d->idagama == null ? '' : $d->agama->nama}}</td>
        </tr>
        <?php $no++; ?>
      @endforeach
    </tbody>
  </table>
