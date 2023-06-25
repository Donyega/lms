<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\LmsEvaluasi;
use Illuminate\Http\Request;
use App\Models\LmsSiswaTugas;
use App\Models\JadwalPelajaran;
use App\Models\LmsEvaluasiSoal;
use App\Models\LmsTopikDiskusi;
use App\Models\LmsSiswaEvaluasi;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PembelajaranPesertaEvaluasiController extends Controller
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

  public function index($idjadwal,$idmateri,$idevaluasi,$img)
  {
    Session::put('tabpengajaran', 4);
    // $data = LmsEvaluasi::with(['materi','jadwal','soal'])->where('id',$idevaluasi)
    //       ->where('idmateri',$idmateri)->first();
    $data = LmsSiswaEvaluasi::with(['siswa', 'evaluasi.materi', 'evaluasi.jadwal'])->where('idevaluasi',$idevaluasi)->get();
    // dd($data[0]->evaluasi);
    return view('guru.pembelajaran.peserta', compact('data','img'));
  }

  public function dt($idevaluasi,$idjenis)
  {
    $data = LmsEvaluasiSoal::with(['cerita','jawaban'])->where('idevaluasi',$idevaluasi)->where('idjenis',$idjenis)->get();
    return DataTables::of($data)
    ->addColumn('action', function($data) {
      return '
      
      ';
      })
    ->make(true);
  }

  public function store(Request $request)
  {
    $diskusi = LmsTopikDiskusi::create([
      'idtopik' => $request->idtopik,
      'iduser' => Auth::user()->id,
      'diskusi' => $request->pesan
    ]);
    
    if(Auth::user()->role == 2){
      $nama = Auth::user()->dosen->nama;
      $foto = 'https://siakad.slua.sch.id/'.Auth::user()->guru->photo;
    }elseif(Auth::user()->role == 3){

    }
    broadcast(new diskusiEvent($request->idtopik, Auth::user()->id,$request->pesan,$nama,$foto));
    return response()->json([
      'sucess' => true,
      'message' => 'sukses'
    ]);
  }

  public function searching($idjadwal,$id,$nama = null)
  {
    $idta = Helper::idta();
    $siswa = JadwalPelajaran::with(['siswa'])
            ->leftjoin('jadwal_pelajaran_detils','jadwal_pelajarans.id','jadwal_pelajaran_detils.idjadwal')
            ->where('jadwal_pelajarans.idta',$idta)
            ->where('jadwal_pelajaran_detils.idjadwal',$idjadwal)
            ->when(!empty($nama), function ($query) use ($nama) {
                  return $query
                  ->leftjoin('siswas','siswas.idkelas','jadwal_pelajarans.idkelas')
                  ->where('idstatus', 1)
                  ->where('nama', 'LIKE', '%'. $nama .'%');
              })
            ->select('jadwal_pelajarans.*')
            ->orderby('jadwal_pelajarans.idkelas')
            ->get();
    $pengumpulan = LmsSiswaEvaluasi::with(['siswa.detil','evaluasi'])
            ->when(!empty($nama), function ($query) use ($nama) {
                return $query
                ->leftjoin('siswas','siswas.nis','lms_siswa_tugas.nis')
                ->where('nama', 'LIKE', '%'. $nama .'%');
            })->where('idevaluasi',$id)->orderby('created_at','desc')->select('lms_siswa_evaluasis.*')->get();
    $data = LmsEvaluasi::where('id',$id)->first();
    $rubrik = 0;
    if (count(array($data->rubrik)) > 0) {
      $rubrik = 1;
    }
    $kelompok = array();
    if ($data->idjenis == 2) {
      $kelompok = LmsSiswaTugas::where('idpenugasan',$data->id)
                ->when(!empty($nama), function ($query) use ($nama) {
                    return $query
                    ->leftjoin('siswas','siswas.nis','lms_siswa_tugas.nis')
                    ->where('nama', 'LIKE', '%'. $nama .'%');
                })->groupby('lms_siswa_tugas.idkelompok')->select('lms_siswa_tugas.idkelompok')->get();
    }
    $metode = $data->idmetode;
    $batas = $data->batastgl.' '.$data->batasjam;
    $batas = strtotime($batas);
    $swsnis = array();

    $tampil= '<div>';
    if (count($pengumpulan) > 0) {
      if ($data->idjenis == 1) {
        foreach ($pengumpulan as $tgs) {
          $tglkumpul = strtotime($tgs->created_at);
          $photo = asset('images/user-lms.png');
          $color = '';
          $swsnis[] = $tgs->nis;
          if ($tgs->siswa->detil->photo != 'images/user-default.png') {
            $photo = asset($tgs->siswa->detil->photo);
          }
          $nama = $tgs->siswa->nama;
          $nis = $tgs->siswa->nis;

        $tampil.='<div class="card mb-50">
          <div class="card-body py-75">
            <div class="row align-items-center">
              <div class="col-lg-4">
                <div class="d-flex align-items-center">
                  <div class="avatar-lecture">
                    <img src="'.$photo.'" width="50">
                  </div>
                  <div class="col">
                      <div class="text-'.$color.'">
                        <span><b>'.$nama.'</b></span>
                        <span class="d-block font-small-2">'.$nis.'</span>';
                      $tampil.='</div>
                  </div>
                </div>
              </div>
              <div class="col-lg-5">
                <div class="mt-50 border-bottom-primary border-bottom-1 d-md-none"></div>';
                if ($metode == 1){
                  $tampil.='<span class="d-block d-lg-inline mt-50 mt-lg-0">
                    <i data-feather="user-check"></i> <i data-feather="calendar"></i> '.(new \App\Helper)->tanggal($tgs->created_at).', '.date("H:i",strtotime($tgs->created_at)).' WITA
                  </span>
                  <div class="d-block d-lg-inline my-25 mb-lg-0">';
                    if ($tglkumpul <= $batas){
                      $tampil.='<div class="badge badge-light-success"><i data-feather="check"></i> Tepat Waktu</div>';
                    }else{
                      $tampil.='<div class="badge badge-light-secondary"><i data-feather="clock"></i> Terlambat</div>';
                    }
                  $tampil.='</div>';
                }
              $tampil.='</div>
              <div class="col-lg-3">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <div class="avatar bg-light-';
                    if ($tglkumpul <= $batas) {
                      $tampil.='primary';
                    }else {
                      $tampil.='secondary';
                    }
                    $tampil.='p-25 d-none d-lg-block">
                      <div class="avatar-content font-medium-1">'.round($tgs->nilai).'</div>
                    </div>
                  </div>
                  <div class="text-right">
                    <button class="btn btn-sm btn-outline-primary btnnilai mt-25 mt-lg-0" data-toggle="modal" data-target="#modal-nilai" value="'.$tgs->id.'"><i data-feather="plus"></i> Nilai</button>
                    <div class="d-none d-lg-inline">
                      <a href="#tgs-'.$tgs->id.'" class="btn btn-sm btn-icon btn-info btnnilai mt-25 mt-lg-0" ole="button" data-toggle="collapse" title="Detail Pengumpulan"><i data-feather="edit-3"></i><i data-feather="file-text"></i></a>
                    </div>
                    <div class="d-inline d-lg-none">
                      <a href="#tgs-'.$tgs->id.'" class="btn btn-sm btn-info btnnilai mt-25 mt-lg-0" ole="button" data-toggle="collapse" title="Detail Pengumpulan"><i data-feather="info"></i> Detail</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="collapse" id="tgs-'.$tgs->id.'">
              <div class="dropdown-divider"></div>
              <div class="row">
                <div class="col-lg-4">
                  <span class="font-small-3 text-muted">Dokumen</span>';
                    foreach ($tgs->dokumenindividu as $dok) {
                      $tampil.='<div class="card col border-secondary border-left-3 my-75 py-50">
                        <a href="'.asset($dok->dokumen).'" target="_blank">
                          <p class="font-small-2 mb-25" style="line-height: 1rem">
                            '.$dok->nama.'
                          </p>
                          <footer class="blockquote-footer font-small-1">
                            '.(new \App\Helper)->tanggal($dok->created_at).', '.date("H:i", strtotime($dok->created_at)).'
                          </footer>
                        </a>';
                        if (strtotime($dok->created_at) <= $batas){
                          $tampil.='<span class="font-small-2 text-success"><i data-feather="check" class="font-small-1" style="margin-top: -2px"></i> Tepat Waktu</span>';
                        }else{
                          $tampil.='<span class="font-small-2 text-danger"><i data-feather="clock" class="font-small-1" style="margin-top: -2px"></i> Terlambat</span>';
                        }
                      $tampil.='</div>';
                    }
                  $tampil.='<div class="dropdown-divider d-lg-none"></div>
                </div>
                <div class="col-lg-4">
                  <span class="font-small-3 text-muted">Nilai</span>';
                  if ($tgs->nilai != null){
                    if ($rubrik == 1){
                      foreach ($tgs->detilnilai as $nilai){
                        $tampil.='<div class="dropdown-divider"></div>
                        <div class="d-flex justify-content-between">
                          <span class="font-small-3">'.$nilai->rubrik->nama.' ('.$nilai->rubrik->bobot.'%)</span>
                          <div class="badge badge-light-secondary">'.$nilai->nilai.'</div>
                        </div>';
                      }
                    }
                    $tampil.='<div class="dropdown-divider"></div>
                    <div class="d-flex justify-content-between">
                      <span class="font-small-3"><b>Nilai Akhir</b></span>
                      <div class="badge badge-light-primary">'.round($tgs->nilai,2).'</div>
                    </div>';
                  }else{
                    $tampil.='<div class="alert alert-secondary mt-75 mb-0" role="alert">
                      <div class="alert-body font-small-3">
                        Belum diberikan penilaian
                      </div>
                    </div>';
                  }
                  $tampil.='<div class="dropdown-divider d-lg-none"></div>
                </div>
                <div class="col-lg-4 font-small-3">
                  <span class="text-muted">Komentar</span>
                  <div class="alert alert-';
                  if ($tgs->komentar == null) {
                    $tampil.='secondary';
                  }else {
                    $tampil.='primary';
                  }
                  $tampil.='mt-75 mb-0" role="alert">
                    <div class="alert-body">';
                      if ($tgs->komentar == null) {
                        $tampil.='Belum diberikan komentar';
                      }else {
                        $tampil.=$tgs->komentar;
                      }

                    $tampil.='</div>
                  </div>
                </div>
              </div>
              <div class="dropdown-divider mb-75"></div>
            </div>
          </div>
        </div>';
      }
      }elseif ($data->idjenis == 2) {
        foreach ($kelompok as $k){
          $tampil.='<div class="card mb-50">
            <div class="card-body py-75">
              <div class="row align-items-center">
                <div class="col-lg-6">';
                  foreach ($pengumpulan->where('idkelompok',$k->idkelompok) as $tgs){
                      $tglkumpul = strtotime($tgs->created_at);
                      $photo = asset('images/user-lms.png');
                      $color = '';
                      $swsnis[] = $tgs->nis;
                      if ($tgs->siswa->detil->photo != 'images/user-default.png') {
                        $photo = asset($tgs->siswa->detil->photo);
                      }
                      $nama = $tgs->siswa->nama;
                      $nis = $tgs->siswa->nis;

                    $tampil.='<div class="d-flex justify-content-between align-items-center">
                      <div class="d-flex align-items-center mb-50 mb-lg-0">
                        <div class="avatar-lecture">
                          <img src="'.$photo.'" width="50">
                        </div>
                        <div class="col">
                          <div class="text-'.$color.'">
                            <span><b>'.$nama.'</b></span>
                            <span class="d-block font-small-2">'.$nis.'</span>';
                          $tampil.='</div>
                        </div>
                      </div>
                      <div>
                        <div class="avatar bg-light-';
                        if ($tglkumpul <= $batas) {
                          $tampil.='primary';
                        }else {
                          $tampil.='secondary';
                        }
                        $tampil.='p-25">
                          <div class="avatar-content font-medium-1">'.round($tgs->nilai).'</div>
                        </div>
                      </div>
                    </div>
                    <div class="dropdown-divider d-none d-lg-block"></div>';
                  }
                $tampil.='</div>';
                  $tgs = $pengumpulan->where('idkelompok',$k->idkelompok)->first();
                  $tglkumpul = strtotime($tgs->created_at);

                $tampil.='<div class="col-lg-6 text-left text-lg-right">
                  <div class="mt-50 border-bottom-primary border-bottom-1 d-md-none"></div>
                  <span class="d-block mt-50 mt-lg-0"><i data-feather="users"></i> Anggota : <b>'.count($pengumpulan->where("idkelompok",$k->idkelompok)).'</b> Siswa</span>';
                  if ($metode == 1){
                    $tampil.='<span class="d-block d-lg-inline mt-50 mt-lg-0">
                      <i data-feather="user-check"></i> <i data-feather="calendar"></i> '.(new \App\Helper)->tanggal($tgs->created_at).', '.date("H:i",strtotime($tgs->created_at)).' WITA
                    </span>
                    <div class="d-block d-lg-inline my-25 mb-lg-0">';
                      if ($tglkumpul <= $batas){
                        $tampil.='<div class="badge badge-light-success"><i data-feather="check"></i> Tepat Waktu</div>';
                      }else{
                        $tampil.='<div class="badge badge-light-secondary"><i data-feather="clock"></i> Terlambat</div>';
                      }
                    $tampil.='</div>';
                  }
                  $tampil.='<div class="text-right mt-75">
                    <button class="btn btn-sm btn-outline-primary btnnilaiklp mt-25 mt-lg-0" data-toggle="modal" data-target="#modal-nilaiklp" value="'.$k->idkelompok.'"><i data-feather="plus"></i> Nilai</button>
                    <div class="d-none d-lg-inline">
                      <a href="#klp-'.$k->idkelompok.'" class="btn btn-sm btn-icon btn-info btnnilai mt-25 mt-lg-0" ole="button" data-toggle="collapse" title="Detail Pengumpulan"><i data-feather="edit-3"></i><i data-feather="file-text"></i></a>
                    </div>
                    <div class="d-inline d-lg-none">
                      <a href="#klp-'.$k->idkelompok.'" class="btn btn-sm btn-info btnnilai mt-25 mt-lg-0" ole="button" data-toggle="collapse" title="Detail Pengumpulan"><i data-feather="info"></i> Detail</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="collapse" id="klp-'.$k->idkelompok.'">
                <div class="dropdown-divider"></div>
                <div class="row">
                  <div class="col-lg-6">
                    <span class="font-small-3 text-muted">Dokumen</span>';
                    if($tgs->idkelompok != null) 
                      foreach ($tgs->dokumenkelompok as $dok ){
                        $tampil.='<div class="card col border-secondary border-left-3 my-75 py-50">
                          <a href="'.asset($dok->dokumen).'" target="_blank">
                            <p class="font-small-2 mb-25" style="line-height: 1rem">
                              '.$dok->nama.'
                            </p>
                            <footer class="blockquote-footer font-small-1">
                              '.(new \App\Helper)->tanggal($dok->created_at).', '.date("H:i", strtotime($dok->created_at)).'
                            </footer>
                          </a>';
                          if (strtotime($dok->created_at) <= $batas){
                            $tampil.='<span class="font-small-2 text-success"><i data-feather="check" class="font-small-1" style="margin-top: -2px"></i> Tepat Waktu</span>';
                          }else{
                            $tampil.='<span class="font-small-2 text-danger"><i data-feather="clock" class="font-small-1" style="margin-top: -2px"></i> Terlambat</span>';
                          }
                          $tampil.='</div>';
                      }
                    else {
                      // $tampil.='Tidak ada data kelompok';
                    }
                    $tampil.='<div class="dropdown-divider d-lg-none"></div>
                  </div>
                  <div class="col-lg-6 font-small-3">
                    <span class="text-muted">Komentar</span>
                    <div class="alert alert-';
                    if ($tgs->komentar == null) {
                      $tampil.='secondary';
                    }else {
                      $tampil.='primary';
                    } $tampil.=' mt-75 mb-0" role="alert">
                      <div class="alert-body">';
                      if ($tgs->komentar == null) {
                        $tampil.='Belum diberikan komentar';
                      }else {
                        $tampil.=$tgs->komentar;
                      }
                      $tampil.='</div>
                    </div>
                  </div>
                  <div class="dropdown-divider mb-75"></div>
                </div>
              </div>
            </div>
          </div>';
        }
      }
    }

    foreach ($siswa->wherenotin('nis',$swsnis)->where('idstatus', 1) as $jadwal){
        $photo = asset('images/user-lms.png');
        if ($jadwal->siswa->detil->photo != 'images/user-default.png') {
          $photo = asset($jadwal->siswa->detil->photo);
        }
        $nama = $jadwal->siswa->nama;
        $nis = $jadwal->siswa->nis;

      $tampil.='<div class="card mb-50">
        <div class="card-body py-50">
          <div class="row align-items-center">
            <div class="col-lg-8">
              <div class="d-flex align-items-center">
                <div class="avatar-lecture">
                  <img src="'.$photo.'" width="50">
                </div>
                <div class="col">
                  <div>
                    <span><b>'.$nama.'</b></span>
                    <span class="d-block font-small-2">'.$nis.'</span>';
                  $tampil.='</div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-right">
              <div class="badge badge-light-danger"><i data-feather="x"></i> Belum Mengumpulkan</div>
            </div>
          </div>
        </div>
      </div>';
    }

    return $tampil;
  }

}
