<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LmsTopik extends Model
{
  protected $guarded = ['id'];

  public function diskusi()
  {
    return $this->hasmany(LmsTopikDiskusi::class,'idtopik','id');
  }

  public function user()
  {
    return $this->hasone(User::class,'id','iduser');
  }

}
