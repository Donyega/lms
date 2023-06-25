<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Ta;
use App\Models\MdBiaya;
use App\Models\MdKelas;
use App\Models\Siswa;
use App\Models\SiswaKelas;
use App\Models\SiswaStatus;
use App\Models\RiwayatWaliKelas;
use App\Helper;
use DataTables;

class MDTaController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    return view('masterdata.ta.index');
  }

  public function dt()
  {
    return DataTables::of(Ta::all())
    ->addColumn('action', function($data) {
      $a='';
      if ($data->isAktif == 0) {
        $a='<form action="'.route("md.ta.aktif").'" method="post">
          <button type="submit" id="submit" name="id" value="'.$data->id.'"  class="btn btn-sm btn-outline-success waves-effect waves-float waves-light">Aktifkan</button>
          '.csrf_field().'
        </form>';
      }
      return $a ;
    })
    ->setRowClass(function ($data) {
      $text='';
      if ($data->isAktif == 1) {
        $text ='text-success';
      }
      return $text;
    })
    ->make(true);
  }

  public function aktif(Request $request)
  {
    try {
      $idta = Helper::idta();
      $ta = Ta::where('id',$request->id)->first();
      $semester = 'Ganjil';
      if ($ta->semester == '2') {
        $semester = 'Genap';
      }

      Ta::where('id','!=',$request->id)->update([
        'isAktif' => 0
      ]);

      Ta::where('id',$request->id)->update([
        'isAktif' => 1
      ]);

      $kelas = MdKelas::all();
      $siswa = Siswa::where('idstatus',1)->get();

      // update siswa kelas dan status
      if ($ta->semester == '2') {
        foreach ($siswa as $s) {
          $ceksk = SiswaKelas::where('idta',$ta->id)->where('nis',$s->nis)->count();
          if ($ceksk == 0) {
            SiswaKelas::create([
              'idta' => $ta->id,
              'nis' => $s->nis,
              'idkelas' => $s->idkelas,
            ]);
          }
          $cekss = SiswaStatus::where('idta',$ta->id)->where('nis',$s->nis)->count();
          if ($cekss == 0) {
            SiswaStatus::create([
              'idta' => $ta->id,
              'nis' => $s->nis,
              'idstatus' => $s->idstatus,
            ]);
          }
        }
        // update riwayat wali
        foreach ($kelas as $k) {
          $cekwali = RiwayatWaliKelas::where('idta',$ta->id)->count();
          if ($cekwali == 0) {
            RiwayatWaliKelas::create([
              'idta' => $ta->id,
              'idkelas' => $k->idkelas,
              'idwali' => $k->idwali
            ]);
          }
        }
      }

      // update kelas di tabel siswa sesuai kelasnya di idta yg dipilih
      foreach ($siswa as $s) {
        $cekkelas = SiswaKelas::where('idta',$ta->id)->where('nis',$s->nis)->first();
        if ($cekkelas != null) {
          Siswa::where('nis',$s->nis)->update([
            'idkelas' => $cekkelas->idkelas,
          ]);
        }
      }
      
      // update wali di tabel kelas sesuai riwayat di idta yg dipilih
      $walikelas = RiwayatWaliKelas::where('idta',$ta->id)->get();
      foreach ($kelas as $k) {
        MdKelas::where('id',$k->id)->update([
          'idwali' => null
        ]);
      }
      if (count($walikelas) > 0) {
        foreach ($walikelas as $w) {
          MdKelas::where('id',$w->idkelas)->update([
            'idwali' => $w->idwali
          ]);
        }
      }

      return back()->with('notif', json_encode([
        'title' => "TAHUN AJARAN",
        'text' => "Berhasil mengaktifkan tahun ajaran $ta->tahun $semester.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "TAHUN AJARAN",
        'text' => "Gagal mengaktifkan tahun ajaran $ta->tahun $semester, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function store(Request $request)
  {
    try {
      Ta::create([
        'tahun' => $request->tahun,
        'semester' => $request->semester,
        'kkm' => $request->kkm,
        'idkurikulum' => Helper::idkurikulum(),
        'isAktif' => 0,
      ]);
      return back()->with('notif', json_encode([
        'title' => "TAHUN AJARAN",
        'text' => "Berhasil menambah tahun ajaran baru.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "TAHUN AJARAN",
        'text' => "Gagal menambah tahun ajaran baru ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }
}
