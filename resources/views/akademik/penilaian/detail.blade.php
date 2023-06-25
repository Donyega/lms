@extends('layouts.menu')

@section('title-head', 'Laporan Nilai')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Laporan Nilai
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('laporan.penilaian')}}">Laporan</a></li>
              <li class="breadcrumb-item active">Laporan Nilai</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="content-body">
    <div class="row">

      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6 col-sm-12">
                <div class="table-responsive">
                  <table class="table table-striped">
                    <tr>
                      <td>Mata Pelajaran</td>
                      <td><b>{{$mapel->nama}}</b></td>
                    </tr>
                    <tr>
                      <td>Kelas</td>
                      <td><b>{{$kelas->nama}} {{$kelas->jenis->nama}}</b></td>
                    </tr>
                  </table>
                </div>
              </div>
              <div class="col-lg-6 col-sm-12">
                <div class="table-responsive-lg">
                  <table class="table table-striped">
                    <tr>
                      <td>Guru</td>
                      <td>
                        @if (count($guru) == 1)
                          <b>{{$guru[0]->guru->nama}}</b>
                        @elseif (count($guru) > 1)
                        <ul class="pl-1 mb-0">
                          @foreach ($guru as $jg)
                            <li><b>{{$jg->guru->nama}}</b></li>
                          @endforeach
                        </ul>
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td>Jenis Nilai</td>
                      <td>Tugas</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="text-center text-lg-left mb-1">
          {{-- <button class="btn btn-danger my-25 my-lg-0" type="button" data-toggle="modal" data-target="#modal-nilai" data-backdrop="static" data-keyboard="false"><i data-feather="clipboard"></i> Penilaian</button> --}}
          <form class="d-inline" action="{{route('laporan.penilaian.cetaknilaitugas')}}" target="_blank" method="post">
            <input type="hidden" name="idta" value="{{$ta->id}}">
            <input type="hidden" name="idmapel" value="{{$mapel->id}}">
            <input type="hidden" name="idkelas" value="{{$kelas->id}}">
            {{-- <input type="hidden" name="idjenis" value="{{$jenismapel->id}}"> --}}
            <input type="hidden" name="isagama" value="{{$mapel->agama}}">
            <button type="submit" class="btn btn-outline-success my-25 my-lg-0" name="button" style="white-space:nowrap"><i data-feather="file-text"></i> Cetak Laporan Nilai</button>
            @csrf
          </form>
        </div>
      </div>

      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <table class="dt-complex-header table table-bordered table-hover" id="tabelsiswa">
              <thead class="text-center">
                <tr>
                  <th rowspan="2" style="vertical-align: middle">NIS</th>
                  <th rowspan="2" style="vertical-align: middle">Nama Siswa</th>
                  @foreach ($penugasan->wherein('idjenis', [1,2]) as $p)
                    <th>{{$p->judul}}</th>
                  @endforeach
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; ?>
                @foreach($siswa as $s)
                  <tr>
                    <td class="text-center">{{$s->nis}}</td>
                    <td>{{$s->nama}}</td>
                    <td>
                      @foreach ($penugasan->where('idjenis', 1) as $p)
                        @php
                            $nail = App\Models\LmsSiswaTugas::where('idpenugasan', $p->id)->where('nis', $s->nis)->get();
                        @endphp
                        @foreach ($nail as $n)
                          {{$n->nilai}}
                        @endforeach
                      @endforeach
                    </td>
                    <td>
                      @foreach ($penugasan->where('idjenis', 2) as $p)
                        @php
                            $nail = App\Models\LmsSiswaTugas::where('idpenugasan', $p->id)->where('nis', $s->nis)->get();
                        @endphp
                        @foreach ($nail as $n)
                          {{$n->nilai}}
                        @endforeach
                      @endforeach
                    </td>
                  </tr>
                  <?php $no++; ?>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@section('modal')
{{-- <div class="modal fade" id="modal-nilai" tabindex="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Pengisian Nilai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="jquery-val-form" class="forms-sample" action="{{route('laporan.penilaian.store')}}" method="post">
        <div class="modal-body">
          <input type="hidden" name="idta" value="{{$ta->id}}">
          <input type="hidden" name="idmapel" value="{{$mapel->id}}">
          <input type="hidden" name="idjenis" value="{{$jenismapel->id}}">
          <input type="hidden" name="iduser" value="{{auth::user()->id}}">
          <div class="col-12">
            <div class="row">
              <div class="col-lg-6 col-sm-12">
                <div class="table-responsive">
                  <table class="table table-striped">
                    <tr>
                      <td>Mata Pelajaran</td>
                      <td><b>{{$mapel->nama}}</b></td>
                    </tr>
                    <tr>
                      <td>Kelompok</td>
                      <td><b>{{$jenismapel->nama}}</b></td>
                    </tr>
                    <tr>
                      <td>Guru</td>
                      <td>
                        @if (count($guru) == 1)
                          <b>{{$guru[0]->guru->nama}}</b>
                        @elseif (count($guru) > 1)
                          <ul class="pl-1 mb-0">
                            @foreach ($guru as $jg)
                              <li><b>{{$jg->guru->nama}}</b></li>
                            @endforeach
                          </ul>
                        @endif
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
              <div class="col-lg-6 col-sm-12">
                <div class="table-responsive">
                  <table class="table table-striped">                    
                    <tr>
                      <td>KKM</td>
                      <td><b>{{$ta->kkm}}</b></td>
                    </tr>
                    <tr>
                      <td style="width: 32%">Kelas</td>
                      <td><b>{{$kelas->nama}} {{$kelas->jenis->nama}}</b></td>
                    </tr>
                    <tr>
                      <td>Jadwal</td>
                      <td>
                        @foreach ($jadwal as $j)
                          <div class="d-flex my-25">
                            <span style="width:60px">
                              <b>{{$j->hari->nama}}</b>
                            </span>
                            <small>
                              <i data-feather="chevrons-right"></i> Jam
                              @foreach ($j->detil as $jdt)
                                <div class="badge badge-light-secondary" style="width: 25px">{{$jdt->jampelajaran->nama}}</div>
                              @endforeach
                            </small>
                          </div>
                        @endforeach
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 mt-1">
            <div class="alert alert-dark mb-2" role="alert">
              <div class="alert-body text-center">
                UH : Ulangan Harian <span class="mx-75 text-muted">|</span> UTS : Ujian Tengah Semester <span class="mx-75 text-muted">|</span> UAS : Ujian Akhir Semester <span class="mx-75 text-muted">|</span> NP : Nilai Praktik
              </div>
            </div>
            <div class="table-responsive">
              <table class="table dt-complex-header table-bordered table-striped">
                <thead class="text-center">
                  <tr>
                    <th rowspan="2" style="vertical-align: middle">No</th>
                    <th rowspan="2" style="vertical-align: middle">NIS</th>
                    <th rowspan="2" style="vertical-align: middle">Nama Siswa</th>
                    <th colspan="5">Pengetahuan (KI3)</th>
                    <th colspan="3">Keterampilan (KI4)</th>
                  </tr>
                  <tr>
                    <th style="padding-left: 2rem; padding-right: 2rem">UH.1</th>
                    <th style="padding-left: 2rem; padding-right: 2rem">UH.2</th>
                    <th style="padding-left: 2rem; padding-right: 2rem">UH.3</th>
                    <th style="padding-left: 2rem; padding-right: 2rem">UTS</th>
                    <th style="padding-left: 2rem; padding-right: 2rem">UAS</th>
                    <th style="padding-left: 2rem; padding-right: 2rem">NP.1</th>
                    <th style="padding-left: 2rem; padding-right: 2rem">NP.2</th>
                    <th style="padding-left: 2rem; padding-right: 2rem">NP.3</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 0; $no = 1; ?>
                  @foreach ($siswa as $s)
                    <input type="hidden" name="nis[]" value="{{$s->nis}}">
                    <input type="hidden" name="no[]" value="{{$i}}">
                    <?php
                      $h1   = '';
                      $h2   = '';
                      $h3   = '';
                      $uts  = '';
                      $uas  = '';
                      $n1   = '';
                      $n2   = '';
                      $n3   = '';
                      foreach ($nilai as $n) {
                        if ($n->nis == $s->nis) {
                          $h1   = $n->h1;
                          $h2   = $n->h2;
                          $h3   = $n->h3;
                          $uts  = $n->uts;
                          $uas  = $n->uas;
                          $n1   = $n->n1;
                          $n2   = $n->n2;
                          $n3   = $n->n3;
                        }
                      }
                    ?>
                    <tr>
                      <td class="text-center">{{$no}}</td>
                      <td class="text-center">{{$s->nis}}</td>
                      <td>{{$s->nama}}</td>
                      <td style="width: 90px">
                        <input type="number" class="form-control text-center" min="1" max="100" name="h1[]" value="{{$h1}}">
                      </td>
                      <td style="width: 90px">
                        <input type="number" class="form-control text-center" min="1" max="100" name="h2[]" value="{{$h2}}">
                      </td>
                      <td style="width: 90px">
                        <input type="number" class="form-control text-center" min="1" max="100" name="h3[]" value="{{$h3}}">
                      </td>
                      <td style="width: 90px">
                        <input type="number" class="form-control text-center" min="1" max="100" name="uts[]" value="{{$uts}}">
                      </td>
                      <td style="width: 90px">
                        <input type="number" class="form-control text-center" min="1" max="100" name="uas[]" value="{{$uas}}">
                      </td>
                      <td style="width: 90px">
                        <input type="number" class="form-control text-center" min="1" max="100" name="n1[]" value="{{$n1}}">
                      </td>
                      <td style="width: 90px">
                        <input type="number" class="form-control text-center" min="1" max="100" name="n2[]" value="{{$n2}}">
                      </td>
                      <td style="width: 90px">
                        <input type="number" class="form-control text-center" min="1" max="100" name="n3[]" value="{{$n3}}">
                      </td>
                    </tr>
                    <?php $i++; $no++; ?>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          {{ csrf_field() }}
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-success"><i data-feather="save"></i> Simpan</button>
          <button class="btn btn-sm btn-outline-dark" data-dismiss="modal">Kembali</button>
        </div>
      </form>
    </div>
  </div>
</div> --}}
@endsection

@section('jspage')
<script>
$(document).ready(function() {

});
</script>
@stop