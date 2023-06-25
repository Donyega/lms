<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Rekap Presensi - {{$data->mapel->nama}}</title>
<style media="screen">
  table {
    border-collapse: collapse;
    width: 100%;
    font-family: "Times New Roman", Times, serif;
    font-size: 14px;
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
    padding-left: 8px;
    list-style-type: none;
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
    margin-left: 25px;
    margin-right: 25px;
    margin-top: -100px !important;
    position: fixed;
  }
  main {
    font-size: 14px;
    margin-left: 25px;
    margin-right: 25px;
    margin-bottom: 40px;
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
    margin-top: 130px;
  }
</style>
@php
    $gs = App\Models\Profil::find(1);
@endphp
<div class="header">
  <img src="{{asset($gs->logo)}}"width="80" height="87" style="margin-right: 15px;" align="left">
  <div style="margin-bottom: -10px;">
      <p style="font-weight: bold; font-size:16px !important; margin-top:-2px; font-family: Arial, Helvetica, sans-serif;">{{$gs->nama}}</p>
      <p style="font-weight: bold; font-size:20px; margin-top:-15px;">{{$data->mapel->nama}}</p>
      <p style="font-size:12px; margin-top:-15px;">Sekretariat: {{$gs->alamat}} 80233</p>
      <p style="font-size:12px; margin-top:-10px;">Telp. {{$gs->telpon}} <span style="word-spacing: 10px;"> </span> {{$gs->fax == null ? '' : 'Fax. '.$gs->fax}}</p>
      <p style="font-size:11px; margin-top:-11px;">website: {{$gs->website}} <span style="word-spacing: 20px;"> </span> e-mail: {{$gs->email}}</p>
  </div>
  <hr>
</div>

<main>
  <center>
    <h2 style="margin-bottom: 0px; text-decoration:underline">Rekap Presensi Pembelajaran</h2>
    <h4 style="margin-top: 5px; margin-bottom: 15px;">Tahun Ajaran {{$data->ta->tahun}} {{$data->ta->semester == 1 ? 'Ganjil':'Genap'}}</h4>
  </center>

  <table>
    <tr>
      <td style="width:90px;">Kelas</td>
      <td style="width:260px;">: {{$data->kelas->nama}}</td>
      <td style="width:40px;">Jadwal</td>
      <td style="width:120px;">: {{$data->hari}}, {{$data->jam}}</td>
    </tr>
    <tr>
      <td>Mata Pelajaran</td>
      <td colspan="3">: {{$data->mapel->nama}}</td>
    </tr>
    <tr>
      <td>Jumlah Siswa</td>
      <td colspan="3">: {{count($data->kelas->siswa)}}</td>
    </tr>
    <tr>
      <td>Guru Pengampu</td>
      <td colspan="3">
        <ul>
          @foreach($data->guru as $guru)
          <li>
            {{$guru->guru->nama}}
            @if ($guru->jenis == 1)
            <span><b>*</b></span>
            @endif
          </li>
          @endforeach
        </ul>
      </td>
    </tr>
  </table>
  <br>
  <table border="1">
    <thead>
      <tr>
        <th>Pertemuan</th>
        <th>Tanggal</th>
        <th colspan="2">Detail Pembelajaran</th>
      </tr>
    </thead>

    <tbody>
      @foreach($ba as $b)
      <tr>
        <td rowspan="{{$b->tugas != null ? '4' : '3'}}" style="text-align: center; width:70px;">{{$b->pertemuan}}</td>
        <td rowspan="{{$b->tugas != null ? '4' : '3'}}" style="width:120px;">{{ (new \App\Helper)->tanggal($b->tanggal) }}</td>
        <td style="width: 80px; border-right:none; border-bottom: none;">Materi</td>          
        <td style="border-left: none; border-bottom: none;">{{$b->materi}}</td>          
      </tr>
      @if($b->tugas != null)
      <tr>
        <td style="border-top: none; border-right:none; border-bottom: none;">Tugas</td>
        <td style="border-top: none; border-left: none; border-bottom: none;">{{$b->tugas}}</td>     
      </tr>     
      @endif
      <tr>
        <td style="border-top: none; border-bottom: none; border-right:none;">Siswa</td>
        <td style="border-top: none; border-bottom: none; border-left:none;">
          <?php $hadir = 0 ?>
          @foreach($jumlahhadir as $h)
            @if($h->pertemuan == $b->pertemuan)
              <?php $hadir = $h->jumlah ?>
            @endif
          @endforeach
          {{$hadir}} Hadir
          @if(count($data->kelas->siswa) - $hadir != 0)
            , {{count($data->kelas->siswa) - $hadir}} Tidak Hadir
          @endif
        </td>
      </tr>
      <tr>
        <td style="border-top: none; border-right:none;">Guru</td>
        <td style="border-top: none; border-left:none;">{{$b->guru->nama}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <br><br>
  <p style="text-transform: uppercase;"><b>Rekapitulasi Gurus</b></p>
  <table border="1" style="width: 425px;">
    <thead>
      <tr>
        <th style="width: 285px;">Guru Pengampu</th>
        <th style="width: 120px;">Jumlah Pertemuan</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($barekap as $r)
      <tr>
        <td>{{$r->guru->nama}}</td>
        <td style="text-align: center;">{{$r->jumlah}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{-- <footer>
    <table>
      <tr>
        <td style="width: 55px">
          <?php echo '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG(route("baperkuliahan",$data->id), 'QRCODE') . '" width="50px" alt="barcode"   />'; ?>
        </td>
        <td>
          <hr class="noteline">
          <span class="note">
            Dokumen dicetak secara terkomputerisasi dan telah divalidasi melalui sistem informasi akademik.<br>
            Scan barcode untuk menampilkan halaman original.<br>
            &copy; {{$gs->nama}}</span>
          </span>
        </td>
      </tr>
    </table>
  </footer> --}}

</main>
