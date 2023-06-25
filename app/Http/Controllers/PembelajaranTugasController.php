<?php

namespace App\Http\Controllers;

use auth;
use Excel;
use App\Helper;
use App\Models\Siswa;
use Illuminate\Support\Str;
use App\Models\LmsPenugasan;
use Illuminate\Http\Request;
use App\Models\LmsSiswaTugas;
use App\Models\JadwalPelajaran;
use Yajra\DataTables\DataTables;
use App\Models\LmsPenugasanRubrik;
use App\Models\LmsSiswaTugasNilai;
use Illuminate\Support\Facades\Session;

class PembelajaranTugasController extends Controller
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

  public function store(Request $request)
  {
    try {
      Session::put('tabpengajaran', 3);
      if ($request->file('doktugas') != null) {
        $dokumen = $request->file('doktugas')->store('doktugas/'.$request->idjadwal);
        $request->merge([
          'dokumen' => $dokumen
        ]);
      }

      LmsPenugasan::create($request->all());
      return back()->with('notif', json_encode([
        'title' => "PENGUGASAN",
        'text' => "Berhasil menambah tugas",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PENUGASAN",
        'text' => "Gagal menambah tugas, ".$e->getMessage(),
        'type' => "error"
      ]));
    }

  }

  public function storerubrik(Request $request)
  {
    try {
      Session::put('tabpengajaran', 3);
      $cek = LmsPenugasanRubrik::where('idpenugasan',$request->idpenugasan)->sum('bobot');
      if ($cek + $request->bobot > 100) {
        return back()->with('notif', json_encode([
          'title' => "PENGUGASAN",
          'text' => "Gagal menambah rubrik, bobot melebihi 100 %",
          'type' => "danger"
        ]));
      }
      LmsPenugasanRubrik::create($request->all());
      return back()->with('notif', json_encode([
        'title' => "PENGUGASAN",
        'text' => "Berhasil menambah rubrik",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PENUGASAN",
        'text' => "Gagal menambah rubrik, ".$e->getMessage(),
        'type' => "error"
      ]));
    }

  }

  public function updatenilai(Request $request)
  {
    try {
      Session::put('tabpengajaran', 3);
      if ($request->rubrik == 0) {
        LmsSiswaTugas::where('id',$request->id)->update([
          'nilai' => $request->nilai,
          'komentar' => $request->komentar
        ]);
      }else {
        $rubrik = LmsPenugasanRubrik::where('idpenugasan',$request->idpenugasan)->get();
        LmsSiswaTugasNilai::where('id',$request->id)->delete();
        $na = 0;
        foreach ($rubrik as $r) {
          $n ='nilai-'.$r->id;
          $nilai = $request->$n;
          $nilaibobot = $nilai*$r->bobot/100;
          $na+=$nilaibobot;
          LmsSiswaTugasNilai::create([
            'idtugas' => $request->id,
            'idrubrik' => $r->id,
            'nilai' => $nilai,
            'nilaibobot' => $nilaibobot
          ]);
        }

        LmsSiswaTugas::where('id',$request->id)->update([
          'nilai' => $na,
          'komentar' => $request->komentar
        ]);
      }
      return back()->with('notif', json_encode([
        'title' => "PENGUGASAN",
        'text' => "Berhasil menyimpan nilai penugasan.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PENUGASAN",
        'text' => "Gagal menyimpan nilai penugasan, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function updatenilaikelompok(Request $request)
  {
    try {
      // dd($request->all());
      Session::put('tabpengajaran', 3);
      $i = 0;
      if ($request->rubrik == 0) {
        foreach ($request->idtugas as $idtugas) {
          $nilai = 'nilai-'.$idtugas;
          if ($request->$nilai != null) {
            LMSSiswaTugas::where('id',$idtugas)->update([
              'nilai' => $request->$nilai,
              'komentar' => $request->komentar,
              'iduser' => $request->iduser
            ]);
          }
        }
      }else {
        $rubrik = LmsPenugasanRubrik::where('idpenugasan',$request->idpenugasan)->get();
        foreach ($request->idtugas as $idtugas) {
          LmsSiswaTugasNilai::where('idtugas',$idtugas)->delete();
          $na = 0;
          foreach ($rubrik as $r) {
            $n ='nilai-'.$idtugas.'-'.$r->id;
            $nilai = $request->$n;
            $nilaibobot = $nilai * $r->bobot / 100;
            $na += $nilaibobot;
            if ($nilai != null) {
              LmsSiswaTugasNilai::create([
                'idtugas' => $idtugas,
                'idrubrik' => $r->id,
                'nilai' => $nilai,
                'nilaibobot' => $nilaibobot
              ]);
            }
          }

          if ($na > 0) {
            LMSSiswaTugas::where('id',$idtugas)->update([
              'nilai' => $na,
              'komentar' => $request->komentar,
              'iduser' => $request->iduser
            ]);
          }
        }
      }

      return back()->with('notif', json_encode([
        'title' => "PENGUGASAN",
        'text' => "Berhasil menyimpan nilai penugasan.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PENUGASAN",
        'text' => "Gagal menyimpan nilai penugasan, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function storenilai(Request $request)
  {
    try {
      Session::put('tabpengajaran', 3);
      if ($request->rubrik == 0) {
        LmsSiswaTugas::create($request->all());
      }else {
        $rubrik = LmsPenugasanRubrik::where('idpenugasan',$request->idpenugasan)->get();
        $lms = LmsSiswaTugas::create([
          'idjadwal' => $request->idjadwal,
          'idpenugasan' => $request->idpenugasan,
          'nis' => $request->nis,
          'komentar' => $request->komentar
        ]);
        $na = 0;
        foreach ($rubrik as $r) {
          $n ='nilai-'.$r->id;
          $nilai = $request->$n;
          $nilaibobot = $nilai*$r->bobot/100;
          $na+=$nilaibobot;
          LmsSiswaTugasNilai::create([
            'idtugas' => $lms->id,
            'idrubrik' => $r->id,
            'nilai' => $nilai,
            'nilaibobot' => $nilaibobot
          ]);
        }

        LmsSiswaTugas::where('id',$lms->id)->update([
          'nilai' => $na
        ]);

      }
      return back()->with('notif', json_encode([
        'title' => "PENGUGASAN",
        'text' => "Berhasil memberikan nilai",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PENUGASAN",
        'text' => "Gagal memberikan nilai, ".$e->getMessage(),
        'type' => "error"
      ]));
    }

  }

  public function deleterubrik(Request $request)
  {
    try {
      Session::put('tabpengajaran', 3);
      LmsPenugasanRubrik::where('id',$request->id)->delete();
      return back()->with('notif', json_encode([
        'title' => "PENGUGASAN",
        'text' => "Berhasil menghapus penilaian",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PENUGASAN",
        'text' => "Gagal menghapus penilaian, ".$e->getMessage(),
        'type' => "error"
      ]));
    }

  }

  public function detail($idjadwal,$id)
  {
    Session::put('tabpengajaran', 3);
    $idta = Helper::idta();
    $data = LmsPenugasan::with(['rubrik','kumpul'])->where('id',$id)->first();
    $rubrik = 0;
    if (count($data->rubrik) > 0) {
      $rubrik = 1;
    }
    $siswa = JadwalPelajaran::with(['siswa'])
            ->leftjoin('jadwal_pelajaran_detils','jadwal_pelajarans.id','jadwal_pelajaran_detils.idjadwal')
            ->where('jadwal_pelajarans.idta',$idta)
            ->where('jadwal_pelajaran_detils.idjadwal',$data->idjadwal)
            ->select('jadwal_pelajarans.*')
            ->orderby('jadwal_pelajarans.idkelas')
            ->get();
    $pengumpulan = LmsSiswaTugas::with(['siswa.detil','detilnilai.rubrik','penugasan','dokumenindividu','dokumenkelompok'])
            ->where('idpenugasan',$data->id)->groupby('nis')->orderby('created_at','desc')->get();
    $kelompok = array();
    if ($data->idjenis == 2) {
      $kelompok = LmsSiswaTugas::where('idpenugasan',$data->id)->groupby('idkelompok')->select('idkelompok')->get();
    }
    return view('guru.pembelajaran.tugas.detail', compact('data','rubrik','pengumpulan','siswa','kelompok'));
  }

  public function searching($idjadwal,$id,$nama = null)
  {
    $idta = Helper::idta();
    $siswa = JadwalPelajaran::with(['siswa', 'siswa.detil'])
            ->leftjoin('jadwal_pelajaran_detils','jadwal_pelajarans.id','jadwal_pelajaran_detils.idjadwal')
            ->where('jadwal_pelajarans.idta',$idta)
            ->where('jadwal_pelajaran_detils.idjadwal',$idjadwal)
            ->when(!empty($nama), function ($query) use ($nama) {
                  return $query
                  ->leftjoin('siswas','siswas.idkelas','jadwal_pelajarans.idkelas')
                  ->where('nama', 'LIKE', '%'. $nama .'%');
              })
            ->select('jadwal_pelajarans.*')
            ->orderby('jadwal_pelajarans.idkelas')
            ->get();
    $pengumpulan = LmsSiswaTugas::with(['siswa.detil','detilnilai.rubrik','penugasan','dokumenindividu','dokumenkelompok'])
            ->when(!empty($nama), function ($query) use ($nama) {
                return $query
                ->leftjoin('siswas','siswas.nis','lms_siswa_tugas.nis')
                ->where('nama', 'LIKE', '%'. $nama .'%');
            })->where('idpenugasan',$id)->orderby('created_at','desc')->select('lms_siswa_tugas.*')->get();
    $data = LmsPenugasan::with(['rubrik','kumpul'])->where('id',$id)->first();
    $rubrik = 0;
    if (count($data->rubrik) > 0) {
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
            $photo = $photo = asset($tgs->siswa->detil->photo);
          }
          $nama = $tgs->siswa->nama;
          $nis = $tgs->siswa->nis;

        $tampil.='<div class="card mb-50">
          <div class="card-body py-75">
            <div class="row align-items-center">
              <div class="col-lg-4">
                <div class="d-flex align-items-center">
                  <div class="avatar-lecture">
                    <img src="'.$photo.'" width="30px">
                  </div>
                  <div class="col">
                      <div class="text-'.$color.'">
                        <span><b>'.$nama.'</b></span>
                        <span class="d-block font-small-2">'.$nis.'</span>';
                          $tampil.='<span class="d-block font-small-2"></span>';
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
                          <img src="'.$photo.'" width="30px">
                        </div>
                        <div class="col">
                          <div class="text-'.$color.'">
                            <span><b>'.$nama.'</b></span>
                            <span class="d-block font-small-2">'.$nis.'</span>';
                              $tampil.='<span class="d-block font-small-2"></span>';
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
                    foreach ($tgs->dokumenkelompok as $dok){
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
          $photo = 'http://siakad.slua.sch.id/'.$jadwal->siswa->detil->photo;
        }
        $nama = $jadwal->siswa->nama;
        $nis = $jadwal->siswa->nis;
      $tampil.='<div class="card mb-50">
        <div class="card-body py-50">
          <div class="row align-items-center">
            <div class="col-lg-8">
              <div class="d-flex align-items-center">
                <div class="avatar-lecture">
                  <img src="'.$photo.'" width="30px">
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

  public function update(Request $request)
  {
    try {
      Session::put('tabpengajaran', 3);
      if ($request->file('doktugas') != null) {
        $dokumen = $request->file('doktugas')->store('doktugas/'.$request->idjadwal);
        $request->merge([
          'dokumen' => $dokumen
        ]);
      }

      LmsPenugasan::where('id',$request->idtugas)->update($request->except(['idtugas','doktugas','_token','_idjadwal']));
      return back()->with('notif', json_encode([
        'title' => "PENGUGASAN",
        'text' => "Berhasil mengubah tugas",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PENUGASAN",
        'text' => "Gagal mengubah tugas, ".$e->getMessage(),
        'type' => "error"
      ]));
    }

  }

  public function gettugas($id)
  {
    $data = LmsPenugasan::where('id',$id)->first();
    return $data;
  }

  public function siswagettugas($id)
  {
    $data = LmsSiswaTugas::with(['siswa.detil','detilnilai','penugasan'])->where('id',$id)->first();
    return $data;
  }

  public function siswagetkelompok($id)
  {
    $data = LmsSiswaTugas::with(['siswa.detil','detilnilai','penugasan'])
          ->where('idkelompok',$id)->get();
    $rubrik = LmsPenugasanRubrik::where('idpenugasan',$data[0]->idpenugasan)->get();
    $komentar = $data->where('komentar','!=',null)->pluck('komentar')->first();
    $table ='<div class="row">';
    foreach ($data as $d) {
      if ($d->siswa == null) {
        $nama = 'Belum ada siswa';
        $nis = '000000';
      } else {
        $nama = $d->siswa->nama;
        $nis = $d->siswa->nis;
      }
      $table.='<div class="col-xl-12 mb-1"><div class="table-responsive">
      <table class="table table-striped mb-0">
        <input type="hidden" name="idtugas[]" value="'.$d->id.'">
        <tr>
          <td style="width: 40%">Nama Siswa</td>
          <td class="px-0" style="width: 1px">:</td>
          <th>'.$nama.'</th>
        </tr>
        <tr>
          <td>NIS</td>
          <td class="px-0" style="width: 1px">:</td>
          <th>'.$nis.'</th>
        </tr>';
        if (count($rubrik) > 0) {
          foreach($rubrik as $r) {
            $nrubrik = $d->detilnilai->where('idrubrik',$r->id)->pluck('nilai')->first();
            $table.='<tr>
              <td>'.$r->nama.' ('.$r->bobot.'%)</td>
              <td class="px-0" style="width: 1px">:</td>
              <td>
                <input type="number" step="0.1" class="form-control" name="nilai-'.$d->id.'-'.$r->id.'" value="'.$nrubrik.'" style="width: 90px">
              </td>
            </tr>';
          }
        }else {
          $table.='<tr>
            <td>Nilai</td>
            <td class="px-0" style="width: 1px">:</td>
            <td>
              <input type="number" step="0.1" class="form-control" name="nilai-'.$d->id.'" id="nilai-'.$d->id.'" value="'.$d->nilai.'" style="width: 90px">
            </td>
          </tr>';
        }
        $table.='
        </table></div><hr class="mt-0 mb-1">
      </div>';
    }
    $table.='
      <div class="col-xl-12">
        <div class="form-group">
          <label><b>Komentar</b></label>
          <textarea name="komentar" required class="form-control" rows="4" cols="80">'.$komentar.'</textarea>
        </div>
      </div>
    </div>';
    return $table;
  }

  public function dtkumpul($idpenugasan)
  {
    $data = LmsSiswaTugas::with(['siswa.detil','detilnilai','penugasan'])->where('idpenugasan',$idpenugasan)->get();

    return DataTables::of($data)
    ->addColumn('action', function($data) {
      return '
      <button class="btn btn-sm btn-outline-primary waves-effect waves-float waves-light btnnilai" data-toggle="modal" data-target="#modal-nilai" value="'.$data->id.'"><i data-feather="plus"></i> Nilai</button>
      ';
      })

    ->addColumn('waktu', function($data) {
      if ($data->penugasan->idmetode == 1) {
        return '
        Dikumpul Pada :
        '.Helper::tanggal($data->created_at).', Pukul :'.date("H:i",strtotime($data->created_at));
      }else {
        return '-';
      }
    })
    ->addColumn('photo', function($data){
      $photo = 'http://siakad.slua.sch.id/'.$data->siswa->detil->photo;
      if ($data->siswa->detil->photo == 'images/user-default.png') {
        $photo = asset('images/user-lms.png');
      }

      return $photo;
    })
    ->make(true);
  }

}
