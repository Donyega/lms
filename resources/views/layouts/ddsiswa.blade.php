<div class="table-responsive-lg">
  <table class="table table-striped">
    <tr>
      <td colspan="2"><h2 class="mb-0">{{$data->nama}}</h2></td>
    </tr>
    <tr>
      <td style="width:30%">NIS</td>
      <th>{{$data->nis}}</th>
    </tr>
    <tr>
      <td>NISN</td>
      <th>{{$data->nisn}}</th>
    </tr>
    @if($data->idstatus == 1)
      <tr>
        <td>Kelas</td>
        <th>
          @if($data->idkelas == null)
          <div class="badge badge-light-danger">Belum Ditentukan</div>
          @else
          {{$data->kelas->nama}} ({{$data->kelas->jenis->nama}})</th>
          @endif
      </tr>
    @endif
    <tr>
      <td>Tempat, Tanggal Lahir</td>
      <th>{{$data->tplahir}}, {{ (new \App\Helper)->tanggal($data->tglahir) }}</th>
    </tr>
    <tr>
      <td>Usia</td>
      <th>{{ (new \App\Helper)->lamamengajar($data->tglahir) }}</th>
    </tr>
    <tr>
      <td>Jenis Kelamin</td>
      <th>{{$data->jk == 'L' ? 'Laki-Laki' : 'Perempuan'}}</th>
    </tr>
    <tr>
      <td>Agama</td>
      <th>{{$data->idagama == null ? '-' : $data->agama->nama}}</th>
    </tr>
  </table>
</div>