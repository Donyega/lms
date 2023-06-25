<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Auth;
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'remember_token',
        'link'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pegawai()
    {
      return $this->hasOne(Pegawai::class, 'id','link');
    }

    public function siswa()
    {
      return $this->hasOne(Siswa::class, 'id','link');
    }

    public function admin()
    {
      return $this->hasOne(RoleAdmin::class, 'iduser','id');
    }

    public function pejabat()
    {
      return $this->hasOne(RiwayatPejabat::class, 'idpegawai','link')->where('status',1);
    }

    public function ssa()
    {
      return $this->hasOne(Siswa::class, 'id','link');
    }

    public function permissions()
    {
        return $this->hasManyThrough(Permission::class, role::class);
    }

    public function hasRole($role)
    {

        if (is_string($role)) {
            return $this->role->contains('id', $role);
        }

        return !! $this->roles->intersect($role)->count();
    }
}
