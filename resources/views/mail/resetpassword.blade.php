@component('mail::message')
  # Halo {{$data['nama']}}
<p>Seseorang telah meminta perubahan password pada akun Portal anda. Jika ini anda, silahkan klik tombol <b>Reset Password</b>. Jika bukan, abaikan email ini.</p>
@component('mail::button', ['url' => $link])
Reset Password
@endcomponent
<br>
Terima kasih,
<br>
{{ config('app.name') }}<br>
IT Division
@endcomponent
