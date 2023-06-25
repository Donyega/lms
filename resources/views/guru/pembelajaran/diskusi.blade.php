@extends('layouts.menu')

@section('title-head', 'Pembelajaran '.$data->mapel->nama)

@section('content')
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
        <div class="row breadcrumbs-top">
          <div class="col-12">
            <h2 class="content-header-title float-left mb-0">{{$data->mapel->nama}}
            </h2>
            <div class="breadcrumb-wrapper">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="{{route('home')}}"><i data-feather="home"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="#">Pembelajaran</a></li>
                <li class="breadcrumb-item"><a href="#">Diskusi</a></li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="content-body">
      <div class="row">
        <div class="col-lg-8 order-2 order-md-1 order-lg-1">
          <div class="card">
            <div class="card-body">
              <div class="card card-congratulations mb-50">
                <div class="card-body text-center">
                  <img src="{{asset('images/img-frame.png')}}" class="congratulations-img-left">
                  <div class="avatar avatar-lg bg-light-info shadow mb-50">
                    <div class="avatar-content"><i data-feather="users"></i></div>
                  </div>
                  <h5 class="text-light mb-0">TOPIK DISKUSI</h5>
                  <span class="d-block">{{$topik->judul}}</span>
                  <input type="hidden" name="idtopik" id="idtopik" value="{{$topik->id}}">
                  @if(auth::user()->role == 2)
                    <input type="hidden" id="namachat" value="{{auth::user()->pegawai->nama}}">
                    <input type="hidden" id="fotochat" value="{{auth::user()->pegawai->photo == null ? asset('images/user-default.jpg') : 'https://siakad.slua.sch.id/'.auth::user()->pegawai->photo}}">
                  @else
                  @endif
                </div>
              </div>
              <div class="dropdown-divider"></div>
                <div id="app">
                    <section class="chat-app-window">
                      <div class="active-chat">
                          <div class="user-chats">
                              <div id="chat-area" class="chats">
                              @if(count($topik->diskusi) == 0)
                                  <h4 class="text-center belum">Belum Ada Diskusi</h4>
                              @else
                                @foreach($topik->diskusi as $d)
                                  @if($d->iduser == auth::user()->id)

                                    @php
                                      if(auth::user()->role == 2){
                                        $nama = auth::user()->pegawai->nama;
                                        $foto = 'https://siakad.slua.sch.id/'.auth::user()->pegawai->photo;
                                      }elseif(auth::user()->role == 3){

                                      }
                                    @endphp

                                    <div class="chat">
                                      <div class="chat-avatar">
                                        <div class="avatar-lecture">
                                          <img src="{{$foto}}" alt="avatar" width="100%" />
                                        </div></div><div class="chat-body">
                                        @if($d->iddiskusi != null)
                                          @php 
                                            if($d->balas->user->role == 2){
                                              $namabalas = $d->balas->user->pegawai->nama;
                                            }
                                          @endphp
                                          <div class="chat-content alert-dark">
                                            <small class="text-right">{{$namabalas}}</small>
                                            <p><b>{{$d->balas->diskusi}}</b></p>
                                          </div>
                                        @endif
                                        <div class="chat-content">
                                          <small class="text-right">{{$nama}}</small>
                                          <p><b>{{$d->diskusi}}</b></p>
                                          <button class="btn btn-sm balas text-warning" style="margin-left:60%;" value={{$d->id}}>Balas</button>
                                        </div>

                                      </div>
                                    </div>
                                  @else
                                  @php
                                      if(auth::user()->role == 2){
                                        $nama = $d->user->pegawai->nama;
                                        $foto = 'https://siakad.slua.sch.id/'.$d->user->pegawai->photo;
                                      }elseif(auth::user()->role == 3){

                                      }
                                    @endphp
                                    <div class="chat chat-left">
                                      <div class="chat-avatar">
                                        <div class="avatar-lecture">
                                          <img src="{{$foto}}" alt="avatar" width="100%" />
                                        </div>
                                      </div>
                                      <div class="chat-body">
                                        @if($d->iddiskusi != null)
                                          @php 
                                            if($d->balas->user->role == 2){
                                              $namabalas = $d->balas->user->pegawai->nama;
                                            }
                                          @endphp
                                          <div class="chat-content alert-dark">
                                            <small class="text-right">{{$namabalas}}</small>
                                            <p><b>{{$d->balas->diskusi}}</b></p>
                                          </div>
                                        @endif

                                        <div class="chat-content">
                                        <small>{{$nama}}</small>
                                        <p><b>{{$d->diskusi}}</b></p>
                                        <button class="btn btn-sm balas text-warning" style="margin-left:60%;" value={{$d->id}}>Balas</button>
                                        </div>
                                      </div>
                                    </div>
                                  @endif
                                @endforeach
                              @endif
                              </div>
                              <div class="balasdisini"></div>
                              <input id="type-area" class="type-area form-control mt-3" placeholder="Type something...">
                          </div>
                      </div>
                      @csrf
                    </section>
                </div>
              </div>
            </div>
        </div>
        {{-- <div class="col-lg-4 order-1 order-md-2 order-lg-2">
          <div class="blog-list-wrapper">
            <div class="card">
              <img class="card-img-top img-fluid" width="100%" src="{{asset('images/lms-bg-'.$i.'.jpg')}}">
              <div class="card-body">
                <div class="img-badge float-right">Kelas <b>{{$data->kelompok->nama}}</b></div>
                <h5 class="media mb-25">
                  <span class="blog-title-truncate text-body-heading"><b>{{$data->matakuliah->nama}}</b></span>
                </h5>
                <div class="media mb-25">
                  <div class="media-body row m-0">
                    <div class="pr-50"><small>{{$data->matakuliah->kodemk}}</small></div>
                    <div class="px-50 border-left-primary">
                      <small>{{$data->matakuliah->prodi->jenjang}} {{$data->matakuliah->prodi->nama}}</small>
                    </div>
                    @if ($data->pendek == 1)
                      <div class="pl-50 border-left-primary">
                        <div class="badge badge-light-warning">Antara</div>
                      </div>
                    @endif
                  </div>
                </div>
                <div class="alert alert-dark mt-75 mb-0" role="alert">
                  <div class="alert-body">
                    <div class="row m-0 justify-content-between align-items-center">
                      @if ($data->hari2 == null)
                        <span class="font-small-3">{{$data->hari}}, {{$data->jam}}</span>
                      @else
                        <ul class="font-small-3 pl-1 mb-0">
                          <li>{{$data->hari}}, {{$data->jam}}</li>
                          <li>{{$data->hari2}}, {{$data->jam2}}</li>
                          @if ($data->hari3 != null)
                            <li>{{$data->hari3}}, {{$data->jam3}}</li>
                          @endif
                          @if ($data->hari4 != null)
                            <li>{{$data->hari4}}, {{$data->jam4}}</li>
                          @endif
                        </ul>
                      @endif

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header border-bottom pb-75">
              <h5 class="mb-0">pegawai Pengampu</h5>
            </div>
            <div class="card-body pt-25">
              @foreach ($data->pegawai as $dd)
                <div class="row mx-0 my-50 align-items-center">
                  <div class="avatar-lecture">
                    <img src="{{'https://siakad.slua.sch.id/'.$dd->pegawai->photo}}" width="100%">
                  </div>
                  <div class="col pl-50 pr-0">
                    <span class="font-small-3">{{$dd->pegawai->nama}}</span>
                    @if ($dd->jenis == 1)
                      <span class="d-block font-small-2 text-muted">Koordinator</span>
                    @endif
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div> --}}
      </div>
    </div>
  </div>
