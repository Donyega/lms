<?php

namespace App\Http\Controllers;

use auth;
use App\Helper;
use DataTables;
use App\Models\Ta;
use App\Models\User;
use App\Models\Siswa;
use App\Models\MdHari;
use App\Models\MdAgama;
use App\Models\MdBiaya;
use App\Models\MdBulan;
use App\Models\MdKelas;
use App\Models\Pegawai;
use App\Models\MdJabatan;
use App\Models\MdPangkat;
use App\Models\RoleAdmin;
use App\Models\MdProvinsi;
use App\Models\SiswaDetil;
use App\Models\MdKabupaten;
use App\Models\MdKecamatan;
use App\Models\MdKurikulum;
use App\Models\MdPekerjaan;
use App\Models\PpdbSekolah;
use Illuminate\Support\Str;
use App\Models\MdKelasJenis;
use App\Models\MdSiswaJenis;
use Illuminate\Http\Request;
use App\Models\LmsSiswaTugas;
use App\Models\MdPelanggaran;
use App\Models\PegawaiStatus;
use App\Models\PelatihEkskul;
use App\Models\RoleAdminNama;
use App\Models\MdJamPelajaran;
use App\Models\MdKelasTingkat;
use App\Models\RiwayatPejabat;
use App\Models\JadwalPelajaran;
use App\Models\MdBiayaJenisSub;
use App\Models\MdSuratKategori;
use App\Models\PegawaiJenisPtk;
use App\Models\PegawaiPresensi;
use App\Models\MdFrekuensiBayar;
use App\Models\RiwayatPejabatSk;
use App\Models\MdLmsJenisevaluasi;
use App\Models\MdLmsJenispertemuan;
use App\Models\PpdbSekolahProvinsi;
use App\Models\JadwalPelajaranAgama;
use App\Models\JadwalPelajaranDetil;
use App\Models\MdPelanggaranTingkat;

class Select2Controller extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {

  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */

