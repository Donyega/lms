@extends('layouts.page')

@section('title-head', 'Ubah Pengumuman Siswa')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Ubah Pengumuman Siswa
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('akademik.pengumuman')}}">Pengumuman Siswa</a></li>
              <li class="breadcrumb-item active">Ubah</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="content-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <form id="jquery-val-form" class="forms-sample" action="{{route('akademik.pengumuman.update')}}" method="post" enctype="multipart/form-data" id="formguru">
              <input type="hidden" name="id" value="{{$data->id}}">
              <div class="row">
                <div class="form-group col-md-5">
                  <label class="col-sm-12 col-form-label"><b>Gambar</b></label>
                  <div class="col-sm-12">
                    <div class="body">
                      <input type="file" class="dropify" @if($data->gambar != null) data-default-file="{{asset($data->gambar)}}" @endif name="gbr" data-allowed-file-extensions="jpg jpeg png" data-max-file-size="1M">
                    </div>
                    <label class="col-form-label"><small>* format file <b>.jpg</b>, <b>.jpeg</b> atau <b>.png</b>, ukuran maksimal 1MB</small></label>
                  </div>
                </div>

                <div class="col-md-7">
                  <div class="row">
                    <div class="form-group col-md-12">
                      <label class="col-sm-12 col-form-label"><b>Judul Pengumuman</b></label>
                      <div class="col-sm-12">
                        <input type="text" name="judul" class="form-control" value="{{$data->judul}}" required>
                      </div>
                    </div>

                    <div class="form-group col-md-12">
                      <label class="col-sm-12 col-form-label"><b>Status Pengumuman</b></label>
                      <div class="col-sm-12">
                        <select class="form-control show-tick ms select2" name="status"  data-placeholder="Pilih">
                          <option></option>
                          <option {{$data->status == "0" ? 'selected':''}} value="0">Draft</option>
                          <option {{$data->status == "1" ? 'selected':''}} value="1">Publish</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group col-md-12">
                      <label class="col-sm-12 col-form-label"><b>Tanggal Publish</b></label>
                      <div class="col-sm-12">
                        <input type="text" class="form-control flatpickr-basic" name="tglpublish" placeholder="Pilih" value="{{$data->tglpublish}}" style="background-color: white" required>
                      </div>
                    </div>                    
                  </div>
                </div>

                <div class="form-group col-md-5">
                  <label class="col-sm-12 col-form-label"><b>Peruntukan Tingkat Kelas</b></label>
                  <div class="col-sm-12">
                    <select class="form-control show-tick ms select2" name="idtingkat" id="idtingkat"  data-placeholder="Semua Tingkat">
                      @if($idtingkat != 0)
                        <option selected value="{{$idtingkat}}">{{$tingkat->nama}}</option>
                      @endif
                    </select>
                  </div>
                </div>

                <div class="form-group col-md-7">
                  <label class="col-sm-12 col-form-label"><b>Peruntukan Kelas</b></label>
                  <div class="col-sm-12">
                    <select class="form-control show-tick ms select2" multiple name="idkelas[]" id="idkelas">
                      @if($data->tujuansiswa[0]->idkelas != 0)
                        <option></option>
                        @foreach($kelas as $k)
                          <option selected value="{{$k->id}}">{{$k->nama}} {{$k->jenis->nama}}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>

                <div class="col-12 my-1">
                  <label class="col-sm-12 col-form-label"><b>Isi Pengumuman</b></label>
                  <input type="hidden" name="isi" id="isi">
                  <section class="full-editor col-12">
                    <div id="full-wrapper">
                      <div id="full-container">
                        <div class="editor">
                          {!! $data->isi !!}
                        </div>
                      </div>
                    </div>
                  </section>
                </div>

                <div class="col-sm-12">
                  <div class="col-sm-12">
                    <button type="submit" id="btn-submit" class="btn btn-icon btn-lg btn-block btn-success mb-2"><i data-feather="save"></i> Simpan</button>
                  </div>
                </div>

              </div>
              {{ csrf_field() }}
            </form>
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
<script src="{{asset('app-assets/vendors/js/editors/quill/katex.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/editors/quill/highlight.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/editors/quill/quill.js')}}"></script>
<script src="{{asset('app-assets/js/scripts/forms/form-quill-editor.js')}}"></script>
<script>
$(document).ready(function() {
  $('#btn-submit').on('click', function() {
    var myEditor = document.querySelector('.editor')
    var html = myEditor.children[0].innerHTML
    $('#isi').val(html)
  })

  var idtingkatkelas = '{{$idtingkat}}';

  $("#idtingkat").select2({
    placeholder: "Semua Tingkat",
    ajax: {
        url: '{!!route("s2.tingkatkelas")!!}',
        dataType: 'json',
        data: function (params) {
            return {
                q: $.trim(params.term)
            };
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
    },
  });

  $("#idkelas").select2({
    placeholder: "Semua Kelas",
    ajax: {
        url: '{!!route("s2.kelas")!!}',
        dataType: 'json',
        data: function (params) {
            return {
                q: $.trim(params.term),
                idtingkat:idtingkatkelas
            };
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
    },
  });

  $('#idtingkat').on('change', function(){
    idtingkatkelas = $(this).val()
    $("#idkelas").val('');
    $("#idkelas").select2({
      placeholder: "Semua Kelas",
      ajax: {
          url: '{!!route("s2.kelas")!!}',
          dataType: 'json',
          data: function (params) {
              return {
                  q: $.trim(params.term),
                  idtingkat:idtingkatkelas
              };
          },
          processResults: function (data) {
              return {
                  results: data
              };
          },
          cache: true
      },
    });
  })
  
});
</script>
@stop
