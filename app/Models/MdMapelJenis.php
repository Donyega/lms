<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MdMapelJenis extends Model
{
  protected $guarded = ['id'];

  public function kurikulum()
  {
    return $this->hasone(MdKurikulum::class,'id','idkurikulum');
  }
}
