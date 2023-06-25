<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains thakademie "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
  return redirect('home');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('sessiontema/{id}', [App\Http\Controllers\HomeController::class, 'sessiontema'])->name('sessiontema');
Route::get('dashboard/jmlsiswa', [App\Http\Controllers\HomeController::class, 'jmlsiswa'])->name('dashboard.jmlsiswa');

Route::prefix('select2')->group(function () {
  Route::get('jenisevaluasi', [App\Http\Controllers\Select2Controller::class, 'jenisevaluasi'])->name('s2.jenisevaluasi');
  Route::get('jenispertemuan', [App\Http\Controllers\Select2Controller::class, 'jenispertemuan'])->name('s2.jenispertemuan');
  Route::get('siswa', [App\Http\Controllers\Select2Controller::class, 'siswa'])->name('s2.siswa');
  Route::get('agama', [App\Http\Controllers\Select2Controller::class, 'agama'])->name('s2.agama');
  Route::get('jadwalagama', [App\Http\Controllers\Select2Controller::class, 'jadwalagama'])->name('s2.jadwalagama');
  Route::get('hari', [App\Http\Controllers\Select2Controller::class, 'hari'])->name('s2.hari');
  Route::get('guru', [App\Http\Controllers\Select2Controller::class, 'guru'])->name('s2.guru');
  Route::get('pegawaiaktif', [App\Http\Controllers\Select2Controller::class, 'pegawaiaktif'])->name('s2.pegawaiaktif');
  Route::get('adminpegawai', [App\Http\Controllers\Select2Controller::class, 'adminpegawai'])->name('s2.adminpegawai');
  Route::get('kelas', [App\Http\Controllers\Select2Controller::class, 'kelas'])->name('s2.kelas');
  Route::get('semuakelas', [App\Http\Controllers\Select2Controller::class, 'semuakelas'])->name('s2.semuakelas');
  Route::get('tingkatkelas', [App\Http\Controllers\Select2Controller::class, 'tingkatkelas'])->name('s2.tingkatkelas');
  Route::get('kurikulum', [App\Http\Controllers\Select2Controller::class, 'kurikulum'])->name('s2.kurikulum');
  Route::get('kecamatan', [App\Http\Controllers\Select2Controller::class, 'kecamatan'])->name('s2.kecamatan');
  Route::get('pekerjaan', [App\Http\Controllers\Select2Controller::class, 'pekerjaan'])->name('s2.pekerjaan');
  Route::get('jabatan', [App\Http\Controllers\Select2Controller::class, 'jabatan'])->name('s2.jabatan');
  Route::get('pejabat', [App\Http\Controllers\Select2Controller::class, 'pejabat'])->name('s2.pejabat');
  Route::get('roleadmin', [App\Http\Controllers\Select2Controller::class, 'roleadmin'])->name('s2.roleadmin');
  Route::get('jampelajaran/{jampelajaran}/{idkelas}', [App\Http\Controllers\Select2Controller::class, 'jampelajaran'])->name('s2.jampelajaran');
  Route::get('jampelajaranagama/{jampelajaran}/{idtingkat}/{idagama}', [App\Http\Controllers\Select2Controller::class, 'jampelajaranagama'])->name('s2.jampelajaranagama');
  Route::get('jenisptk', [App\Http\Controllers\Select2Controller::class, 'jenisptk'])->name('s2.jenisptk');
  Route::get('pangkat', [App\Http\Controllers\Select2Controller::class, 'pangkat'])->name('s2.pangkat');
  Route::get('statuskerja', [App\Http\Controllers\Select2Controller::class, 'statuskerja'])->name('s2.statuskerja');
  Route::get('tahunajaran', [App\Http\Controllers\Select2Controller::class, 'tahunajaran'])->name('s2.tahunajaran');
  Route::get('tahunlulusan', [App\Http\Controllers\Select2Controller::class, 'tahunlulusan'])->name('s2.tahunlulusan');
  Route::get('bulanspp', [App\Http\Controllers\Select2Controller::class, 'bulanspp'])->name('s2.bulanspp');
  Route::get('jeniskelas', [App\Http\Controllers\Select2Controller::class, 'jeniskelas'])->name('s2.jeniskelas');
  Route::get('jenissiswa', [App\Http\Controllers\Select2Controller::class, 'jenissiswa'])->name('s2.jenissiswa');
  Route::get('subjenisbiaya', [App\Http\Controllers\Select2Controller::class, 'subjenisbiaya'])->name('s2.subjenisbiaya');
  Route::get('sekolahprovinsi', [App\Http\Controllers\Select2Controller::class, 'sekolahprovinsi'])->name('s2.sekolahprovinsi');
  Route::get('sekolah', [App\Http\Controllers\Select2Controller::class, 'sekolah'])->name('s2.sekolah');
  Route::get('frekuensibayar', [App\Http\Controllers\Select2Controller::class, 'frekuensibayar'])->name('s2.frekuensibayar');
  Route::get('siswaaktif', [App\Http\Controllers\Select2Controller::class, 'siswaaktif'])->name('s2.siswaaktif');
  Route::get('siswakonseling', [App\Http\Controllers\Select2Controller::class, 'siswakonseling'])->name('s2.siswakonseling');
  Route::get('periodeabsen', [App\Http\Controllers\Select2Controller::class, 'periodeabsen'])->name('s2.periodeabsen');
  Route::get('skpejabat', [App\Http\Controllers\Select2Controller::class, 'skpejabat'])->name('s2.skpejabat');
  Route::get('bidangsurat', [App\Http\Controllers\Select2Controller::class, 'bidangsurat'])->name('s2.bidangsurat');
  Route::get('kategorisurat', [App\Http\Controllers\Select2Controller::class, 'kategorisurat'])->name('s2.kategorisurat');
  Route::get('pelanggaran', [App\Http\Controllers\Select2Controller::class, 'pelanggaran'])->name('s2.pelanggaran');
  Route::get('tingkatpelanggaran', [App\Http\Controllers\Select2Controller::class, 'tingkatpelanggaran'])->name('s2.tingkatpelanggaran');
  Route::get('pelatihekskul', [App\Http\Controllers\Select2Controller::class, 'pelatihekskul'])->name('s2.pelatihekskul');
  Route::get('provinsi', [App\Http\Controllers\Select2Controller::class, 'provinsi'])->name('s2.provinsi');
  Route::get('kabupaten', [App\Http\Controllers\Select2Controller::class, 'kabupaten'])->name('s2.kabupaten');
  Route::get('pilihkecamatan', [App\Http\Controllers\Select2Controller::class, 'pilihkecamatan'])->name('s2.pilihkecamatan');
  Route::get('jenisevaluasi', [App\Http\Controllers\Select2Controller::class, 'jenisevaluasi'])->name('s2.jenisevaluasi');
  Route::get('jenispertemuan', [App\Http\Controllers\Select2Controller::class, 'jenispertemuan'])->name('s2.jenispertemuan');
});

