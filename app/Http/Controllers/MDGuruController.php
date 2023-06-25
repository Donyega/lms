<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Pegawai;
use App\Models\MdPendidikan;
use App\Models\RiwayatPendidikan;
use App\Helper;
use DB;
use PDF;
use auth;
use DataTables;
use DateTime;
use Session;
class MDGuruController extends Controller
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
    $data = Pegawai::where('jenis',1)->where('idstatus',1)
            ->leftjoin('pegawai_detils','pegawais.id','idpegawai')
            ->get();
    return view('masterdata.guru.index', compact('data'));
  }

  public function dt($idstatus = null) {
    if ($idstatus == 0) {
      $idstatus = null;
    }
    $data = Pegawai::with(['detil.jenisptk','user'])->where('jenis',1)
            ->when(!empty($idstatus), function ($query) use ($idstatus) {
                return $query->where('idstatus',$idstatus);
            })->get();
    return DataTables::of($data)
      ->addColumn('action', function($data) {
        $user = '';
        if ($data->user == null) {
          $user ='<button type="button" class="btn btn-outline-danger btn-sm waves-effect waves-float waves-light" name="button" id="btnuser" data-toggle="modal" data-target="#modal-user" data-backdrop="static" data-keyboard="false" style="white-space: nowrap" title="Buat User"><i data-feather="user-plus"></i></button>';
        }
        return '<div class="row mx-0 justify-content-center" style="flex-wrap:nowrap">'.$user.'
        <a href='.route("md.guru.detail", $data->id).' class="btn btn-outline-info btn-sm waves-effect waves-float waves-light" style="white-space: nowrap"><i data-feather="user"></i> Detail</a>
        </div>';
      })
      ->make(true);
  }

  public function detail($id)
  {
    $data = Pegawai::with(['status','kecamatan.kabupaten','detil','user','jadwalguru.jadwal'])->where('id',$id)->first();
    $pendidikan = MdPendidikan::where('id','>','2')->get();
    $riwayatpendidikan = RiwayatPendidikan::with('pendidikan')->where('idpegawai',$id)->orderby('idpendidikan','desc')->get();
    return view('masterdata.guru.detail', compact('data','pendidikan','riwayatpendidikan'));
  }

}
