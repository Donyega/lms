<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helper;

class MdKelasTingkat extends Model
{
  protected $guarded = ['id'];

  public function kelas()
  {
    return $this->hasmany(MdKelas::class,'idtingkat','id')->where('isaktif',1);
  }

  public function jadwalnonhindu()
  {
    $idta = Helper::idta();
    return $this->hasmany(JadwalPelajaranAgama::class,'idtingkatkelas','id')->where('idta',$idta);
  }

}
