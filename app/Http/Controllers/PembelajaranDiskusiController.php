<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\LmsTopik;
use App\Models\LmsMateri;
use App\Events\diskusiEvent;
use Illuminate\Http\Request;
use App\Models\LmsMateriDetil;
use App\Models\JadwalPelajaran;
use App\Models\LmsTopikDiskusi;
use Illuminate\Support\Facades\Auth;

class PembelajaranDiskusiController extends Controller
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

  public function index($idjadwal,$idtopik)
  {
    $idta = Helper::idta();

    // select jadwal dan topik berdasarkan id topik dan idjadwal
    $topik = LmsTopik::with(['diskusi.user.pegawai','diskusi.balas.user.pegawai'])->where('id',$idtopik)->first();
    $data = JadwalPelajaran::with(['mapel','kelas','guru.guru','materilms.detil','topiklms'])->where('id',$topik->idjadwal)->first();
    
    return view('guru.pembelajaran.diskusi-new', compact('data','topik'));
  }

  public function getdiskusi($idtopik)
  {
    $data = LmsTopikDiskusi::where('idtopik',$idtopik)->get();
    return $data;
  }

  public function getbalas($id)
  {
    // select data diskusi berdasarkan id
    $data = LmsTopikDiskusi::with(['user'])->where('id',$id)->first();
    if ($data->user->role == 2) {
      $nama = $data->user->pegawai->nama;
    }elseif($data->user->role == 3){
      $nama = $data->user->siswa->nama;
    }
    return [$nama,$data];
  }

  public function store(Request $request)
  {
    $diskusi = LmsTopikDiskusi::create([
      'idtopik' => $request->idtopik,
      'iduser' => Auth::user()->id,
      'diskusi' => $request->pesan,
      'iddiskusi' => $request->iddiskusi
    ]);

    if(Auth::user()->role == 2){
      $nama = Auth::user()->pegawai->nama;
      $foto = 'https://siakad.slua.sch.id/'.Auth::user()->pegawai->photo;
    }elseif(Auth::user()->role == 3){

    }
    $balas = LmsTopikDiskusi::with(['user.pegawai'])->where('id',$request->iddiskusi)->first();
    broadcast(new diskusiEvent($request->idtopik,Auth::user()->id,$request->pesan,$nama,$foto,$diskusi,$balas));

    return [$diskusi,$balas];
  }

}
