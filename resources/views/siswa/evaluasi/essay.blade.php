<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LMS | Evaluasi</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="icon" type="image/png" href="{{asset('icon.ico')}}" />
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700;800&family=Lato&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('test-assets/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('test-assets/css/animate.min.css')}}">
  <link rel="stylesheet" href="{{asset('test-assets/css/style.css')}}">
  <style>
    .pr-0 {
      padding-right: 0 !important;
    }
  </style>
</head>

<body>
  <div class="wrapper position-relative overflow-x-hidden">
    <div class="container m-0 vh-100">
      <div class="row vh-100 js-get-set-width">
        <div class="col-12 px-4 pt-3">
          <div class="waktumauhabis pb-4" style="display: none;">
            <div class="alert alert-warning mb-0" role="alert">
              <h4 class="alert-heading"><i data-feather="info"></i>WAKTU SEGERA HABIS</h4>
              <div class="alert-body">
                Sisa Waktu Kurang Dari 10 Menit
              </div>
            </div>
          </div>
          <div class="multisteps_form_panel" style="display: block;">

            <input type="hidden" id="berakhir" value="{{$evaluasi->tgl}} {{$evaluasi->berakhir}}">

              <div class="row justify-content-start align-items-end essay-judul">
                <div class="count_box essay_count d-flex flex-row rounded-pill col-md-auto col-12 order-md-last mb-md-0 mb-4" style="z-index: 5">
                  <div class="count_clock ps-1">
                    <img src="{{asset('test-assets/images/clock/clock.png')}}" alt="image-not-found">
                  </div>
                  <div class="count_title px-2">
                    <h4 class="text-white">Sisa</h4>
                    <span class="text-white">Waktu</span>
                  </div>
                  <div class="count_number p-3 d-flex justify-content-around align-items-center position-relative overflow-hidden bg-white rounded-pill countdown_timer">
                    <div><h3 id="count_hours" class="mb-0">0</h3><span class="text-uppercase">jam</span></div>
                    <div><h3 class="mb-0" id="count_min">0</h3><span class="text-uppercase">menit</span></div>
                    <div><h3 class="mb-0" id="count_sec">0</h3><span class="text-uppercase">detik</span></div>
                  </div>
                </div>
                <span class="step_content col-md-auto col-12">Evaluasi Essay</span>
              </div>

              <form class="" action="{{route('swa.evaluasi.storeessay')}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="{{$tes->id}}">
                <div class="soal essay">

                  <div class="form_items form-group mt-3">
                    <input type="file" name="file" value="">
                  </div>

                  <div class="form_content soalhilang" style="display: none;">
                      @foreach($soal as $s)
                        <input type="hidden" name="idsoal[]" value="{{$s->id}}">
                        <div class="question_title pt-4">
                          <p><b>{{$s->soal->soal}}</b></p>
                        </div>

                        <div class="form_items form-group mt-3">
                          <textarea placeholder="Jawaban..." class="textarea form-control essay-jawab" name="jawaban{{$s->id}}" id="form-message" rows="3" cols="20"></textarea>
                        </div>

                        <!-- <div class="form_items form-group mt-3">
                          <input type="file" name="jawabanfile{{$s->id}}" value="">
                        </div> -->

                        <div class="dropdown-divider mt-5"></div>
                      @endforeach
                  </div>
                  <div class="form_btn py-5 d-flex justify-content-end">
                    @csrf
                    <button type="submit" class="prev_btn essay-submit col text-center" onsubmit="return confirm('Selesaikan ujian wawancara? Anda tidak dapat mengakses halaman ini lagi setelahnya.')" name="button"><span><i class="far fa-save"></i></span> Simpan & Selesai Ujian</button>
                  </div>
                  </div>
                </form>
              </div>

              <div class="waktuhabis pb-4" style="display: none;">
                <div class="alert alert-warning mt-5" role="alert">
                  <h4 class="alert-heading"><i data-feather="info"></i>WAKTU HABIS</h4>
                  <div class="alert-body">
                    Silakan tekan Simpan & Selesaikan Ujian.
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="{{asset('test-assets/js/jquery-3.6.0.min.js')}}"></script>
  <script src="{{asset('test-assets/js/countdown.js')}}"></script>
  <script src="{{asset('test-assets/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('test-assets/js/jquery.validate.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script>


    $('.waktuhabis').hide();
    $('.waktumauhabis').hide();
      // Set the date we're counting down to

    // Update the count down every 1 second
    var end_date = $('#berakhir').val()
    console.log(end_date);
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

      // Display the result in the element with id="demo"
      document.getElementById("count_hours").innerHTML =hours;
      document.getElementById("count_min").innerHTML =minutes;
      document.getElementById("count_sec").innerHTML =seconds;

      if(distance < 0) {
        $('.soalhilang').hide()
        $('.waktuhabis').show()
        $('.waktumauhabis').hide()
      } else {
        $('.soalhilang').show()

        if (minutes >= 0 && minutes < 10 && hours < 1) {
          $('.waktumauhabis').show()
        }
      }


    var x = setInterval(function() {

      distance = distance - 1000;
      // Get today's date and time

      // Time calculations for days, hours, minutes and seconds
      days = Math.floor(distance / (1000 * 60 * 60 * 24));
      hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      seconds = Math.floor((distance % (1000 * 60)) / 1000);


      // Display the result in the element with id="demo"
      document.getElementById("count_hours").innerHTML =hours;
      document.getElementById("count_min").innerHTML =minutes;
      document.getElementById("count_sec").innerHTML =seconds;
      //
      // document.getElementById("count_hours").innerHTML = days + "d " + hours + "h "
      // + minutes + "m " + seconds + "s ";

      // $('.count_hours').innerHTML='aaa';

      // If the count down is finished, write some text
      // if (minutes < 10) {
      //   $('.waktumauhabis').show()
      // }

      if (minutes >= 0 && minutes < 10 && hours < 1) {
        $('.waktumauhabis').show()
      }

      if (distance < 0) {
        $('.soalhilang').hide()
        $('.waktuhabis').show()
        $('.waktumauhabis').hide()
      }
      if (distance < 0) {
        clearInterval(x);
        document.getElementById("count_hours").innerHTML =0;
        document.getElementById("count_min").innerHTML =0;
        document.getElementById("count_sec").innerHTML =0;
      }

    }, 1000);

    if ($('.js-get-set-width').length) {
      $('.js-get-set-width').find('.js-set-width').css('max-width', $('.js-get-width').outerWidth() - 24);
      $(window).on('resize', function() {
        $('.js-get-set-width').find('.js-set-width').css('max-width', $('.js-get-width').outerWidth() - 24);
      })
    }

    $('.step_box_banyak').on('click', function () {
      if ($(this).find('.step_box_desc').parent().hasClass('active')) {
        $(this).find('input[type=checkbox]').attr("checked", false);
        $(this).find('.step_box_desc').parent().removeClass('active');
      } else {
        $(this).find('input[type=checkbox]').attr("checked", true);
        $(this).find('.step_box_desc').parent().addClass('active');
      }
    });

    $('.step_box_pilihan').on('click', function () {
      $(this).parents('.pilih-salah-satu').find('.step_box_pilihan').find('.step_box_desc').parent().removeClass('active');
      if ($(this).find('.step_box_desc').parent().hasClass('active')) {
        $(this).find('input[type=radio]').prop("checked", false);
        $(this).find('.step_box_desc').parent().removeClass('active');
      } else {
        $(this).find('input[type=radio]').prop("checked", true);
        $(this).find('.step_box_desc').parent().addClass('active');
      }
    });
  </script>
</body>

</html>
