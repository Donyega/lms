<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Awobaz\Compoships\Compoships;

class LmsEvaluasiJawaban extends Model
{
  protected $guarded = ['id'];
  use Compoships;

  public function jawaban()
  {
    return $this->hasMany(LmsEvaluasiJawaban::class,'kode','kode');
  }
}
