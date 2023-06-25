@extends('layouts.menu')

@section('title-head', 'Diskusi '.$data->mapel->nama)

@section('content')

  <div class="content-area-wrapper chat-application">
    <div class="content-right">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
          <div class="body-content-overlay"></div>
          <section class="chat-app-window">
            <div class="active-chat">
              <div class="chat-navbar">
                <header class="chat-header">
                  <div class="d-flex align-items-center">
                    <div class="avatar bg-gradient-primary user-profile-toggle p-25 mr-1">
                      <div class="avatar-content">
                        <i data-feather="twitch" class="font-medium-3"></i>
                      </div>
                    </div>
                    <h6 class="mb-0">{{$topik->judul}}</h6>
                    <input type="hidden" name="idtopik" id="idtopik" value="{{$topik->id}}">
                    @if(auth::user()->role == 2)
                      <input type="hidden" id="namachat" value="{{auth::user()->pegawai->nama}}">
                      <input type="hidden" id="fotochat" value="{{auth::user()->pegawai->photo == null ? asset('images/user-lms.jpg') : 'https://siakad.slua.sch.id/'.auth::user()->pegawai->photo}}">
                    @else
                    @endif
                  </div>
                  <div class="d-flex align-items-center">
                    <div class="dropdown">
                      <button class="btn-icon btn btn-transparent hide-arrow btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i data-feather="more-vertical" id="chat-header-actions" class="font-medium-2"></i>
                      </button>
                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="chat-header-actions">
                        <a class="dropdown-item" href="{{route('home')}}"><i data-feather="home" class="mr-50" style="margin-top:-2px"></i>Dashboard</a>
                        <a class="dropdown-item" href="{{route('pembelajaran',[Session::get('idjadwalglobal'),Session::get('idgambarglobal')])}}"><i data-feather="file-text" class="mr-50" style="margin-top:-2px"></i>{{$data->mapel->nama}}</a>
                      </div>
                    </div>
                  </div>
                </header>
              </div>

              <div class="user-chats p-0">
                <div id="app">
                  @if (count($topik->diskusi) == 0)
                    <div class="start-chat-area">
                      <div class="mb-1 start-chat-icon">
                        <i data-feather="message-square"></i>
                      </div>
                      <h4 class="start-chat-text">
                        <span class="d-block text-center text-muted font-small-3">Belum Ada Percakapan</span>
                        Silakan Mulai Diskusi
                      </h4>
                    </div>
                  @else
                    <div id="chat-area" class="chats p-1">
                      @foreach($topik->diskusi as $d)
                        @if($d->iduser == auth::user()->id)
                          @php
                            if(auth::user()->role == 2){
                              $nama = auth::user()->pegawai->panggilan;
                              $foto = 'https://siakad.slua.sch.id/'.auth::user()->pegawai->photo;
                            }elseif(auth::user()->role == 3){

                            }
                          @endphp
                          <div class="chat">
                            <div class="chat-avatar">
                              <div class="avatar-lecture m-0">
                                <img src="{{$foto}}" alt="avatar" width="100%" />
                              </div>
                            </div>
                            <div class="chat-body">
                              @if($d->iddiskusi != null)
                                @php
                                  if($d->balas->user->role == 2){
                                    $namabalas = $d->balas->user->pegawai->panggilan;
                                  }
                                @endphp
                                <div class="chat-content">
                                  <small class="text-right">{{$namabalas}}</small>
                                  <p>{{$d->balas->diskusi}}</p>
                                </div>
                              @endif
                              <div class="chat-content mr-50">
                                <div class="text-right font-small-3">
                                  {{$nama}} <span class="font-small-1">({{date('d-M-y H:i',strtotime($d->created_at))}})</span>
                                </div>
                                <div class="dropdown-divider" style="border-top: 1px solid #9fb0ef"></div>
                                <p>{{$d->diskusi}}</p>
                                <div class="text-right font-small-2 mt-50">
                                  <a class="balas text-white mr-50" value={{$d->id}}><i data-feather="corner-up-left"></i> Balas</a>
                                  <a class="balas text-white" value={{$d->id}}><i data-feather="trash-2"></i></a>
                                </div>
                              </div>
                            </div>
                          </div>
                        @else
                          @php
                            if(auth::user()->role == 2){
                              $nama = $d->user->pegawai->panggilan;
                              $foto = 'https://siakad.slua.sch.id/'.$d->user->pegawai->photo;
                            }elseif(auth::user()->role == 3){

                            }
                          @endphp
                          <div class="chat chat-left">
                            <div class="chat-avatar">
                              <div class="avatar-lecture mr-0">
                                <img src="{{$foto}}" alt="avatar" width="100%"/>
                              </div>
                            </div>
                            <div class="chat-body">
                              <div class="chat-content ml-50">
                                <div class="font-small-3">
                                  {{$nama}} <span class="text-muted font-small-1">({{date('d-M-y H:i',strtotime($d->created_at))}})</span>
                                </div>
                                <div class="dropdown-divider"></div>
                                @if($d->iddiskusi != null)
                                  @php
                                    if($d->balas->user->role == 2){
                                      $namabalas = $d->balas->user->pegawai->panggilan;
                                    }
                                  @endphp
                                  <div class="card col border-left-primary border-left-3 mb-75 py-50">
                                    <p class="font-small-2" style="line-height: 1rem">
                                      {{$d->balas->diskusi}}
                                    </p>
                                    <footer class="blockquote-footer font-small-1">
                                      {{$namabalas}}
                                    </footer>
                                  </div>
                                @endif
                                <p>{{$d->diskusi}}</p>
                                <div class="text-right font-small-2 mt-50">
                                  <a class="balas text-secondary" value={{$d->id}}><i data-feather="corner-up-left"></i> Balas</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endif
                      @endforeach
                      <div class="divider">
                        <div class="divider-text h5">Hari Ini</div>
                      </div>
                    </div>
                  @endif
                </div>
              </div>
              <form class="chat-app-form" action="javascript:void(0);" onsubmit="enterChat();">
                <div class="input-group input-group-merge mr-1 form-send-message">
                  <input id="type-area" type="text" class="form-control message type-area" placeholder="Tulis sesuatu..." />
                </div>
                <button type="button" class="btn btn-primary send" onclick="enterChat();">
                  <i data-feather="send" class="d-lg-none"></i>
                  <span class="d-none d-lg-block">Kirim</span>
                </button>
                @csrf
              </form>
            </div>
          </section>

          <div class="user-profile-sidebar">
            <header class="user-profile-header">
              <span class="close-icon">
                <i data-feather="x"></i>
              </span>
              <div class="header-profile-sidebar">
                <div class="avatar avatar-lg bg-light-primary avatar-border shadow mb-1">
                  <div class="avatar-content"><i data-feather="twitch"></i></div>
                </div>
                <h6 class="chat-user-name mb-25">{{$topik->judul}}</h6>
                <span class="user-post font-small-3">Daftar Percakapan</span>
              </div>
            </header>
            <div class="user-profile-sidebar-area">
              <h6 class="section-label mb-1">About</h6>
              <p>Toffee caramels jelly-o tart gummi bears cake I love ice cream lollipop.</p>
              <!-- About User -->
              <!-- User's personal information -->
              <div class="personal-info">
                  <h6 class="section-label mb-1 mt-3">Personal Information</h6>
                  <ul class="list-unstyled">
                      <li class="mb-1">
                          <i data-feather="mail" class="font-medium-2 mr-50"></i>
                          <span class="align-middle">kristycandy@email.com</span>
                      </li>
                      <li class="mb-1">
                          <i data-feather="phone-call" class="font-medium-2 mr-50"></i>
                          <span class="align-middle">+1(123) 456 - 7890</span>
                      </li>
                      <li>
                          <i data-feather="clock" class="font-medium-2 mr-50"></i>
                          <span class="align-middle">Mon - Fri 10AM - 8PM</span>
                      </li>
                  </ul>
              </div>
              <!--/ User's personal information -->

              <!-- User's Links -->
              <div class="more-options">
                  <h6 class="section-label mb-1 mt-3">Options</h6>
                  <ul class="list-unstyled">
                      <li class="cursor-pointer mb-1">
                          <i data-feather="tag" class="font-medium-2 mr-50"></i>
                          <span class="align-middle">Add Tag</span>
                      </li>
                      <li class="cursor-pointer mb-1">
                          <i data-feather="star" class="font-medium-2 mr-50"></i>
                          <span class="align-middle">Important Contact</span>
                      </li>
                      <li class="cursor-pointer mb-1">
                          <i data-feather="image" class="font-medium-2 mr-50"></i>
                          <span class="align-middle">Shared Media</span>
                      </li>
                      <li class="cursor-pointer mb-1">
                          <i data-feather="trash" class="font-medium-2 mr-50"></i>
                          <span class="align-middle">Delete Contact</span>
                      </li>
                      <li class="cursor-pointer">
                        <i data-feather="slash" class="font-medium-2 mr-50"></i>
                        <span class="align-middle">Block Contact</span>
                      </li>
                  </ul>
              </div>
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

{{-- <script src="{{asset('js/app.js')}}"></script> --}}
<script src="{{asset('assets/js/chat.js')}}"></script>
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
