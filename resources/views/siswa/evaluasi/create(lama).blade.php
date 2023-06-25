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
  <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/animate.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
  <style>
  </style>
</head>

<body>
  @foreach($tes->soal as $s)
    <p>{{$s->soal->soal}}</p>
      <ul>
        @foreach($s->soal->jawaban as $j)
        <li>{{$j->jawaban}}</li>
        @endforeach
      </ul>
  @endforeach

  <form class="" action="{{route('swa.evaluasi.store')}}" onsubmit="return confirm('Yakin menyelesaikan Evaluasi ?')" method="post">
    <button type="submit" class="btn btn-primary" name="button">Selesai</button>
    <input type="hidden" name="idevaluasi" value="{{$tes->id}}">
    @csrf
  </form>
</body>

</html>
