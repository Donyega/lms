@extends('layouts.menu')

@section('title-head', 'Dashboard')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Dashboard Admin
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">LMS SLUA</a></li>
              <li class="breadcrumb-item active">Dahboard</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="content-body">
    <div class="row match-height">
      <div class="dashboard-jmlsiswa">
      </div>
      <div class="col-12 mb-4">
        <div class="app-calendar overflow-hidden">
          <div class="row g-0">
            <div class="col position-relative">
              <div class="card shadow-none border-0 mb-0 rounded-0">
                <div class="card-body pb-0">
                  <div id="calendar"></div>
                </div>
              </div>
            </div>
            <div class="body-content-overlay"></div>
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
  $.get('dashboard/jmlsiswa',function(data){    
    $('.dashboard-jmlsiswa').html(data)
    feather.replace();
  })
});
</script>
@stop
