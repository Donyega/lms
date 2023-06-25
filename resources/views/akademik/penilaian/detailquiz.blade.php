@extends('layouts.menu')

@section('title-head', 'Laporan Nilai Evaluasi')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Laporan Nilai Evaluasi
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('laporan.penilaian')}}">Laporan</a></li>
              <li class="breadcrumb-item active">Laporan Nilai Evaluasi</li>
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
                      <tr>
                          <td>Bulan</td>
                          <td>{{App\Helper::bulan($bulan->created_at)}}</td>
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
          <form class="d-inline" action="{{route('laporan.penilaian.cetakevaluasi', [$kelas->id, $mapel->id])}}" target="_blank" method="post">
            <input type="hidden" name="idta" value="{{$ta->id}}">
            <input type="hidden" name="idmapel" value="{{$mapel->id}}">
            <input type="hidden" name="idkelas" value="{{$kelas->id}}">
            {{-- <input type="hidden" name="idjenis" value="{{$jenismapel->id}}"> --}}
            <button type="submit" class="btn btn-outline-success my-25 my-lg-0" name="button" style="white-space:nowrap"><i data-feather="file-text"></i> Cetak Laporan Evaluasi</button>
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
                  @foreach ($materi->wherein('idjenis', [2,3,4]) as $m)
                  <th>{{$m->materi}}</th>
                  @endforeach
                  {{-- <th>Ujian Tengah Semester</th>
                  <th>Ujian Akhir Semester</th> --}}
                </tr>
              </thead>
              <tbody>
                @foreach($siswa as $s)
                  <tr>
                    <td>{{$s->nis}}</td>
                    <td>{{$s->nama}}</td>
                    <td>
                      @foreach ($materi->where('idjenis', 2) as $m)
                      <?php $eva = App\Models\LmsEvaluasi::with('materi')->where('idmateri', $m->id)->get(); ?>
                        @foreach ($eva as $e)
                          <?php $nil = App\Models\LmsSiswaEvaluasi::where('idevaluasi', $e->id)->get(); ?>
                          @foreach ($nil->where('nis', $s->nis) as $n)
                            {{$n->nilai}}
                          @endforeach
                        @endforeach
                      @endforeach
                    </td>
                    <td>
                      @foreach ($materi->where('idjenis', 3) as $m)
                      <?php $eva = App\Models\LmsEvaluasi::with('materi')->where('idmateri', $m->id)->get(); ?>
                        @foreach ($eva as $e)
                          <?php $nil = App\Models\LmsSiswaEvaluasi::where('idevaluasi', $e->id)->get(); ?>
                          @foreach ($nil->where('nis', $s->nis) as $n)
                            {{$n->nilai}}
                          @endforeach
                        @endforeach
                      @endforeach
                    </td>
                    <td>
                      @foreach ($materi->where('idjenis', 4) as $m)
                      <?php $eva = App\Models\LmsEvaluasi::with('materi')->where('idmateri', $m->id)->get(); ?>
                        @foreach ($eva as $e)
                          <?php $nil = App\Models\LmsSiswaEvaluasi::where('idevaluasi', $e->id)->get(); ?>
                          @foreach ($nil->where('nis', $s->nis) as $n)
                            {{$n->nilai}}
                          @endforeach
                        @endforeach
                      @endforeach
                    </td>
                  </tr>
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