Route::prefix('masterdata')->group(function(){
  Route::prefix('siswa')->group(function(){
    Route::get('', [App\Http\Controllers\MDSiswaController::class, 'index'])->name('md.siswa');
    Route::get('dt/{idkelas}/{idjenis}',[App\Http\Controllers\MDSiswaController::class, 'dt'])->name('md.siswa.dt');
    Route::get('detail/{id}',[App\Http\Controllers\MDSiswaController::class, 'detail'])->name('md.siswa.detail');
    Route::post('store', [App\Http\Controllers\MDSiswaController::class, 'store'])->name('md.siswa.store');
    Route::post('update', [App\Http\Controllers\MDSiswaController::class, 'update'])->name('md.siswa.update');
    Route::get('kartupelajar/{id?}',[App\Http\Controllers\MDSiswaController::class, 'kartupelajar'])->name('md.siswa.kartupelajar');
    Route::post('exportexcel', [App\Http\Controllers\MDSiswaController::class, 'exportexcel'])->name('md.siswa.exportexcel');
  });

  Route::prefix('guru')->group(function(){
    Route::get('', [App\Http\Controllers\MDGuruController::class, 'index'])->name('md.guru');
    Route::get('dt/{idstatus?}',[App\Http\Controllers\MDGuruController::class, 'dt'])->name('md.guru.dt');
    Route::get('detail/{id}',[App\Http\Controllers\MDGuruController::class, 'detail'])->name('md.guru.detail');
  });

  Route::prefix('kelas')->group(function(){
    Route::get('', [App\Http\Controllers\MDKelasController::class, 'index'])->name('md.kelas');
    Route::get('dt/{aktif}',[App\Http\Controllers\MDKelasController::class, 'dt'])->name('md.kelas.dt');
    Route::get('detail/{id}',[App\Http\Controllers\MDKelasController::class, 'detail'])->name('md.kelas.detail');
    Route::get('dtsiswa/{id}',[App\Http\Controllers\MDKelasController::class, 'dtsiswa'])->name('md.kelas.dtsiswa');
    Route::get('getjenis/{id?}',[App\Http\Controllers\MDKelasController::class, 'getjenis'])->name('md.kelas.getjenis');
    Route::post('store', [App\Http\Controllers\MDKelasController::class, 'store'])->name('md.kelas.store');
    Route::post('update', [App\Http\Controllers\MDKelasController::class, 'update'])->name('md.kelas.update');
    Route::post('updatewali', [App\Http\Controllers\MDKelasController::class, 'updatewali'])->name('md.kelas.updatewali');
    Route::post('resetwali', [App\Http\Controllers\MDKelasController::class, 'resetwali'])->name('md.kelas.resetwali');
    Route::post('updatesiswa', [App\Http\Controllers\MDKelasController::class, 'updatesiswa'])->name('md.kelas.updatesiswa');
    Route::post('pindahkelas', [App\Http\Controllers\MDKelasController::class, 'pindahkelas'])->name('md.kelas.pindahkelas');
    Route::post('updateaktif', [App\Http\Controllers\MDKelasController::class, 'updateaktif'])->name('md.kelas.updateaktif');
  });

  Route::prefix('kurikulum')->group(function(){
    Route::get('', [App\Http\Controllers\MDKurikulumController::class, 'index'])->name('md.kurikulum');
    Route::get('dt',[App\Http\Controllers\MDKurikulumController::class, 'dt'])->name('md.kurikulum.dt');
    Route::post('store', [App\Http\Controllers\MDKurikulumController::class, 'store'])->name('md.kurikulum.store');
    Route::post('update', [App\Http\Controllers\MDKurikulumController::class, 'update'])->name('md.kurikulum.update');
    Route::post('aktif', [App\Http\Controllers\MDKurikulumController::class, 'aktif'])->name('md.kurikulum.aktif');
  });

  Route::prefix('matapelajaran')->group(function(){
    Route::get('', [App\Http\Controllers\MDMatapelajaranController::class, 'index'])->name('md.mapel');
    Route::get('dt',[App\Http\Controllers\MDMatapelajaranController::class, 'dt'])->name('md.mapel.dt');
    Route::post('store', [App\Http\Controllers\MDMatapelajaranController::class, 'store'])->name('md.mapel.store');
    Route::post('update', [App\Http\Controllers\MDMatapelajaranController::class, 'update'])->name('md.mapel.update');
  });

  Route::prefix('pegawai')->group(function(){
    Route::get('', [App\Http\Controllers\MDPegawaiController::class, 'index'])->name('md.pegawai');
    Route::get('dt/{idstatus?}',[App\Http\Controllers\MDPegawaiController::class, 'dt'])->name('md.pegawai.dt');
    Route::get('detail/{id}',[App\Http\Controllers\MDPegawaiController::class, 'detail'])->name('md.pegawai.detail');
    Route::post('store', [App\Http\Controllers\MDPegawaiController::class, 'store'])->name('md.pegawai.store');
    Route::post('update', [App\Http\Controllers\MDPegawaiController::class, 'update'])->name('md.pegawai.update');
    Route::post('updatekepegawaian', [App\Http\Controllers\MDPegawaiController::class, 'updatekepegawaian'])->name('md.pegawai.updatekepegawaian');
    Route::post('exportexcel', [App\Http\Controllers\MDPegawaiController::class, 'exportexcel'])->name('md.pegawai.exportexcel');
  });

  Route::prefix('user')->group(function(){
    Route::post('create', [App\Http\Controllers\MDUserController::class, 'store'])->name('md.user.store');
    Route::post('delete', [App\Http\Controllers\MDUserController::class, 'delete'])->name('md.user.delete');
    Route::post('generateusersiswa', [App\Http\Controllers\MDUserController::class, 'generateusersiswa'])->name('md.siswa.generateuser');
    Route::post('generateuserpegawai', [App\Http\Controllers\MDUserController::class, 'generateuserpegawai'])->name('md.pegawai.generateuser');
  });

  Route::prefix('ta')->group(function(){
    Route::get('', [App\Http\Controllers\MDTaController::class, 'index'])->name('md.ta');
    Route::get('dt', [App\Http\Controllers\MDTaController::class, 'dt'])->name('md.ta.dt');
    Route::post('aktif', [App\Http\Controllers\MDTaController::class, 'aktif'])->name('md.ta.aktif');
    Route::post('store', [App\Http\Controllers\MDTaController::class, 'store'])->name('md.ta.store');
  });

  Route::prefix('jadwalpelajaran')->group(function(){
    Route::get('', [App\Http\Controllers\AkademikJadwalController::class, 'index'])->name('md.jadwal');
    Route::get('dt', [App\Http\Controllers\AkademikJadwalController::class, 'dt'])->name('md.jadwal.dt');
    Route::get('dtagama', [App\Http\Controllers\AkademikJadwalController::class, 'dtagama'])->name('md.jadwal.dtagama');
    Route::get('detail/{idkelas}', [App\Http\Controllers\AkademikJadwalController::class, 'detail'])->name('md.jadwal.detail');
    Route::post('store', [App\Http\Controllers\AkademikJadwalController::class, 'store'])->name('md.jadwal.store');
    Route::post('delete', [App\Http\Controllers\AkademikJadwalController::class, 'delete'])->name('md.jadwal.delete');
    Route::prefix('agama')->group(function(){
      Route::get('detail/{idtingkat}', [App\Http\Controllers\AkademikJadwalController::class, 'detailagama'])->name('md.jadwal.detailagama');
      Route::post('storeagama', [App\Http\Controllers\AkademikJadwalController::class, 'storeagama'])->name('md.jadwal.storeagama');
      Route::post('deleteagama', [App\Http\Controllers\AkademikJadwalController::class, 'deleteagama'])->name('md.jadwal.deleteagama');
    });
  });
});

