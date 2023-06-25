<?php

namespace App\Http\Controllers;

use Session;
use App\Helper;
use DataTables;
use App\Models\Siswa;
use App\Models\MdKelas;
use App\Models\Pegawai;
use App\Models\LmsMateri;
use App\Models\SiswaDetil;
use App\Models\LmsPenugasan;
use App\Models\MdPendidikan;
use App\Models\PegawaiDetil;
use Illuminate\Http\Request;
use App\Models\JadwalPresensi;
use App\Models\JadwalPelajaran;
use App\Models\LmsMateriKontrak;
use App\Models\RiwayatPendidikan;
use App\Models\JadwalPelajaranGuru;
use Illuminate\Support\Facades\Auth;

class DatadiriController extends Controller
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
    public function index()
    {
      $id = Auth::user()->link;

      if (Auth::user()->role == 3) {
        $data = Siswa::with(['detil'])->where('id',$id)->first();
        $kelas = MdKelas::where('id', $data->idkelas)->first();
        $mapel = JadwalPelajaran::with('detil')->where('idta', $kelas->idtaaktif)->where('idkelas', $data->idkelas)->first();
        return view('datadiri.siswa', compact('data', 'mapel'));
      }


      if (Auth::user()->role == 2) {
        $idta = Helper::idta();
        $data = Pegawai::with(['detil'])->where('id',auth::user()->link)->first();
        $jadwal = JadwalPelajaranGuru::where('idguru', Auth::user()->link)
                ->leftjoin('jadwal_pelajarans','jadwal_pelajarans.id','jadwal_pelajaran_gurus.idjadwal')
                ->where('idta',$idta)->get();
        $mapel = JadwalPelajaran::where('idta',$idta)
                ->leftjoin('jadwal_pelajaran_gurus','jadwal_pelajarans.id','jadwal_pelajaran_gurus.idjadwal')
                ->where('idkelas', Auth::user()->link)
                ->groupby('idmapel')->get();
        $idjadwal = array();
        foreach ($jadwal as $j) {
          $idjadwal[] = $j->idjadwal;
        }
        $video = LmsMateriKontrak::wherein('idjadwal',$idjadwal)->where('idguru',Auth::user()->link)
                  ->where('jenis',3)->get();
        $unggahmateri = LmsMateri::wherein('idjadwal',$idjadwal)->where('iduser',Auth::user()->id)
                  ->groupby('idjadwal')->get();
        $penugasan = LmsPenugasan::wherein('idjadwal',$idjadwal)->where('iduser',Auth::user()->id)->get();
        return view('datadiri.guru', compact('data','jadwal','mapel','unggahmateri','video','penugasan'));
      }

      if (auth::user()->role == 1) {
        $data = Pegawai::with(['detil'])->where('id',auth::user()->link)->first();
        $pendidikan = MdPendidikan::where('id','>','2')->get();
        $riwayatpendidikan = RiwayatPendidikan::with('pendidikan')->where('idpegawai',auth::user()->link)->orderby('idpendidikan','desc')->get();
        return view('datadiri.pegawai', compact('data','pendidikan','riwayatpendidikan'));
      }
      
    }

    public function update(Request $request)
    {
      try {
        if ($request->jenis == 1) {
          Pegawai::where('id',$request->idpegawai)->update([
            'nama' => $request->nama,
            'panggilan' => $request->panggilan,
            'jk' => $request->jk,
            'tplahir' => $request->tplahir,
            'tglahir' => $request->tglahir,
            'idagama' => $request->idagama,
            'nuptk' => $request->nuptk,
            'nip' => $request->nip,
            'nohp' => $request->nohp,
            'alamat' => $request->alamat,
            'idkec' => $request->idkec,
            'email' => $request->email,
          ]);
  
          $pegawai = Pegawai::with('detil')->where('id',$request->idpegawai)->first();
          $photo = $pegawai->detil->photo;
  
          if ($request->file('photos') != null) {
              $photo = $request->file('photos')->store('pegawai/'.$pegawai->id.'/photo');
          }
  
          PegawaiDetil::where('idpegawai',$request->idpegawai)->update([
            'nik' => $request->nik,
            'photo' => $photo,
          ]);
  
        }elseif ($request->jenis == 3) {
          $detil = SiswaDetil::where('nis',$request->nis)->first();
          if ($request->idkec == null) {
            $idkec = null;
          }else {
            $idkec = $request->idkec;
          }
          Siswa::where('nis',$request->nis)->update([
            'nisn' => $request->nisn,
            'jk' => $request->jk,
            'tplahir' => $request->tplahir,
            'tglahir' => $request->tglahir,
            'idagama' => $request->idagama,
            'nohp' => $request->nohp,
            'alamat' => $request->alamat,
            'idkec' => $idkec,
          ]);
  
          $aktalahir = $detil->aktalahir;
          $kk = $detil->kk;
  
          SiswaDetil::where('nis',$request->nis)->update([
            'email' => $request->email,
            'nik' => $request->nik,
            'noakta' => $request->noakta,
            'anakke' => $request->anakke,
            'jumlahsaudara' => $request->jumlahsaudara,
            'noijazahsmp' => $request->noijazahsmp,
            'kpos' => $request->kpos,
            'idjenistinggal' => $request->idjenistinggal,
            'idtransportasi' => $request->idtransportasi,
            'idasalsekolah' => $request->idasalsekolah,
            'beratbadan' => $request->beratbadan,
            'tinggibadan' => $request->tinggibadan,
            'lingkarkepala' => $request->lingkarkepala,
            'aktalahir' => $aktalahir,
            'kk' => $kk,
          ]);
        }
  
        return redirect('datadiri')->with('notif', json_encode([
          'title' => "DATA DIRI",
          'text' => "Berhasil mengubah data diri.",
          'type' => "success"
        ]));
      } catch (\Exception $e) {
        return back()->with('notif', json_encode([
          'title' => "DATA DIRI",
          'text' => "Gagal mengubah data diri,".$e->getMessage(),
          'type' => "error"
        ]));
      }
  
    }
  
    public function storependidikan(Request $request)
    {
      try {
        $dokijazah = null;
        $doktranskrip = null;
  
        if ($request->file('ijazah') != null) {
          $dokijazah = $request->file('ijazah')->store('pegawai/'.$request->idpegawai.'/ijazah');
        }
        if ($request->file('transkrip') != null) {
          $doktranskrip = $request->file('transkrip')->store('pegawai/'.$request->idpegawai.'/transkrip');
        }
  
        $cek = Pegawai::where('id',$request->idpegawai)->pluck('idpendidikan')->first();
        if ($cek == null || $cek < $request->idpendidikan) {
          Pegawai::where('id',$request->idpegawai)->update([
            'idpendidikan' => $request->idpendidikan
          ]);
        }
  
        RiwayatPendidikan::create([
          'idpegawai' => $request->idpegawai,
          'idpendidikan' => $request->idpendidikan,
          'namakampus' => $request->namakampus,
          'prodi' => $request->prodi,
          'thnmasuk' => $request->thnmasuk,
          'tgllulus' => $request->tgllulus,
          'dokijazah' => $dokijazah,
          'doktranskrip' => $doktranskrip,
        ]);
        return back()->with('notif', json_encode([
          'title' => "DATA PENDIDIKAN",
          'text' => "Berhasil menambah data pendidikan.",
          'type' => "success"
      ]));
      } catch (\Exception $e) {
        return back()->with('notif', json_encode([
          'title' => "DATA PENDIDIKAN",
          'text' => "Gagal menambah data pendidikan, ".$e->getMessage(),
          'type' => "error"
        ]));
      }
    }
  
    public function getriwayat($id)
    {
      $data = RiwayatPendidikan::where('id',$id)->first();
      return $data;
    }
  
    public function updatependidikan(Request $request)
    {
      try {
        $data = RiwayatPendidikan::where('id',$request->id)->first();
        $dokijazah = $data->dokijazah;
        $doktranskrip = $data->doktranskrip;
  
        if ($request->file('ijazah') != null) {
          $dokijazah = $request->file('ijazah')->store('pegawai/'.$request->idpegawai.'/ijazah');
        }
        if ($request->file('transkrip') != null) {
          $doktranskrip = $request->file('transkrip')->store('pegawai/'.$request->idpegawai.'/transkrip');
        }
  
        $cek = Pegawai::where('id',$request->idpegawai)->pluck('idpendidikan')->first();
        if ($cek == null || $cek < $request->idpendidikan) {
          Pegawai::where('id',$request->idpegawai)->update([
            'idpendidikan' => $request->idpendidikan
          ]);
        }
  
        RiwayatPendidikan::where('id',$request->id)->update([
          'idpendidikan' => $request->idpendidikan,
          'namakampus' => $request->namakampus,
          'prodi' => $request->prodi,
          'thnmasuk' => $request->thnmasuk,
          'tgllulus' => $request->tgllulus,
          'dokijazah' => $dokijazah,
          'doktranskrip' => $doktranskrip,
        ]);
        return back()->with('notif', json_encode([
          'title' => "DATA PENDIDIKAN",
          'text' => "Berhasil mengubah data riwayat pendidikan.",
          'type' => "success"
      ]));
      } catch (\Exception $e) {
        return back()->with('notif', json_encode([
          'title' => "DATA PENDIDIKAN",
          'text' => "Gagal mengubah data riwayat pendidikan, ".$e->getMessage(),
          'type' => "error"
        ]));
      }
    }
}
