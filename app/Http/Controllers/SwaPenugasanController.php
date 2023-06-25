<?php

namespace App\Http\Controllers;

use View;
use Excel;
use Session;
use App\Helper;
use App\Models\LmsPenugasan;
use Illuminate\Http\Request;
use App\Models\LmsSiswaTugas;
use App\Models\JadwalPelajaran;
use App\Models\JadwalPelajaranDetil;
use App\Models\LmsSiswaTugasDokumen;
use Illuminate\Support\Facades\Auth;

class SwaPenugasanController extends Controller
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
    $idta = Helper::idta();
    $nis = auth::user()->siswa->nis;
    $idjadwal = JadwalPelajaranDetil::whereHas('jadwal', function($query) use($idta,$nis){
                $query->where('idta',$idta);
            })->select('idjadwal');
    $data = LmsPenugasan::with(['jadwal','tugassiswa'])->wherein('idjadwal',$idjadwal)->orderby('batastgl','desc')->get();
    return view('siswa.penugasan.index', compact('data','nis'));
  }

  public function detil($id)
  {
    $data = LmsPenugasan::with(['jadwal','tugassiswa','user'])->where('id',$id)->first();
    if ($data->idjenis == 1) {
      $sws = array();
    }else {
      $kumpul = $data->tugassiswa->where('nis', Auth::user()->siswa->nis)->first();
      if ($kumpul != null) {
        $tglkumpul = strtotime($kumpul->created_at);

        $anggota = array();
        foreach ($kumpul->kelompok as $k) {
          $anggota[] = $k->nis;
        }

        $sws = JadwalPelajaran::leftjoin('jadwal_pelajaran_detils','idjadwal','jadwal_pelajarans.id')->where('idjadwal',$data->idjadwal)->leftjoin('siswas','siswas.idkelas','jadwal_pelajarans.idkelas')->where('idstatus', 1)->wherenotin('jadwal_pelajarans.idkelas',$anggota)->get();
      }else {
        $sws = JadwalPelajaran::leftjoin('jadwal_pelajaran_detils','idjadwal','jadwal_pelajarans.id')->where('idjadwal',$data->idjadwal)->leftjoin('siswas','siswas.idkelas','jadwal_pelajarans.idkelas')->where('idstatus', 1)->get();
      }
    }
    return view('siswa.penugasan.detil', compact('data','sws'));
  }

  public function store(Request $request)
  {
    try {
      $cek = LmsSiswaTugas::where('nis',$request->nis)->where('idpenugasan',$request->idpenugasan)->first();
      if ($request->idjenis == 1) {
        if ($cek == null) {
          $tugas = LmsSiswaTugas::create([
            'idjadwal' => $request->idjadwal,
            'idpenugasan' => $request->idpenugasan,
            'nis' => $request->nis
          ]);

          if ($request->file('dokumen') != null) {
            $file = $request->file('dokumen')->storeAs('tugassiswa/'.$request->idpenugasan.'/'.$request->nis,
                    $request->file('dokumen')->getClientOriginalName()
            );

            LmsSiswaTugasDokumen::create([
              'idtugas' => $tugas->id,
              'nama' => $request->namadokumen,
              'dokumen' => $file,
              'iduser' =>auth::user()->id
            ]);
          }

        }else {
          if ($request->file('dokumen') != null) {
            $file = $request->file('dokumen')->storeAs('tugassiswa/'.$request->idpenugasan.'/'.$request->nis,
                    $request->file('dokumen')->getClientOriginalName()
            );

            LmsSiswaTugasDokumen::create([
              'idtugas' => $cek->id,
              'nama' => $request->namadokumen,
              'dokumen' => $file,
              'iduser' =>auth::user()->id
            ]);
          }
        }
      }else {
        if ($cek == null) {
          $tugas = LmsSiswaTugas::create([
            'idjadwal' => $request->idjadwal,
            'idpenugasan' => $request->idpenugasan,
            'nis' => $request->nis,
            'iduser' =>auth::user()->id
          ]);

          LmsSiswaTugas::where('id',$tugas->id)->update([
            'idkelompok' => $tugas->id
          ]);

          foreach ($request->kelompok as $k) {
            LmsSiswaTugas::create([
              'idjadwal' => $request->idjadwal,
              'idpenugasan' => $request->idpenugasan,
              'nis' => $k,
              'iduser' =>auth::user()->id,
              'idkelompok' => $tugas->id
            ]);
          }

          if ($request->file('dokumen') != null) {
            $file = $request->file('dokumen')->storeAs('tugassiswa/'.$request->idpenugasan.'/'.$request->nis,
                    $request->file('dokumen')->getClientOriginalName()
            );

            LmsSiswaTugasDokumen::create([
              'idkelompok' => $tugas->id,
              'nama' => $request->namadokumen,
              'dokumen' => $file,
              'iduser' =>auth::user()->id
            ]);
          }

        }else {
          if ($request->file('dokumen') != null) {
            $file = $request->file('dokumen')->storeAs('tugassiswa/'.$request->idpenugasan.'/'.$request->nis,
                    $request->file('dokumen')->getClientOriginalName()
            );

            LmsSiswaTugasDokumen::create([
              'idkelompok' => $cek->idkelompok,
              'nama' => $request->namadokumen,
              'dokumen' => $file,
              'iduser' =>auth::user()->id
            ]);
          }
        }
      }
      return back()->with('notif', json_encode([
        'title' => "PENUGASAN",
        'text' => "Berhasil mengunggah tugas.",
        'type' => "success"
    ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PENUGASAN",
        'text' => "Gagal mengunggah tugas, ".$e->getMessage(),
        'type' => "error"
      ]));
    }

  }

  public function storeanggota(Request $request)
  {
    try {
      $cek = LmsSiswaTugas::where('nis',$request->nis)->where('idpenugasan',$request->idpenugasan)->first();
      foreach ($request->kelompok as $k) {
        LmsSiswaTugas::create([
          'idjadwal' => $request->idjadwal,
          'idpenugasan' => $request->idpenugasan,
          'nis' => $k,
          'iduser' =>auth::user()->id,
          'idkelompok' => $cek->id
        ]);
      }
      return back()->with('notif', json_encode([
        'title' => "PENUGASAN",
        'text' => "Berhasil mengunggah tugas.",
        'type' => "success"
    ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PENUGASAN",
        'text' => "Gagal mengunggah tugas, ".$e->getMessage(),
        'type' => "error"
      ]));
    }

  }

  public function deletedokumen(Request $request)
  {
    try {
      if ($request->idjenis == 1) {
        LmsSiswaTugasDokumen::where('id',$request->id)->delete();
      }else {
        LmsSiswaTugasDokumen::where('idkelompok',$request->id)->delete();
      }
      return back()->with('notif', json_encode([
        'title' => "PENUGASAN",
        'text' => "Berhasil menghapus dokumen.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PENUGASAN",
        'text' => "Gagal menghapus dokumen, ".$e->getMessage(),
        'type' => "error"
      ]));
    }

  }

  public function deletkelompok(Request $request)
  {
    try {
      LmsSiswaTugas::where('id',$request->id)->delete();
      return back()->with('notif', json_encode([
        'title' => "PENUGASAN",
        'text' => "Berhasil menghapus anggota kelompok.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PENUGASAN",
        'text' => "Gagal menghapus anggota kelompok, ".$e->getMessage(),
        'type' => "error"
      ]));
    }

  }

}
