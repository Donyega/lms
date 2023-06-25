<!DOCTYPE html>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>{{$namakelas}}</title>
  <style media="screen">
    table {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 12px;
    }
  </style>
  <table>
    <tr>
      <td colspan="2">MP</td>
      <td colspan="10">{{$mapel->nama}}</td>
    </tr>
    <tr>
      <td colspan="2">Kelas</td>
      <td colspan="10">{{$namakelas}}</td>
    </tr>
    <tr>
      <td colspan="2">Kelompok</td>
      <td colspan="10">{{$jadwal[0]->jenismapel->nama}}</td>
    </tr>
    <tr>
      <td colspan="2">Guru</td>
      <td colspan="10">
        @if (count($guru) == 1)
          {{$guru[0]->guru->nama}}
        @elseif (count($guru) > 1)
          @foreach ($guru as $jg)
            {{$jg->guru->nama}}, 
          @endforeach
        @endif
      </td>
    </tr>
    <tr>
      <td colspan="2">Siswa</td>
      <td colspan="10">{{count($siswa)}}</td>
    </tr>
    <tr>
      <td colspan="2" style="vertical-align: center">Jadwal</td>
      <td colspan="10">
        <?php $nj = 1; ?>
        @foreach ($jadwal as $j)
          {{$j->hari->nama}}, 
          <?php $njt = 1; ?>
          @foreach ($j->detil as $jdt)
            {{$jdt->jampelajaran->mulai}} - {{$jdt->jampelajaran->selesai}} 
            @if (count($j->detil) - $njt > 0)
              | 
            @endif
            <?php $njt ++; ?>
          @endforeach
          @if (count($jadwal) - $nj > 0)
            <br>
          @endif
          <?php $nj ++; ?>
        @endforeach
      </td>
    </tr>
  </table>
  <table>
    <tr>
      <td rowspan="3" style="text-align: center; vertical-align: center"><b>No</b></td>
      <td rowspan="3" style="text-align: center; vertical-align: center"><b>NIS</b></td>
      <td rowspan="3" style="text-align: center; vertical-align: center"><b>Nama Siswa</b></td>
      <td rowspan="3" style="text-align: center; vertical-align: center"><b>JK</b></td>
      <td colspan="8" style="text-align: center"><b>Aspek Penilaian</b></td>
    </tr>
    <tr>
      <td colspan="5" style="text-align: center"><b>Pengetahuan (KI3)</b></td>
      <td colspan="3" style="text-align: center"><b>Keterampilan (KI4)</b></td>
    </tr>
    <tr>
      <td style="text-align: center"><b>UH.1</b></td>
      <td style="text-align: center"><b>UH.2</b></td>
      <td style="text-align: center"><b>UH.3</b></td>
      <td style="text-align: center"><b>UTS</b></td>
      <td style="text-align: center"><b>UAS</b></td>
      <td style="text-align: center"><b>NP.1</b></td>
      <td style="text-align: center"><b>NP.2</b></td>
      <td style="text-align: center"><b>NP.3</b></td>
    </tr>
    <?php $i=1; ?>
    @foreach($siswa as $s)
      <tr>
        <td style="text-align: center">{{$i}}</td>
        <td style="text-align: center">{{$s->nis}}</td>
        <td>
          {{$s->nama}}
          @if ($agama == 1)
            <br>
            {{$s->kelas->nama}} {{$s->kelas->jenis->nama}}
          @endif
        </td>
        <td style="text-align: center">{{$s->jk}}</td>
        <td style="text-align: center"></td>
        <td style="text-align: center"></td>
        <td style="text-align: center"></td>
        <td style="text-align: center"></td>
        <td style="text-align: center"></td>
        <td style="text-align: center"></td>
        <td style="text-align: center"></td>
        <td style="text-align: center"></td>
      </tr>
      <?php $i++; ?>
    @endforeach
  </table>
