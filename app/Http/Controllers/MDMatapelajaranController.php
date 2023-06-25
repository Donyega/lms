<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\MdMapel;
use App\Helper;
use DB;
use PDF;
use auth;
use DataTables;
use DateTime;
use Session;
class MDMatapelajaranController extends Controller
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
    return view('masterdata.matapelajaran.index');
  }

  public function dt() {
    $data = MdMapel::get();
    return DataTables::of($data)
      ->addColumn('action', function($data) {
        return  '
        <button class="btn btn-outline-info btn-sm waves-effect waves-float waves-light" type="button" data-toggle="modal" data-target="#modal-mapel" data-backdrop="static" data-keyboard="false" id="btnedit"><i data-feather="edit"></i> Ubah</button>
        ';
      })
      ->make(true);
  }

  public function store(Request $request)
  {
    try {
      MdMapel::create([
        'nama' => $request->nama
      ]);
      return back()->with('notif', json_encode([
        'title' => "MATA PELAJARAN",
        'text' => "Berhasil menambah mata pelajaran baru.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "MATA PELAJARAN",
        'text' => "Gagal menambah mata pelajaran baru, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function update(Request $request)
  {
    try {
      MdMapel::where('id',$request->idmapel)->update([
        'nama' => $request->nama
      ]);
      return back()->with('notif', json_encode([
        'title' => "MATA PELAJARAN",
        'text' => "Berhasil mengubah mata pelajaran.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "MATA PELAJARAN",
        'text' => "Gagal mengubah mata pelajaran, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

}
