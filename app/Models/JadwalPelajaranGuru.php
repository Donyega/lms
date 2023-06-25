<?php

namespace App\Models;

use App\Helper;
use \Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;

class JadwalPelajaranGuru extends Model
{
  protected $guarded = ['id'];
  use Compoships;

  public function jadwal()
  {
    return $this->hasone(JadwalPelajaran::class,'id','idjadwal');
  }

  public function jadwalagama()
  {
    return $this->hasone(JadwalPelajaranAgama::class,'id','idjadwal');
  }

  public function jadwalrpp()
  {
    $idta = Helper::idta();
    $idjenismapel = MdMapelJenis::where('israport',1)->select('id');
    return $this->hasone(JadwalPelajaran::class,'id','idjadwal')->where('idta',$idta)->wherein('idjenismapel',$idjenismapel);
  }

  public function jadwalagamarpp()
  {
    $idta = Helper::idta();
    $idjenismapel = MdMapelJenis::where('israport',1)->select('id');
    return $this->hasone(JadwalPelajaranAgama::class,'id','idjadwal')->where('idta',$idta)->wherein('idjenismapel',$idjenismapel);
  }

  public function pengayaancp()
  {
    $idta = Helper::idta();
    $idjenismapel = MdMapelJenis::where('israport',0)->select('id');
    return $this->hasone(JadwalPelajaran::class,'id','idjadwal')->where('idta',$idta)->wherein('idjenismapel',$idjenismapel);
  }

  public function jadwalcp()
  {
    $idta = Helper::idta();
    $idjenismapel = MdMapelJenis::where('israport',0)->select('id');
    return $this->hasone(JadwalPelajaran::class,'id','idjadwal')->where('idta',$idta)->where('idkurikulum',2)->wherenotin('idjenismapel',$idjenismapel);
  }

  public function jadwalagamacp()
  {
    $idta = Helper::idta();
    $idjenismapel = MdMapelJenis::where('israport',0)->select('id');
    return $this->hasone(JadwalPelajaranAgama::class,'id','idjadwal')->where('idta',$idta)->where('idkurikulum',2)->wherenotin('idjenismapel',$idjenismapel);
  }

  public function jampelajaran()
  {
    return $this->hasmany(JadwalPelajaranDetil::class,['idjadwal','isagama'],['idjadwal','isagama']);
  }

  public function guru()
  {
    return $this->hasone(Pegawai::class,'id','idguru');
  }

  public function rpp()
  {
    return $this->hasone(JadwalRpp::class,'id','idrpp');
  }
}