  public function siswaaktif(Request $request)
  {
    $term = trim($request->q);
    $datas = Siswa::where('idstatus',1)->when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%')->orwhere('nis', 'LIKE', '%'. $term .'%');
      })->orderby('nis','asc')->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->nis, 'text' => $data->nis.' - '.$data->nama];
    }
    return response()->json($ta);
  }

  public function agama(Request $request)
  {
    $term = trim($request->q);
    $datas = MdAgama::when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama];
    }
    return response()->json($ta);
  }

  public function jadwalagama(Request $request)
  {
    $term = trim($request->q);
    $idkelas = MdKelas::where('isaktif',1)->where('idtingkat',$request->idtingkat)->select('id');
    $idagama = Siswa::where('idstatus',1)->wherein('idkelas',$idkelas)
          ->where('idagama','!=',4)->select('idagama');
    $datas = MdAgama::when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->wherein('id',$idagama)->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama];
    }
    return response()->json($ta);
  }

  public function hari(Request $request)
  {
    $term = trim($request->q);
    $datas = MdHari::when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama];
    }
    return response()->json($ta);
  }

  public function guru(Request $request)
  {
    $term = trim($request->q);
    $datas = Pegawai::where('jenis',1)->where('idstatus',1)->when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->orderby('nama','asc')->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama];
    }
    return response()->json($ta);
  }

  public function pegawaiaktif(Request $request)
  {
    $term = trim($request->q);
    $jenis = $request->jenis;
    if ($request->jenis == 3) {
      $jenis = null;
    }
    $datas = Pegawai::where('idstatus',1)
            ->when(!empty($jenis), function ($query) use ($jenis) {
              return $query->where('jenis',$jenis);
            })
            ->when(!empty($term), function ($query) use ($term) {
              return $query->where('nama', 'LIKE', '%'. $term .'%');
            })->orderby('nama','asc')->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama];
    }
    return response()->json($ta);
  }

  public function adminpegawai(Request $request)
  {
    $term = trim($request->q);
    $admin = RoleAdmin::wherenotin('iduser',[1,9999])->select('iduser');
    $idadmin = User::where('role',1)->wherein('id',$admin)->select('link');
    $idpejabat = RiwayatPejabat::where('status',1)->select('idpegawai');
    $datas = Pegawai::where('jenis',2)->where('idstatus',1)->when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->wherenotin('id',$idadmin)->wherenotin('id',$idpejabat)->orderby('nama','asc')->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama];
    }
    return response()->json($ta);
  }

  public function roleadmin(Request $request)
  {
    $term = trim($request->q);
    $datas = RoleAdminNama::when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->orderby('name','asc')->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->name];
    }
    return response()->json($ta);
  }

  public function jabatan(Request $request)
  {
    $term = trim($request->q);
    $datas = MdJabatan::when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama.' '.$data->bidang];
    }
    return response()->json($ta);
  }

  public function pejabat(Request $request)
  {
    $term = trim($request->q);
    $idjabatan = $request->idjabatan;
    $idpegawai = RiwayatPejabat::where('idjabatan',$idjabatan)->where('status',1)->pluck('idpegawai')->first();
    $datas = Pegawai::where('idstatus',1)->when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->where('id','!=',$idpegawai)->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama.' '.$data->bidang];
    }
    return response()->json($ta);
  }

  public function kecamatan(Request $request)
  {
    $term = trim($request->q);
    $datas = MdKecamatan::with('kabupaten.provinsi')->where('idkab','<',10)->when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => 'Kecamatan '.$data->nama.', '.$data->kabupaten->nama];
    }
    return response()->json($ta);
  }

  public function pekerjaan(Request $request)
  {
    $term = trim($request->q);
    $datas = MdPekerjaan::when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama];
    }
    return response()->json($ta);
  }

  public function tingkatkelas(Request $request)
  {
    $term = trim($request->q);
    $datas = MdKelasTingkat::when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama];
    }
    return response()->json($ta);
  }

  public function kurikulum(Request $request)
  {
    $term = trim($request->q);
    $datas = MdKurikulum::when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama];
    }
    return response()->json($ta);
  }

  public function kelas(Request $request)
  {
    $term = trim($request->q);
    $idtingkat = $request->idtingkat;
    $datas = MdKelas::with('jenis')->where('isaktif',1)->when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->where('idtingkat',$idtingkat)->orderby('nama','asc')->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama.' '.$data->jenis->nama];
    }
    return response()->json($ta);
  }

  public function semuakelas(Request $request)
  {
    $term = trim($request->q);
    $idkelas = Siswa::where('idstatus',1)->select('idkelas');
    $datas = MdKelas::with('jenis')->where('isaktif',1)
            ->when(!empty($term), function ($query) use ($term) {
                return $query->where('nama', 'LIKE', '%'. $term .'%');
            })->orderby('nama','asc')->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama.' '.$data->jenis->nama];
    }
    $ta[] = ['id' => 0, 'text' => 'Semua Kelas'];
    return response()->json($ta);
  }

  public function jeniskelas(Request $request)
  {
    $term = trim($request->q);
    $datas = MdKelasJenis::when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama];
    }
    return response()->json($ta);
  }

  public function jenissiswa(Request $request)
  {
    $term = trim($request->q);
    $datas = MdSiswaJenis::when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama];
    }
    $ta[] = ['id' => 0, 'text' => 'Semua Jenis Siswa'];
    return response()->json($ta);
  }

  public function jampelajaran($jadwal,$idkelas)
  {
    $idjadwal = JadwalPelajaran::where('idkelas',$idkelas)->where('idhari',$jadwal)->select('id');
    $idjam = JadwalPelajaranDetil::where('isagama',0)->wherein('idjadwal',$idjadwal)->select('idjam');
    $datas = MdJamPelajaran::wherenotin('id',$idjam)->get();

    $jam = '';
    foreach ($datas as $data) {
        $jam.='
        <div class="row mx-0 mb-50 align-items-center">
          <input class="mr-50" value="'.$data->nama.'" name="idjam[]" type="checkbox" style="height:18px; width:18px; left:0;">
          <label style="width: 15px; margin:0;">'.$data->nama.'</label>
          <span class="badge badge-light-secondary" style="width: 100px">'.$data->mulai.' - '.$data->selesai.'</span>
        </div>';
    }
    return $jam;
  }

  public function jampelajaranagama($jadwal,$idtingkat,$idagama)
  {
    $idjadwal = JadwalPelajaranAgama::where('idtingkatkelas',$idtingkat)->where('idagama',$idagama)->where('idhari',$jadwal)->select('id');
    $idjam = JadwalPelajaranDetil::where('isagama',1)->wherein('idjadwal',$idjadwal)->select('idjam');
    $datas = MdJamPelajaran::wherenotin('id',$idjam)->get();

    $jam = '';
    foreach ($datas as $data) {
        $jam.='
        <div class="row m-0 mb-50 align-items-center">
          <div class="custom-control custom-checkbox">
            <input id="a-'.$data->id.'" name="idjam[]" value="'.$data->nama.'" class="custom-control-input" type="checkbox">
            <label style="width: 20px; margin:0;" class="custom-control-label" for="a-'.$data->id.'">'.$data->nama.'</label>
          </div>
          <span class="badge badge-light-secondary" style="width: 100px">'.$data->mulai.' - '.$data->selesai.'</span>
        </div>
        ';
    }
    return $jam;
  }

  public function jenisptk(Request $request)
  {
    $term = trim($request->q);
    $datas = PegawaiJenisPtk::when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama];
    }
    return response()->json($ta);
  }

  public function pangkat(Request $request)
  {
    $term = trim($request->q);
    $datas = MdPangkat::when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->pangkat.' ('.$data->golongan.'/'.$data->ruang.')'];
    }
    return response()->json($ta);
  }

  public function statuskerja(Request $request)
  {
    $term = trim($request->q);
    $datas = PegawaiStatus::when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama];
    }
    return response()->json($ta);
  }

  public function skpejabat(Request $request)
  {
    $term = trim($request->q);
    $datas = RiwayatPejabatSk::when(!empty($term), function ($query) use ($term) {
          return $query->where('nomor', 'LIKE', '%'. $term .'%');
      })->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nomor];
    }
    return response()->json($ta);
  }

  public function tahunajaran(Request $request)
  {
    $term = trim($request->q);
    $datas = Ta::when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->orderby('id','desc')->get();
    $ta  = array();
    $smt = '';
    foreach ($datas as $data) {
        if ($data->semester == 1) {
          $smt = 'Ganjil';
        }else {
          $smt = 'Genap';
        }
        $ta[] = ['id' => $data->id, 'text' => $data->tahun.' '.$smt];
    }
    return response()->json($ta);
  }

  public function tahunlulusan(Request $request)
  {
    $term = trim($request->q);
    $datas = SiswaDetil::where('thnlulus','!=',null)->where('idstatus',3)
            ->leftjoin('siswas','siswas.nis','siswa_detils.nis')
            ->when(!empty($term), function ($query) use ($term) {
                return $query->where('thnlulus', 'LIKE', '%'. $term .'%');
            })->groupby('thnlulus')->orderby('thnlulus','desc')->select('thnlulus')->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->thnlulus, 'text' => 'Lulusan '.$data->thnlulus];
    }
    return response()->json($ta);
  }

  public function bulanspp(Request $request)
  {
    $term = trim($request->q);
    $semester = Ta::where('id',$request->semester)->pluck('semester')->first();
    $datas = MdBulan::when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->where('semester',$semester)->orderby('id','desc')->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama];
    }
    return response()->json($ta);
  }

  public function periodeabsen(Request $request)
  {
    $term = trim($request->q);
    $tanggal = date('Y-m-d');
    $sebelumnya = date('Y-m-d', strtotime('-6 months', strtotime($tanggal)));
    $datas = PegawaiPresensi::where('tanggal','>',$sebelumnya)->orderby('tanggal','desc')
            ->groupby('idbulan')->select('idbulan','tanggal')
            ->when(!empty($term), function ($query) use ($term) {
                return $query->where('nama', 'LIKE', '%'. $term .'%');
            })->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->tanggal, 'text' => Helper::periodeabsen($data->tanggal)];
    }
    return response()->json($ta);
  }

  public function bidangsurat(Request $request)
  {
    $term = trim($request->q);
    $datas = MdJabatan::where('bidang','!=',null)->when(!empty($term), function ($query) use ($term) {
          return $query->where('bidang', 'LIKE', '%'. $term .'%');
      })->orderby('bidang','asc')->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->bidang];
    }
    return response()->json($ta);
  }

  public function provinsi(Request $request)
  {
    $term = trim($request->q);
    $datas = MdProvinsi::when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->orderby('nama','asc')->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama];
    }
    return response()->json($ta);
  }

  public function kabupaten(Request $request)
  {
    $term = trim($request->q);
    $idprov = $request->idprov;
    $datas = MdKabupaten::where('idprov',$idprov)->when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->orderby('nama','asc')->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama];
    }
    return response()->json($ta);
  }

  public function pilihkecamatan(Request $request)
  {
    $term = trim($request->q);
    $idkab = $request->idkab;
    $datas = MdKecamatan::where('idkab',$idkab)->when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->orderby('nama','asc')->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama];
    }
    return response()->json($ta);
  }

  public function jenispertemuan(Request $request)
  {
    $term = trim($request->q);
    $datas = MdLmsJenispertemuan::when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama];
    }
    return response()->json($ta);
  }

  public function siswa(Request $request)
  {
    $term = trim($request->q);
    $idjadwal = $request->idjadwal;
    $nis = LmsSiswaTugas::where('idjadwal',$idjadwal)->select('nis');
    $datas = JadwalPelajaran::leftjoin('jadwal_pelajaran_detils','idjadwal','jadwal_pelajarans.id')->where('idjadwal',$idjadwal)->leftjoin('siswas','siswas.nis','jadwal_pelajarans.nis')->when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->wherenotin('jadwal_pelajarans.nis',$nis)->select('jadwal_pelajarans.nis','nama')->get();

    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->nis, 'text' => $data->nama];
    }
    return response()->json($ta);
  }

  public function jenisevaluasi(Request $request)
  {
    $term = trim($request->q);
    $datas = MdLmsJenisevaluasi::when(!empty($term), function ($query) use ($term) {
          return $query->where('nama', 'LIKE', '%'. $term .'%');
      })->get();
    $ta  = array();
    foreach ($datas as $data) {
        $ta[] = ['id' => $data->id, 'text' => $data->nama];
    }
    return response()->json($ta);
  }

}
