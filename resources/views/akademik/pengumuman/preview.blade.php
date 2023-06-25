@extends('layouts.page')

@section('title-head', 'Preview Pengumuman')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Preview Pengumuman
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('akademik.pengumuman')}}">Pengumuman</a></li>
              <li class="breadcrumb-item active">Preview</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="content-body">
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <img src="{{asset($data->gambar)}}" class="img-fluid card-img-top" alt="Gambar" />
          <div class="card-body">
            <h4 class="card-title mb-25">{{$data->judul}}</h4>
            <div class="media">
              <div class="media-body mb-2">
                <span class="text-muted font-small-3"><i data-feather='calendar' style="margin-top: -2px"></i> {{(new \App\Helper)->tanggal($data->tglpublish)}}</span>
                <span class="mx-75 text-muted">|</span>
                <span class="text-muted font-small-3"><i data-feather='user' style="margin-top: -2px"></i> {{$data->user->pegawai->panggilan}}</span>
                <span class="mx-75 text-muted">|</span>
                <div class="font-small-1 badge badge-light-{{$data->status == 1 ? 'success' : 'secondary'}}">{{$data->status == 1 ? 'Publish' : 'Draft'}}</div>
              </div>
            </div>
            <div class="text-justify mb-2">
              {!! $data->isi !!}
            </div>
            <hr class="my-2" />
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="blog-recent-posts">
          <h6 class="section-label">Pengumuman Terkini</h6>
          <div class="mt-2">
            @if(count($dataterkini) == 0)
              <div class="alert alert-danger mb-0" role="alert">
                <div class="alert-body">
                  Belum ada pengumuman berstatus <b>Publish</b> untuk ditampilkan di kolom Pengumuman Terkini.
                </div>
              </div>
            @else
              @foreach ($dataterkini as $d)
                <div class="media mb-2 align-items-center">
                  <a href="page-blog-detail.html" class="mr-2">
                    <div style="height: 75px; overflow:hidden; border-radius:5px;">
                      <img class="rounded" src="{{asset($d->gambar)}}" width="100" alt="Gambar" />
                    </div>
                  </a>
                  <div class="media-body">
                    @php
                      $strlenitem = Str::length($d->judul);
                      if ($strlenitem > 50) {
                        $judul_cut = substr($d->judul, 0, 50);
                        if ($judul_cut[49] != ' ') {
                          $new_pos = strrpos($judul_cut, ' ');
                          $judul_cut = substr($d->judul, 0, $new_pos);
                          $judul_cut = $judul_cut.'...';
                        }else {
                          $judul_cut = substr($d->judul, 0, 49);
                          $judul_cut = $judul_cut.'...';
                        }
                      }else {
                        $judul_cut = $d->judul;
                      }
                    @endphp
                    <h6 class="blog-recent-post-title">
                      <a href="{{ route('akademik.pengumuman.preview', $d->id) }}" class="text-body-heading">{{$judul_cut}}</a>
                    </h6>
                    <div class="text-muted mb-0 font-small-3"><i data-feather='calendar' style="margin-top: -2px"></i> {{(new \App\Helper)->tanggal($d->tglpublish)}}</div>
                  </div>
                </div>
                <div class="dropdown-divider mb-2"></div>
              @endforeach
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('modal')

@endsection

@section('jspage')
<script>
$(document).ready(function() {

});
</script>
@stop