Route::prefix('profilsekolah')->group(function(){
  route::get('',[App\Http\Controllers\ProfilSekolahController::class, 'index'])->name('profilsekolah');
  route::post('store',[App\Http\Controllers\ProfilSekolahController::class, 'store'])->name('profilsekolah.store');
  route::post('favicon',[App\Http\Controllers\ProfilSekolahController::class, 'favicon'])->name('profilsekolah.favicon');
  route::post('logo',[App\Http\Controllers\ProfilSekolahController::class, 'logo'])->name('profilsekolah.logo');
});

Route::get('baperkuliahan/{id}', [App\Http\Controllers\BarcodeController::class, 'ba'])->name('baperkuliahan');

Route::prefix('pembelajaran')->group(function(){
  Route::get('{idjadwal}/{idgambar}', [App\Http\Controllers\PembelajaranController::class, 'index'])->name('pembelajaran');

  Route::prefix('video')->group(function(){
    Route::post('storevideo', [App\Http\Controllers\PembelajaranController::class, 'storevideo'])->name('pembelajaran.storevideo');
    Route::post('updatevideo', [App\Http\Controllers\PembelajaranController::class, 'updatevideo'])->name('pembelajaran.updatevideo');
    Route::post('deletevideo', [App\Http\Controllers\PembelajaranController::class, 'deletevideo'])->name('pembelajaran.deletevideo');
    Route::post('storekontrak', [App\Http\Controllers\PembelajaranController::class, 'storekontrak'])->name('pembelajaran.storekontrak');
    Route::post('updatekontrak', [App\Http\Controllers\PembelajaranController::class, 'updatekontrak'])->name('pembelajaran.updatekontrak');
  });


  Route::prefix('materi')->group(function(){
    Route::get('getmateri/{id}', [App\Http\Controllers\PembelajaranController::class, 'getmateri'])->name('pembelajaran.getmateri');
    Route::post('storemateri', [App\Http\Controllers\PembelajaranController::class, 'storemateri'])->name('pembelajaran.storemateri');
    Route::post('unduhtemplate', [App\Http\Controllers\PembelajaranController::class, 'unduhtemplate'])->name('pembelajaran.materi.unduhtemplate');
    Route::post('unggahtemplate', [App\Http\Controllers\PembelajaranController::class, 'unggahtemplate'])->name('pembelajaran.materi.unggahtemplate');
    Route::post('updatemateri', [App\Http\Controllers\PembelajaranController::class, 'updatemateri'])->name('pembelajaran.updatemateri');
    Route::post('publishmateri', [App\Http\Controllers\PembelajaranController::class, 'publishmateri'])->name('pembelajaran.publishmateri');
    Route::post('deletemateri', [App\Http\Controllers\PembelajaranController::class, 'deletemateri'])->name('pembelajaran.deletemateri');
    Route::get('getmaterisalin/{idjadwal}', [App\Http\Controllers\PembelajaranController::class, 'getmaterisalin'])->name('pembelajaran.getmaterisalin');
    Route::post('storesalinmateri', [App\Http\Controllers\PembelajaranController::class, 'storesalinmateri'])->name('pembelajaran.storesalinmateri');
  });

  Route::prefix('presensi')->group(function(){
    Route::post('store', [App\Http\Controllers\PembelajaranPresensiController::class, 'store'])->name('pembelajaran.presensi.store');
    Route::post('update', [App\Http\Controllers\PembelajaranPresensiController::class, 'update'])->name('pembelajaran.presensi.update');
    route::post('updatetgl',[App\Http\Controllers\PembelajaranPresensiController::class, 'updatetgl'])->name('pembelajaran.presensi.updatetgl');
    route::get('edit/{id}',[App\Http\Controllers\PembelajaranPresensiController::class, 'edit'])->name('pembelajaran.presensi.edit');
    route::get('getmateri/{idjadwal}/{pertemuan}',[App\Http\Controllers\PembelajaranPresensiController::class, 'getmateri'])->name('pembelajaran.presensi.getmateri');
    route::post('ba',[App\Http\Controllers\PembelajaranPresensiController::class, 'ba'])->name('pembelajaran.presensi.ba');
    route::post('rekap',[App\Http\Controllers\PembelajaranPresensiController::class, 'rekap'])->name('pembelajaran.presensi.rekap');
  });

  Route::prefix('{idjadwal}')->group(function(){

    Route::prefix('presensi')->group(function(){
      Route::get('detail', [App\Http\Controllers\PembelajaranPresensiController::class, 'index'])->name('pembelajaran.presensi');
      Route::get('detailkehadiran', [App\Http\Controllers\PembelajaranPresensiController::class, 'detail'])->name('pembelajaran.presensi.detail');
      Route::get('barcode', [App\Http\Controllers\PembelajaranPresensiController::class, 'barcode'])->name('pembelajaran.presensi.barcode');
    });

    Route::prefix('penilaian')->group(function(){
      Route::get('detail', [App\Http\Controllers\PembelajaranNilaiController::class, 'index'])->name('pembelajaran.penilaian');
      Route::get('detailquiz/{idkelas}/{idmapel}/{idjenismapel}/{isagama}',[App\Http\Controllers\PembelajaranNilaiController::class, 'detailquiz'])->name('pembelajaran.penilaian.detailquiz');
      Route::get('detailevaluasi/{id}',[App\Http\Controllers\PembelajaranNilaiController::class, 'detailevaluasi'])->name('pembelajaran.penilaian.detailevaluasi');
      Route::post('cetaknilaitugas', [App\Http\Controllers\PembelajaranNilaiController::class, 'cetaknilaitugas'])->name('pembelajaran.penilaian.cetaknilaitugas');
      Route::post('cetakevaluasi/{idkelas}/{idmapel}', [App\Http\Controllers\PembelajaranNilaiController::class, 'cetakevaluasi'])->name('pembelajaran.penilaian.cetakevaluasi');
    });

    Route::prefix('diskusi')->group(function(){
      Route::get('{id}', [App\Http\Controllers\PembelajaranDiskusiController::class, 'index'])->name('pembelajaran.diskusi');
    });

    route::prefix('evaluasi')->group(function(){
      Route::get('{idmateri}/{idevaluasi}', [App\Http\Controllers\PembelajaranEvaluasiController::class, 'index'])->name('pembelajaran.evaluasi');
      Route::get('soal/detail/{id}', [App\Http\Controllers\PembelajaranEvaluasiController::class, 'detailsoal'])->name('pembelajaran.evaluasi.detailsoal');
      Route::get('dtcerita', [App\Http\Controllers\PembelajaranEvaluasiController::class, 'dtcerita'])->name('pembelajaran.evaluasi.dtcerita');
    });

    route::prefix('tugas')->group(function(){
      Route::get('detail/{id}', [App\Http\Controllers\PembelajaranTugasController::class, 'detail'])->name('pembelajaran.penugasan.detail');
      Route::get('searching/{id}/{nama?}', [App\Http\Controllers\PembelajaranTugasController::class, 'searching'])->name('pembelajaran.penugasan.searching');
    });

  });

  Route::prefix('diskusi')->group(function(){
    Route::get('gettopikdiskusi/{id}', [App\Http\Controllers\PembelajaranController::class, 'gettopikdiskusi'])->name('pembelajaran.gettopikdiskusi');
    Route::post('storetopikdiskusi', [App\Http\Controllers\PembelajaranController::class, 'storetopikdiskusi'])->name('pembelajaran.storetopikdiskusi');
    Route::post('updatetopikdiskusi', [App\Http\Controllers\PembelajaranController::class, 'updatetopikdiskusi'])->name('pembelajaran.updatetopikdiskusi');
        Route::get('store', [App\Http\Controllers\PembelajaranDiskusiController::class, 'store'])->name('pembelajaran.diskusi.store');
  });

  Route::prefix('dokumen')->group(function(){
    Route::get('getdokumen/{id}', [App\Http\Controllers\PembelajaranController::class, 'getdokumen'])->name('pembelajaran.getdokumen');
    Route::post('storedokumen', [App\Http\Controllers\PembelajaranController::class, 'storedokumen'])->name('pembelajaran.storedokumen');
    Route::post('updatedokumen', [App\Http\Controllers\PembelajaranController::class, 'updatedokumen'])->name('pembelajaran.updatedokumen');
    Route::post('deletedokumen', [App\Http\Controllers\PembelajaranController::class, 'deletedokumen'])->name('pembelajaran.deletedokumen');
  });

  Route::prefix('tugas')->group(function(){
    Route::post('store', [App\Http\Controllers\PembelajaranTugasController::class, 'store'])->name('pembelajaran.penugasan.store');
    Route::post('update', [App\Http\Controllers\PembelajaranTugasController::class, 'update'])->name('pembelajaran.penugasan.update');
    Route::get('gettugas/{id}', [App\Http\Controllers\PembelajaranTugasController::class, 'gettugas'])->name('pembelajaran.penugasan.gettugas');

    Route::prefix('rubrik')->group(function(){
      Route::post('store', [App\Http\Controllers\PembelajaranTugasController::class, 'storerubrik'])->name('pembelajaran.penugasan.rubrik.store');
      Route::post('delete', [App\Http\Controllers\PembelajaranTugasController::class, 'deleterubrik'])->name('pembelajaran.penugasan.rubrik.delete');
    });

    Route::prefix('nilai')->group(function(){
      Route::post('store', [App\Http\Controllers\PembelajaranTugasController::class, 'storenilai'])->name('pembelajaran.penugasan.nilai.store');
      Route::post('update', [App\Http\Controllers\PembelajaranTugasController::class, 'updatenilai'])->name('pembelajaran.penugasan.nilai.update');
      Route::post('updatekelompok', [App\Http\Controllers\PembelajaranTugasController::class, 'updatenilaikelompok'])->name('pembelajaran.penugasan.nilai.updatekelompok');
      Route::get('dt/{idpenugasan}', [App\Http\Controllers\PembelajaranTugasController::class, 'dtkumpul'])->name('pembelajaran.penugasan.nilai.dt');

      Route::get('gettugas/{idtugas}', [App\Http\Controllers\PembelajaranTugasController::class, 'siswagettugas'])->name('pembelajaran.penugasan.nilai.gettugas');
      Route::get('getkelompok/{id}', [App\Http\Controllers\PembelajaranTugasController::class, 'siswagetkelompok'])->name('pembelajaran.penugasan.nilai.getkelompok');
    });
  });


  Route::prefix('evaluasi')->group(function(){
    Route::get('getevaluasi/{id}', [App\Http\Controllers\PembelajaranController::class, 'getevaluasi'])->name('pembelajaran.getevaluasi');
    Route::post('setevaluasi', [App\Http\Controllers\PembelajaranController::class, 'setevaluasi'])->name('pembelajaran.setevaluasi');
    Route::get('dt/{idevaluasi}/{idmapel}/{idjenis}', [App\Http\Controllers\PembelajaranEvaluasiController::class, 'dt'])->name('pembelajaran.evaluasi.dt');


    Route::post('unduhtemplate', [App\Http\Controllers\PembelajaranEvaluasiController::class, 'unduhtemplate'])->name('pembelajaran.evaluasi.unduhtemplate');
    Route::post('unggahsoaljawaban', [App\Http\Controllers\PembelajaranEvaluasiController::class, 'unggahsoaljawaban'])->name('pembelajaran.evaluasi.unggahsoaljawaban');

    Route::post('storesoal', [App\Http\Controllers\PembelajaranEvaluasiController::class, 'storesoal'])->name('pembelajaran.evaluasi.storesoal');
    Route::post('updatesoal', [App\Http\Controllers\PembelajaranEvaluasiController::class, 'updatesoal'])->name('pembelajaran.evaluasi.updatesoal');
  });

  Route::prefix('peserta')->group(function(){
    Route::get('{idjadwal}/{idmateri}/{idevaluasi}/{i}', [App\Http\Controllers\PembelajaranPesertaEvaluasiController::class, 'index'])->name('pembelajaran.evaluasi.peserta');
    Route::get('dt/{idevaluasi}/{idjenis}', [App\Http\Controllers\PembelajaranPesertaEvaluasiController::class, 'dt'])->name('pembelajaran.evaluasi.peserta.dt');
    Route::get('searching/{idjadwal}/{idevaluasi}/{nama?}', [App\Http\Controllers\PembelajaranPesertaEvaluasiController::class, 'searching'])->name('pembelajaran.evaluasi.peserta.searching');
  });

});

