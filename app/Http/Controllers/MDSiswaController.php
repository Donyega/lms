<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\excelexport\excelsiswa;
use App\Models\Siswa;
use App\Models\SiswaDetil;
use App\Models\SiswaJenis;
use App\Models\SiswaKelas;
use App\Models\SiswaStatus;
use App\Models\JadwalPelajaran;
use App\Models\MdJenisDaftar;
use App\Models\MdKecamatan;
use App\Models\MdPendidikan;
use App\Models\MdSekolah;
use App\Models\MdAgama;
use App\Models\MdKelas;
use App\Models\MdKelasTingkat;
use App\Models\MdTransportasi;
use PDF;
use DataTables;
use Excel;
class MDSiswaController extends Controller
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
    $data = Siswa::with('jenis')->where('idstatus',1)->selectraw('idjenis, count(idjenis) as jumlah')->groupby('idjenis')->get();
    $jenisdaftar = MdJenisDaftar::get();
    return view('masterdata.siswa.index', compact('data','jenisdaftar'));
  }

  public function dt($idkelas,$idjenis) {
    $data = Siswa::with(['agama','kelas.jenis','jenis'])->where('idstatus',1)
            ->when(!empty($idkelas), function ($query) use ($idkelas) {
                return $query->where('idkelas',$idkelas);
            })
            ->when(!empty($idjenis), function ($query) use ($idjenis) {
                return $query->where('idjenis',$idjenis);
            })->get();
    return DataTables::of($data)
    ->addColumn('kelas', function($data) {
      return $data->kelas->nama.' '.$data->kelas->jenis->nama;
    })
    ->addColumn('action', function($data) {
      return  '
      <a href='.route("md.siswa.detail", $data->id).' class="btn btn-outline-info btn-sm waves-effect waves-float waves-light"><i data-feather="user"></i> Detail</a>
      ';
    })
    ->make(true);
  }

  public function detail($id)
  {
    $data = Siswa::with(['status','detil','kecamatan.kabupaten','jenis','user'])->where('id',$id)->first();
    $sekolah = MdSekolah::get();
    $jenisdaftar = MdJenisDaftar::get();
    $pendidikan = MdPendidikan::get();
    $kecamatan = MdKecamatan::with('kabupaten.provinsi')->get();
    $riwayatakademik = SiswaStatus::with(['ta','status'])->where('nis',$data->nis)
                      ->orderby('idta','desc')->get();
    $riwayatkelas = SiswaKelas::with(['kelas','riwayatwali'])->where('nis',$data->nis)->get();
    $jadwal = JadwalPelajaran::where('idkelas',$data->idkelas)
            ->selectraw('idta, count(id) as jumlah')
            ->groupby('idta')->get();
    return view('masterdata.siswa.detail', compact('data','sekolah','kecamatan','jenisdaftar','pendidikan','riwayatakademik','riwayatkelas','jadwal'));
  }

  public function store(Request $request)
  {
    try {
      $nis = $request->nis;
      $photo = null;
      $idjenis = $request->idjenis;

      $cek = Siswa::where('nis',$nis)->first();
      if ($cek != null && $cek->nis == $nis) {
        return back()->with('notif', json_encode([
          'title' => "DATA SISWA",
          'text' => "Gagal menambah siswa, NIS $nis sudah terdaftar a/n ".$cek->nama.".",
          'type' => "warning"
        ]));
      }

      if ($request->file('photos') != null) {
          $photo = $request->file('photos')->store('siswa/'.$nis.'/photo');
      }
      if ($request->idasalsekolah == 14308) {
          $idjenis = 3;
      }

      $siswa = Siswa::create([
        'nis' => $nis,
        'nisn' => $request->nisn,
        'nama' => $request->nama,
        'jk' => $request->jk,
        'iddaftar' => $request->iddaftar,
        'idjenis' => $idjenis,
        'tplahir' => $request->tplahir,
        'tglahir' => $request->tglahir,
        'idagama' => $request->idagama,
        'nohp' => $request->nohp,
        'alamat' => $request->alamat,
        'idkec' => $request->idkec,
      ]);
      
      SiswaDetil::create([
        'nis' => $nis,
        'email' => $request->email,
        'thnmasuk' => $request->thnmasuk,
        'photo' => $photo,
      ]);

      return redirect('masterdata/siswa/detail/'.$siswa->id)->with('notif', json_encode([
        'title' => "DATA SISWA",
        'text' => "Berhasil menambah siswa.",
        'type' => "success"
    ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "DATA SISWA",
        'text' => "Gagal menambah siswa, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function update(Request $request)
  {
    try {
      $detil = SiswaDetil::where('nis',$request->nis)->first();
      if ($request->idkec == null) {
        $idkec = null;
      }else {
        $idkec = $request->idkec;
      }
      Siswa::where('id',$request->id)->update([
        'nis' => $request->nis,
        'nisn' => $request->nisn,
        'nama' => $request->nama,
        'jk' => $request->jk,
        'iddaftar' => $request->iddaftar,
        'tplahir' => $request->tplahir,
        'tglahir' => $request->tglahir,
        'idagama' => $request->idagama,
        'nohp' => $request->nohp,
        'alamat' => $request->alamat,
        'idkec' => $idkec,
      ]);

      $photo = $detil->photo;

      if ($request->file('photos') != null) {
          $photo = $request->file('photos')->store('siswa/'.$request->nis.'/photo');
      }
      
      SiswaDetil::where('nis',$request->nis)->update([
        'thnmasuk' => $request->thnmasuk,
        'email' => $request->email,
        'photo' => $photo,
      ]);

      return back()->with('notif', json_encode([
        'title' => "DATA SISWA",
        'text' => "Berhasil mengubah biodata siswa.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "DATA SISWA",
        'text' => "Gagal mengubah biodata siswa, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function kartupelajar($id = null)
  {
    $data = Siswa::with(['kelas'])->where('id',$id)->first();
    $customPaper = array(0,0,226.7716535433071,141.7322834645669);
    $pdf=PDF::loadView('masterdata.siswa.kartupelajar', compact('data'))->setPaper($customPaper);
    return $pdf->stream('Kartu Pelajar - '.$data->nama.'.pdf');
  }

  public function exportexcel(Request $request)
  {
    if ($request->idtingkat == null && $request->idkelas == null) {
      $data = Siswa::with(['status','detil','kecamatan.kabupaten','jenis'])->where('idstatus',1)->orderby('nis','asc')->get();
      $namakelas = 'Semua Siswa';
    }elseif ($request->idtingkat != null && $request->idkelas == null) {
      $tingkat = MdKelasTingkat::where('id',$request->idtingkat)->first();
      $idkelas = MdKelas::where('idtingkat',$request->idtingkat)->select('id');
      $data = Siswa::with(['status','detil','kecamatan.kabupaten','jenis'])->where('idstatus',1)->wherein('idkelas',$idkelas)->orderby('nis','asc')->get();
      $namakelas = 'Siswa Tingkat '.$tingkat->nama;
    }elseif ($request->idtingkat != null && $request->idkelas != null) {
      $kelas = MdKelas::with('jenis')->where('id',$request->idkelas)->first();
      $data = Siswa::with(['status','detil','kecamatan.kabupaten','jenis'])->where('idstatus',1)->where('idkelas',$request->idkelas)->orderby('nis','asc')->get();
      $namakelas = 'Siswa Kelas '.$kelas->nama.' '.$kelas->jenis->nama;
    }
    return Excel::download(new excelsiswa($data), 'Data '.$namakelas.'.xlsx');
    return view('masterdata.siswa.excel', compact('data'));
  }

}
