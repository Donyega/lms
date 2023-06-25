<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Ta;
use App\Models\Siswa;
use App\Models\MdKelas;
use App\Models\MdMapel;
use App\Models\LmsMateri;
use App\Models\LmsEvaluasi;
use App\Models\MapingMapel;
use App\Models\LmsPenugasan;
use Illuminate\Http\Request;
use App\Models\LmsSiswaTugas;
use App\Models\SiswaNilaiKi34;
use App\Models\JadwalPelajaran;
use App\Models\LmsEvaluasiSoal;
use App\Models\LmsTopikDiskusi;
use App\Models\LmsSiswaEvaluasi;
use Yajra\DataTables\DataTables;
use App\Models\JadwalPelajaranGuru;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PembelajaranNilaiController extends Controller
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

  public function index() {
    // cek tahun ajaran yg aktif
    $idta = Helper::idta();

    // get data jadwal pelajaran berdasarkan tahun ajaran yg aktif
    $data = JadwalPelajaran::with(['hari','detil.jampelajaran','mapel','kelas.jenis','jadwalguru.guru','jenismapel', 'penugasanlms'])
    ->leftjoin('jadwal_pelajaran_gurus','jadwal_pelajarans.id','idjadwal')
    ->where('jadwal_pelajaran_gurus.idguru', Auth::user()->link)
    ->wherehas('jadwalguru')
    ->where('idta',$idta)
    ->groupby('idkelas')
    ->groupby('idmapel')
    ->groupby('idjenismapel')
    ->get();

    return view('guru.pembelajaran.penilaian.index', compact('data', 'idta'));
  }

  public function detail($idkelas,$idmapel,$idjenis)
  {
    $ta = Helper::ta();
    // get id kelas
    $kelas = MdKelas::where('id',$idkelas)->first();
    // get id mapel
    $mapel = MdMapel::where('id',$idmapel)->first();
    // get detail jadwal pelajaran sesuai mapel dan kelas
    $jadwal = JadwalPelajaran::with(['detil','hari'])->where('idta',$ta->id)->where('idmapel',$idmapel)
              ->orderby('idhari','asc')
              ->where('idkelas',$idkelas)->get();
    dd($jadwal);
    $idjadwal = array();
    foreach ($jadwal as $j) {
      $idjadwal[] = $j->id;
    }
    // get data guru sesuai dengan jadwal pelajaran
    $guru = JadwalPelajaranGuru::with('guru')->wherein('idjadwal',$idjadwal)->groupby('idguru')->get();
    // get data siswa sesuai kelas dan status aktif
    $siswa = Siswa::where('idkelas',$idkelas)->where('idstatus',1)->orderby('nama','asc')->get();
    $nis = array();
    foreach ($siswa as $s) {
      $nis[] = $s->nis;
    }

    $penugasan = LmsPenugasan::wherein('idjadwal', $idjadwal)->get();
    $idpenugasan = array();
    foreach ($idpenugasan as $p) {
      $idpenugasan[] = $p->id;
    }

    return view('guru.penilaian.detail', compact('ta','kelas','mapel','guru','siswa', 'jadwal', 'penugasan'));
  }

  public function detailquiz($idkelas,$idmapel,$idjenis)
  {
    $ta = Helper::ta();
    // get id kelas
    $kelas = MdKelas::where('id',$idkelas)->first();
    // get id mapel
    $mapel = MdMapel::where('id',$idmapel)->first();
    // get detail jadwal pelajaran sesuai mapel dan kelas
    $jadwal = JadwalPelajaran::with(['detil','hari'])->where('idta',$ta->id)->where('idmapel',$idmapel)
              ->orderby('idhari','asc')
              ->where('idkelas',$idkelas)->get();

    $idjadwal = array();
    foreach ($jadwal as $j) {
      $idjadwal[] = $j->id;
    }
    // get data guru sesuai dengan jadwal pelajaran
    $guru = JadwalPelajaranGuru::with('guru')->wherein('idjadwal',$idjadwal)->groupby('idguru')->get();
    // get data siswa sesuai kelas dan status aktif
    $siswa = Siswa::where('idkelas',$idkelas)->where('idstatus',1)->orderby('nama','asc')->get();
    $nis = array();
    foreach ($siswa as $s) {
      $nis[] = $s->nis;
    }

    $materi = LmsMateri::wherein('idjadwal', $idjadwal)->get();
    $idmateri = array();
    foreach ($materi as $m) {
      $idmateri[] = $m->id;
    }

    $evaluasi = LmsEvaluasi::with('materi')->wherein('idmateri', $idmateri)->get();
    $idevaluasi = array();
    foreach ($evaluasi as $e) {
      $idevaluasi[] = $e->id;
    }

    $bulan = LmsSiswaEvaluasi::where('idevaluasi', $idevaluasi)->first();

   return view('guru.penilaian.detailquiz', compact('ta','kelas','mapel','guru','siswa', 'jadwal', 'evaluasi', 'materi', 'bulan'));
  }

  public function cetaknilaitugas(Request $request)
  {
    $ta = Ta::where('id',$request->idta)->first();
    $agama = 0;
    $mapel = MdMapel::where('id',$request->idmapel)->first();
    $kelas = MdKelas::with('jenis')->where('id',$request->idkelas)->first();
    $namakelas = $kelas->nama.' '.$kelas->jenis->nama;
    $idjenismapel = MapingMapel::where('idkurikulum',$kelas->idkurikulum)
          ->where('idtingkat',$kelas->idtingkat)->where('idminat',$kelas->idminat)
          ->where('idjeniskelas',$kelas->idjenis)->where('idmapel',$mapel->id)
          ->pluck('idjenismapel')->first();
    $jadwal = JadwalPelajaran::with(['detil','hari'])->where('idta',$ta->id)
          ->where('idmapel',$mapel->id)
          ->where('idjenismapel',$idjenismapel)->orderby('idhari','asc')
          ->where('idkelas',$kelas->id)->get();
    $idjadwal = array();
    foreach ($jadwal as $j) {
      $idjadwal[] = $j->id;
    }
    $guru = JadwalPelajaranGuru::with('guru')->wherein('idjadwal',$idjadwal)->where('isagama','0')
          ->groupby('idguru')->get();
    
    $idagama = null;
    if ($request->isagama == 1) {
      $idagama = 4;
    }
    $siswa = Siswa::where('idkelas',$request->idkelas)->where('idstatus',1)
            ->when(!empty($idagama), function ($query) use ($idagama) {
                return $query->where('idagama',$idagama);
            })->orderby('nama','asc')->get();
    foreach ($siswa as $s) {
      $nis[] = $s->nis;
    }

    $penugasan = LmsPenugasan::where('idjadwal', $idjadwal)->get();
    foreach ($penugasan as $pp) {
      $tugas[] = $pp->id;
    }

    if ($kelas->idkurikulum == 1) {
      // $nilai = SiswaNilaiKi12::with(['ki1','ki2'])->where('idta',$ta->id)->wherein('nis',$nis)->get();
      $nilaimapel = SiswaNilaiKi34::where('idta',$ta->id)->where('idmapel',$request->idmapel)
              ->wherein('nis',$nis)->get();
      $grade = MdNilai::where('status',1)->get();
      $pdf = PDF::loadView('guru.penilaian.nilaitugas', compact('ta','mapel','kelas','jadwal','guru','siswa','nilaimapel','grade','namakelas','agama', 'penugasan'))->setPaper('A4','landscape');
      return $pdf->stream('Nilai - '.$mapel->nama.' ('.$namakelas.').pdf');
    }
  }

  public function cetakevaluasi($idkelas,$idmapel)
  {
    $ta = Helper::ta();
    // get id kelas
    $kelas = MdKelas::where('id',$idkelas)->first();
    // get id mapel
    $mapel = MdMapel::where('id',$idmapel)->first();
    // get detail jadwal pelajaran sesuai mapel dan kelas
    $jadwal = JadwalPelajaran::with(['detil','hari'])->where('idta',$ta->id)->where('idmapel',$idmapel)
              ->orderby('idhari','asc')
              ->where('idkelas',$idkelas)->get();

    $idjadwal = array();
    foreach ($jadwal as $j) {
      $idjadwal[] = $j->id;
    }
    // get data guru sesuai dengan jadwal pelajaran
    $guru = JadwalPelajaranGuru::with('guru')->wherein('idjadwal',$idjadwal)->groupby('idguru')->get();
    // get data siswa sesuai kelas dan status aktif
    $siswa = Siswa::where('idkelas',$idkelas)->where('idstatus',1)->orderby('nama','asc')->get();
    $nis = array();
    foreach ($siswa as $s) {
      $nis[] = $s->nis;
    }

    $materi = LmsMateri::wherein('idjadwal', $idjadwal)->get();
    $idmateri = array();
    foreach ($materi as $m) {
      $idmateri[] = $m->id;
    }

    $evaluasi = LmsEvaluasi::with('materi')->wherein('idmateri', $idmateri)->get();
    $idevaluasi = array();
    foreach ($evaluasi as $e) {
      $idevaluasi[] = $e->id;
    }

    $bulan = LmsSiswaEvaluasi::where('idevaluasi', $idevaluasi)->first();

    $pdf = PDF::loadView('guru.penilaian.cetakevaluasi', compact('ta','kelas','mapel','guru','siswa', 'jadwal', 'evaluasi', 'materi', 'bulan'))->setPaper('A4','landscape');
    return $pdf->stream('Evaluasi - '.$mapel->nama.' ('.$kelas->nama.').pdf');
  }
}