Route::get('getbalas/{id}', [App\Http\Controllers\PembelajaranDiskusiController::class, 'getbalas'])->name('pembelajaran.diskusi.getbalas');

Route::prefix('siswa')->group(function(){
  Route::prefix('pembelajaran')->group(function(){
    Route::get('{idjadwal}/{idgambar}', [App\Http\Controllers\SwaPembelajaranController::class, 'index'])->name('swa.pembelajaran');
  });
  Route::prefix('penugasan')->group(function(){
    Route::get('', [App\Http\Controllers\SwaPenugasanController::class, 'index'])->name('swa.penugasan');
    Route::get('detil/{id}', [App\Http\Controllers\SwaPenugasanController::class, 'detil'])->name('swa.penugasan.detil');
    Route::post('store', [App\Http\Controllers\SwaPenugasanController::class, 'store'])->name('swa.penugasan.store');
    Route::post('deletedokumen', [App\Http\Controllers\SwaPenugasanController::class, 'deletedokumen'])->name('swa.penugasan.deletedokumen');
    Route::post('deletkelompok', [App\Http\Controllers\SwaPenugasanController::class, 'deletkelompok'])->name('swa.penugasan.deletkelompok');
    Route::post('storeanggota', [App\Http\Controllers\SwaPenugasanController::class, 'storeanggota'])->name('swa.penugasan.storeanggota');
  });

  Route::prefix('evaluasi')->group(function(){
    Route::get('', [App\Http\Controllers\SwaEvaluasiController::class, 'index'])->name('swa.evaluasi');
    Route::get('create/{id}', [App\Http\Controllers\SwaEvaluasiController::class, 'create'])->name('swa.evaluasi.create');
    Route::get('essay-unggah/{id}', [App\Http\Controllers\SwaEvaluasiController::class, 'essay_unggah'])->name('swa.evaluasi.essay-unggah');
    Route::post('store', [App\Http\Controllers\SwaEvaluasiController::class, 'store'])->name('swa.evaluasi.store');
    Route::post('storeessay', [App\Http\Controllers\SwaEvaluasiController::class, 'storeessay'])->name('swa.evaluasi.storeessay');
    Route::get('jawab/{jawaban}', [App\Http\Controllers\SwaEvaluasiController::class, 'jawab'])->name('swa.evaluasi.jawab');
    Route::get('getsoal/{idevaluasi}/{soalke}', [App\Http\Controllers\SwaEvaluasiController::class, 'getsoal'])->name('swa.evaluasi.getsoal');

  });
});

