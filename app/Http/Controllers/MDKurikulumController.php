<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\MdKurikulum;
use App\Models\MdMapel;
use App\Helper;
use DB;
use PDF;
use auth;
use DataTables;
use DateTime;
use Session;
class MDKurikulumController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Contracts\Support\Renderable
  */
  public function index() {
    return view('masterdata.kurikulum.index');
  }

  public function dt() {
    $data = MdKurikulum::all();
    return DataTables::of($data)
    ->addColumn('status', function($data) {
      if($data->status == 0) {
        $status = 'Tidak Aktif';
      }else {
        $status = 'Aktif';
      }
      return $status;
    })
    ->addColumn('action', function($data) {
      if ($data->status == 0) {
        $btn='<button type="submit" class="btn btn-sm btn-outline-success btnaktif" name="button" style="width:130px"><i data-feather="play-circle"></i> Aktifkan</button>';
      }else {
        $btn = '<button type="submit" class="btn btn-sm btn-outline-danger btnaktif" name="button" style="width:130px"><i data-feather="pause-circle"></i> Non-Aktifkan</button>';
      }
      return '<div class="text-center" style="white-space: nowrap">
        <button type="button" id="btnubah" name="button" class="btn btn-sm btn-icon btn-outline-warning waves-effect waves-float waves-light" style="white-space:nowrap" title="Ubah"><i data-feather="edit"></i></button>
        <form class="d-inline" action="'.route("md.kurikulum.aktif").'" method="post">
          <input type="hidden" name="id" value="'.$data->id.'">
          '.$btn.'
          '.csrf_field().'
        </form>
        </div>';
    })
    ->setRowClass(function ($data) {
      $text='';
      if ($data->status == 1) {
        $text ='text-success';
      }
      return $text;
    })
    ->make(true);
  }

  public function store(Request $request)
  {
    try {
      MdKurikulum::create([
        'nama' => $request->nama,
        'tahun' => $request->tahun,
        'deskripsi' => $request->deskripsi,
        'status' => 0,
      ]);
      return back()->with('notif', json_encode([
        'title' => "KURIKULUM",
        'text' => "Berhasil menambah kurikulum baru.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "KURIKULUM",
        'text' => "Gagal menambah kurikulum baru ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function update(Request $request)
  {
    try {
      MdKurikulum::where('id',$request->idkurikulum)->update([
        'nama' => $request->nama,
        'tahun' => $request->tahun,
        'deskripsi' => $request->deskripsi,
      ]);
      return back()->with('notif', json_encode([
        'title' => "KURIKULUM",
        'text' => "Berhasil mengubah data kurikulum.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "KURIKULUM",
        'text' => "Gagal mengubah data kurikulum, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function aktif(Request $request)
  {
    try {
      $data = MdKurikulum::where('id',$request->id)->first();
      if ($data->status == 1) {
        $isaktif = 0;
        $status = 'menonaktifkan';
      }else {
        $isaktif = 1;
        $status = 'mengaktifkan';
      }
      MdKurikulum::where('id',$request->id)->update([
        'status' => $isaktif
      ]);
      return back()->with('notif', json_encode([
        'title' => "KURIKULUM",
        'text' => "Berhasil $status Kurikulum $data->nama Tahun $data->tahun.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "KURIKULUM",
        'text' => "Gagal $status Kurikulum $data->nama, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

}
