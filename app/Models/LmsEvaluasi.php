<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Awobaz\Compoships\Compoships;
class LmsEvaluasi extends Model
{
  protected $guarded = ['id'];
  use Compoships;
  public function soal()
  {
    return $this->hasMany(LmsEvaluasiSoal::class,['idevaluasi','idjenis'],['id','idjenis']);
  }
  
  public function jenis()
  {
    return $this->hasone(MdLmsJenisevaluasi::class,'id','idjenis');
  }

  public function materi()
  {
    return $this->hasone(LmsMateri::class,'id','idmateri');
  }

  public function jadwal()
  {
    return $this->hasone(JadwalPelajaran::class,'id','idjadwal');
  }

  public function user()
  {
    return $this->hasone(User::class,'id','iduser');
  }
}
