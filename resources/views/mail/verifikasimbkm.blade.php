@component('mail::message')
<p>Halo <b>{{$data['panggilan']}}</b>,<br>
Kami sudah melakukan verifikasi dan validasi terhadap pendaftaran Pertukaran Siswa yang Anda ajukan.
@if($data['status'] == 1)
Kami sangat senang karena Anda akan mengikuti perkuliahan di SMA (SLUA) Saraswati 1 Denpasar. Selanjutnya Anda dapat mengakses siakad melalui alamat:<br>
<p>https://siakad.slua.sch.id</p>

@component('mail::table')
|        |          |
| ------------- |:-------------:|
| Username      | {{$data['email']}}  |
| Password |  {{$data['email']}}      |
@endcomponent
<p>Selamat datang dan selamat belajar.</p>
@else
Mohon maaf saat ini kami belum bisa menerima pendaftaran Anda karena {{$data['alasantolak']}}.
<p></p><br>
@endif
<span>
  <small>{{ config('app.name') }}<br>
  Jalan Kamboja 11 A Denpasar<br>
  Telepon (0361) 227019 | smasaraswatidps@gmail.com
  </small>
</span>
@endcomponent
