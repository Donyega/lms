<?php

namespace App\Http\Controllers;

use PDF;
use auth;
use Excel;
use Session;
use App\Helper;
use DataTables;
use App\Models\Siswa;
use App\Models\JadwalBap;
use Illuminate\Support\Str;
use App\Models\LmsPenugasan;
use Illuminate\Http\Request;
use App\Models\JadwalPresensi;
use App\Models\JadwalPelajaran;
use App\Models\JadwalPelajaranDetil;

class PembelajaranPresensiController extends Controller
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

  public function index($idjadwal)
  {
    $data = JadwalPelajaran::with(['mapel','kelas','siswa', 'guru', 'hari', 'detil.jampelajaran'])->where('jadwal_pelajarans.id',$idjadwal)->first();
    $siswa = JadwalPelajaran::leftjoin('siswas', 'jadwal_pelajarans.idkelas', 'siswas.idkelas')
    ->leftjoin('jadwal_pelajaran_detils','jadwal_pelajarans.id','idjadwal')
    ->where('idjadwal',$idjadwal)
    ->where('idstatus', 1)
    ->orderby('idjenismapel','desc')
    ->orderby('jadwal_pelajarans.idkelas','asc')
    // ->select('jadwal_pelajarans.*')
    ->get();
    $pertemuanke = JadwalBap::where('idjadwal',$idjadwal)->orderby('pertemuan','asc')->get();
    $presensi = JadwalPresensi::where('idjadwal',$idjadwal)->get();
    return view('guru.pembelajaran.presensi.index',compact('data','siswa','pertemuanke','presensi'));
  }

  public function detail($idjadwal)
  {
    $data = JadwalPelajaran::with(['mapel','kelas','guru'])->where('jadwal_pelajarans.id',$idjadwal)->first();
    $siswa = JadwalPelajaran::leftjoin('siswas', 'jadwal_pelajarans.idkelas', 'siswas.idkelas')
                ->leftjoin('jadwal_pelajaran_detils','jadwal_pelajarans.id','idjadwal')
                ->where('idjadwal',$idjadwal)
                ->where('idstatus', 1)
                ->orderby('idjenismapel','desc')
                ->orderby('jadwal_pelajarans.idkelas','asc')
                // ->select('jadwal_pelajarans.*')
                ->get();
    $pertemuanke = JadwalBap::where('idjadwal',$idjadwal)->orderby('pertemuan','asc')->get();
    $presensi = JadwalPresensi::where('idjadwal',$idjadwal)->get();
    return view('guru.pembelajaran.presensi.detail',compact('data','siswa','pertemuanke','presensi'));
  }

  public function store(Request $request)
  {
    try {
      $i = 0;
      $cek = JadwalPresensi::where('idjadwal',$request->idjadwal)->where('tanggal',$request->tanggal)->where('iduser',auth::user()->id)->count();
      if ($cek > 0) {
        return back()->with('notif', json_encode([
          'title' => "PRESENSI",
          'text' => "Gagal, presensi tanggal ".Helper::tanggal($request->tanggal)." sudah diinput sebelumnya!",
          'type' => "error"
      ]));
      }
      foreach ($request->sws2 as $sws) {
        $variable = 'a'.$i;
        if ($request->jenis == 2) {
          $hadir = null;
        }else {
          $hadir = $request->$variable;
        }
        $keterangan = 'keterangan'.$i;
        JadwalPresensi::create([
          'idjadwal' => $request->idjadwal,
          'iduser' => $request->iduser,
          'nis' => $request->sws[$i],
          'pertemuan' => $request->pertemuan,
          'tanggal' => $request->tanggal,
          'catatan' => $request->$keterangan,
          'hadir' => $hadir
        ]);
        $i++;
      }

      JadwalBap::create([
        'idguru' => $request->idguru,
        'idjadwal'=>$request->idjadwal,
        'pertemuan' => $request->pertemuan,
        'tanggal' => $request->tanggal,
        'materi' => $request->materi,
        'tugas' => $request->tugas,
        'iduser' => $request->iduser
      ]);

      if ($request->jenis == 1) {
        return back()->with('notif', json_encode([
          'title' => "PRESENSI",
          'text' => "Berhasil melakukan input presensi.",
          'type' => "success"
      ]));
      }else {
        return redirect(route('pembelajaran.presensi.barcode',$request->idjadwal));
      }
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PRESENSI",
        'text' => "Gagal melakukan input presensi, ".$e->getMessage(),
        'type' => "error"
      ]));
    }

  }

  public function barcode($idjadwal)
  {
    $idjadwal = $idjadwal;
    return view('guru.pembelajaran.presensi.barcode', compact('idjadwal'));
  }

  public function edit($id)
  {
    $data = JadwalPresensi::with(['siswa'])->where('id',$id)->first();
    return $data;
  }

  public function update(Request $request)
  {
    try {
      JadwalPresensi::where('id',$request->id)->update([
        'hadir' => $request->hadir,
        'catatan' => $request->catatan,
        'iduser' => auth::user()->id
      ]);

      return back()->with('notif', json_encode([
        'title' => "PRESENSI",
        'text' => "Berhasil mengubah presensi.",
        'type' => "success"
    ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PRESENSI",
        'text' => "Gagal mengubah presensi, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function getmateri($idjadwal,$pertemuan)
  {
    $data = JadwalBap::where('idjadwal',$idjadwal)->where('pertemuan',$pertemuan)->first();
    return $data;
  }

  public function updatetgl(Request $request)
  {
    try {
      JadwalPresensi::where('idjadwal',$request->idjadwal)->where('pertemuan',$request->pertemuan)->update([
        'tanggal' => $request->tanggal
      ]);

      JadwalBap::where('idjadwal',$request->idjadwal)->where('pertemuan',$request->pertemuan)->update([
        'materi' => $request->materi,
        'tanggal' => $request->tanggal,
        'tugas' => $request->tugas,
        'iduser' => auth::user()->link
      ]);

      return back()->with('notif', json_encode([
        'title' => "DETAIL PERTEMUAN",
        'text' => "Berhasil menyimpan perubahan detail pertemuan.",
        'type' => "success"
    ]));

    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "DETAIL PERTEMUAN",
        'text' => "Gagal mengubah detail presensi, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function ba(Request $request)
  {
    $data = JadwalPelajaran::with(['mapel','ta','kelas','guru.guru','kelas.siswa'])->where('id',$request->id)->first();
    $ba = JadwalBap::with(['guru'])->where('idjadwal',$request->id)->orderby('pertemuan','asc')->get();
    $barekap = JadwalBap::with(['guru'])->where('idjadwal',$request->id)->selectraw('idguru,count(idguru) as jumlah')->groupby('idguru')->get();
    $jumlahhadir = JadwalPresensi::where('idjadwal',$request->id)->where('hadir',1)->selectraw('idjadwal, pertemuan, count(hadir) as jumlah')->groupby('pertemuan')->get();
    $pdf=PDF::loadView('guru.pembelajaran.presensi.ba', compact('data','ba','barekap','jumlahhadir'))->setPaper('A4','potrait');
          return $pdf->stream('BA.pdf');
  }

  public function rekap(Request $request)
  {
    $data = JadwalPelajaran::with(['hari','mapel','kelas','jadwalguru.guru','detil'])->where('id',$request->idjadwal)->first();
    $pertemuanke = JadwalPresensi::where('idjadwal',$request->idjadwal)->orderby('pertemuan','asc')->groupby('pertemuan')->get();
    $presensi = JadwalPresensi::where('idjadwal',$request->idjadwal)->get();
    $siswa = Siswa::where('idkelas', 15)->where('idstatus',1)->orderby('nama','asc')->get();

    $pdf = PDF::loadView('guru.pembelajaran.presensi.rekap', compact('data','pertemuanke','presensi','siswa'))->setPaper('A4','landscape');
          return $pdf->stream('Rekap Absen.pdf');
  }

}
