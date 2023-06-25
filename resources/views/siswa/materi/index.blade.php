@extends('layouts.menu')

@section('title-head', 'Materi ')

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
                <a href="#">Pembelajaran</a>
              </li>
            </ol>
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
<script>
$(document).ready(function() {

});
</script>
@stop
