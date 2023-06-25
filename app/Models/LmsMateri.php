<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LmsMateri extends Model
{
  protected $guarded = ['id'];

  public function detil()
  {
    return $this->hasMany(LmsMateriDetil::class,'idmateri','id');
  }

  public function jadwal()
  {
    return $this->hasone(JadwalPelajaran::class,'id','idjadwal');
  }
  
  public function jenis()
  {
    return $this->hasone(MdLmsJenispertemuan::class,'id','idjenis');
  }

  public function evaluasi()
  {
    return $this->hasone(LmsEvaluasi::class,'idmateri','id');
  }

  public function user()
  {
    return $this->hasone(User::class,'id','iduser');
  }
}
