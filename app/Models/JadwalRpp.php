<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalRpp extends Model
{
  protected $guarded = ['id'];

  public function mapel()
  {
    return $this->hasone(MdMapel::class,'id','idmapel');
  }

  public function tingkatkelas()
  {
    return $this->hasone(MdKelasTingkat::class,'id','idtingkatkelas');
  }

  public function minat()
  {
    return $this->hasone(MdPeminatan::class,'id','idminat');
  }

  public function guru()
  {
    return $this->hasone(Pegawai::class,'id','idguru');
  }

  public function jadwal()
  {
    return $this->hasmany(JadwalPelajaran::class,'idrpp','id');
  }

  public function cp()
  {
    return $this->hasmany(JadwalCp::class,'idrpp','id');
  }
}
