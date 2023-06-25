<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\JadwalPelajaran;
use App\Models\JadwalPresensi;
use App\Models\MdBiaya;
use App\Models\MdKelas;
use App\Models\Siswa;
use App\Models\SiswaKelas;
use App\Models\SiswaNilaiKi34;
use App\Models\RiwayatWaliKelas;
use App\Models\TagihanSiswa;
use App\Models\TagihanSiswaDetil;
use App\Helper;
use DB;
use PDF;
use auth;
use DataTables;
use DateTime;
use Session;
class MDKelasController extends Controller
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
    return view('masterdata.kelas.index');
  }

  public function dt($aktif) {
    $data = MdKelas::with(['minat','tingkat','jenis','wali','siswa'])->where('isaktif',$aktif)->get();
    return DataTables::of($data)
      ->addColumn('jumlah', function($data) {
        return count($data->siswa->where('idstatus',1));
      })
      ->addColumn('action', function($data) {
        $detil = '';
        if ($data->isaktif == 0) {
          $btn = '<button type="submit" class="btn btn-sm btn-outline-success btnaktif" name="button"><i data-feather="play-circle"></i> Aktifkan</button>';
        }else {
          $detil = '<a href="'.route("md.kelas.detail", $data->id).'" class="btn btn-outline-info btn-sm waves-effect waves-float waves-light"><i data-feather="users"></i> Detail</a>';
          $btn = '<button type="submit" class="btn btn-sm btn-outline-danger btnaktif" name="button"><i data-feather="pause-circle"></i> Non-Aktifkan</button>';
        }
        return  '<div style="white-space:nowrap">'.$detil.'
        <form class="d-inline" action="'.route("md.kelas.updateaktif").'" method="post">
          <input type="hidden" name="idkelas" value="'.$data->id.'">
          '.$btn.'
          '.csrf_field().'
        </form></div>
        ';
      })
      ->make(true);
  }

  public function detail($id)
  {
    $ta = Helper::ta();
    $data = MdKelas::with(['wali','kurikulum'])->where('id',$id)->first();
    $siswa = Siswa::where('idstatus',1)->where('idkelas',null)->get();
    return view('masterdata.kelas.detail', compact('data','siswa','ta'));
  }

  public function dtsiswa($id)
  {
    $data = Siswa::with(['agama','jenis','jenisdaftar'])->where('idkelas',$id)->where('idstatus',1);
    return DataTables::of($data)
    ->addColumn('presensi', function($data) {
      $idta = Helper::idta();
      $idjadwal = JadwalPelajaran::where('idta',$idta)->where('idkelas',$data->idkelas)->select('id');
      $presensi = JadwalPresensi::wherein('idjadwal',$idjadwal)->where('nis',$data->nis)->count();
      return $presensi;
    })
    ->addColumn('action', function($data) {
      return  '<div style="white-space: nowrap">
      <a href='.route("md.siswa.detail", $data->id).' class="btn btn-outline-info btn-sm waves-effect waves-float waves-light"><i data-feather="user"></i> Detail</a>
      <button type="button" id="btnedit" class="btn btn-sm btn-outline-warning waves-effect waves-float waves-light" name="button" data-toggle="modal" data-target="#modal-pindah" data-backdrop="static" data-keyboard="false"><i data-feather="repeat"></i> Pindah Kelas</button>
      </div>';
    })
    ->make(true);
  }

  public function getjenis($id)
  {
    $data = MdKelas::where('id',$id)->first();
    return $data;
  }

  public function store(Request $request)
  {
    try {
      $idminat = 0;
      if ($request->idminat != null) {
        $idminat = $request->idminat;
      }
      MdKelas::create([
        'nama' => $request->nama,
        'idtingkat' => $request->idtingkat,
        'idjenis' => $request->idjenis,
        'idminat' => $idminat,
        'idkurikulum' => $request->idkurikulum
      ]);
      return back()->with('notif', json_encode([
        'title' => "DATA KELAS",
        'text' => "Berhasil menambah kelas baru.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "DATA KELAS",
        'text' => "Gagal menambah kelas baru ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function update(Request $request)
  {
    try {
      $idminat = 0;
      if ($request->idminat != null) {
        $idminat = $request->idminat;
      }
      MdKelas::where('id',$request->id)->update([
        'nama' => $request->nama,
        'idtingkat' => $request->idtingkat,
        'idjenis' => $request->idjenis,
        'idminat' => $idminat,
        'idkurikulum' => $request->idkurikulum
      ]);
      return back()->with('notif', json_encode([
        'title' => "DATA KELAS",
        'text' => "Berhasil mengubah data kelas.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "DATA KELAS",
        'text' => "Gagal mengubah data kelas, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function updatewali(Request $request)
  {
    try {
      $idta = Helper::idta();
      $cek = Mdkelas::with('wali')->where('idwali',$request->idwali)->get();
      $riwayatwali = RiwayatWaliKelas::where('idta',$idta)->where('idkelas',$request->idkelas)->count();
      if (count($cek) != 0) {
        return back()->with('notif', json_encode([
          'title' => "WALI KELAS",
          'text' => "Gagal menentukan wali kelas, ".$cek[0]->wali->nama." telah ditentukan sebagai wali kelas ".$cek[0]->nama." ".$cek[0]->jenis->nama,
          'type' => "error"
        ]));
      }
      
      MdKelas::where('id',$request->idkelas)->update([
        'idwali' => $request->idwali,
      ]);

      if ($riwayatwali > 0) {
        RiwayatWaliKelas::where('idta',$idta)->where('idkelas',$request->idkelas)->update([
          'idwali' => $request->idwali,
        ]);
      }else {
        RiwayatWaliKelas::create([
          'idta' => $idta,
          'idkelas' => $request->idkelas,
          'idwali' => $request->idwali
        ]);
      }

      return back()->with('notif', json_encode([
        'title' => "WALI KELAS",
        'text' => "Berhasil menentukan wali kelas.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "WALI KELAS",
        'text' => "Gagal menentukan wali kelas,".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function resetwali(Request $request)
  {
    try {
      $idta = Helper::idta();
      MdKelas::where('idwali','!=',null)->update([
        'idwali' => null
      ]);

      RiwayatWaliKelas::where('idta',$idta)->delete();

      return back()->with('notif', json_encode([
        'title' => "RESET WALI KELAS",
        'text' => "Berhasil memproses reset wali kelas.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "RESET WALI KELAS",
        'text' => "Gagal memproses reset wali kelas,".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function updatesiswa(Request $request)
  {
    try {
      $idta = Helper::idta();
      $kelas = MdKelas::with('jenis')->where('id',$request->idkelas)->first();
      foreach($request->nis as $nis) {
        Siswa::where('nis',$nis)->update([
          'idkelas' => $request->idkelas,
        ]);

        SiswaKelas::create([
          'idta' => $idta,
          'nis' => $nis,
          'idkelas' => $request->idkelas
        ]);
      }

      return back()->with('notif', json_encode([
        'title' => "TAMBAH SISWA",
        'text' => "Berhasil menambahkan siswa ke kelas $kelas->nama ".$kelas->jenis->nama.".",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "TAMBAH SISWA",
        'text' => "Gagal menambahkan siswa,".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function pindahkelas(Request $request)
  {
    try {
      $idta = Helper::idta();
      $kelas = MdKelas::with('jenis')->where('id',$request->idkelas2)->first();
      $siswa = Siswa::with('detil')->where('nis',$request->nis2)->first();
      $idjadwal = JadwalPelajaran::where('idta',$idta)->where('idkelas',$request->idklsasal)->select('id');
      $presensi = JadwalPresensi::wherein('idjadwal',$idjadwal)->where('nis',$siswa->nis)->count();
      $nilai = SiswaNilaiKi34::wherein('idjadwal',$idjadwal)->where('nis',$siswa->nis)->count();

      Siswa::where('nis',$request->nis2)->update([
        'idkelas' => $request->idkelas2
      ]);

      SiswaKelas::where('idta',$idta)->where('nis',$request->nis2)->update([
        'idkelas' => $request->idkelas2
      ]);

      // hapus jika ada presensi di kelas sebelumnya
      if ($presensi > 0) {
        JadwalPresensi::wherein('idjadwal',$idjadwal)->where('nis',$siswa->nis)->delete();
      }

      // hapus jika ada nilai di kelas sebelumnya
      if ($nilai > 0) {
        SiswaNilaiKi34::wherein('idjadwal',$idjadwal)->where('nis',$siswa->nis)->delete();
      }

      return back()->with('notif', json_encode([
        'title' => "PINDAH KELAS",
        'text' => "Berhasil memindahkan $siswa->nama ke kelas $kelas->nama ".$kelas->jenis->nama.".",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      dd($e->getMessage());
      return back()->with('notif', json_encode([
        'title' => "PINDAH KELAS",
        'text' => "Gagal memindahkan siswa,".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function updateaktif(Request $request)
  {
    try {
      $kelas = MdKelas::with('jenis')->where('id',$request->idkelas)->first();
      $namakelas = $kelas->nama.' '.$kelas->jenis->nama;
      $jmlsiswa = Siswa::where('idstatus',1)->where('idkelas',$kelas->id)->count();

      if ($jmlsiswa > 0) {
        return back()->with('notif', json_encode([
          'title' => "STATUS KELAS",
          'text' => "Gagal mengubah status kelas $namakelas karena masih terdapat $jmlsiswa Siswa yang terdaftar di kelas tersebut.",
          'type' => "warning"
        ]));
      }

      if ($kelas->isaktif == 1) {
        $isaktif = 0;
        $status = 'menonaktifkan';
      }else {
        $isaktif = 1;
        $status = 'mengaktifkan';
      }
      MdKelas::where('id',$request->idkelas)->update([
        'isaktif' => $isaktif
      ]);
      return back()->with('notif', json_encode([
        'title' => "STATUS KELAS",
        'text' => "Berhasil $status kelas $namakelas.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "STATUS KELAS",
        'text' => "Gagal $status kelas $namakelas,".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

}
