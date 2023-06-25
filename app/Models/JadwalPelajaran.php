<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
  protected $guarded = ['id'];
  
  public function hari()
  {
    return $this->hasone(MdHari::class,'id','idhari');
  }

  public function detil()
  {
    return $this->hasmany(JadwalPelajaranDetil::class,'idjadwal','id')->where('isagama',0);
  }

  public function kelas()
  {
    return $this->hasone(MdKelas::class,'id','idkelas');
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
    return $this->hasmany(JadwalPelajaranGuru::class,'idjadwal','id')->where('isagama',0);
  }

  public function guru()
  {
    return $this->hasMany(JadwalPelajaranGuru::class,'idjadwal','id');
  }

  public function siswa()
  {
    return $this->hasone(Siswa::class, 'idkelas', 'idkelas');
  }

  public function rpp()
  {
    return $this->hasone(JadwalRpp::class,'id','idrpp');
  }

  public function ba()
  {
    return $this->hasmany(JadwalBap::class,'idjadwal','id')->where('isagama',0);
  }

  public function materilms()
  {
    return $this->hasMany(LmsMateri::class,'idjadwal','id');
  }

  public function topiklms()
  {
    return $this->hasMany(LmsTopik::class,'idjadwal','id');
  }
  
  public function penugasanlms()
  {
    return $this->hasMany(LmsPenugasan::class,'idjadwal','id');
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
