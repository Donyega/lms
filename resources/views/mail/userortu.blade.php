@component('mail::message')
  # Halo {{$data['orangtua']}}, orangtua dari {{$data['nama']}},
<p>Berikut Username dan Password SIPERI (Sistem Informasi Profesi Dokter Gigi) untuk memonitoring proses studi {{$data['nama']}}</p>
@component('mail::table')
|        |          |
| ------------- |:-------------:|
| Username      | {{$data['ot_email']}}  |
| Password |  {{$data['ot_email']}}      |
@endcomponent
@component('mail::button', ['url' => $link])
Masuk ke SIPERI
@endcomponent
<br>
Terima kasih,
<br>
{{ config('app.name') }}
<br>
Universitas Mahasaraswati Denpasar 
@endcomponent
