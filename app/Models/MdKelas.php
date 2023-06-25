<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helper;

class MdKelas extends Model
{
  protected $guarded = ['id'];

  public function minat()
  {
    return $this->hasone(MdPeminatan::class,'id','idminat');
  }

  public function jenis()
  {
    return $this->hasone(MdKelasJenis::class,'id','idjenis');
  }

  public function tingkat()
  {
    return $this->hasone(MdKelasTingkat::class,'id','idtingkat');
  }

  public function wali()
  {
    return $this->hasone(Pegawai::class,'id','idwali');
  }

  public function kurikulum()
  {
    return $this->hasone(MdKurikulum::class,'id','idkurikulum');
  }

  public function siswa()
  {
    return $this->hasmany(Siswa::class,'idkelas','id')->where('idstatus',1);
  }

  public function siswanonhindu()
  {
    return $this->hasmany(Siswa::class,'idkelas','id')->where('idstatus',1)->where('idagama','!=',4);
  }

  public function jadwal()
  {
    return $this->hasmany(JadwalPelajaran::class,'idkelas','id')->where('idta',Helper::idta());
  }

}
