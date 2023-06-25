@foreach ($jam as $ja)
  <tr>
    <td class="text-center" style="vertical-align: top">{{$ja->nama}}</td>
    <td style="vertical-align: top; min-width:150px;">
      @foreach ($jadwal->where('idhari',1) as $jd)
        <?php
          $cekpresensi = App\Models\JadwalBap::where('idjadwal',$jd->id)->get();
          $alert = '';
          if (count($cekpresensi) == 0) {
            $alert = 'Hapus jadwal pelajaran '.$jd->mapel->nama.'?';
          }else {
            $alert = 'Guru mata pelajaran '.$cekpresensi[0]->guru->nama.' telah mengisi presensi, apakah Anda yakin akan menghapus jadwal '.$jd->mapel->nama.'?';
          }
        ?>
        @foreach($jd->detil->where('idjam',$ja->nama) as $jdd)
          <div class="row mx-0">
            <div class="col pl-0 pr-25">
              <small>{{$jdd->jampelajaran->mulai}} - {{$jdd->jampelajaran->selesai}}</small>
            </div>
            <form action="{{route('md.jadwal.delete')}}" method="post"  onsubmit="return confirm('{{$alert}}')">
              <input type="hidden" name="idjadwal" value="{{$jd->id}}">
              <input type="hidden" name="idguru" value="{{$jd->jadwalguru[0]->idguru}}">
              <button type="submit" class="btn btn-icon btn-flat p-0" name="button"><i data-feather="trash-2"></i></button>
              {{csrf_field()}}
            </form>
          </div>
          <hr class="my-25">
          <small>
            <div class="badge badge-light-danger text-left mb-25" style="white-space: normal">{{$jd->mapel->nama}}</div>
            <br>
            @foreach ($jd->jadwalguru as $jg)
              <span class="d-block">
                <div class="badge badge-light-secondary text-left mb-25" style="white-space: normal">{{$jg->guru->nama}}</div>
              </span>
            @endforeach
          </small>
          <div class="text-muted mt-25" style="font-size: 0.6rem">
            <i data-feather='chevrons-right' style="margin-top: -2px"></i>
            {{$jd->user->pegawai->panggilan}} | 
            {{date('d-m-y', strtotime($jd->created_at))}}
          </div>
        @endforeach
      @endforeach
    </td>
    <td style="vertical-align: top; min-width:150px;">
      @foreach ($jadwal->where('idhari',2) as $jd)
        <?php
          $cekpresensi = App\Models\JadwalBap::where('idjadwal',$jd->id)->get();
          $alert = '';
          if (count($cekpresensi) == 0) {
            $alert = 'Hapus jadwal pelajaran '.$jd->mapel->nama.'?';
          }else {
            $alert = 'Guru mata pelajaran '.$cekpresensi[0]->guru->nama.' telah mengisi presensi, apakah Anda yakin akan menghapus jadwal '.$jd->mapel->nama.'?';
          }
        ?>
        @foreach($jd->detil->where('idjam',$ja->nama) as $jdd)
          <div class="row mx-0">
            <div class="col pl-0 pr-25">
              <small>{{$jdd->jampelajaran->mulai}} - {{$jdd->jampelajaran->selesai}}</small>
            </div>
            <form action="{{route('md.jadwal.delete')}}" method="post"  onsubmit="return confirm('{{$alert}}')">
              <input type="hidden" name="idjadwal" value="{{$jd->id}}">
              <input type="hidden" name="idguru" value="{{$jd->jadwalguru[0]->idguru}}">
              <button type="submit" class="btn btn-icon btn-flat p-0" name="button"><i data-feather="trash-2"></i></button>
              {{csrf_field()}}
            </form>
          </div>
          <hr class="my-25">
          <small>
            <div class="badge badge-light-danger text-left mb-25" style="white-space: normal">{{$jd->mapel->nama}}</div>
            <br>
            @foreach ($jd->jadwalguru as $jg)
              <span class="d-block">
                <div class="badge badge-light-secondary text-left mb-25" style="white-space: normal">{{$jg->guru->nama}}</div>
              </span>
            @endforeach
          </small>
          <div class="text-muted mt-25" style="font-size: 0.6rem">
            <i data-feather='chevrons-right' style="margin-top: -2px"></i>
            {{$jd->user->pegawai->panggilan}} | 
            {{date('d-m-y', strtotime($jd->created_at))}}
          </div>
        @endforeach
      @endforeach
    </td>
    <td style="vertical-align: top; min-width:150px;">
      @foreach ($jadwal->where('idhari',3) as $jd)
        <?php
          $cekpresensi = App\Models\JadwalBap::where('idjadwal',$jd->id)->get();
          $alert = '';
          if (count($cekpresensi) == 0) {
            $alert = 'Hapus jadwal pelajaran '.$jd->mapel->nama.'?';
          }else {
            $alert = 'Guru mata pelajaran '.$cekpresensi[0]->guru->nama.' telah mengisi presensi, apakah Anda yakin akan menghapus jadwal '.$jd->mapel->nama.'?';
          }
        ?>
        @foreach($jd->detil->where('idjam',$ja->nama) as $jdd)
          <div class="row mx-0">
            <div class="col pl-0 pr-25">
              <small>{{$jdd->jampelajaran->mulai}} - {{$jdd->jampelajaran->selesai}}</small>
            </div>
            <form action="{{route('md.jadwal.delete')}}" method="post"  onsubmit="return confirm('{{$alert}}')">
              <input type="hidden" name="idjadwal" value="{{$jd->id}}">
              <input type="hidden" name="idguru" value="{{$jd->jadwalguru[0]->idguru}}">
              <button type="submit" class="btn btn-icon btn-flat p-0" name="button"><i data-feather="trash-2"></i></button>
              {{csrf_field()}}
            </form>
          </div>
          <hr class="my-25">
          <small>
            <div class="badge badge-light-danger text-left mb-25" style="white-space: normal">{{$jd->mapel->nama}}</div>
            <br>
            @foreach ($jd->jadwalguru as $jg)
              <span class="d-block">
                <div class="badge badge-light-secondary text-left mb-25" style="white-space: normal">{{$jg->guru->nama}}</div>
              </span>
            @endforeach
          </small>
          <div class="text-muted mt-25" style="font-size: 0.6rem">
            <i data-feather='chevrons-right' style="margin-top: -2px"></i>
            {{$jd->user->pegawai->panggilan}} | 
            {{date('d-m-y', strtotime($jd->created_at))}}
          </div>
        @endforeach
      @endforeach
    </td>
    <td style="vertical-align: top; min-width:150px;">
      @foreach ($jadwal->where('idhari',4) as $jd)
        <?php
          $cekpresensi = App\Models\JadwalBap::where('idjadwal',$jd->id)->get();
          $alert = '';
          if (count($cekpresensi) == 0) {
            $alert = 'Hapus jadwal pelajaran '.$jd->mapel->nama.'?';
          }else {
            $alert = 'Guru mata pelajaran '.$cekpresensi[0]->guru->nama.' telah mengisi presensi, apakah Anda yakin akan menghapus jadwal '.$jd->mapel->nama.'?';
          }
        ?>
        @foreach($jd->detil->where('idjam',$ja->nama) as $jdd)
          <div class="row mx-0">
            <div class="col pl-0 pr-25">
              <small>{{$jdd->jampelajaran->mulai}} - {{$jdd->jampelajaran->selesai}}</small>
            </div>
            <form action="{{route('md.jadwal.delete')}}" method="post"  onsubmit="return confirm('{{$alert}}')">
              <input type="hidden" name="idjadwal" value="{{$jd->id}}">
              <input type="hidden" name="idguru" value="{{$jd->jadwalguru[0]->idguru}}">
              <button type="submit" class="btn btn-icon btn-flat p-0" name="button"><i data-feather="trash-2"></i></button>
              {{csrf_field()}}
            </form>
          </div>
          <hr class="my-25">
          <small>
            <div class="badge badge-light-danger text-left mb-25" style="white-space: normal">{{$jd->mapel->nama}}</div>
            <br>
            @foreach ($jd->jadwalguru as $jg)
              <span class="d-block">
                <div class="badge badge-light-secondary text-left mb-25" style="white-space: normal">{{$jg->guru->nama}}</div>
              </span>
            @endforeach
          </small>
          <div class="text-muted mt-25" style="font-size: 0.6rem">
            <i data-feather='chevrons-right' style="margin-top: -2px"></i>
            {{$jd->user->pegawai->panggilan}} | 
            {{date('d-m-y', strtotime($jd->created_at))}}
          </div>
        @endforeach
      @endforeach
    </td>
    <td style="vertical-align: top; min-width:150px;">
      @foreach ($jadwal->where('idhari',5) as $jd)
        <?php
          $cekpresensi = App\Models\JadwalBap::where('idjadwal',$jd->id)->get();
          $alert = '';
          if (count($cekpresensi) == 0) {
            $alert = 'Hapus jadwal pelajaran '.$jd->mapel->nama.'?';
          }else {
            $alert = 'Guru mata pelajaran '.$cekpresensi[0]->guru->nama.' telah mengisi presensi, apakah Anda yakin akan menghapus jadwal '.$jd->mapel->nama.'?';
          }
        ?>
        @foreach($jd->detil->where('idjam',$ja->nama) as $jdd)
          <div class="row mx-0">
            <div class="col pl-0 pr-25">
              <small>{{$jdd->jampelajaran->mulai}} - {{$jdd->jampelajaran->selesai}}</small>
            </div>
            <form action="{{route('md.jadwal.delete')}}" method="post"  onsubmit="return confirm('{{$alert}}')">
              <input type="hidden" name="idjadwal" value="{{$jd->id}}">
              <input type="hidden" name="idguru" value="{{$jd->jadwalguru[0]->idguru}}">
              <button type="submit" class="btn btn-icon btn-flat p-0" name="button"><i data-feather="trash-2"></i></button>
              {{csrf_field()}}
            </form>
          </div>
          <hr class="my-25">
          <small>
            <div class="badge badge-light-danger text-left mb-25" style="white-space: normal">{{$jd->mapel->nama}}</div>
            <br>
            @foreach ($jd->jadwalguru as $jg)
              <span class="d-block">
                <div class="badge badge-light-secondary text-left mb-25" style="white-space: normal">{{$jg->guru->nama}}</div>
              </span>
            @endforeach
          </small>
          <div class="text-muted mt-25" style="font-size: 0.6rem">
            <i data-feather='chevrons-right' style="margin-top: -2px"></i>
            {{$jd->user->pegawai->panggilan}} | 
            {{date('d-m-y', strtotime($jd->created_at))}}
          </div>
        @endforeach
      @endforeach
    </td>
    <td style="vertical-align: top; min-width:150px;">
      @foreach ($jadwal->where('idhari',6) as $jd)
        <?php
          $cekpresensi = App\Models\JadwalBap::where('idjadwal',$jd->id)->get();
          $alert = '';
          if (count($cekpresensi) == 0) {
            $alert = 'Hapus jadwal pelajaran '.$jd->mapel->nama.'?';
          }else {
            $alert = 'Guru mata pelajaran '.$cekpresensi[0]->guru->nama.' telah mengisi presensi, apakah Anda yakin akan menghapus jadwal '.$jd->mapel->nama.'?';
          }
        ?>
        @foreach($jd->detil->where('idjam',$ja->nama) as $jdd)
          <div class="row mx-0">
            <div class="col pl-0 pr-25">
              <small>{{$jdd->jampelajaran->mulai}} - {{$jdd->jampelajaran->selesai}}</small>
            </div>
            <form action="{{route('md.jadwal.delete')}}" method="post"  onsubmit="return confirm('{{$alert}}')">
              <input type="hidden" name="idjadwal" value="{{$jd->id}}">
              <input type="hidden" name="idguru" value="{{$jd->jadwalguru[0]->idguru}}">
              <button type="submit" class="btn btn-icon btn-flat p-0" name="button"><i data-feather="trash-2"></i></button>
              {{csrf_field()}}
            </form>
          </div>
          <hr class="my-25">
          <small>
            <div class="badge badge-light-danger text-left mb-25" style="white-space: normal">{{$jd->mapel->nama}}</div>
            <br>
            @foreach ($jd->jadwalguru as $jg)
              <span class="d-block">
                <div class="badge badge-light-secondary text-left mb-25" style="white-space: normal">{{$jg->guru->nama}}</div>
              </span>
            @endforeach
          </small>
          <div class="text-muted mt-25" style="font-size: 0.6rem">
            <i data-feather='chevrons-right' style="margin-top: -2px"></i>
            {{$jd->user->pegawai->panggilan}} | 
            {{date('d-m-y', strtotime($jd->created_at))}}
          </div>
        @endforeach
      @endforeach
    </td>
  </tr>
@endforeach