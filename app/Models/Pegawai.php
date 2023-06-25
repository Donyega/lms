<?php

namespace App\Models;

use App\Helper;
use \Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
  protected $guarded = ['id'];
  use Compoships;

  public function detil()
  {
    return $this->hasone(PegawaiDetil::class,'idpegawai','id');
  }

  public function agama()
  {
    return $this->hasone(MdAgama::class,'id','idagama');
  }

  public function pendidikan()
  {
    return $this->hasone(MdPendidikan::class,'id','idpendidikan');
  }

  public function pendidikanterakhir()
  {
    return $this->hasone(RiwayatPendidikan::class,['idpegawai','idpendidikan'],['id','idpendidikan']);
  }

  public function kecamatan()
  {
    return $this->hasone(MdKecamatan::class,'id','idkec');
  }

  public function status()
  {
    return $this->hasone(PegawaiStatus::class,'id','idstatus');
  }

  public function user()
  {
    return $this->hasone(User::class,'link','id')->where('role','<',3);
  }

  public function jadwalguru()
  {
    $idta = Helper::idta();
    $idjadwal = JadwalPelajaran::where('idta',$idta)->pluck('id')->first();
    return $this->hasone(JadwalPelajaranGuru::class,'idguru','id')->where('idjadwal',$idjadwal);
  }
  
}
