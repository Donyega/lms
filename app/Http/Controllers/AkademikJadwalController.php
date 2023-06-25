<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Session;
use DateTime;
use App\Helper;
use App\Models\Siswa;
use App\Models\MdAgama;
use App\Models\MdKelas;
use App\Models\MdMapel;
use App\Models\Pegawai;
use App\Models\JadwalRpp;
use App\Models\MapingMapel;
use App\Models\MdMapelJenis;
use Illuminate\Http\Request;
use App\Models\MdJamPelajaran;
use App\Models\MdKelasTingkat;
use App\Models\JadwalPelajaran;
use Yajra\DataTables\DataTables;
use App\Models\JadwalPelajaranGuru;
use App\Models\JadwalPelajaranAgama;
use App\Models\JadwalPelajaranDetil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AkademikJadwalController extends Controller
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
    return view('akademik.jadwal.index');
  }

  public function dt() {
    // get idkelas pada tabel siswa
    $idkelas = Siswa::where('idstatus',1)->groupby('idkelas')->select('idkelas');
    
    // get data kelas yg berelasi di beberapa tabel sesuai dengan idkelas
    $data = MdKelas::with(['minat','tingkat','jenis','siswa','jadwal'])->wherein('id',$idkelas)->get();
    return DataTables::of($data)
      ->addColumn('jumlah', function($data) {
        return count($data->siswa);
      })
      ->addColumn('jadwal', function($data) {
        return count($data->jadwal->groupby('idmapel'));
      })
      ->addColumn('action', function($data) {
        return  '
        <a href='.route("md.jadwal.detail", $data->id).' class="btn btn-outline-info btn-sm waves-effect waves-float waves-light"><i data-feather="file-text"></i> Detail</a>
        ';
      })
      ->make(true);
  }

  public function dtagama() {
    $data = MdKelasTingkat::with('kelas.siswanonhindu','jadwalnonhindu')->wherehas('kelas')->get();
    return DataTables::of($data)
      ->addColumn('jumlah', function($data) {
        $jumlah = 0;
        foreach ($data->kelas as $k) {
          $jumlah += count($k->siswanonhindu);
        }
        return $jumlah;
      })
      ->addColumn('jadwal', function($data) {
        return count($data->jadwalnonhindu);
      })
      ->addColumn('action', function($data) {
        return  '
        <a href='.route("md.jadwal.detailagama", $data->id).' class="btn btn-outline-info btn-sm waves-effect waves-float waves-light"><i data-feather="file-text"></i> Detail</a>
        ';
      })
      ->make(true);
  }

  public function detail($idkelas) {
    // cek idta yang aktif/status 1
    $idta = Helper::idta();
    // cek idkurikulum yang aktif/status 1
    $idkurikulum = Helper::idkurikulum();
    
    // get data jadwal disertai dengan idta yang aktif dan idkelas
    $jadwal = JadwalPelajaran::with(['hari','detil.jampelajaran','jadwalguru.guru','mapel','user'])->where('idta',$idta)->where('idkelas',$idkelas)->get();
    $jam = MdJamPelajaran::all();
    $kelas = MdKelas::where('id',$idkelas)->first();
    $guru = Pegawai::where('jenis',1)->where('idstatus',1)->orderby('nama','asc')->get();
    $mapel = MapingMapel::with(['mapel','jenismapel'])
            ->where('idtingkat',$kelas->idtingkat)
            ->where('idjeniskelas',$kelas->idjenis)
            ->where('idminat',$kelas->idminat)
            ->get();
    return view('akademik.jadwal.detail', compact('jadwal','jam','kelas','guru','mapel'));
  }

  public function detailagama($idtingkat) {
    $idta = Helper::idta();
    $idkurikulum = Helper::idkurikulum();
    $jadwal = JadwalPelajaranAgama::with(['hari','detil.jampelajaran','jadwalguru.guru','agama','user'])->where('idta',$idta)->where('idtingkatkelas',$idtingkat)->get();
    $jam = MdJamPelajaran::all();
    $tingkat = MdKelasTingkat::with('kelas')->where('id',$idtingkat)->first();
    $guru = Pegawai::where('jenis',1)->where('idstatus',1)->orderby('nama','asc')->get();
    $agama = MdAgama::where('id','!=',4)->get();
    $idmapel = MdMapel::where('agama',1)->pluck('id')->first();
    $mapel = MapingMapel::with(['mapel','jenismapel'])
            ->where('idtingkat',$idtingkat)
            ->where('idjeniskelas',$tingkat->kelas[0]->idjenis)
            ->where('idminat',$tingkat->kelas[0]->idminat)
            ->where('idmapel',$idmapel)
            ->first();
    return view('akademik.jadwal.detailagama', compact('jadwal','jam','tingkat','guru','agama','mapel'));
  }

  public function store(Request $request)
  {
    try {
      $idta = Helper::idta();
      $maping = MapingMapel::where('id',$request->idmaping)->first();
      $idmapel = $maping->idmapel;
      $idjenismapel = $maping->idjenismapel;
      $israport = MdMapelJenis::where('id',$idjenismapel)->pluck('israport')->first();
      $kelas = MdKelas::where('id',$request->idkelas)->first();

      if($request->idjam == null ) {
        return back()->with('notif', json_encode([
          'title' => "PENGATURAN JADWAL",
          'text' => "Gagal menyimpan jadwal, jam pelajaran belum dipilih.",
          'type' => "warning"
        ]));
      }

      $jadwal = JadwalPelajaran::create([
        'idta' => $idta,
        'idmapel' => $idmapel,
        'idjenismapel' => $idjenismapel,
        'idkelas' => $request->idkelas,
        'idkurikulum' => $kelas->idkurikulum,
        'idhari' => $request->idhari,
        'iduser' => Auth::user()->id,
      ]);

      foreach ($request->idjam as $idjam) {
        JadwalPelajaranDetil::create([
          'idjadwal' => $jadwal->id,
          'idjam' => $idjam,
          'isagama' => 0
        ]);
      }

      foreach ($request->idguru as $idguru) {
        JadwalPelajaranGuru::create([
          'idjadwal' => $jadwal->id,
          'idguru' => $idguru,
          'isagama' => 0
        ]);
      }
      return back()->with('notif', json_encode([
        'title' => "PENGATURAN JADWAL",
        'text' => "Berhasil menambah jadwal pelajaran.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PENGATURAN JADWAL",
        'text' => "Gagal menambah jadwal pelajaran, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function delete(Request $request)
  {
    try {
      $idrpp = JadwalPelajaranGuru::where('idjadwal',$request->idjadwal)->where('idguru',$request->idguru)
              ->where('isagama',0)->pluck('idrpp')->first();
      JadwalPelajaran::where('id',$request->idjadwal)->delete();
      JadwalPelajaranDetil::where('idjadwal',$request->idjadwal)->where('isagama',0)->delete();
      JadwalPelajaranGuru::where('idjadwal',$request->idjadwal)->where('isagama',0)->delete();
      $cekrpp = JadwalPelajaranGuru::where('idrpp',$idrpp)->count();
      if ($cekrpp == 0) {
        JadwalRpp::where('id',$idrpp)->delete();
      }
      return back()->with('notif', json_encode([
        'title' => "PENGATURAN JADWAL",
        'text' => "Berhasil menghapus jadwal pelajaran.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PENGATURAN JADWAL",
        'text' => "Gagal menghapus jadwal pelajaran, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function storeagama(Request $request)
  {
    try {
      // dd($request->all());
      $idta = Helper::idta();
      $maping = MapingMapel::where('id',$request->idmaping)->first();
      $idmapel = $maping->idmapel;
      $idjenismapel = $maping->idjenismapel;
      $israport = MdMapelJenis::where('id',$idjenismapel)->pluck('israport')->first();
      $kelas = MdKelas::where('idtingkat',$request->idtingkatkelas)->where('isaktif',1)->first();
      $agama = MdAgama::where('id',$request->idagama)->first();

      if($request->idjam == null ) {
        return back()->with('notif', json_encode([
          'title' => "PENGATURAN JADWAL",
          'text' => "Gagal menyimpan jadwal, jam pelajaran belum dipilih.",
          'type' => "warning"
        ]));
      }

      $jadwal = JadwalPelajaranAgama::create([
        'idta' => $idta,
        'idmapel' => $idmapel,
        'idagama' => $request->idagama,
        'idjenismapel' => $idjenismapel,
        'idtingkatkelas' => $kelas->idtingkat,
        'idkurikulum' => $kelas->idkurikulum,
        'idhari' => $request->idhari,
        'iduser' => auth::user()->id,
      ]);

      foreach ($request->idjam as $idjam) {
        JadwalPelajaranDetil::create([
          'idjadwal' => $jadwal->id,
          'idjam' => $idjam,
          'isagama' => 1
        ]);
      }

      $rpp = JadwalRpp::where('idta',$idta)
            ->where('israport',$israport)
            ->where('idmapel',$idmapel)
            ->where('idtingkatkelas',$kelas->idtingkat)
            ->where('idminat',$kelas->idminat)
            ->where('idguru',$request->idguru)
            ->first();
      if ($rpp == null) {
        $rpp = JadwalRpp::create([
          'idta' => $idta,
          'israport' => $israport,
          'idmapel' => $idmapel,
          'idtingkatkelas' => $kelas->idtingkat,
          'idminat' => 0,
          'idguru' => $request->idguru,
          'iduser' => auth::user()->id
        ]);
      }
      JadwalPelajaranGuru::create([
        'idjadwal' => $jadwal->id,
        'idguru' => $request->idguru,
        'idrpp' => $rpp->id,
        'isagama' => 1
      ]);
      
      return back()->with('notif', json_encode([
        'title' => "PENGATURAN JADWAL",
        'text' => "Berhasil menambah jadwal pelajaran Agama $agama->nama.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PENGATURAN JADWAL",
        'text' => "Gagal menambah jadwal pelajaran, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function deleteagama(Request $request)
  {
    try {
      $idrpp = JadwalPelajaranGuru::where('idjadwal',$request->idjadwal)->where('idguru',$request->idguru)
              ->where('isagama',1)->pluck('idrpp')->first();
      JadwalPelajaranAgama::where('id',$request->idjadwal)->delete();
      JadwalPelajaranDetil::where('idjadwal',$request->idjadwal)->where('isagama',1)->delete();
      JadwalPelajaranGuru::where('idjadwal',$request->idjadwal)->where('isagama',1)->delete();
      $cekrpp = JadwalPelajaranGuru::where('idrpp',$idrpp)->count();
      if ($cekrpp == 0) {
        JadwalRpp::where('id',$idrpp)->delete();
      }
      return back()->with('notif', json_encode([
        'title' => "PENGATURAN JADWAL",
        'text' => "Berhasil menghapus jadwal pelajaran.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PENGATURAN JADWAL",
        'text' => "Gagal menghapus jadwal pelajaran, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

}