<input type="hidden" id="iddiskusi">
@endsection

@section('modal')

@endsection

@section('jspage')
<script src="{{ asset("assets/js/chat.js") }}"></script>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('assets/plugins/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/dropify.js')}}"></script> 
<script>            
$(document).ready(function() {
  Echo.channel(`diskusi.{{$topik->id}}`)
    .listen('diskusiEvent', (e) => {
        if(e.iduser != '{{auth::user()->id}}'){
          console.log(e)
          handelLeftMessage(e)
        }
    });

    $('.balas').click(function(){
      $('.formbalas').remove()
      iddiskusi = $(this).val();
      $('#iddiskusi').val(iddiskusi)
      $.get('/getbalas/'+iddiskusi, function(data){
        var balas ='<div class="card alert-dark formbalas" style="margin-bottom:-40px;"><div class="chat"><div class="row"><div class="col-md-10"><div class="chat-body"><div class="chat-content" style="padding:20px;"><small class="text-right text-primary">'+data[0]+'</small><p>'+data[1].diskusi+'</p></div></div></div><div class="col-md-2"><button id="batalbalas" type="button" class="close p-2 batalbalas"><span aria-hidden="true"><b>&times;</b></span></button></div></div></div></div>';

      $('.balasdisini').before(balas)
      $('.batalbalas').click(function(){
        $('.formbalas').remove()
      })
      })
    })
});
</script>
@stop
