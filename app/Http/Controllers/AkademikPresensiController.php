<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Siswa;
use App\Models\JadwalPelajaran;
use App\Models\JadwalPelajaranAgama;
use App\Models\JadwalPresensi;
use App\Models\JadwalBap;
use App\Models\MdKelas;
use App\Models\MapingMapel;
use App\Helper;
use DB;
use PDF;
use auth;
use DataTables;
use DateTime;
use Session;
class AkademikPresensiController extends Controller
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
    $idta = Helper::idta();
    $jadwal = JadwalPelajaran::with(['hari','detil.jampelajaran','mapel','kelas.jenis','jadwalguru.guru'])->where('idta',$idta)->get();
    $jadwalagama = JadwalPelajaranAgama::with(['hari','detil.jampelajaran','mapel','tingkatkelas','jadwalguru.guru','agama'])->where('idta',$idta)->get();
    return view('akademik.presensi.index', compact('jadwal','jadwalagama'));
  }

  public function dt($idhari)
  {
    $idta = Helper::idta();
    $data = JadwalPelajaran::with(['hari','detil.jampelajaran','mapel','kelas.jenis','jadwalguru.guru'])
          ->when(!empty($idhari), function ($query) use ($idhari) {
            return $query->where('idhari',$idhari);
          })
          ->where('idta',$idta)
          ->get();
    return DataTables::of($data)
    ->addColumn('kelas', function($data) {
      return $data->kelas->nama.' '.$data->kelas->jenis->nama;
    })
    ->addColumn('namaguru', function($data) {
      $namaguru = '';
      foreach ($data->jadwalguru as $d) {
        $namaguru .= $d->guru->nama.'-';
      }
      return $namaguru;
    })
    ->addColumn('action', function($data) {
      return '
      <a href='.route("presensi.detail", $data->id).' class="btn btn-outline-info btn-sm waves-effect waves-float waves-light"style="white-space:nowrap"><i data-feather="check-square"></i> Presensi</a>
      ';
    })
    ->make(true);
  }

  public function detail($id)
  {
    $data = JadwalPelajaran::with(['hari','detil.jampelajaran','mapel','jenismapel','kelas.jenis','jadwalguru.guru','ta'])->where('id',$id)->first();
    $idagama = null;
    if ($data->mapel->agama == 1) {
      $idagama = 4;
    }
    $siswa = Siswa::where('idkelas',$data->idkelas)->where('idstatus',1)
            ->when(!empty($idagama), function ($query) use ($idagama) {
                return $query->where('idagama',$idagama);
            })->orderby('nama','asc')->get();

    if (empty($data)) {
      return back()->with('notif', json_encode([
        'title' => "PRESENSI",
        'text' => "Data jadwal pelajaran tidak ditemukan",
        'type' => "error"
      ]));
    }

    $pertemuanke = JadwalPresensi::where('idjadwal',$id)->where('isagama',0)->orderby('pertemuan','asc')->groupby('pertemuan')->get();
    $presensi = JadwalPresensi::where('idjadwal',$id)->where('isagama',0)->get();
    $jumlahhadir = JadwalPresensi::where('idjadwal',$id)->where('isagama',0)->where('hadir',1)->groupby('nis')->get();
    return view('akademik.presensi.detail', compact('data','pertemuanke','presensi','jumlahhadir','siswa'));
  }

  public function detailagama($id)
  {
    $data = JadwalPelajaranAgama::with(['hari','detil.jampelajaran','mapel','jenismapel','tingkatkelas','jadwalguru.guru','ta','agama'])->where('id',$id)->first();
    $idkelas = MdKelas::where('isaktif',1)->where('idtingkat',$data->idtingkatkelas)->select('id');
    $siswa = Siswa::with('kelas')->wherein('idkelas',$idkelas)->where('idstatus',1)->where('idagama',$data->idagama)->orderby('nama','asc')->get();

    if (empty($data)) {
      return back()->with('notif', json_encode([
        'title' => "PRESENSI",
        'text' => "Data jadwal pelajaran tidak ditemukan",
        'type' => "error"
      ]));
    }

    $pertemuanke = JadwalPresensi::where('idjadwal',$id)->where('isagama',1)->orderby('pertemuan','asc')->groupby('pertemuan')->get();
    $presensi = JadwalPresensi::where('idjadwal',$id)->where('isagama',1)->get();
    $jumlahhadir = JadwalPresensi::where('idjadwal',$id)->where('isagama',1)->where('hadir',1)->groupby('nis')->get();
    return view('akademik.presensi.detailagama', compact('data','pertemuanke','presensi','jumlahhadir','siswa'));
  }

  public function detailpresensi($id,$isagama)
  {
    $isagama = $isagama;
    if ($isagama == 0) {
      $data = JadwalPelajaran::with(['hari','mapel','jenismapel','kelas.jenis','jadwalguru.guru','ta'])->where('id',$id)->first();
      $idagama = null;
      if ($data->mapel->agama == 1) {
        $idagama = 4;
      }
      $siswa = Siswa::where('idkelas',$data->idkelas)->where('idstatus',1)
              ->when(!empty($idagama), function ($query) use ($idagama) {
                  return $query->where('idagama',$idagama);
              })->orderby('nama','asc')->get();
    }elseif ($isagama == 1) {
      $data = JadwalPelajaranAgama::with(['hari','detil.jampelajaran','mapel','jenismapel','tingkatkelas','jadwalguru.guru','ta','agama'])->where('id',$id)->first();
      $idkelas = MdKelas::where('isaktif',1)->where('idtingkat',$data->idtingkatkelas)->select('id');
      $siswa = Siswa::with('kelas')->wherein('idkelas',$idkelas)->where('idstatus',1)->where('idagama',$data->idagama)->orderby('nama','asc')->get();
    }
    $pertemuanke = JadwalPresensi::where('idjadwal',$id)->where('isagama',$isagama)->orderby('pertemuan','asc')->groupby('pertemuan')->get();
    $presensi = JadwalPresensi::where('idjadwal',$id)->where('isagama',$isagama)->get();
    $jumlahhadir = JadwalPresensi::where('idjadwal',$id)->where('isagama',$isagama)->where('hadir',1)->groupby('nis')->get();
    return view('akademik.presensi.detailpresensi', compact('data','pertemuanke','presensi','jumlahhadir','siswa','isagama'));
  }

  public function store(Request $request)
  {
    try {
      //dd($request->all());
      $i = 0;
      $tanggal = Helper::tanggal($request->tanggal);
      if ($request->tanggal > date('Y-m-d')) {
        return back()->with('notif', json_encode([
          'title' => "PRESENSI",
          'text' => "Gagal menyimpan presensi, tanggal $tanggal mendahului hari ini.",
          'type' => "error"
        ]));
      }
      
      $cek = JadwalPresensi::where('idjadwal',$request->idjadwal)->where('tanggal',$request->tanggal)->count();
      if ($cek > 0) {
        return back()->with('notif', json_encode([
          'title' => "PRESENSI",
          'text' => "Gagal, presensi tanggal $tanggal sudah diisi!",
          'type' => "error"
        ]));
      }

      $cekhari = date('w', strtotime($request->tanggal));
      if ($cekhari == 0) {
        return back()->with('notif', json_encode([
          'title' => "PRESENSI",
          'text' => "Gagal menyimpan presensi, tanggal $tanggal adalah hari minggu. Proses belajar mengajar tidak dapat dilakukan pada hari minggu.",
          'type' => "error"
        ]));
      }

      foreach ($request->siswa2 as $s) {
        $variable = 'a'.$i;
        $keterangan = 'keterangan'.$i;
        $hadir = $request->$variable;
        $catatan = $request->$keterangan;
        if ($hadir == null) {
          $hadir = null;
        }else {
          $hadir = 1;
        }

        if ($catatan == 'Dispensasi') {
          $hadir = 1;
        }

        JadwalPresensi::create([
          'idjadwal' => $request->idjadwal,
          'isagama' => $request->isagama,
          'nis' => $request->siswa[$i],
          'pertemuan' => $request->pertemuan,
          'tanggal' => $request->tanggal,
          'catatan' => $catatan,
          'hadir' => $hadir,
          'idguru' => $request->idguru,
          'iduser' => auth::user()->id,
        ]);
        $i++;
      }

      JadwalBap::create([
        'idguru' => $request->idguru,
        'idjadwal' => $request->idjadwal,
        'isagama' => $request->isagama,
        'pertemuan' => $request->pertemuan,
        'tanggal' => $request->tanggal,
        'materi' => $request->materi,
        'tugas' => $request->tugas,
        'iduser' => auth::user()->id,
      ]);

      return back()->with('notif', json_encode([
        'title' => "PRESENSI",
        'text' => "Berhasil melakukan pengisian presensi pertemuan ke-$request->pertemuan tanggal $tanggal.",
        'type' => "success"
    ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PRESENSI",
        'text' => "Gagal melakukan pengisian presensi, ".$e->getMessage(),
        'type' => "error"
      ]));
    }

  }

  public function edit($id,$isagama)
  {
    $data = JadwalPresensi::with('siswa')->where('id',$id)->where('isagama',$isagama)->first();
    return $data;
  }

  public function getmateri($idjadwal,$isagama,$pertemuan)
  {
    $data = JadwalBap::where('idjadwal',$idjadwal)->where('isagama',$isagama)->where('pertemuan',$pertemuan)->first();
    return $data;
  }

  public function update(Request $request)
  {
    try {
      //dd($request->all());
      $data = JadwalPresensi::with('siswa')->where('id',$request->id)->first();
      $namasiswa = $data->siswa->nama;
      $tanggal = Helper::tanggal($data->tanggal);
      $hadir = $request->hadir;
      if ($request->catatan == 'Dispensasi') {
        $hadir = 1;
      }
      JadwalPresensi::where('id',$request->id)->update([
        'hadir' => $hadir,
        'catatan' => $request->catatan,
        'iduser' => auth::user()->id
      ]);

      return back()->with('notif', json_encode([
        'title' => "PRESENSI",
        'text' => "Berhasil mengubah presensi siswa a/n $namasiswa pada pertemuan ke-$data->pertemuan tanggal $tanggal.",
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

  public function updatetgl(Request $request)
  {
    try {
      $isagama = $request->isagama;
      $cek = JadwalPresensi::where('idjadwal',$request->idjadwal)->where('isagama',$isagama)->where('tanggal',$request->tanggal)->where('pertemuan','!=',$request->pertemuan)->count();
      if ($cek > 0) {
        return back()->with('notif', json_encode([
          'title' => "PRESENSI",
          'text' => "Gagal, presensi tanggal ".Helper::tanggal($request->tanggal)." sudah diinput sebelumnya!",
          'type' => "error"
        ]));
      }

      JadwalPresensi::where('idjadwal',$request->idjadwal)->where('isagama',$isagama)->where('pertemuan',$request->pertemuan)->update([
        'tanggal' => $request->tanggal
      ]);

      JadwalBap::where('idjadwal',$request->idjadwal)->where('isagama',$isagama)->where('pertemuan',$request->pertemuan)->update([
        'materi' => $request->materi,
        'tanggal' => $request->tanggal,
        'tugas' => $request->tugas,
        'iduser' => auth::user()->link
      ]);

      return back()->with('notif', json_encode([
        'title' => "PRESENSI",
        'text' => "Berhasil melakukan perubahan detail pertemuan.",
        'type' => "success"
    ]));

    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PRESENSI",
        'text' => "Gagal mengubah detail pertemuan, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function ba(Request $request)
  {
    $isagama = $request->isagama;
    if ($isagama == 0) {
      $data = JadwalPelajaran::with(['hari','mapel','kelas','jadwalguru.guru','detil','ta'])->where('id',$request->idjadwal)->first();
      $idagama = null;
      if ($data->mapel->agama == 1) {
        $idagama = 4;
      }
      $siswa = Siswa::where('idkelas',$data->idkelas)->where('idstatus',1)
              ->when(!empty($idagama), function ($query) use ($idagama) {
                  return $query->where('idagama',$idagama);
              })->orderby('nama','asc')->get();
      $namakelas = $data->kelas->nama.' '.$data->kelas->jenis->nama;
    }elseif ($isagama == 1) {
      $data = JadwalPelajaranAgama::with(['hari','detil.jampelajaran','mapel','tingkatkelas','jadwalguru.guru','ta','agama'])->where('id',$request->idjadwal)->first();
      $idkelas = MdKelas::where('isaktif',1)->where('idtingkat',$data->idtingkatkelas)->select('id');
      $siswa = Siswa::with('kelas')->wherein('idkelas',$idkelas)->where('idstatus',1)->where('idagama',$data->idagama)->orderby('nama','asc')->get();
      $namakelas = 'Agama '.$data->agama->nama.' Kelas '.$data->tingkatkelas->nama;
    }
    $ba = JadwalBap::with(['guru'])->where('idjadwal',$request->idjadwal)->where('isagama',$isagama)->orderby('pertemuan','asc')->get();
    $jumlahhadir = JadwalPresensi::where('idjadwal',$request->idjadwal)->where('isagama',$isagama)->where('hadir',1)->selectraw('idjadwal, pertemuan, count(hadir) as jumlah')->groupby('pertemuan')->get();
    $pdf = PDF::loadView('akademik.presensi.ba', compact('data','ba','siswa','jumlahhadir','namakelas','isagama'))->setPaper('A4','potrait');
    return $pdf->stream('BAP - '.$data->mapel->nama.' ('.$namakelas.').pdf');
  }

  public function rekap(Request $request)
  {
    $data = JadwalPelajaran::with(['hari','mapel','kelas','jadwalguru.guru','detil'])->where('id',$request->idjadwal)->first();
    $pertemuanke = JadwalPresensi::where('idjadwal',$request->idjadwal)->orderby('pertemuan','asc')->groupby('pertemuan')->get();
    $presensi = JadwalPresensi::where('idjadwal',$request->idjadwal)->get();
    $siswa = Siswa::where('idkelas', $data->idkelas)->where('idstatus',1)->orderby('nama','asc')->get();

    $pdf = PDF::loadView('akademik.presensi.rekap', compact('data','pertemuanke','presensi','siswa'))->setPaper('A4','landscape');
    return $pdf->stream('Rekapitulasi Presensi - '.$data->mapel->nama.' ('.$data->kelas->nama.' '.$data->kelas->jenis->nama.').pdf');
  }

  public function cetak(Request $request)
  {
    $ta = Helper::ta();
    $tgl = Helper::haritanggal($request->tgl);
    $kelas = MdKelas::with(['jenis','minat','wali'])->where('id',$request->idkelas)->first();
    $data = Siswa::where('idstatus',1)->where('idkelas',$request->idkelas)->orderby('nama','asc')->get();
    $pdf = PDF::loadView('akademik.presensi.cetak', compact('data','kelas','ta','tgl'))->setPaper('A4','potrait');
    return $pdf->stream('Presensi - '.$kelas->nama.' '.$kelas->jenis->nama.'.pdf');
  }

}
