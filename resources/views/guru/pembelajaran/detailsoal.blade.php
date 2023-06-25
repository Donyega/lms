@extends('layouts.menu')

@section('title-head', 'Detail Soal')

@section('content')
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
        <div class="row breadcrumbs-top">
          <div class="col-12">
            <h2 class="content-header-title float-left mb-0">Detail Soal
            </h2>
            <div class="breadcrumb-wrapper">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="{{route('home')}}"><i data-feather="home"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="{{route('pembelajaran.evaluasi',[Session::get('idjadwalglobal'),Session::get('idmateriglobal'),Session::get('idevaluasiglobal')])}}">Evaluasi</a></li>
                <li class="breadcrumb-item"><a href="#">Detail</a></li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="content-body">
      <div class="row">
        <div class="col-lg-12 order-2 order-md-1 order-lg-1">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample form-dokumen" action="{{route('pembelajaran.evaluasi.updatesoal')}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="idsoal" value="{{$data->id}}">
                <input type="hidden" name="idceritalama" id="idceritalama" value="">
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
                        <label class="col-sm-12 col-form-label"><b>Kode</b></label>
                        <div class="col-sm-12">
                          <input type="text" name="kode" class="form-control" required value="{{$data->kode}}">
                        </div>
                      </div>

                      <div class="form-group col-md-12">
                        <label class="col-sm-12 col-form-label"><b>Cerita</b></label>
                        <div class="col-md-12">
                          <button type="button" class="mb-1 btn btn-sm btn-outline-primary waves-effect waves-float waves-light" name="button" data-toggle="modal" data-target="#modal-cerita">Ambil dari cerita yang sudah pernah dibuat</button>
                          <button type="button" class="mb-1 btn btn-sm btn-outline-success waves-effect waves-float waves-light btnceritabaru" name="button">Ubah Cerita</button>
                        </div>
                        <div class="col-sm-12">
                          @if($data->idcerita == null)
                          <div class="alert alert-warning mb-0 alertcerita" role="alert">
                            <h4 class="alert-heading"><i data-feather="info" style="margin-top: -2px"></i> INFORMASI</h4>
                            <div class="alert-body">
                              <small>
                                Tidak Ada Cerita
                              </small>
                            </div>
                          </div>
                          @endif
                          <textarea class="form-control ceritalama" id="ceritalama" readonly rows="4" cols="80">{{$data->idcerita == null ? '':$data->cerita->cerita}}</textarea>
                          <div class="ceritabarudisini">

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group col-md-12">
                    <label class="col-sm-12 col-form-label"><b>Soal</b></label>
                    <div class="col-sm-12">
                      <textarea name="soal" required class="form-control" rows="4" cols="80">{{$data->soal}}</textarea>
                    </div>
                  </div>

                  @if($data->idjenis == 2)
                  <input type="hidden" name="idjenis" value="{{$data->idjenis}}">
                  <div class="form-group col-md-12">
                    <div class="col-md-12">
                      <table class="table table-bordered table-striped mb-0">
                        <thead class="text-center">
                          <th>Pilihan Jawaban</th>
                          <th class="px-50" style="width: 1px">Benar</th>
                        </thead>
                        <tbody>
                          <?php $no = 1; ?>
                          @foreach($data->jawaban as $j)
                          <tr>
                            <td>
                              <div class="row align-items-center">
                                <div class="pl-1"><b>{{$no}}</b></div>
                                <div class="col">
                                  <input type="text" class="form-control" name="jawab[]" required value="{{$j->jawaban}}">
                                </div>
                              </div>
                            </td>
                            <td class="text-center">
                              <div class="custom-control custom-control-inline custom-radio ml-50 mr-0">
                                <input type="radio" name="jawaban" class="custom-control-input" {{$j->benar == 1 ? 'checked':''}} value="{{$no-1}}" id="jawabana{{$j->id}}">
                                <label class="custom-control-label" for="jawabana{{$j->id}}"></label>
                              </div>
                            </td>
                          </tr>
                          <?php $no++ ?>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                  @endif
                  <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-block" name="button">Simpan</button>
                  </div>
                </div>
                @csrf
              </form>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('modal')
<div class="modal fade text-left" id="modal-cerita" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title-materi">Pilih Cerita</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <table class="table table-bordered table-hover" id="tablecerita">
            <thead class="text-center">
              <th>Cerita</th>
              <th>Aksi</th>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <!-- <button type="submit" class="btn btn-sm btn-success"><i data-feather="save"></i> Simpan</button> -->
        </div>
    </div>
  </div>
</div>
@endsection

@section('jspage')
<script>
$(document).ready(function() {
  if ('{{$data->idcerita}}' < 1) {
    $('#ceritalama').addClass("d-none");
  }
  $('.btnceritabaru').click(function(){
    $('.alertcerita').hide();
    $('#ceritalama').addClass("d-none");
    $('.ceritabarudisini').html('<textarea class="form-control" name="cerita" rows="4" cols="80"></textarea>')
    $('#idceritalama').val(null)
  })

  var table = $('#tablecerita').DataTable({
    processing: true,
    serverSide: true,
    autoWidth: false,
    "drawCallback": function( settings ) {
      feather.replace();
    },
    dom: '<"box-body"<"row"<"col-sm-3"l><"col-sm-5"<"toolbar">><"col-sm-4"f>>><"box-body table-responsive"tr><"box-body"<"row"><"row"<"col-sm-6"i><"col-sm-6"p>>>',
    ajax: '{!! route('pembelajaran.evaluasi.dtcerita',[Session::get("idjadwalglobal")]) !!}',
    columns: [
        { data: 'cerita', name: 'cerita'},
        { data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'},
    ],
  });

  $('#tablecerita tbody').on('click','.pilihcerita', function(){
    $('.alertcerita').hide();
    $('#idceritalama').val($(this).val())
    $('.pilihcerita').text('Pilih')
    $(this).text('Dipilih')
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var data = row.data()
    $('.ceritalama').removeClass("d-none");
    $('.ceritalama').val(data.cerita)
  })

});
</script>
@stop
