<?php

namespace App\Http\Controllers;

use View;
use Excel;
use App\Helper;
use App\Models\LmsEvaluasi;
use Illuminate\Http\Request;
use App\Models\LmsEvaluasiSoal;
use App\Models\LmsSiswaEvaluasi;
use App\Models\JadwalPelajaranDetil;
use Illuminate\Support\Facades\Auth;
use App\Models\LmsSiswaEvaluasiEssay;
use App\Models\LmsSiswaEvaluasiJawaban;
use Illuminate\Support\Facades\Session;

class SwaEvaluasiController extends Controller
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

  public function index()
  {
    // cek idta yg aktif
    $idta = Helper::idta();
    // cek relasi pada model siswa dan user
    $nis = Auth::user()->siswa->nis;
    // cek idjadwal pada model jadwal pelajaran detil
    $idjadwal = JadwalPelajaranDetil::whereHas('jadwal', function($query) use($idta,$nis){
                $query->where('idta',$idta)->where('nis',$nis);
            })->select('idjadwal')->get();
    // get data evaluasi pada halaman siswa sesuai dengan jadwal
    $data = LmsEvaluasi::wherein('idjadwal',$idjadwal)->orderby('tgl','desc')->where('tgl','!=',null)->get();
    return view('siswa.evaluasi.index', compact('data','nis'));
  }

  public function create($idevaluasi)
  {
    Session::put('tabpengajaran', 4);
    $evaluasi = LmsEvaluasi::with(['jadwal','user'])->where('id',$idevaluasi)->first();

    $jam2 = strtotime($evaluasi->mulai);
    $jam3 = strtotime($evaluasi->berakhir);
    $jam1 = strtotime('now');
    if ($evaluasi->idjenis == 1) {
      if ($jam1 < $jam2  ) {
        return back()->with('notif', json_encode([
          'title' => "EVALUASI",
          'text' => "Evaluasi belum dimulai.",
          'type' => "warning"
        ]));
      }elseif($jam1 > $jam3){
        return back()->with('notif', json_encode([
          'title' => "EVALUASI",
          'text' => "Evaluasi sudah berakhir.",
          'type' => "warning"
        ]));
      }
    }

    $soal = LmsEvaluasiSoal::where('idjenis',$evaluasi->idjenis)->where('idmapel',$evaluasi->jadwal->idmapel)->where('idguru',$evaluasi->user->link)->inRandomOrder()->take($evaluasi->jmlsoal)->where('idjenisevaluasi',$evaluasi->materi->idjenis)->get();

    if (!$soal->count() > 0) {
      return back()->with('notif', json_encode([
        'title' => "EVALUASI",
        'text' => "Soal tidak ditemukan",
        'type' => "warning"
      ]));
    }

    $tes = LmsSiswaEvaluasi::with(['soal.soal','siswa','evaluasi'])->where('idevaluasi',$idevaluasi)->where('nis', Auth::user()->siswa->nis)->first();

    if ($tes == null) {
      $tes = LmsSiswaEvaluasi::create([
        'idevaluasi' => $idevaluasi,
        'nis' => Auth::user()->siswa->nis
      ]);
      
      if ($evaluasi->idjenis == 2) {
        foreach ($soal as $s) {
          LmsSiswaEvaluasiJawaban::create([
            'idsiswaevaluasi' => $tes->id,
            'idsoal' => $s->id
          ]);
        }
      }else {
        foreach ($soal as $s) {
          LmsSiswaEvaluasiEssay::create([
            'idsiswaevaluasi' => $tes->id,
            'idsoal' => $s->id
          ]);
        }
      }

      $tes = LmsSiswaEvaluasi::with(['soal.soal','siswa','evaluasi'])->where('idevaluasi',$idevaluasi)->first();
    }

    if ($evaluasi->idjenis == 2) {
      $soal = LmsSiswaEvaluasiJawaban::with(['soal.jawaban'])->where('idsiswaevaluasi',$tes->id)->paginate(1);
      return view('siswa.evaluasi.create',compact('tes', 'evaluasi','soal'));
    }else {
      $soal = LmsSiswaEvaluasiEssay::with(['soal.cerita'])->where('idsiswaevaluasi',$tes->id)->get();
      return view('siswa.evaluasi.essay',compact('tes', 'evaluasi','soal'));
    }
  }

  public function essay_unggah($idevaluasi)
  {
    Session::put('tabpengajaran', 4);
    $evaluasi = LmsEvaluasi::with(['jadwal','user','materi'])->where('id',$idevaluasi)->first();

    $jam2 = strtotime($evaluasi->mulai);
    $jam3 = strtotime($evaluasi->berakhir);
    $jam1 = strtotime('now');
    if ($evaluasi->idjenis == 1) {
      if ($jam1 < $jam2  ) {
        return back()->with('notif', json_encode([
          'title' => "EVALUASI",
          'text' => "Evaluasi belum dimulai.",
          'type' => "warning"
        ]));
      }elseif($jam1 > $jam3){
        return back()->with('notif', json_encode([
          'title' => "EVALUASI",
          'text' => "Evaluasi sudah berakhir.",
          'type' => "warning"
        ]));
      }
    }

    $soal = LmsEvaluasiSoal::where('idjenis',$evaluasi->idjenis)->where('idmapel',$evaluasi->jadwal->idmapel)->where('idguru',$evaluasi->user->link)->inRandomOrder()->take($evaluasi->jmlsoal)->where('idjenisevaluasi',$evaluasi->materi->idjenis)->get();

    if (!$soal->count() > 0) {
      return back()->with('notif', json_encode([
        'title' => "EVALUASI",
        'text' => "Soal tidak ditemukan",
        'type' => "warning"
      ]));
    }

    $tes = LmsSiswaEvaluasi::with(['soal.soal','siswa','evaluasi'])->where('idevaluasi',$idevaluasi)->where('nis', auth::user()->siswa->nis)->first();
    if ($tes == null) {
      $tes = LmsSiswaEvaluasi::create([
        'idevaluasi' => $idevaluasi,
        'nis' => auth::user()->siswa->nis
      ]);

      if ($evaluasi->idjenis == 2) {
        foreach ($soal as $s) {
          LmsSiswaEvaluasiJawaban::create([
            'idsiswaevaluasi' => $tes->id,
            'idsoal' => $s->id
          ]);
        }
      }else {
        foreach ($soal as $s) {
          LmsSiswaEvaluasiEssay::create([
            'idsiswaevaluasi' => $tes->id,
            'idsoal' => $s->id
          ]);
        }
      }

      $tes = LmsSiswaEvaluasi::with(['soal.soal','siswa','evaluasi'])->where('idevaluasi',$idevaluasi)->first();
    }

    if ($evaluasi->idjenis == 1) {
      $soal = LmsSiswaEvaluasiEssay::with(['soal.cerita'])->where('idsiswaevaluasi',$tes->id)->get();
      return view('siswa.evaluasi.essay-unggah', compact('tes', 'evaluasi','soal'));
    }
  }

  public function jawab($jawaban)
  {
    $jawaban = explode('-',$jawaban);
    LmsSiswaEvaluasiJawaban::where('id',$jawaban[1])->update([
      'idjawaban' => $jawaban[0]
    ]);

    return $jawaban[0];
  }

  public function getsoal($idevaluasi,$soalke)
  {
    $soal = LmsSiswaEvaluasiJawaban::with(['soal.jawaban'])->where('idsiswaevaluasi',$idevaluasi)->get();
    
    $tampil='
    <div class="form_content">
      <div class="question_title pt-4">
        <div class="dropdown-divider mb-4"></div>
        <div class="row justify-content-center mb-0">';
          if($soal[$soalke-1]->soal->gambar != null){
          $tampil.='<div class="col-lg-4 mb-3">
                      <img width="100%" src="'.asset($soal[$soalke-1]->soal->gambar).'" alt="">
                    </div>';
          }
          if($soal[$soalke-1]->soal->idcerita != null){
            $tampil.='<div class="col-12 mb-2">
                        <p class="text-justify">'.$soal[$soalke-1]->soal->cerita->cerita.'</p>
                      </div>';
          }
          $tampil.='<div class="col-12 mb-1">
                      <p class="m-0"><b>'.$soal[$soalke-1]->soal->soal.'</b></p>
                    </div>';
        $tampil.='</div>
      </div>
      <div class="form_items mt-lg-3 row">';
        foreach($soal[$soalke-1]->soal->jawaban as $j){
        $tampil.='<div class="col-lg-6 mb-2">
          <label id="opt_'.$j->id.'" class="stepnya d-inline-block flex-column bg-white ';
          if ($soal[$soalke-1]->idjawaban == $j->id) {
            $tampil.='active ';
          }
          $tampil.='mb-2">
            <p class="step_box_desc">';
              if ($j->jawaban != null){
                $tampil.=$j->jawaban;
              }else{
                $tampil.='<img width="80px" src="'.asset($j->gambar).'" alt="">';
              }
            $tampil.='</p>
            <input for="opt_'.$j->id.'" id="soal'.$j->id.'" type="radio" name="jawaban" class="jawaban" value="'.$j->id.'-'.$soal[$soalke-1]->id.'">
          </label>
        </div>';
      }
      $tampil.='</div>
    </div>';
    return $tampil;

  }

  public function store(Request $request)
  {
    try {
      $evaluasi = LmsEvaluasi::find($request->id);
      Session::put('idjadwalglobal',$evaluasi->idjadwal);
      Session::put('idgambarglobal',$evaluasi->idjenis);

      $id_siswa_evaluasi = LmsSiswaEvaluasi::where('idevaluasi', $request->id)->where('nis',auth::user()->siswa->nis)->first()->id;

      $jawaban = LmsSiswaEvaluasiJawaban::where('idsiswaevaluasi',$id_siswa_evaluasi)->leftjoin('lms_evaluasi_jawabans','idjawaban','lms_evaluasi_jawabans.id');
      $jumlah = $jawaban->count();
      $nilai = $jawaban->sum('benar');

      $hasil_nilai = $nilai / $jumlah * 100;

      LmsSiswaEvaluasi::where('id',$id_siswa_evaluasi)->update([
        'idstatus' => 1,
        'nilai' => $hasil_nilai
      ]);
      return redirect('siswa/pembelajaran/'.Session::get("idjadwalglobal").'/'.Session::get("idgambarglobal"))->with('notif', json_encode([
        'title' => "EVALUASI",
        'text' => "Berhasil melakukan evaluasi",
        'type' => "success"
    ]));
    } catch (\Exception $e) {
      dd('terjadi kesalahan '.$e->getMessage());
    }
  }

  public function storeessay(Request $request)
  {
    try {
      $evaluasi = LmsSiswaEvaluasiEssay::where('idsiswaevaluasi',$request->id)->get();
      foreach ($evaluasi as $e) {
        $jawaban = 'jawaban'.$e->id;
        $file = 'jawabanfile'.$e->id;
        if ($request->file($file) != null) {
            $file = $request->file($file)->store('evaluasi/'.$request->id.'/'.auth::user()->siswa->nis);
        }else {
          $file = null;
        }
        LmsSiswaEvaluasiEssay::where('id',$e->id)->update([
          'jawaban' => $request->$jawaban,
          'file' => $file
        ]);

      }

      $file = null;
      if ($request->file('file') != null) {
          $file = $request->file('file')->store('evaluasi/'.$request->id.'/'.auth::user()->siswa->nis);
      }
      LmsSiswaEvaluasi::where('id',$request->id)->update([
        'idstatus' => 1,
        'file' => $file,
      ]);

      return redirect('siswa/pembelajaran/'.Session::get("idjadwalglobal").'/'.Session::get("idgambarglobal"))->with('notif', json_encode([
        'title' => "EVALUASI",
        'text' => "Berhasil melakukan evaluasi",
        'type' => "success"
    ]));
    } catch (\Exception $e) {
      dd('terjadi kesalahan '.$e->getMessage());
    }

  }

}
