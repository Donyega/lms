<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LmsTopikDiskusi extends Model
{
  protected $guarded = ['id'];

  public function user()
  {
    return $this->hasone(User::class,'id','iduser');
  }

  public function balas()
  {
    return $this->hasone(LmsTopikDiskusi::class,'id','iddiskusi');
  }

}
