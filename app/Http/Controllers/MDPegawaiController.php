<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\excelexport\excelpegawai;
use App\Models\Pegawai;
use App\Models\PegawaiDetil;
use App\Models\PegawaiStatus;
use App\Models\MdKecamatan;
use App\Models\MdPendidikan;
use App\Models\RiwayatPendidikan;
use App\Helper;
use DB;
use PDF;
use auth;
use DataTables;
use DateTime;
use Excel;
use Session;
class MDPegawaiController extends Controller
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
    $data = Pegawai::where('jenis',2)->where('idstatus',1)
            ->leftjoin('pegawai_detils','pegawais.id','idpegawai')
            ->get();
    return view('masterdata.pegawai.index', compact('data'));
  }

  public function dt($idstatus = null) {
    if ($idstatus == 0) {
      $idstatus = null;
    }
    $data = Pegawai::with(['detil.jenisptk','user'])->where('jenis',2)
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
        <a href='.route("md.pegawai.detail", $data->id).' class="btn btn-outline-info btn-sm waves-effect waves-float waves-light" style="white-space: nowrap"><i data-feather="user"></i> Detail</a>
        </div>';
      })
      ->make(true);
  }

  public function detail($id)
  {
    $data = Pegawai::with(['status','kecamatan.kabupaten','detil','user'])->where('id',$id)->first();
    $pendidikan = MdPendidikan::where('id','>','2')->get();
    $riwayatpendidikan = RiwayatPendidikan::with('pendidikan')->where('idpegawai',$id)->orderby('idpendidikan','desc')->get();
    return view('masterdata.pegawai.detail', compact('data','pendidikan','riwayatpendidikan'));
  }

  public function store(Request $request)
  {
    try {
      $email = $request->email;
      $photo = null;

      $cek = Pegawai::where('email',$email)->first();
      if ($cek != null && $cek->email == $email) {
        return back()->with('notif', json_encode([
          'title' => "TAMBAH DATA",
          'text' => "Gagal menambah data baru, Email $email sudah terdaftar a/n ".$cek->nama.".",
          'type' => "warning"
        ]));
      }
      
      $pegawai = Pegawai::create([
        'nama' => $request->nama,
        'panggilan' => $request->panggilan,
        'jk' => $request->jk,
        'tplahir' => $request->tplahir,
        'tglahir' => $request->tglahir,
        'idagama' => $request->idagama,
        'nohp' => $request->nohp,
        'alamat' => $request->alamat,
        'idkec' => $request->idkec,
        'email' => $request->email,
        'jenis' => $request->jenis,
        'idstatus' => 1
      ]);

      if ($request->file('photos') != null) {
          $photo = $request->file('photos')->store('pegawai/'.$pegawai->id.'/photo');
      }
      
      PegawaiDetil::create([
        'idpegawai' => $pegawai->id,
        'photo' => $photo,
      ]);

      $js = 'pegawai';
      if ($request->jenis == 1) {
        $js = 'guru';
      }

      return redirect('masterdata/'.$js.'/detail/'.$pegawai->id)->with('notif', json_encode([
        'title' => "TAMBAH DATA",
        'text' => "Berhasil menambah data baru.",
        'type' => "success"
    ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "TAMBAH DATA",
        'text' => "Gagal menambah data baru, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function update(Request $request)
  {
    try {
      Pegawai::where('id',$request->idpegawai)->update([
        'nama' => $request->nama,
        'panggilan' => $request->panggilan,
        'jk' => $request->jk,
        'tplahir' => $request->tplahir,
        'tglahir' => $request->tglahir,
        'idagama' => $request->idagama,
        'nohp' => $request->nohp,
        'alamat' => $request->alamat,
        'idkec' => $request->idkec,
        'email' => $request->email,
      ]);

      $pegawai = Pegawai::with('detil')->where('id',$request->idpegawai)->first();
      $photo = $pegawai->detil->photo;

      if ($request->file('photos') != null) {
          $photo = $request->file('photos')->store('pegawai/'.$pegawai->id.'/photo');
      }

      PegawaiDetil::where('idpegawai',$request->idpegawai)->update([
        'photo' => $photo,
      ]);

      return back()->with('notif', json_encode([
        'title' => "UBAH DATA",
        'text' => "Berhasil mengubah data.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "UBAH DATA",
        'text' => "Gagal mengubah data,".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function updatekepegawaian(Request $request)
  {
    try {
      Pegawai::where('id',$request->idpegawai)->update([
        'idstatus' => $request->idstatus,
        'nuptk' => $request->nuptk,
        'nip' => $request->nip,
      ]);

      PegawaiDetil::where('idpegawai',$request->idpegawai)->update([
        'idjenisptk' => $request->idjenisptk,
        'idpangkat' => $request->idpangkat,
      ]);

      return back()->with('notif', json_encode([
        'title' => "DATA KEPEGAWAIAN",
        'text' => "Berhasil mengubah data kepegawaian.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "DATA KEPEGAWAIAN",
        'text' => "Gagal mengubah data kepegawaian,".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function exportexcel(Request $request)
  {
    $jenis = $request->jenispegawai;
    $status = PegawaiStatus::where('id',$request->idstatus)->pluck('nama')->first();
    $tgl = date('Y-m-d');
    $tgl = Helper::tanggal($tgl);
    $namafile = 'Pegawai '.$status;
    if ($jenis == 1) {
      $namafile = 'Guru '.$status;
    }
    if ($request->idstatus == null) {
      $data = Pegawai::with(['status','kecamatan.kabupaten','detil','user'])->where('jenis',$jenis)->get();
    }else {
      $data = Pegawai::with(['status','kecamatan.kabupaten','detil','user'])->where('jenis',$jenis)->where('idstatus',$request->idstatus)->get();
    }
    
    return Excel::download(new excelpegawai($data), 'Data '.$namafile.' ('.$tgl.').xlsx');
    return view('masterdata.pegawai.excel', compact('data'));
  }
}
