<?php

namespace App\Http\Controllers;

use View;
use Excel;
use App\Helper;
use App\Models\Siswa;
use App\Models\LmsTopik;
use App\Models\LmsMateri;
use App\Models\LmsEvaluasi;
use Illuminate\Http\Request;
use App\excelimport\unggahrps;
use App\Models\LmsMateriDetil;
use App\Models\JadwalPelajaran;
use App\Models\LmsEvaluasiSoal;
use App\Models\LmsMateriKontrak;
use App\Models\MdLmsJenispertemuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\excelexport\excelunduhtemplaterps;
use App\Models\JadwalPelajaranDetil;

class PembelajaranController extends Controller
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

  public function index($idjadwal,$i)
  {
    // cek session pada menu tab
    if (Session::get('idjadwal') != $idjadwal) {
      Session::put('tabpengajaran', null);
    }
    Session::put('idjadwal', $idjadwal);

    $idta = Helper::idta();
    $img = $i;
    
    // select semua data berdasarkan jadwal
    $data = JadwalPelajaran::with(['mapel','kelas','guru','materilms','penugasanlms.rubrik','topiklms'])->where('id',$idjadwal)->first();
    
    // hitung jumlah pertemuan berdasarkan jadwal
    $pertemuan = LmsMateri::where('idjadwal',$idjadwal)->count();

    // select semua siswa berdasarkan kelas pada data jadwal
    $siswa = Siswa::with('detil')->where('idstatus',3)->where('idkelas',$data->idkelas)
          ->orderby('siswas.nis','asc')->get();

    Session::put('jumlahsws',count($siswa));

    // select semua data materi, dokumen, video dan soal berdasarkan mapel dan jadwal
    $materi = LmsMateri::with('jenis','evaluasi')->where('idjadwal',$idjadwal)->get();
    $dokrps = JadwalPelajaran::where('idkurikulum',$data->idkurikulum)
          ->where('idmapel',$data->idmapel)->pluck('dokrps')->first();
    $video = LmsMateriKontrak::where('idjadwal',$data->id)->get();
    $soal = LmsEvaluasiSoal::where('idmapel',$data->idmapel)->where('idguru',auth::user()->link)->get();

    $jadwalsalin = JadwalPelajaran::with(['mapel','kelas'])
          ->where('idta',$idta)
          ->where('jadwal_pelajarans.id','!=',$data->id)
          ->where('idmapel',$data->idmapel)
          ->leftjoin('jadwal_pelajaran_gurus','jadwal_pelajarans.id','idjadwal')
          ->where('jadwal_pelajaran_gurus.idguru', Auth::user()->link)
          ->wherehas('materilms')
          ->select('jadwal_pelajarans.*')
          ->get();
    Session::put('idjadwalglobal',$idjadwal);
    Session::put('idgambarglobal',$i);
    return view('guru.pembelajaran.index', compact('data','pertemuan','siswa', 'img', 'materi','dokrps','video','soal','jadwalsalin'));
  }

  public function storevideo(Request $request)
  {
    try {
      $file = null;
      if ($request->file('videos') != null) {
        $file = $request->file('videos')->storeAs('videoperkenalan/'.$request->idmapel.'/'.$request->idguru,
                $request->file('videos')->getClientOriginalName()
        );
      }
      LmsMateriKontrak::create([
        'idjadwal' => $request->idjadwal,
        'idmapel' => $request->idmapel,
        'idguru' => $request->idguru,
        'jenis' => 3,
        'nama' => 'Video Perkenalan',
        'file' => $file
      ]);
      Session::put('tabpengajaran', 1);
      return back()->with('notif', json_encode([
        'title' => "VIDEO PERKENALAN",
        'text' => "Berhasil mengunggah video perkenalan.",
        'type' => "success"
    ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "VIDEO PERKENALAN",
        'text' => "Gagal mengunggah video perkenalan, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function updatevideo(Request $request)
  {
    try {
      $data = LmsMateriKontrak::where('id',$request->idvideo)->first();
      $file = $data->file;
      if ($request->file('videos') != null) {
        $file = $request->file('videos')->storeAs('videoperkenalan/'.$request->idmapel.'/'.$request->idguru,
                $request->file('videos')->getClientOriginalName()
        );
      }
      LmsMateriKontrak::where('id',$request->idvideo)->update([
        'file' => $file
      ]);
      Session::put('tabpengajaran', 1);
      return back()->with('notif', json_encode([
        'title' => "VIDEO PERKENALAN",
        'text' => "Berhasil mengubah video perkenalan.",
        'type' => "success"
    ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "VIDEO PERKENALAN",
        'text' => "Gagal mengubah video perkenalan, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function deletevideo(Request $request)
  {
    try {
      LmsMateriKontrak::where('id',$request->idvideo)->delete();
      Session::put('tabpengajaran', 1);
      return back()->with('notif', json_encode([
        'title' => "HAPUS DOKUMEN",
        'text' => "Berhasil menghapus dokumen kontrak perkuliahan.",
        'type' => "success"
    ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "HAPUS DOKUMEN",
        'text' => "Gagal menghapus dokumen kontrak perkuliahan, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function storekontrak(Request $request)
  {
    try {
      if ($request->idjenis == 1) {
        if ($request->file('dokumen') != null) {
          $file = $request->file('dokumen')->storeAs('kontrakperkuliahan/'.$request->idmapel.'/'.$request->idguru,
                  $request->file('dokumen')->getClientOriginalName()
          );
        }
      }else {
        $file = $request->dokumen;
      }
      LmsMateriKontrak::create([
        'idjadwal' => $request->idjadwal,
        'idmapel' => $request->idmapel,
        'idguru' => $request->idguru,
        'jenis' => $request->idjenis,
        'nama' => $request->namadokumen,
        'file' => $file
      ]);
      Session::put('tabpengajaran', 1);
      return back()->with('notif', json_encode([
        'title' => "DOKUMEN KONTRAK",
        'text' => "Berhasil menambah dokumen $request->namadokumen.",
        'type' => "success"
    ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "DOKUMEN KONTRAK",
        'text' => "Gagal menambah dokumen, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function unduhtemplate(Request $request)
  {
    $data = JadwalPelajaran::with(['mapel','kelas','guru.guru','materilms','penugasanlms'])->where('id',$request->idjadwal)->first();
    $pertemuan = MdLmsJenispertemuan::all();
    $rps = LmsMateri::where('idjadwal',$request->idjadwal)->get();
    return Excel::download(new excelunduhtemplaterps($data,$pertemuan,$rps), 'Template RPS.xlsx');
  }

  public function unggahtemplate(Request $request)
  {
    Session::put('tabpengajaran', 1);
    $file = $request->file('dokrps');
    $nama_file = rand().$file->getClientOriginalName();
    $lokasi = $request->file('dokrps')->store('rps/import');
    Excel::import(new unggahrps($request->idjadwal), public_path('/../../'.$lokasi));
    return back()->with('notif', json_encode([
      'title' => "EVALUASI",
      'text' => "Berhasil unggah dokumen",
      'type' => "success"
    ]));
  }

  public function storemateri(Request $request)
  {
    try {
      $pertemuan = LmsMateri::where('idjadwal',$request->idjadwal)->count();
      $pertemuan = $pertemuan + 1;
      LmsMateri::create([
        'idjadwal' => $request->idjadwal,
        'idjenis' => $request->idjenis,
        'pertemuan' => $pertemuan,
        'materi' => $request->namamateri,
        'capaian' => $request->capaian,
        'iduser' => auth::user()->id
      ]);

      Session::put('tabpengajaran', 1);
      return back()->with('notif', json_encode([
        'title' => "MATERI PEMBELAJARAN",
        'text' => "Berhasil menambahkan materi di pertemuan ke-$pertemuan - $request->namamateri.",
        'type' => "success"
    ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "MATERI PEMBELAJARAN",
        'text' => "Gagal menambahkan materi, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function getmateri($id)
  {
    $data = LmsMateri::with('jenis')->where('id',$id)->first();
    return $data;
  }

  public function updatemateri(Request $request)
  {
    try {
      LmsMateri::where('id',$request->idmateri)->update([
        'idjenis' => $request->idjenis,
        'materi' => $request->namamateri,
        'capaian' => $request->capaian,
        'iduser' => auth::user()->id
      ]);
      Session::put('tabpengajaran', 1);
      return back()->with('notif', json_encode([
        'title' => "MATERI PEMBELAJARAN",
        'text' => "Berhasil memperbarui materi di pertemuan $request->pertemuan - $request->namamateri.",
        'type' => "success"
    ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "MATERI PEMBELAJARAN",
        'text' => "Gagal memperbarui materi, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function publishmateri(Request $request)
  {
    try {
      // dd($request->all());
      $data = LmsMateri::where('id',$request->idmateri)->first();
      $tglpublish = $request->tglpublish;
      $status = 'Publish';
      if ($request->statuspublish == 0) {
        $tglpublish = null;
        $status = 'Draft';
      }
      LmsMateri::where('id',$request->idmateri)->update([
        'publish' => $request->statuspublish,
        'tglpublish' => $tglpublish
      ]);
      Session::put('tabpengajaran', 1);
      return back()->with('notif', json_encode([
        'title' => "MATERI PEMBELAJARAN",
        'text' => "Berhasil mengubah status materi pertemuan $data->pertemuan - $data->materi menjadi $status.",
        'type' => "success"
    ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "MATERI PEMBELAJARAN",
        'text' => "Gagal mengubah status materi, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function deletemateri(Request $request)
  {
    try {
      $rp = LmsMateri::where('id',$request->idmateri)->first();
      LmsMateri::where('id',$request->idmateri)->delete();
      $data = LmsMateri::where('idjadwal',$request->idjadwal)->orderby('pertemuan')->get();
      $pertemuan = 1;
      foreach ($data as $d) {
        LmsMateri::where('id',$d->id)->update([
          'pertemuan' => $pertemuan
        ]);
        $pertemuan ++;
      }

      $dokumen = LmsMateriDetil::where('idmateri',$request->idmateri)->count();
      if ($dokumen > 0) {
        LmsMateriDetil::where('idmateri',$request->idmateri)->delete();
      }

      $evaluasi = LmsEvaluasi::where('idjadwal',$request->idjadwal)
                ->where('idmateri',$request->idmateri)->count();
      if ($evaluasi > 0) {
        LmsEvaluasi::where('idjadwal',$request->idjadwal)->where('idmateri',$request->idmateri)->delete();
      }

      Session::put('tabpengajaran', 1);
      return back()->with('notif', json_encode([
        'title' => "HAPUS MATERI",
        'text' => "Berhasil menghapus materi $rp->materi dan dokumen terkait.",
        'type' => "success"
    ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "HAPUS MATERI",
        'text' => "Gagal menghapus materi, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function getmaterisalin($idjadwal)
  {
    $data = LmsMateri::with('jenis','detil')->where('idjadwal',$idjadwal)->orderby('pertemuan','asc')->get();
    $table ='<div class="table-responsive"><table class="table table-striped table-bordered mb-0">
      <thead class="text-center">
        <th style="width: 1px">Pertemuan</th>
        <th>Materi</th>
      </thead>
      <tbody>';
    foreach ($data as $d) {
      $table.='
      <tr>
        <td class="text-center">'.$d->pertemuan.'</td>
        <td>
          <span class="d-block mb-25">'.$d->materi.'</span>';
          if ($d->idjenis != 1) {
            $table.='<div class="badge badge-light-danger">'.$d->jenis->alias.'</div> ';
          };
          if (count($d->detil) > 0) {
            $table.='<div class="badge badge-light-primary">'.count($d->detil).' Dokumen</div>';
          };
          $table.='
        </td>
      </tr>
      ';
    }
    $table.='</tbody>
            </table></div>';

    return $table;
  }

  public function storesalinmateri(Request $request)
  {
    try {
      if ($request->idjadwalsalin == null) {
        return back()->with('notif', json_encode([
          'title' => "SALIN MATERI",
          'text' => "Gagal, materi untuk disalin belum dipilih.",
          'type' => "warning"
        ]));
      }

      $notif = JadwalPelajaran::with(['mapel','kelas'])->where('id',$request->idjadwalsalin)->first();

      // hapus materi yang ada
      $data = LmsMateri::where('idjadwal',$request->idjadwal)->get();
      if (count($data) > 0) {
        LmsMateri::where('idjadwal',$request->idjadwal)->delete();
        foreach ($data as $d) {
          LmsMateriDetil::where('idmateri',$d->id)->delete();
        }
      }

      // salin dari kelas dipilih
      $datasalin = LmsMateri::with('detil')->where('idjadwal',$request->idjadwalsalin)->get();
      foreach ($datasalin as $ds) {
        $materi = LmsMateri::create([
          'idjadwal' => $request->idjadwal,
          'idjenis' => $ds->idjenis,
          'pertemuan' => $ds->pertemuan,
          'publish' => $ds->publish,
          'tglpublish' => $ds->tglpublish,
          'materi' => $ds->materi,
          'capaian' => $ds->capaian,
          'iduser' => auth::user()->id
        ]);
        foreach ($ds->detil as $doksalin) {
          LmsMateriDetil::create ([
            'idmateri' => $materi->id,
            'idjenis' => $doksalin->idjenis,
            'nama' => $doksalin->nama,
            'dokumen' => $doksalin->dokumen,
            'iduser' => auth::user()->id
          ]);
        }
      }
      Session::put('tabpengajaran', 1);
      return back()->with('notif', json_encode([
        'title' => "SALIN MATERI",
        'text' => "Berhasil menyalin materi Mata Pelajaran ".$notif->mapel->nama." dari Kelas ".$notif->kelas->nama.".",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "SALIN MATERI",
        'text' => "Gagal menyalin materi, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function storedokumen(Request $request)
  {
    try {
      $materi = LmsMateri::where('id',$request->idmateri)->first();
      if ($request->idjenis == 1) {
        if ($request->file('dokumen') != null) {
          $dokumen = $request->file('dokumen')->store('materi/'.$materi->idjadwal.'/'.$materi->pertemuan);
        }
      }else {
          $dokumen = $request->dokumen;
      }
      LmsMateriDetil::create([
        'idmateri' => $request->idmateri,
        'nama' => $request->namadokumen,
        'dokumen' => $dokumen,
        'idjenis' => $request->idjenis,
        'iduser' => auth::user()->id
      ]);
      Session::put('tabpengajaran', 1);
      return back()->with('notif', json_encode([
        'title' => "DOKUMEN MATERI",
        'text' => "Berhasil menambah dokumen $request->namadokumen di pertemuan $materi->pertemuan $materi->materi.",
        'type' => "success"
    ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "DOKUMEN MATERI",
        'text' => "Gagal menambah dokumen, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function getdokumen($id)
  {
    $data = LmsMateriDetil::where('id',$id)->first();
    return $data;
  }

  public function updatedokumen(Request $request)
  {
    try {
      $data = LmsMateriDetil::with('materi')->where('id',$request->iddokumen)->first();
      $dokumen = $data->dokumen;
      if ($request->file('dokumen') != null) {
        $dokumen = $request->file('dokumen')->store('materi/'.$data->materi->idjadwal.'/'.$data->materi->pertemuan);
      }
      $namadokumen = $data->nama;
      if ($data->nama != $request->namadokumen) {
        $namadokumen = $request->namadokumen;
      }
      LmsMateriDetil::where('id',$data->id)->update([
        'nama' => $request->namadokumen,
        'dokumen' => $dokumen,
        'iduser' => auth::user()->id
      ]);
      Session::put('tabpengajaran', 1);
      return back()->with('notif', json_encode([
        'title' => "DOKUMEN MATERI",
        'text' => "Berhasil memperbarui dokumen $namadokumen pada materi ".$data->materi->materi.".",
        'type' => "success"
    ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "DOKUMEN MATERI",
        'text' => "Gagal memperbarui dokumen, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function deletedokumen(Request $request)
  {
    try {
      $data = LmsMateriDetil::with('materi')->where('id',$request->iddokumen)->first();
      LmsMateriDetil::where('id',$data->id)->delete();
      Session::put('tabpengajaran', 1);
      return back()->with('notif', json_encode([
        'title' => "DOKUMEN MATERI",
        'text' => "Berhasil menghapus dokumen $data->nama pada materi ".$data->materi->materi.".",
        'type' => "success"
    ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "DOKUMEN MATERI",
        'text' => "Gagal menghapus dokumen, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function getevaluasi($id)
  {
    $data = LmsEvaluasi::with('jenis')->where('idmateri',$id)->first();
    return $data;
  }

  public function setevaluasi(Request $request)
  {
    try {
      //dd($request->all());
      Session::put('tabpengajaran', 4);
      $cek = LmsEvaluasi::where('idmateri',$request->idmateri)->first();
      if ($cek == null) {
        LmsEvaluasi::create($request->all());
      }else {
        LmsEvaluasi::where('idmateri',$request->idmateri)->update($request->except(['idjadwal','idmateri','_token','button']));
      }
      return back()->with('notif', json_encode([
        'title' => "PENGATURAN EVALUASI",
        'text' => "Berhasil memperbarui pengaturan evaluasi.",
        'type' => "success"
    ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PENGATURAN EVALUASI",
        'text' => "Gagal memperbarui pengaturan evaluasi, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function storetopikdiskusi(Request $request)
  {
    try {
      LmsTopik::create($request->all());
      Session::put('tabpengajaran', 2);
      return back()->with('notif', json_encode([
        'title' => "TOPIK DISKUSI",
        'text' => "Berhasil menambah topik diskusi.",
        'type' => "success"
    ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "TOPIK DISKUSI",
        'text' => "Gagal menambahkan topik diskusi, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function gettopikdiskusi($id)
  {
    $data = LmsTopik::where('id',$id)->first();
    return $data;
  }

  public function updatetopikdiskusi(Request $request)
  {
    try {
      LmsTopik::where('id',$request->idtopik)->update($request->except(['idtopik','_token','button']));
      Session::put('tabpengajaran', 2);
      return back()->with('notif', json_encode([
        'title' => "TOPIK DISKUSI",
        'text' => "Berhasil mengubah topik diskusi.",
        'type' => "success"
    ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "TOPIK DISKUSI",
        'text' => "Gagal mengubah topik diskusi, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

}
