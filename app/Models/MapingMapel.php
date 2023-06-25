<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapingMapel extends Model
{
  protected $guarded = ['id'];

  public function kurikulum()
  {
    return $this->hasone(MdKurikulum::class,'id','idkurikulum');
  }

  public function tingkat()
  {
    return $this->hasone(MdKelasTingkat::class,'id','idtingkat');
  }

  public function peminatan()
  {
    return $this->hasone(MdPeminatan::class,'id','idminat');
  }

  public function jeniskelas()
  {
    return $this->hasone(MdKelasJenis::class,'id','idjeniskelas');
  }

  public function mapel()
  {
    return $this->hasone(MdMapel::class,'id','idmapel');
  }

  public function jenismapel()
  {
    return $this->hasone(MdMapelJenis::class,'id','idjenismapel');
  }

}