Route::prefix('laporan')->group(function(){
  Route::prefix('presensi')->group(function(){
    Route::get('', [App\Http\Controllers\AkademikPresensiController::class, 'index'])->name('laporan.presensi');
    Route::get('dt/{idhari}',[App\Http\Controllers\AkademikPresensiController::class, 'dt'])->name('laporan.presensi.dt');
    Route::get('detail/{id}',[App\Http\Controllers\AkademikPresensiController::class, 'detail'])->name('laporan.presensi.detail');
    Route::get('detailpresensi/{id}/{isagama}',[App\Http\Controllers\AkademikPresensiController::class, 'detailpresensi'])->name('laporan.presensi.detailpresensi');
    Route::post('store', [App\Http\Controllers\AkademikPresensiController::class, 'store'])->name('laporan.presensi.store');
    route::get('edit/{id}/{isagama}',[App\Http\Controllers\AkademikPresensiController::class, 'edit'])->name('laporan.presensi.edit');
    route::get('getmateri/{idjadwal}/{isagama}/{pertemuan}',[App\Http\Controllers\AkademikPresensiController::class, 'laporan.getmateri'])->name('laporan.presensi.getmateri');
    route::post('update',[App\Http\Controllers\AkademikPresensiController::class, 'update'])->name('laporan.presensi.update');
    route::post('updatetgl',[App\Http\Controllers\AkademikPresensiController::class, 'updatetgl'])->name('laporan.presensi.updatetgl');
    route::post('ba',[App\Http\Controllers\AkademikPresensiController::class, 'ba'])->name('laporan.presensi.ba');
    route::post('rekap',[App\Http\Controllers\AkademikPresensiController::class, 'rekap'])->name('laporan.presensi.rekap');
    route::post('cetak',[App\Http\Controllers\AkademikPresensiController::class, 'cetak'])->name('laporan.presensi.cetak');
    Route::prefix('agama')->group(function(){
      Route::get('detail/{id}',[App\Http\Controllers\AkademikPresensiController::class, 'detailagama'])->name('laporan.presensi.detailagama');
    });
  });

  Route::prefix('penilaian')->group(function(){
    Route::get('', [App\Http\Controllers\AkademikPenilaianController::class, 'index'])->name('laporan.penilaian');
    Route::get('detail/{idkelas}/{idmapel}/{idjenismapel}/{isagama}',[App\Http\Controllers\AkademikPenilaianController::class, 'detail'])->name('laporan.penilaian.detail');
    Route::get('detailquiz/{idkelas}/{idmapel}/{idjenismapel}/{isagama}',[App\Http\Controllers\AkademikPenilaianController::class, 'detailquiz'])->name('laporan.penilaian.detailquiz');
    Route::get('detailevaluasi/{id}',[App\Http\Controllers\AkademikPenilaianController::class, 'detailevaluasi'])->name('laporan.penilaian.detailevaluasi');
    Route::post('store', [App\Http\Controllers\AkademikPenilaianController::class, 'store'])->name('laporan.penilaian.store');
    Route::post('storemerdeka', [App\Http\Controllers\AkademikPenilaianController::class, 'storemerdeka'])->name('laporan.penilaian.storemerdeka');
    Route::post('template', [App\Http\Controllers\AkademikPenilaianController::class, 'template'])->name('laporan.penilaian.template');
    Route::post('cetaknilaitugas', [App\Http\Controllers\AkademikPenilaianController::class, 'cetaknilaitugas'])->name('laporan.penilaian.cetaknilaitugas');
    Route::post('cetakevaluasi/{idkelas}/{idmapel}', [App\Http\Controllers\AkademikPenilaianController::class, 'cetakevaluasi'])->name('laporan.penilaian.cetakevaluasi');
    Route::prefix('agama')->group(function(){
      Route::get('detail/{idtingkatkelas}/{idmapel}/{idjenismapel}/{idkurikulum}/{idagama}',[App\Http\Controllers\AkademikPenilaianController::class, 'detailagama'])->name('laporan.penilaian.detailagama');
      Route::post('cetaklegeragama', [App\Http\Controllers\AkademikPenilaianController::class, 'cetaklegeragama'])->name('laporan.penilaian.cetaklegeragama');
    });
  });
});

