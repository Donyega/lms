<?php

namespace App\Http\Controllers;

use Excel;
use App\Helper;
use App\Models\Mahasiswa;
use App\Models\LmsEvaluasi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\excelimport\unggahsoal;
use App\Models\LmsEvaluasiSoal;
use Yajra\DataTables\DataTables;
use App\Models\LmsEvaluasiCerita;
use App\excelimport\unggahjawaban;
use App\Models\LmsEvaluasiJawaban;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\excelexport\excelunduhtemplatesoaljawaban;

class PembelajaranEvaluasiController extends Controller
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

  public function index($idjadwal,$idmateri,$idevaluasi)
  {
    // select data evaluasi berdasrkan idevaluasi dan idmateri
    $data = LmsEvaluasi::with(['materi','jadwal','user'])->where('id',$idevaluasi)
          ->where('idmateri',$idmateri)->first();
    $soal = LmsEvaluasiSoal::where('idguru', Auth::user()->link)->where('idmapel',$data->jadwal->idmapel)->where('idjenis',$data->idjenis)->where('idevaluasi', $idevaluasi)->get();
    Session::put('idevaluasiglobal',$data->id);
    Session::put('idmateriglobal',$data->idmateri);
    Session::put('idmapel',$data->jadwal->idmapel);
    return view('guru.pembelajaran.evaluasi', compact('data','soal'));
  }

  public function dt($idevaluasi, $idmapel, $idjenis)
  {
    $data = LmsEvaluasiSoal::with(['cerita','jawaban'])->where('idmapel',$idmapel)->where('idjenis',$idjenis)->where('idguru', Auth::user()->link)->where('idevaluasi', $idevaluasi)->get();
    return DataTables::of($data)
    ->addColumn('action', function($data) {
      return '
      <a class="btn btn-sm btn-outline-primary waves-effect waves-float waves-light" href="'.route("pembelajaran.evaluasi.detailsoal",[Session::get('idjadwalglobal'),$data->id]).'"  title="Detail"><i data-feather="info"></i> Detail
      </a>
      ';
      })
    ->make(true);
  }

  public function dtcerita()
  {
    $data = LmsEvaluasiCerita::where('idguru',auth::user()->link)->where('idmapel',Session::get("idmapel"));
    return DataTables::of($data)
    ->addColumn('action', function($data) {
      return '
      <button class="btn btn-sm btn-outline-primary waves-effect waves-float waves-light pilihcerita" value="'.$data->id.'">Pilih</b>
      ';
      })
    ->make(true);
  }

  public function detailsoal($idjadwal, $id)
  {
    $data = LmsEvaluasiSoal::with(['cerita','jawaban'])->where('id',$id)->first();
    return view('guru.pembelajaran.detailsoal', compact('data'));
  }

  public function unduhtemplate(Request $request)
  {
    $data = LmsEvaluasi::with(['materi','jadwal'])->where('id',$request->idevaluasi)->first();
    $jenis = $request->idjenis;
    return Excel::download(new excelunduhtemplatesoaljawaban($data,$jenis), 'Template.xlsx');
  }

  public function unggahsoaljawaban(Request $request)
  {

    if($request->file('doksoal') != null){
      $file = $request->file('doksoal');
      $nama_file = rand().$file->getClientOriginalName();
      $lokasi = $request->file('doksoal')->store('soal/import');
      // Excel::import(new unggahsoal, public_path('/../../'.$lokasi));
      Excel::import(new unggahsoal($request->idmapel,$request->idjenis), public_path('/../../'.$lokasi));
    }

    if($request->file('dokjawaban') != null){
      $file = $request->file('dokjawaban');
      $nama_file = rand().$file->getClientOriginalName();
      $lokasi = $request->file('dokjawaban')->store('jawaban/import');
      // Excel::import(new unggahsoal, public_path('/../../'.$lokasi));
      Excel::import(new unggahjawaban($request->idmapel,$request->idjenis), public_path('/../../'.$lokasi));
    }

    return back()->with('notif', json_encode([
      'title' => "SOAL EVALUASI",
      'text' => "Berhasil mengunggah dokumen soal.",
      'type' => "success"
    ]));
  }

  public function storesoal(Request $request)
  {
    try {

      if ($request->file('files') != null) {
          $file = $request->file('files')->store('evaluasi/soal');
          $request->merge([
            'file' => $file
          ]);
      }else {
        $file = null;
      }

      LmsEvaluasiSoal::create($request->all());
      if ($request->idjenis == 2) {
        $no = 1;
        foreach ($request->jawab as $j) {
          if ($request->jawaban == $no) {
            $benar = 1;
          }else {
            $benar = null;
          }
          LmsEvaluasiJawaban::create([
            'kode' => $request->kode,
            'idmapel' => $request->idmapel,
            'jawaban' => $j,
            'benar' => $benar,
          ]);
          $no++;
        }
      }
      return back()->with('notif', json_encode([
        'title' => "SOAL EVALUASI",
        'text' => "Berhasil menambah soal.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "SOAL EVALUASI",
        'text' => "Gagal menambahkan soal, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function updatesoal(Request $request)
  {
    try {
      if ($request->file('gbr') != null) {
        $gambar = $request->file('gbr')->store('soal/'.$request->idsoal);
        $request->merge([
          'gambar' => $gambar
        ]);
      }

      if ($request->idceritalama == null) {
          if ($request->cerita != null) {
            $cerita = LmsEvaluasiCerita::create([
              'cerita' => $request->cerita,
              'idguru' => auth::user()->link,
              'idmapel' => Session::get('idmapel')
            ]);

            $request->merge([
              'idcerita' => $cerita->id
            ]);
          }
      }else {
        $request->merge([
          'idcerita' => $request->idceritalama
        ]);
      }

      LmsEvaluasiSoal::where('id',$request->idsoal)->update($request->except(['_token','button','idsoal','gbr','cerita','idceritalama','jawaban','jawab']));

      if ($request->idjenis == 2) {
        $datasoal = LmsEvaluasiSoal::where('id',$request->idsoal)->first();
        LmsEvaluasiJawaban::where('idmapel',$datasoal->idmapel)->where('kode',$datasoal->kode)->delete();
        $b = 0;
        foreach ($request->jawab as $j) {
          $benar = null;
          if ($request->jawaban == $b) {
            $benar = 1;
          }
          LmsEvaluasiJawaban::create([
            'idmapel' => $datasoal->idmapel,
            'kode' => $datasoal->kode,
            'jawaban' => $j,
            'benar' => $benar
          ]);
          $b++;
        }
      }


      return back()->with('notif', json_encode([
        'title' => "SOAL",
        'text' => "Berhasil mengubah soal.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "SOAL",
        'text' => "Gagal mengubah soal, ".$e->getMessage(),
        'type' => "error"
      ]));
    }

  }

}
