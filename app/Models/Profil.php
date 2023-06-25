<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
  protected $guarded = ['id'];

  public function kecamatan()
  {
    return $this->hasone(MdKecamatan::class,'id','idkec');
  }

}
