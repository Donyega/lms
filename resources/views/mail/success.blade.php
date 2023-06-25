@component('mail::message')
  # Terimakasih {{$data['nama']}}, Sudah Mendaftar

  <!-- @component('mail::button', ['url' => 'success/q', 'color' => 'gree'])
    View Invoice
  @endcomponent -->
  @component('mail::table')
|        |          |
| ------------- |:-------------:|
| No Pendaftarn      | {{$data['noDaftar']}}  |
| No Virtual Account |  {{$data['virtual_account']}}      |
@endcomponent

<p>Harap Melakukan Pembayaran Pendaftaran Ke Nomer Virtual Account Agar Dapat Melakukan <b>PENDAFTARAN ULANG</b>
<br><br>
# Batas Pembayaran <br>
{{$data['datetime_expired']}} <br>
<p>Jika Batas pembayaran sudah lewat (<b>Expired</b>) Silahkan login untuk melakukan Aktivasi Virtual Accoun </p>

@component('mail::button', ['url' => route("home")])
Login
@endcomponent

  Thanks,
  {{ config('app.name') }}
@endcomponent
