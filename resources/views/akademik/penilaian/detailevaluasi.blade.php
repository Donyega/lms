@extends('layouts.menu')

@section('title-head', 'Detail Nilai Evaluasi')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Detail Nilai Evaluasi
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('laporan.penilaian')}}">Detail</a></li>
              <li class="breadcrumb-item active">Detail Nilai Evaluasi</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
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
              <th rowspan="2" style="vertical-align: middle">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection