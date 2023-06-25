@extends('layouts.masterreset')
@section('body')

<div class="authentication">    
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-lg-6 col-sm-12">
              <form class="card auth_form" method="POST" action="{{ route('storePassword') }}">
                @csrf
                  <input type="hidden" name="id" value="{{$user->id}}">
                  <div class="header">
                      <img class="logo" src="{{asset('logo.png')}}" alt="Logo SLUA">
                      <h5 class="my-3"><b>RESET PASSWORD</b></h5>
                      <span>Silakan Mengisi Password Baru</span><br>
                      <span>Untuk Mengakses Siakad SLUA</span>
                  </div>
                  <div class="body">                       
                      <div class="input-group mb-3">
                          <input type="password" class="form-control" name="password" required autofocus id="password" placeholder="Password Baru">
                          <div class="input-group-append">                                
                              <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                          </div>                            
                      </div>
                      <div class="input-group mb-3">
                        <input type="password" class="form-control"  name="password" required id="repassword" placeholder="Ulangi Password Baru">
                        <div class="input-group-append">                                
                            <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                        </div>                        
                      </div>
                      <p class="text-danger" id="textpasssalah"><strong>Password Tidak Sama</strong></p>
                      <button type="submit" class="btn btn-success btn-block waves-effect waves-light" id="btnubah">Reset Password</button>
                  </div>
              </form>
              <div class="copyright text-center">
                  &copy;
                  <script>document.write(new Date().getFullYear())</script>
                  <span><a href="http://siakad.slua.sch.id">SLUA Denpasar</a> | IT Division</span>
              </div>
          </div>
      </div>
  </div>
</div>
@stop
@section('js')
  <script>
  $('#textpasssalah').hide()

    $('#repassword').on('keyup', function(){
      var password = $('#password').val()
      var repassword = $(this).val()
      if (password === repassword) {
        $('#textpasssalah').hide()
        $('#btnubah').prop('disabled', false);
      }else {
        $('#textpasssalah').show()
        $('#btnubah').prop('disabled', true);
      }
    })
  </script>
@stop
