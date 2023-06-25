@extends('layouts.masterlogin')

@section('title-head', 'Absen')

@section('content')
<div class="content-body">
  <div class="auth-wrapper auth-v1 px-1">
      <div class="card mb-0">
        <div class="card-body">

          <?php
          echo DNS2D::getBarcodeHTML('4445645656', 'QRCODE',10,10);
           ?>

           <a href="{{route('pembelajaran.presensi',$idjadwal)}}" class="mt-2 text-center">Kembali</a>
        </div>
      </div>
  </div>
</div>
@endsection
