<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LmsMateriDetil extends Model
{
  protected $guarded = ['id'];

  public function materi()
  {
    return $this->hasone(LmsMateri::class,'id','idmateri');
  }

  public function user()
  {
    return $this->hasone(User::class,'id','iduser');
  }
}