Route::prefix('guru/pengajaran')->group(function(){
  Route::prefix('presensi')->group(function(){
    Route::get('', [App\Http\Controllers\GuruPresensiController::class, 'index'])->name('guru.presensi');
    Route::get('detail/{id}',[App\Http\Controllers\GuruPresensiController::class, 'detail'])->name('guru.presensi.detail');
    Route::get('detailpresensi/{id}/{isagama}',[App\Http\Controllers\GuruPresensiController::class, 'detailpresensi'])->name('guru.presensi.detailpresensi');
    Route::prefix('agama')->group(function(){
      Route::get('detail/{id}',[App\Http\Controllers\GuruPresensiController::class, 'detailagama'])->name('guru.presensi.detailagama');
    });
  });
  Route::prefix('penilaian')->group(function(){
    Route::get('', [App\Http\Controllers\GuruPenilaianController::class, 'index'])->name('guru.penilaian');
    Route::get('detail/{idkelas}/{idmapel}/{isagama}',[App\Http\Controllers\GuruPenilaianController::class, 'detail'])->name('guru.penilaian.detail');
    Route::prefix('agama')->group(function(){
      Route::get('detail/{idtingkatkelas}/{idmapel}/{idkurikulum}/{idagama}',[App\Http\Controllers\GuruPenilaianController::class, 'detailagama'])->name('guru.penilaian.detailagama');
    });
  });
  Route::prefix('pengayaan')->group(function(){
    Route::get('', [App\Http\Controllers\GuruPengayaanController::class, 'index'])->name('guru.pengayaan');
    Route::get('detail/{idkelas}/{idmapel}',[App\Http\Controllers\GuruPengayaanController::class, 'detail'])->name('guru.pengayaan.detail');
  });
  Route::prefix('rpp')->group(function(){
    Route::get('', [App\Http\Controllers\GuruRPPController::class, 'index'])->name('guru.rpp');
    Route::get('dt',[App\Http\Controllers\GuruRPPController::class, 'dt'])->name('guru.rpp.dt');
  });
  Route::prefix('cp')->group(function(){
    Route::get('', [App\Http\Controllers\GuruCPController::class, 'index'])->name('guru.cp');
    Route::get('dt',[App\Http\Controllers\GuruCPController::class, 'dt'])->name('guru.cp.dt');
    Route::get('detail/{id}',[App\Http\Controllers\GuruCPController::class, 'detail'])->name('guru.cp.detail');
  });
});

