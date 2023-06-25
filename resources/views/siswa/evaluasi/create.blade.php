<!DOCTYPE html>
<html lang="en" translate="no">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="google" content="notranslate">
  <title>LMS | Evaluasi</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="icon" type="image/png" href="{{asset('icon.ico')}}" />
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700;800&family=Lato&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('test-assets/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('test-assets/css/animate.min.css')}}">
  <link rel="stylesheet" href="{{asset('test-assets/css/style.css')}}">
  <style>
    .card-text {
      font-size: 14px;
    }
    .step_items-mobile {
      display: flex;
      /* box-shadow: inset 0px 8px 20px #092e25, inset 0px -5px 20px #092e25; */
      padding-top: 10px;
    }

    .step.step-mobile {
      margin: 4px 0;
      padding-right: unset !important;
      /* z-index: -1; */
    }

    .step.step-close {
      background: transparent;
      outline: none;
      border: none;
      font-size: 1.5rem;
      margin: 0;
      line-height: 1
    }

    .step.step-close:after {
      width: 42px;
      height: 40px;
      background: #f00;
      margin-top: 2px;
      border: none;
    }

    .menu-nav-mobile {
      bottom: 70px;
      right: 20px;
      position: fixed;
      z-index: 98;
    }

    .btn-burger-icon {
      background: #0073d6;
      border: none;
      border-radius: 50%;
      outline: none;
      padding-right: 14px;
      padding-left: 14px;
    }
    @media (min-width: 1200px) {
      .btn-burger-icon {
        display: none;
      }
    }
    .burger-icon {
      position: relative;
      top: 13px;
      width: 25px;
      height: 51px;
    }

    .burger-icon span {
      position: absolute;
      right: 0;
      display: block;
      height: 3px;
      background-color: #fff;
    }

    .burger-icon span:nth-child(1) {
      top: 0;
      width: 20px;
    }
    .burger-icon span:nth-child(2) {
      top: 10px;
      width: 110%;
    }
    .burger-icon span:nth-child(3) {
      top: 20px;
      width: 23px;
    }

    #nav-mobile {
      position: fixed;
      display: block;
      top: 0;
      left: 0;
      z-index: 100;
    }

    .nav__links {
      position: fixed;
      /* top: 0;
      left: 0; */
      right: calc(47px - 50vw);
      bottom: calc(105px - 50vh);
      height: 100vh;
      width: 100vw;
      transform: scale(0);
      /* background: linear-gradient(118deg, #1679ea, #0f3b7b); */
      /* transform: translateX(-100vw); */
      transition: all 0.5s ease;
      transition-delay: .4s;
      z-index: 100;
    }

    .nav--open .nav__links {
      /* transform: translateX(0); */
      /* box-shadow: 0 0 15px rgba(0, 0, 0, 0.2); */
      bottom: 0;
      right: 0;
      transform: scale(1);
    }

    .nav__link {
      display: flex;
      align-items: center;
      color: #666666;
      font-weight: bold;
      font-size: 14px;
      text-decoration: none;
      padding: 12px 15px;
      background: transform 0.2s;
    }

    .nav__link > i {
      margin-right: 15px;
    }

    .nav__link--active {
      color: #009578;
    }

    .nav__link--active,
    .nav__link:hover {
      background: #eeeeee;
    }

    .nav__overlay {
      /* position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(2px);
      visibility: hidden;
      opacity: 0;
      transition: opacity 0.3s;
      z-index: 1; */

      position: fixed;
      width: 424vw;
      height: 424vw;
      right: calc(47px - 212vw);
      bottom: calc(105px - 212vw);
      z-index: 3;
      display: block;
      background: linear-gradient(118deg, #1679ea, #0f3b7b);
      -webkit-border-radius: 50%;
      -khtml-border-radius: 50%;
      -moz-border-radius: 50%;
      -ms-border-radius: 50%;
      -o-border-radius: 50%;
      border-radius: 50%;
      -webkit-transform: scale(0);
      -khtml-transform: scale(0);
      -moz-transform: scale(0);
      -ms-transform: scale(0);
      -o-transform: scale(0);
      transform: scale(0);
      -webkit-transform-origin: center;
      transform-origin: center;
      -webkit-transition: transform .8s ease-in;
      -khtml-transition: transform .8s ease-in;
      -moz-transition: transform .8s ease-in;
      -ms-transition: transform .8s ease-in;
      -o-transition: transform .8s ease-in;
      transition: transform .8s ease-in;
      transition-delay: .3s;
      -webkit-transition-delay: .3s;
      z-index: 97;
    }

    .nav--open .nav__overlay {
      /* visibility: visible;
      opacity: 1; */

      -webkit-transform: scale(1);
      -khtml-transform: scale(1);
      -moz-transform: scale(1);
      -ms-transform: scale(1);
      -o-transform: scale(1);
      transform: scale(1);
      transition-delay: 0s;
      -webkit-transition-delay: 0s;
      opacity: 1;
      -webkit-transition: transform 1.6s cubic-bezier(.4,0,0,1);
      -khtml-transition: transform 1.6s cubic-bezier(.4,0,0,1);
      -moz-transition: transform 1.6s cubic-bezier(.4,0,0,1);
      -ms-transition: transform 1.6s cubic-bezier(.4,0,0,1);
      -o-transition: transform 1.6s cubic-bezier(.4,0,0,1);
      transition: transform 1.6s cubic-bezier(.4,0,0,1);
      z-index: 99;
    }

    .close_waktumauhabis {
      position: absolute;
      top: 5px;
      right: 5px;
      /* font-weight: 700; */
      color: #f0;
      /* border-radius: 50%; */
      padding: 3px 8px;
    }

    .soaldisini * {
      -webkit-user-select: none;
      -khtml-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      -o-user-select: none;
      user-select: none;
    }
    /* #close-nav-mobile {
      margin-right: 12px
    } */
  </style>
</head>

<body oncontextmenu="return false">
  <nav id="nav-mobile" class="nav">
    <div class="nav__links">
      <div class="container step-counter-mobile">
        <div class="row justify-content-center align-items-end pt-5 pb-3 mx-0">
          {{-- <div class="count_box d-flex flex-row rounded-pill col-md-auto col-12 order-md-2 mb-md-0 mb-3 mt-3">
            <div class="count_clock ps-1">
              <img src="{{asset('test-assets/images/clock/clock.png')}}" alt="image-not-found">
            </div>
            <div class="count_title px-2">
              <h4 class="text-white">Sisa</h4>
              <span class="text-white">Waktu</span>
            </div>
            <div class="count_number p-3 d-flex justify-content-around align-items-center position-relative overflow-hidden bg-white rounded-pill countdown_timer">
              <div><h3 id="count_hours_mobile" class="mb-0"></h3><span class="text-uppercase">jam</span></div>
              <div><h3 class="mb-0" id="count_min_mobile"></h3><span class="text-uppercase">menit</span></div>
              <div><h3 class="mb-0" id="count_sec_mobile"></h3><span class="text-uppercase">detik</span></div>
            </div>
          </div> --}}
          <div class="countdown-baru-mobile col-auto mb-md-0 mb-3 mt-4">
            <div class="bloc-time hours hours_tes" data-init-value="0">
              <div class="figure hours hours-1">
                <span class="top jam_tes_1"></span>
                <span class="top-back">
                  <span class="jam_tes_1"></span>
                </span>
                <span class="bottom jam_tes_1"></span>
                <span class="bottom-back">
                  <span class="jam_tes_1"></span>
                </span>
              </div>
        
              <div class="figure hours hours-2">
                <span class="top jam_tes_2"></span>
                <span class="top-back">
                  <span class="jam_tes_2"></span>
                </span>
                <span class="bottom jam_tes_2"></span>
                <span class="bottom-back">
                  <span class="jam_tes_2"></span>
                </span>
              </div>

              <span class="count-title" style="color: #fff">Jam</span>
            </div>
        
            <div class="bloc-time min minutes_tes" data-init-value="0">
              <div class="figure min min-1">
                <span class="top menit_tes_1"></span>
                <span class="top-back">
                  <span class="menit_tes_1"></span>
                </span>
                <span class="bottom menit_tes_1"></span>
                <span class="bottom-back">
                  <span class="menit_tes_1"></span>
                </span>        
              </div>
        
              <div class="figure min min-2">
                <span class="top menit_tes_2"></span>
                <span class="top-back">
                  <span class="menit_tes_2"></span>
                </span>
                <span class="bottom menit_tes_2"></span>
                <span class="bottom-back">
                  <span class="menit_tes_2"></span>
                </span>
              </div>

              <span class="count-title" style="color: #fff">Menit</span>
            </div>
        
            <div class="bloc-time sec seconds_tes" data-init-value="0">
              <div class="figure sec sec-1">
                <span class="top detik_tes_1"></span>
                <span class="top-back">
                  <span class="detik_tes_1"></span>
                </span>
                <span class="bottom detik_tes_1"></span>
                <span class="bottom-back">
                  <span class="detik_tes_1"></span>
                </span>          
              </div>
        
              <div class="figure sec sec-2">
                <span class="top detik_tes_2"></span>
                <span class="top-back">
                  <span class="detik_tes_2"></span>
                </span>
                <span class="bottom detik_tes_2"></span>
                <span class="bottom-back">
                  <span class="detik_tes_2"></span>
                </span>
              </div>

              <span class="count-title" style="color: #fff">Detik</span>
            </div>
          </div>
          <div class="col-12 mt-2">
            <div class="row justify-content-between align-items-center">
              <div class="col-auto d-flex align-items-center">
                <img class="title-img" src="{{asset('images/logo.png')}}" alt="">
                <h5 class="m-0 text-white navigasi-text">NAVIGASI SOAL</h5>
              </div>
              <div class="col-auto" id="close-nav-mobile">
                <button class="step step-mobile step-close d-block text-center position-relative">x</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container overflow-scroll step_items-mobile justify-content-center col-12 pb-5">
        <div class="row justify-content-center w-100">
          <?php $no = 1; ?>
          @foreach($tes->soal as $s)
          <div class="col-test">
            <a href="#" id="j-{{$no}}" data-halaman="{{$no}}"
                class="j-{{$no}} step step-mobile text-center position-relative {{ $s->idjawaban != null ? 'finish' : '' }}"
                style="padding: 0 10px;">
                {{$no}}
                <?php $no++ ?>
            </a>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="nav__overlay"></div>
  </nav>
  <main class="wrapper position-relative overflow-x-hidden">

    <input type="hidden" id="berakhir" value="{{$evaluasi->tgl}} {{$evaluasi->berakhir}}">

    <div class="menu-nav-mobile navigasi-soal" style="display: none;">
      <button class="btn-burger-icon" id="open-nav-mobile">
        <div class="burger-icon">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </button>
    </div>
    <div class="container m-0 vh-100">
      <div class="row vh-100 js-get-set-width">
        <div class="position-relative d-none d-xl-block js-get-width lebar_nav">
          <div class="image_holder">
          </div>
          <div class="steps_area step_area_fixed d-none d-xl-block h-100 w-100 js-set-width">
            <div class="row justify-content-center">
              <div class="col-12 mt-4 d-flex align-items-center">
                <!-- <img class="title-img" src="{{asset('images/logo.png')}}" alt=""> -->
                <h5 class="m-0 text-white navigasi-text">NAVIGASI SOAL</h5>
                <form class="btn-done" action="{{route('swa.evaluasi.store')}}" method="post" onsubmit="return confirm('Selesaikan ujian? Anda tidak dapat kembali ke halaman ujian setelahnya.')">
                  <input type="hidden" name="id" value="{{$evaluasi->id}}">
                  <button type="submit" class="btn btn-sm btn-warning" name="button">Selesai Ujian</button>
                  @csrf
                </form>
              </div>
              <div class="step_items justify-content-center col-12 mt-4 navigasi-soal" style="display: none;">
                <div class="row justify-content-center w-100">
                  <?php $no = 1; ?>
                  @foreach($tes->soal as $s)
                  <div class="col-test">
                    <a href="#" id="j-{{$no}}" data-halaman="{{$no}}"
                        class="j-{{$no}} step text-center position-relative p-0 {{ $s->idjawaban != null ? 'finish' : '' }}"
                        style="padding: 0 10px;">
                        {{$no}}
                        <?php $no++ ?>
                    </a>
                  </div>
                  @endforeach
                </div>
              </div>

            </div>
          </div>
        </div>
        <div class="col px-4 pt-3">
          <div class="multisteps_form_panel" style="display: block;">
            <div class="row mx-0">
              <div class="card mb-4 px-0">
                <div class="card-body py-2">
                  <div class="row">
                    {{-- <div class="col-lg-1 col-md-1 text-center mb-25">
                      <div class="avatar bg-gradient-primary shadow p-25 m-25">
                        <div class="avatar-content">
                          <img src="" alt="">
                        </div>
                      </div>
                    </div> --}}
                    <div class="col">
                      <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                          <table>
                            <tr>
                              <td class="card-text">Nama</td>
                              <td class="card-text px-2">:</td>
                              <td class="card-text">{{ $tes->siswa->nama }}</td>
                            </tr>
                            <tr>
                              <td class="card-text">NIS</td>
                              <td class="card-text px-2">:</td>
                              <td class="card-text">{{ $tes->siswa->nis }}</td>
                            </tr>
                            <tr>
                              <td class="card-text">Kelas</td>
                              <td class="card-text px-2">:</td>
                              <td class="card-text">{{ $tes->siswa->kelas->nama }}</td>
                            </tr>
                            <tr>
                              <td class="card-text">Mata Pelajaran</td>
                              <td class="card-text px-2">:</td>
                              <td class="card-text">{{ $tes->evaluasi->jadwal->mapel->nama }}</td>
                            </tr>
                          </table>
                        </div>
                        <div class="col-auto">
                          <div class="countdown-baru-mobile-view col-auto order-md-2 mb-md-0 mb-3 d-none d-lg-block">
                            <div class="bloc-time hours hours_tes" data-init-value="0">
                              <div class="figure hours hours-1">
                                <span class="top jam_tes_1"></span>
                                <span class="top-back">
                                  <span class="jam_tes_1"></span>
                                </span>
                                <span class="bottom jam_tes_1"></span>
                                <span class="bottom-back">
                                  <span class="jam_tes_1"></span>
                                </span>
                              </div>
                        
                              <div class="figure hours hours-2">
                                <span class="top jam_tes_2"></span>
                                <span class="top-back">
                                  <span class="jam_tes_2"></span>
                                </span>
                                <span class="bottom jam_tes_2"></span>
                                <span class="bottom-back">
                                  <span class="jam_tes_2"></span>
                                </span>
                              </div>
            
                              <span class="count-title">Jam</span>
                            </div>
                        
                            <div class="bloc-time min minutes_tes" data-init-value="0">
                              <div class="figure min min-1">
                                <span class="top menit_tes_1"></span>
                                <span class="top-back">
                                  <span class="menit_tes_1"></span>
                                </span>
                                <span class="bottom menit_tes_1"></span>
                                <span class="bottom-back">
                                  <span class="menit_tes_1"></span>
                                </span>        
                              </div>
                        
                              <div class="figure min min-2">
                                <span class="top menit_tes_2"></span>
                                <span class="top-back">
                                  <span class="menit_tes_2"></span>
                                </span>
                                <span class="bottom menit_tes_2"></span>
                                <span class="bottom-back">
                                  <span class="menit_tes_2"></span>
                                </span>
                              </div>
            
                              <span class="count-title">Menit</span>
                            </div>
                        
                            <div class="bloc-time sec seconds_tes" data-init-value="0">
                              <div class="figure sec sec-1">
                                <span class="top detik_tes_1"></span>
                                <span class="top-back">
                                  <span class="detik_tes_1"></span>
                                </span>
                                <span class="bottom detik_tes_1"></span>
                                <span class="bottom-back">
                                  <span class="detik_tes_1"></span>
                                </span>          
                              </div>
                        
                              <div class="figure sec sec-2">
                                <span class="top detik_tes_2"></span>
                                <span class="top-back">
                                  <span class="detik_tes_2"></span>
                                </span>
                                <span class="bottom detik_tes_2"></span>
                                <span class="bottom-back">
                                  <span class="detik_tes_2"></span>
                                </span>
                              </div>
            
                              <span class="count-title">Detik</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row justify-content-center mx-0">
              <div class="countdown-baru col-auto order-md-2 mb-md-0 mb-3 d-lg-none">
                <div class="bloc-time hours hours_tes" data-init-value="0">
                  <div class="figure hours hours-1">
                    <span class="top jam_tes_1"></span>
                    <span class="top-back">
                      <span class="jam_tes_1"></span>
                    </span>
                    <span class="bottom jam_tes_1"></span>
                    <span class="bottom-back">
                      <span class="jam_tes_1"></span>
                    </span>
                  </div>
            
                  <div class="figure hours hours-2">
                    <span class="top jam_tes_2"></span>
                    <span class="top-back">
                      <span class="jam_tes_2"></span>
                    </span>
                    <span class="bottom jam_tes_2"></span>
                    <span class="bottom-back">
                      <span class="jam_tes_2"></span>
                    </span>
                  </div>

                  <span class="count-title">Jam</span>
                </div>
            
                <div class="bloc-time min minutes_tes" data-init-value="0">
                  <div class="figure min min-1">
                    <span class="top menit_tes_1"></span>
                    <span class="top-back">
                      <span class="menit_tes_1"></span>
                    </span>
                    <span class="bottom menit_tes_1"></span>
                    <span class="bottom-back">
                      <span class="menit_tes_1"></span>
                    </span>        
                  </div>
            
                  <div class="figure min min-2">
                    <span class="top menit_tes_2"></span>
                    <span class="top-back">
                      <span class="menit_tes_2"></span>
                    </span>
                    <span class="bottom menit_tes_2"></span>
                    <span class="bottom-back">
                      <span class="menit_tes_2"></span>
                    </span>
                  </div>

                  <span class="count-title">Menit</span>
                </div>
            
                <div class="bloc-time sec seconds_tes" data-init-value="0">
                  <div class="figure sec sec-1">
                    <span class="top detik_tes_1"></span>
                    <span class="top-back">
                      <span class="detik_tes_1"></span>
                    </span>
                    <span class="bottom detik_tes_1"></span>
                    <span class="bottom-back">
                      <span class="detik_tes_1"></span>
                    </span>          
                  </div>
            
                  <div class="figure sec sec-2">
                    <span class="top detik_tes_2"></span>
                    <span class="top-back">
                      <span class="detik_tes_2"></span>
                    </span>
                    <span class="bottom detik_tes_2"></span>
                    <span class="bottom-back">
                      <span class="detik_tes_2"></span>
                    </span>
                  </div>

                  <span class="count-title">Detik</span>
                </div>
              </div>
            </div>
            <div class="waktumauhabis pb-4 position-relative" style="display: none;">
              <div class="alert alert-warning mb-0" role="alert">
                <h4 class="alert-heading"><i data-feather="info"></i>WAKTU SEGERA HABIS</h4>
                <div class="alert-body mb-2">
                  Sisa Waktu Kurang Dari 10 Menit
                </div>
              </div>
              <button class="close_waktumauhabis btn btn-sm btn-danger">X</button>
            </div>
            <div class="waktuhabis pb-4" style="display: none;">
              <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading"><i data-feather="info"></i>WAKTU HABIS</h4>
                <div class="alert-body mb-2">
                  Silahkan Klik Tombol Selesai Ujian
                </div>
                <form action="{{route('swa.evaluasi.store')}}" method="post" onsubmit="return confirm('Selesaikan ujian? Anda tidak dapat kembali ke halaman ujian setelahnya.')">
                  <input type="hidden" name="id" value="{{$evaluasi->id}}">
                  <button type="submit" class="btn btn-warning" name="button">Selesai Ujian</button>
                  @csrf
                </form>
              </div>
            </div>
            <div class="row justify-content-md-between justify-content-center align-items-end pt-0 pb-3 pertanyaan-step">
              {{-- <div class="countdown-baru col-auto order-md-2 mb-md-0 mb-3 d-lg-none">
                <div class="bloc-time hours hours_tes" data-init-value="0">
                  <div class="figure hours hours-1">
                    <span class="top jam_tes_1"></span>
                    <span class="top-back">
                      <span class="jam_tes_1"></span>
                    </span>
                    <span class="bottom jam_tes_1"></span>
                    <span class="bottom-back">
                      <span class="jam_tes_1"></span>
                    </span>
                  </div>
            
                  <div class="figure hours hours-2">
                    <span class="top jam_tes_2"></span>
                    <span class="top-back">
                      <span class="jam_tes_2"></span>
                    </span>
                    <span class="bottom jam_tes_2"></span>
                    <span class="bottom-back">
                      <span class="jam_tes_2"></span>
                    </span>
                  </div>

                  <span class="count-title">Jam</span>
                </div>
            
                <div class="bloc-time min minutes_tes" data-init-value="0">
                  <div class="figure min min-1">
                    <span class="top menit_tes_1"></span>
                    <span class="top-back">
                      <span class="menit_tes_1"></span>
                    </span>
                    <span class="bottom menit_tes_1"></span>
                    <span class="bottom-back">
                      <span class="menit_tes_1"></span>
                    </span>        
                  </div>
            
                  <div class="figure min min-2">
                    <span class="top menit_tes_2"></span>
                    <span class="top-back">
                      <span class="menit_tes_2"></span>
                    </span>
                    <span class="bottom menit_tes_2"></span>
                    <span class="bottom-back">
                      <span class="menit_tes_2"></span>
                    </span>
                  </div>

                  <span class="count-title">Menit</span>
                </div>
            
                <div class="bloc-time sec seconds_tes" data-init-value="0">
                  <div class="figure sec sec-1">
                    <span class="top detik_tes_1"></span>
                    <span class="top-back">
                      <span class="detik_tes_1"></span>
                    </span>
                    <span class="bottom detik_tes_1"></span>
                    <span class="bottom-back">
                      <span class="detik_tes_1"></span>
                    </span>          
                  </div>
            
                  <div class="figure sec sec-2">
                    <span class="top detik_tes_2"></span>
                    <span class="top-back">
                      <span class="detik_tes_2"></span>
                    </span>
                    <span class="bottom detik_tes_2"></span>
                    <span class="bottom-back">
                      <span class="detik_tes_2"></span>
                    </span>
                  </div>

                  <span class="count-title">Detik</span>
                </div>
              </div> --}}
              <div class="d-xl-none d-flex col-12 float-right order-md-3 row justify-content-xl-end justify-content-center">
                <div class="col-auto mt-md-3 mb-md-0 mb-2">
                  <form class="" action="{{route('swa.evaluasi.store')}}" method="post" onsubmit="return confirm('Selesaikan ujian? Anda tidak dapat kembali ke halaman ujian setelahnya.')">
                    <input type="hidden" name="id" value="{{$evaluasi->id}}">
                    <button type="submit" class="btn btn-sm btn-warning" name="button">Selesai Ujian</button>
                    @csrf
                  </form>
                </div>
              </div>
              <span class="step_content text-center col-md-auto col-12 order-md-1">Pertanyaan <b id="halaman"></b> dari {{count($tes->soal)}}</span>
            </div>
            <div class="step_progress_bar">
              <div class="progress rounded-pill">
                <div class="progress-bar"></div>
              </div>
            </div>
            <div class="soal js-get-set-width-soal" style="display: none;">
              <div class="soaldisini js-get-width-soal">

              </div>
              <div class="js-set-width-soal" style="position: fixed; bottom: 0; background: #fff;">
                <div class="dropdown-divider mb-0"></div>
                <div class="form_btn py-lg-4 pt-2 pb-3 d-flex justify-content-between">
                  <a href="#" class="prev_btn bg-white hide-btn" id="prevBtn">
                    <span style="margin-right: 10px;"><i class="fas fa-arrow-left"></i></span> Sebelumnya
                  </a>
                  <a href="#" class="prev_btn bg-white hide-btn" id="nextBtn">
                    Selanjutnya <span style="margin-left: 10px;"><i class="fas fa-arrow-right"></i></span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="{{asset('test-assets/js/jquery-3.6.0.min.js')}}"></script>
  <script src="{{asset('test-assets/js/countdown.js')}}"></script>
  <script src="{{asset('test-assets/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('test-assets/js/jquery.validate.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script>
    
    // dont inspect element
    // Disable right-click
    document.addEventListener('contextmenu', (e) => e.preventDefault());

    function ctrlShiftKey(e, keyCode) {
      return e.ctrlKey && e.shiftKey && e.keyCode === keyCode.charCodeAt(0);
    }

    document.onkeydown = (e) => {
      // Disable F12, Ctrl + Shift + I, Ctrl + Shift + J, Ctrl + U
      if (
        event.keyCode === 123 ||
        ctrlShiftKey(e, 'I') ||
        ctrlShiftKey(e, 'J') ||
        ctrlShiftKey(e, 'C') ||
        (e.ctrlKey && e.keyCode === 'U'.charCodeAt(0))
      )
        return false;
    };

  // $(window).on('load', function(){

    window.addEventListener("focus", function(event) { 
      console.log('refresh time');
      Countdown.destroy();
      Countdown_mobile.destroy();
      Countdown_mobile_view.destroy();
      clearInterval(x);
      get_countdown_test();
      Countdown.init();
      Countdown_mobile.init();
      Countdown_mobile_view.init();
    }, false);

    
    var soalke = {{ request()->input('page') == null ? 1 : request()->input('page') }};
    var terjawab = 0;

    window.onpopstate = function (e) {
      soalke = location.href.split("page=")[1];
      getsoal(soalke, 1)
    }

    function changeURL(page) {
      // Current URL: http://lms.test/siswa/evaluasi/create/{{$evaluasi->id}}
      let nextURL = '{{ asset('/') }}siswa/evaluasi/create/{{$evaluasi->id}}?page='+page;
      let nextTitle = 'Evaluasi Siswa';
      let nextState = { additionalInformation: 'Updated the URL with JS' };

      // This will create a new entry in the browser's history, without reloading
      window.history.pushState(nextState, nextTitle, nextURL);

      // This will replace the current entry in the browser's history, without reloading
      window.history.replaceState(nextState, nextTitle, nextURL);
    }

    document.onkeydown = (e) => {
      e = e || window.event;
      if ({{ count($tes->soal) }} <= 50) {
        if (soalke > 5 && (e.keyCode === 38 || e.keyCode === 87)) {
          soalke-=5
          getsoal(soalke)
        } else if (soalke <= ({{ count($tes->soal) }} - 5) && (e.keyCode === 40 || e.keyCode === 83)) {
          soalke+=5
          getsoal(soalke)
        }
      } else {
        if (soalke > 10 && (e.keyCode === 38 || e.keyCode === 87)) {
          soalke-=10
          getsoal(soalke)
        } else if (soalke <= ({{ count($tes->soal) }} - 10) && (e.keyCode === 40 || e.keyCode === 83)) {
          soalke+=10
          getsoal(soalke)
        }
      }


      if (soalke > 1 && (e.keyCode === 37 || e.keyCode === 65)) {
        $('#prevBtn').click()
      } else if (soalke < {{ count($tes->soal) }} && (e.keyCode === 39 || e.keyCode === 68)) {
        $('#nextBtn').click()
      }
    }

    $('.close_waktumauhabis').on('click', function (e) {
      e.preventDefault()
      
      $(this).parent().hide(800);
      setTimeout(() => {
        $(this).parent().addClass('d-none');
      }, 800);
    })


    $('#halaman').text(soalke)

    getsoal(soalke)

    function getsoal(soalke, ubahurl){
      $('.step:not(.step-close)[data-halaman="'+soalke+'"]').addClass('loading-soal');
      $.get('{{ asset('/') }}siswa/evaluasi/getsoal/{{$tes->id}}/'+soalke, function(data){
        
        if (ubahurl == undefined) {
          changeURL(soalke)
        }

        $('.soaldisini').html(data)
        $('.step').removeClass('active loading-soal');
        $('.j-'+soalke).addClass('active');

        $('#halaman').text(soalke)

        if (soalke >= '{{count($tes->soal)}}' ) {
          // $('#nextBtn').hide()
          $('#nextBtn').addClass('hide-btn')
        }
        if (soalke > 1) {
          // $('#prevBtn').show()
          $('#prevBtn').removeClass('hide-btn')
        }
        
        if (soalke < '{{count($tes->soal)}}' ) {
          // $('#nextBtn').show()
          $('#nextBtn').removeClass('hide-btn')
        }
        
        if (soalke == 1) {
          // $('#prevBtn').hide()
          $('#prevBtn').addClass('hide-btn')
        }

        $('.jawaban').on('click', function() {
          jawaban = $(this).val();
          $.get('{{ asset('/') }}siswa/evaluasi/jawab/'+jawaban, function(data){
            $('.jawaban').parent().removeClass('active');
            $("#soal"+data).parent().addClass("active");
            $('.j-'+soalke).addClass('finish');
            terjawab = $('.step_items.navigasi-soal .step.finish').length
            progress = terjawab/'{{count($tes->soal)}}' * 100
            $('.progress-bar').removeAttr("style");
            $('.progress-bar').css('width',''+progress+'%');

            // console.log(hours, minutes, seconds);

            // $(".hours_tes").attr("data-init-value", hours);
            // $(".minutes_tes").attr("data-init-value", minutes);
            // $(".seconds_tes").attr("data-init-value", seconds);

            // Countdown.init();
            // Countdown_mobile.init();
          })
        });
        
        terjawab = $('.step_items.navigasi-soal .step.finish').length
        progress = terjawab/'{{count($tes->soal)}}' * 100
        $('.progress-bar').removeAttr("style");
        $('.progress-bar').css('width',''+progress+'%');

        js_get_set_width_soal()

      }).always(function() {
        // $('.step').removeClass('loading-soal');
        $('#nav-mobile').removeClass('nav--open');
      });
    }

    $('.step').not('.step-close').on('click', function(e){
      e.preventDefault()

      // $(this).addClass('loading-soal');
      soalke = $(this).data('halaman')
      getsoal(soalke)
    })

    $('#nextBtn').on('click', function(e){
      e.preventDefault()
      
      soalke+=1
      getsoal(soalke)
    })

    $('#prevBtn').on('click', function(e){
      e.preventDefault()
      
      soalke-=1
      getsoal(soalke)
    })

    // jawaban (.stepnya)
    $(".stepnya").on('click', function(){
      $(this).parent().parent().find(".stepnya").removeClass("active");
      $(this).addClass("active");
    });
  // });

  $('.navigasi-soal').hide();
  $('.waktuhabis').hide();
  $('.waktumauhabis').hide();
    halaman = window.location['search'];
    halaman = halaman.split('=')
    shalaman = '{{ count($tes->soal) }}'
    progress = halaman[1] / shalaman * 100
    $('.progress-bar').removeAttr("style");
    $('.progress-bar').css('width',''+progress+'%');


    // Set the date we're counting down to
  var end_date = $('#berakhir').val()
  var countDownDate = moment(end_date, 'YYYY-MM-DD HH:mm:ss').toDate();
  var xmlHttp;
  function srvTime(){
      try {
          //FF, Opera, Safari, Chrome
          xmlHttp = new XMLHttpRequest();
      }
      catch (err1) {
          //IE
          try {
              xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
          }
          catch (err2) {
              try {
                  xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
              }
              catch (eerr3) {
                  //AJAX not supported, use CPU time.
                  alert("AJAX not supported");
              }
          }
      }
      xmlHttp.open('HEAD',window.location.href.toString(),false);
      xmlHttp.setRequestHeader("Content-Type", "text/html");
      xmlHttp.send('');
      return xmlHttp.getResponseHeader("Date");
  }
  var st = srvTime();

  var now = new Date(st);
  convertTZ(now, "Asia/Singapore")
  function convertTZ(date, tzString) {
    now = new Date((typeof date === "string" ? new Date(date) : date).toLocaleString("en-US", {timeZone: tzString}));
  }

  // var now = new Date().getTime();
  // Find the distance between now and the count down date
  var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    days = days < 0 ? 0 : days;
    hours = hours < 0 ? 0 : hours;
    minutes = minutes < 0 ? 0 : minutes;
    seconds = seconds < 0 ? 0 : seconds;

    $(".jam_tes_1").text( String(hours)[1] == undefined ? 0 : (String(hours)[0] == undefined ? 0 : String(hours)[0]) );
    $(".jam_tes_2").text( String(hours)[1] == undefined ? String(hours)[0] : String(hours)[1] );
    $(".menit_tes_1").text( String(minutes)[1] == undefined ? 0 : (String(minutes)[0] == undefined ? 0 : String(minutes)[0]) );
    $(".menit_tes_2").text( String(minutes)[1] == undefined ? String(minutes)[0] : String(minutes)[1] );
    $(".detik_tes_1").text( String(seconds)[1] == undefined ? 0 : (String(seconds)[0] == undefined ? 0 : String(seconds)[0]) );
    $(".detik_tes_2").text( String(seconds)[1] == undefined ? String(seconds)[0] : String(seconds)[1] );

    $(".hours_tes").attr("data-init-value", hours);
    $(".minutes_tes").attr("data-init-value", minutes);
    $(".seconds_tes").attr("data-init-value", seconds);


    if(distance < 0) {
      $('.pertanyaan-step').hide()
      $('.pertanyaan-step').parent().css('height', 'auto')
      $('.step_progress_bar').hide()
      $('.soal').hide()
      $('.waktuhabis').show()
      $('.waktumauhabis').hide()
    } else {
      $('.navigasi-soal').show();
      $('.soal').show();

      if (minutes >= 0 && minutes < 10 && hours < 1) {
        $('.waktumauhabis').show()
      }
    }

    
    function get_countdown_test() {
      end_date = $('#berakhir').val()
      countDownDate = moment(end_date, 'YYYY-MM-DD HH:mm:ss').toDate();
      st = srvTime();
      now = new Date(st);
      convertTZ(now, "Asia/Singapore");
      distance = countDownDate - now;

      days = Math.floor(distance / (1000 * 60 * 60 * 24));
      hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      seconds = Math.floor((distance % (1000 * 60)) / 1000);

      days = days < 0 ? 0 : days;
      hours = hours < 0 ? 0 : hours;
      minutes = minutes < 0 ? 0 : minutes;
      seconds = seconds < 0 ? 0 : seconds;

      $(".jam_tes_1").text( String(hours)[1] == undefined ? 0 : (String(hours)[0] == undefined ? 0 : String(hours)[0]) );
      $(".jam_tes_2").text( String(hours)[1] == undefined ? String(hours)[0] : String(hours)[1] );
      $(".menit_tes_1").text( String(minutes)[1] == undefined ? 0 : (String(minutes)[0] == undefined ? 0 : String(minutes)[0]) );
      $(".menit_tes_2").text( String(minutes)[1] == undefined ? String(minutes)[0] : String(minutes)[1] );
      $(".detik_tes_1").text( String(seconds)[1] == undefined ? 0 : (String(seconds)[0] == undefined ? 0 : String(seconds)[0]) );
      $(".detik_tes_2").text( String(seconds)[1] == undefined ? String(seconds)[0] : String(seconds)[1] );

      $(".hours_tes").attr("data-init-value", hours);
      $(".minutes_tes").attr("data-init-value", minutes);
      $(".seconds_tes").attr("data-init-value", seconds);

      if(distance < 0) {
        $('.pertanyaan-step').hide()
        $('.pertanyaan-step').parent().css('height', 'auto')
        $('.step_progress_bar').hide()
        $('.soal').hide()
        $('.waktuhabis').show()
        $('.waktumauhabis').hide()
      } else {
        $('.waktumauhabis').hide()
        $('.waktuhabis').hide()
        $('.navigasi-soal').show();
        $('.soal').show();

        if (minutes >= 0 && minutes < 10 && hours < 1) {
          $('.waktumauhabis').show()
        }
      }

      x = setInterval(function() {

        distance = distance - 1000;
        // Get today's date and time

        // Time calculations for days, hours, minutes and seconds
        days = Math.floor(distance / (1000 * 60 * 60 * 24));

        hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        seconds = Math.floor((distance % (1000 * 60)) / 1000);


        if (minutes >= 0 && minutes < 10 && hours < 1) {
          $('.waktumauhabis').show()
        }

        if (distance < 0) {
          $('.soal').hide()
          $('.waktuhabis').show()
          $('.waktumauhabis').hide()
          $('.navigasi-soal').hide()
        }
        if (distance < 0) {
          clearInterval(x);
          $('.pertanyaan-step').hide()
          $('.pertanyaan-step').parent().css('height', 'auto')
          $('.step_progress_bar').hide()
          $('#nav-mobile').removeClass('nav--open')
        }

      }, 1000);
      
    }


  var x = setInterval(function() {

    distance = distance - 1000;
    // Get today's date and time


    // Time calculations for days, hours, minutes and seconds
    days = Math.floor(distance / (1000 * 60 * 60 * 24));
    hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    seconds = Math.floor((distance % (1000 * 60)) / 1000);

    days = days < 0 ? 0 : days;
    hours = hours < 0 ? 0 : hours;
    minutes = minutes < 0 ? 0 : minutes;
    seconds = seconds < 0 ? 0 : seconds;

    if (minutes >= 0 && minutes < 10 && hours < 1) {
      $('.waktumauhabis').show()
    }

    if (distance < 0) {
      Countdown.destroy();
      Countdown_mobile.destroy();
      Countdown_mobile_view.destroy();
      get_countdown_test();
      Countdown.init();
      Countdown_mobile.init();
      Countdown_mobile_view.init();
      
      $('.soal').hide()
      $('.waktuhabis').show()
      $('.waktumauhabis').hide()
      $('.navigasi-soal').hide()
    }
    if (distance < 0) {
      clearInterval(x);
      $('.pertanyaan-step').hide()
      $('.pertanyaan-step').parent().css('height', 'auto')
      $('.step_progress_bar').hide()
      $('#nav-mobile').removeClass('nav--open')
    }

  }, 1000);

  if ({{ count($tes->soal) }} <= 50) {
    $('.lebar_nav').addClass('col-xl-3');
    $('.navigasi-soal').addClass('navigasi-50');
    $('#nav-mobile').addClass('navigasi-50');
    $('#nav-mobile').find('.step_items-mobile').find('.col-auto').removeClass('.col-auto').addClass('.col-test');
    js_get_set_width();
  } else {
    $('.lebar_nav').addClass('col-xl-4');
    $('.navigasi-soal').removeClass('navigasi-50');
    $('#nav-mobile').removeClass('navigasi-50')
    $('#nav-mobile').find('.step_items-mobile').find('.col-test').removeClass('.col-test').addClass('.col-auto')
    js_get_set_width();
  }

  function js_get_set_width() {
    if ($('.js-get-set-width').length) {
      $('.js-get-set-width').find('.js-set-width').css('max-width', $('.js-get-width').outerWidth() - 24);
      $(window).on('resize', function() {
        $('.js-get-set-width').find('.js-set-width').css('max-width', $('.js-get-width').outerWidth() - 24);
      })
    }
  }

  function js_get_set_width_soal() {
    if ($('.js-get-set-width-soal').length) {
      $('.js-get-set-width-soal').find('.js-set-width-soal').css('width', $('.js-get-width-soal').outerWidth());
      $(window).on('resize', function() {
        $('.js-get-set-width-soal').find('.js-set-width-soal').css('width', $('.js-get-width-soal').outerWidth());
      })
    }
  }

  $('.step_items-mobile').css('height', 'calc(100vh - (' + $('.step-counter-mobile').outerHeight() + 'px + 150px))');

  $('#nav-mobile').on('click', '#close-nav-mobile', function (e) {
    e.preventDefault();

    $(this).parents('#nav-mobile').removeClass('nav--open');
  });

  $('.wrapper').on('click', '#open-nav-mobile', function (e) {
    e.preventDefault();

    $('#nav-mobile').addClass('nav--open');
  });

  $(window).on('resize', function (e) {
    if ($(window).width() > 1200) {
      $('#nav-mobile').removeClass('nav--open');
    }
  })

  </script>


  <script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js'></script>
  <script>
    // Create Countdown
    var Countdown = {
      
      // Backbone-like structure
      $el: $('.countdown-baru'),
      
      // Params
      countdown_interval: null,
      total_seconds     : 0,
      
      // Initialize the countdown  
      init: function() {

        // DOM
        this.$ = {
          hours  : this.$el.find('.bloc-time.hours .figure'),
          minutes: this.$el.find('.bloc-time.min .figure'),
          seconds: this.$el.find('.bloc-time.sec .figure')
        };

        // Init countdown values
        this.values = {
            hours  : this.$.hours.parent().attr('data-init-value'),
            minutes: this.$.minutes.parent().attr('data-init-value'),
            seconds: this.$.seconds.parent().attr('data-init-value'),
        };
        
        // Initialize total seconds
        this.total_seconds = this.values.hours * 60 * 60 + (this.values.minutes * 60) + this.values.seconds;

        // Animate countdown to the end 
        this.count();    
      },
      
      destroy: function() {
        clearInterval(this.countdown_interval);
      },

      count: function() {
        
        var that    = this,
            $hour_1 = this.$.hours.eq(0),
            $hour_2 = this.$.hours.eq(1),
            $min_1  = this.$.minutes.eq(0),
            $min_2  = this.$.minutes.eq(1),
            $sec_1  = this.$.seconds.eq(0),
            $sec_2  = this.$.seconds.eq(1);
        
            this.countdown_interval = setInterval(function() {

              if(that.total_seconds > 0) {

                  --that.values.seconds;              

                  if(that.values.minutes >= 0 && that.values.seconds < 0) {

                      that.values.seconds = 59;
                      --that.values.minutes;
                  }

                  if(that.values.hours >= 0 && that.values.minutes < 0) {

                      that.values.minutes = 59;
                      --that.values.hours;
                  }

                  // Update DOM values
                  // Hours
                  that.checkHour(that.values.hours, $hour_1, $hour_2);

                  // Minutes
                  that.checkHour(that.values.minutes, $min_1, $min_2);

                  // Seconds
                  that.checkHour(that.values.seconds, $sec_1, $sec_2);

                  --that.total_seconds;
              }
              else {
                  clearInterval(that.countdown_interval);
              }

            }, 1000);
      },
      
      animateFigure: function($el, value) {
        
        var that         = this,
            $top         = $el.find('.top'),
            $bottom      = $el.find('.bottom'),
            $back_top    = $el.find('.top-back'),
            $back_bottom = $el.find('.bottom-back');

        // Before we begin, change the back value
        $back_top.find('span').html(value);

        // Also change the back bottom value
        $back_bottom.find('span').html(value);

        // Then animate
        TweenMax.to($top, 0.8, {
            rotationX           : '-180deg',
            transformPerspective: 300,
            ease                : Quart.easeOut,
            onComplete          : function() {

                $top.html(value);

                $bottom.html(value);

                TweenMax.set($top, { rotationX: 0 });
            }
        });

        TweenMax.to($back_top, 0.8, { 
            rotationX           : 0,
            transformPerspective: 300,
            ease                : Quart.easeOut, 
            clearProps          : 'all' 
        });    
      },
      
      checkHour: function(value, $el_1, $el_2) {
        
        var val_1       = value.toString().charAt(0),
            val_2       = value.toString().charAt(1),
            fig_1_value = $el_1.find('.top').html(),
            fig_2_value = $el_2.find('.top').html();

        if(value >= 10) {

            // Animate only if the figure has changed
            if(fig_1_value !== val_1) this.animateFigure($el_1, val_1);
            if(fig_2_value !== val_2) this.animateFigure($el_2, val_2);
        }
        else {

            // If we are under 10, replace first figure with 0
            if(fig_1_value !== '0') this.animateFigure($el_1, 0);
            if(fig_2_value !== val_1) this.animateFigure($el_2, val_1);
        }    
      }
    };

    var Countdown_mobile = {
      
      // Backbone-like structure
      $el: $('.countdown-baru-mobile'),
      
      // Params
      countdown_interval: null,
      total_seconds     : 0,
      
      // Initialize the countdown  
      init: function() {
        
        // DOM
        this.$ = {
          hours  : this.$el.find('.bloc-time.hours .figure'),
          minutes: this.$el.find('.bloc-time.min .figure'),
          seconds: this.$el.find('.bloc-time.sec .figure')
        };

        // Init countdown values
        this.values = {
            hours  : this.$.hours.parent().attr('data-init-value'),
            minutes: this.$.minutes.parent().attr('data-init-value'),
            seconds: this.$.seconds.parent().attr('data-init-value'),
        };
        
        // Initialize total seconds
        this.total_seconds = this.values.hours * 60 * 60 + (this.values.minutes * 60) + this.values.seconds;

        // Animate countdown to the end 
        this.count();    
      },

      destroy: function() {
        clearInterval(this.countdown_interval);
      },
      
      count: function() {
        
        var that    = this,
            $hour_1 = this.$.hours.eq(0),
            $hour_2 = this.$.hours.eq(1),
            $min_1  = this.$.minutes.eq(0),
            $min_2  = this.$.minutes.eq(1),
            $sec_1  = this.$.seconds.eq(0),
            $sec_2  = this.$.seconds.eq(1);
        
            this.countdown_interval = setInterval(function() {

              if(that.total_seconds > 0) {

                  --that.values.seconds;              

                  if(that.values.minutes >= 0 && that.values.seconds < 0) {

                      that.values.seconds = 59;
                      --that.values.minutes;
                  }

                  if(that.values.hours >= 0 && that.values.minutes < 0) {

                      that.values.minutes = 59;
                      --that.values.hours;
                  }

                  // Update DOM values
                  // Hours
                  that.checkHour(that.values.hours, $hour_1, $hour_2);

                  // Minutes
                  that.checkHour(that.values.minutes, $min_1, $min_2);

                  // Seconds
                  that.checkHour(that.values.seconds, $sec_1, $sec_2);

                  --that.total_seconds;
              }
              else {
                  clearInterval(that.countdown_interval);
              }
            }, 1000);    
      },
      
      animateFigure: function($el, value) {
        
        var that         = this,
            $top         = $el.find('.top'),
            $bottom      = $el.find('.bottom'),
            $back_top    = $el.find('.top-back'),
            $back_bottom = $el.find('.bottom-back');

        // Before we begin, change the back value
        $back_top.find('span').html(value);

        // Also change the back bottom value
        $back_bottom.find('span').html(value);

        // Then animate
        TweenMax.to($top, 0.8, {
            rotationX           : '-180deg',
            transformPerspective: 300,
            ease                : Quart.easeOut,
            onComplete          : function() {

                $top.html(value);

                $bottom.html(value);

                TweenMax.set($top, { rotationX: 0 });
            }
        });

        TweenMax.to($back_top, 0.8, { 
            rotationX           : 0,
            transformPerspective: 300,
            ease                : Quart.easeOut, 
            clearProps          : 'all' 
        });    
      },
      
      checkHour: function(value, $el_1, $el_2) {
        
        var val_1       = value.toString().charAt(0),
            val_2       = value.toString().charAt(1),
            fig_1_value = $el_1.find('.top').html(),
            fig_2_value = $el_2.find('.top').html();

        if(value >= 10) {

            // Animate only if the figure has changed
            if(fig_1_value !== val_1) this.animateFigure($el_1, val_1);
            if(fig_2_value !== val_2) this.animateFigure($el_2, val_2);
        }
        else {

            // If we are under 10, replace first figure with 0
            if(fig_1_value !== '0') this.animateFigure($el_1, 0);
            if(fig_2_value !== val_1) this.animateFigure($el_2, val_1);
        }    
      }
    };

    var Countdown_mobile_view = {
      
      // Backbone-like structure
      $el: $('.countdown-baru-mobile-view'),
      
      // Params
      countdown_interval: null,
      total_seconds     : 0,
      
      // Initialize the countdown  
      init: function() {
        
        // DOM
        this.$ = {
          hours  : this.$el.find('.bloc-time.hours .figure'),
          minutes: this.$el.find('.bloc-time.min .figure'),
          seconds: this.$el.find('.bloc-time.sec .figure')
        };

        // Init countdown values
        this.values = {
            hours  : this.$.hours.parent().attr('data-init-value'),
            minutes: this.$.minutes.parent().attr('data-init-value'),
            seconds: this.$.seconds.parent().attr('data-init-value'),
        };
        
        // Initialize total seconds
        this.total_seconds = this.values.hours * 60 * 60 + (this.values.minutes * 60) + this.values.seconds;

        // Animate countdown to the end 
        this.count();    
      },

      destroy: function() {
        clearInterval(this.countdown_interval);
      },
      
      count: function() {
        
        var that    = this,
            $hour_1 = this.$.hours.eq(0),
            $hour_2 = this.$.hours.eq(1),
            $min_1  = this.$.minutes.eq(0),
            $min_2  = this.$.minutes.eq(1),
            $sec_1  = this.$.seconds.eq(0),
            $sec_2  = this.$.seconds.eq(1);
        
            this.countdown_interval = setInterval(function() {

              if(that.total_seconds > 0) {

                  --that.values.seconds;              

                  if(that.values.minutes >= 0 && that.values.seconds < 0) {

                      that.values.seconds = 59;
                      --that.values.minutes;
                  }

                  if(that.values.hours >= 0 && that.values.minutes < 0) {

                      that.values.minutes = 59;
                      --that.values.hours;
                  }

                  // Update DOM values
                  // Hours
                  that.checkHour(that.values.hours, $hour_1, $hour_2);

                  // Minutes
                  that.checkHour(that.values.minutes, $min_1, $min_2);

                  // Seconds
                  that.checkHour(that.values.seconds, $sec_1, $sec_2);

                  --that.total_seconds;
              }
              else {
                  clearInterval(that.countdown_interval);
              }
            }, 1000);    
      },
      
      animateFigure: function($el, value) {
        
        var that         = this,
            $top         = $el.find('.top'),
            $bottom      = $el.find('.bottom'),
            $back_top    = $el.find('.top-back'),
            $back_bottom = $el.find('.bottom-back');

        // Before we begin, change the back value
        $back_top.find('span').html(value);

        // Also change the back bottom value
        $back_bottom.find('span').html(value);

        // Then animate
        TweenMax.to($top, 0.8, {
            rotationX           : '-180deg',
            transformPerspective: 300,
            ease                : Quart.easeOut,
            onComplete          : function() {

                $top.html(value);

                $bottom.html(value);

                TweenMax.set($top, { rotationX: 0 });
            }
        });

        TweenMax.to($back_top, 0.8, { 
            rotationX           : 0,
            transformPerspective: 300,
            ease                : Quart.easeOut, 
            clearProps          : 'all' 
        });    
      },
      
      checkHour: function(value, $el_1, $el_2) {
        
        var val_1       = value.toString().charAt(0),
            val_2       = value.toString().charAt(1),
            fig_1_value = $el_1.find('.top').html(),
            fig_2_value = $el_2.find('.top').html();

        if(value >= 10) {

            // Animate only if the figure has changed
            if(fig_1_value !== val_1) this.animateFigure($el_1, val_1);
            if(fig_2_value !== val_2) this.animateFigure($el_2, val_2);
        }
        else {

            // If we are under 10, replace first figure with 0
            if(fig_1_value !== '0') this.animateFigure($el_1, 0);
            if(fig_2_value !== val_1) this.animateFigure($el_2, val_1);
        }    
      }
    };

    // Let's go !
    Countdown.init(); 
    
    Countdown_mobile.init();

    Countdown_mobile_view.init();
  </script>
</body>

</html>
