<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPelajaranAgama extends Model
{
  protected $guarded = ['id'];

  public function agama()
  {
    return $this->hasone(MdAgama::class,'id','idagama');
  }

  public function hari()
  {
    return $this->hasone(MdHari::class,'id','idhari');
  }

  public function detil()
  {
    return $this->hasmany(JadwalPelajaranDetil::class,'idjadwal','id')->where('isagama',1);
  }

  public function tingkatkelas()
  {
    return $this->hasone(MdKelasTingkat::class,'id','idtingkatkelas');
  }

  public function mapel()
  {
    return $this->hasone(MdMapel::class,'id','idmapel');
  }

  public function jenismapel()
  {
    return $this->hasone(MdMapelJenis::class,'id','idjenismapel');
  }

  public function jampelajaran()
  {
    return $this->hasone(MdJamPelajaran::class,'id','idjam');
  }

  public function jadwalguru()
  {
    return $this->hasone(JadwalPelajaranGuru::class,'idjadwal','id')->where('isagama',1);
  }

  public function rpp()
  {
    return $this->hasone(JadwalRpp::class,'id','idrpp');
  }

  public function ba()
  {
    return $this->hasmany(JadwalBap::class,'idjadwal','id')->where('isagama',1);
  }

  public function ta()
  {
    return $this->hasone(Ta::class,'id','idta');
  }

  public function user()
  {
    return $this->hasone(User::class,'id','iduser');
  }

}