Route::prefix('datadiri')->group(function(){
  Route::get('', [App\Http\Controllers\DatadiriController::class, 'index'])->name('datadiri');
  Route::post('update', [App\Http\Controllers\DataDiriController::class, 'update'])->name('datadiri.update');
  Route::post('storependidikan', [App\Http\Controllers\DataDiriController::class, 'storependidikan'])->name('datadiri.storependidikan');
  Route::get('getriwayat/{id}', [App\Http\Controllers\DataDiriController::class, 'getriwayat'])->name('datadiri.getriwayat');
  Route::post('updatependidikan', [App\Http\Controllers\DataDiriController::class, 'updatependidikan'])->name('datadiri.updatependidikan');
});

Route::post('reset-password',[App\Http\Controllers\ResetPasswordController::class, 'sendemail'])->name('ResetPassword');
Route::post('store-password',[App\Http\Controllers\ResetPasswordController::class, 'storepassword'])->name('storePassword');
Route::get('reset',[App\Http\Controllers\ResetPasswordController::class, 'reset'])->name('reset');
Route::get('new-password/{token}',[App\Http\Controllers\ResetPasswordController::class, 'newpassword'])->name('NewPassword');
Route::post('ubahpassword',[App\Http\Controllers\MDUserController::class, 'ubahpassword'])->name('user.ubahpassword');
