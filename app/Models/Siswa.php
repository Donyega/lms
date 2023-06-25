<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
  protected $guarded = ['id'];
  protected $connection = 'mysql';

  public function detil()
  {
    return $this->hasone(SiswaDetil::class,'nis','nis');
  }

  public function agama()
  {
    return $this->hasone(MdAgama::class,'id','idagama');
  }

  public function kelas()
  {
    return $this->hasone(MdKelas::class,'id','idkelas');
  }

  public function status()
  {
    return $this->hasone(MdSiswaStatus::class,'id','idstatus');
  }

  public function jenis()
  {
    return $this->hasone(MdSiswaJenis::class,'id','idjenis');
  }

  public function kecamatan()
  {
    return $this->hasone(MdKecamatan::class,'id','idkec');
  }

  public function jenisdaftar()
  {
    return $this->hasone(MdJenisDaftar::class,'id','iddaftar');
  }

  public function user()
  {
    return $this->hasone(User::class,'link','id')->where('role',3);
  }

}
