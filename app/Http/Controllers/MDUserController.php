<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use auth;
class MDUserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
      try {
        $cek = User::where('role',$request->role)->where('username',$request->username)->first();
        if ($cek != null) {
          return back()->with('notif', json_encode([
            'title' => "BUAT USER",
            'text' => "Gagal menambahkan user baru, username $cek->username sudah terdaftar.",
            'type' => "error"
          ]));
        }

        $request->merge([
          'password' => Hash::make($request->password),
          'remember_token' => Str::random(40),
        ]);

        User::create($request->all());
        return back()->with('notif', json_encode([
          'title' => "BUAT USER",
          'text' => "Berhasil menambahkan user baru.",
          'type' => "success"
      ]));
      } catch (\Exception $e) {
        return back()->with('notif', json_encode([
          'title' => "BUAT USER",
          'text' => "Gagal menambahkan user baru ".$e->getMessage(),
          'type' => "error"
        ]));
      }
    }

    public function ubahpassword(Request $request)
    {
      try {
        if (Hash::check($request->passwordlama, Auth::user()->password)) {
          User::where('id',auth::user()->id)->update([
            'password' => bcrypt($request->passwordbaru),
            'remember_token' => Str::random(40)
          ]);
        }else {
          return back()->with('notif', json_encode([
            'title' => "UBAH PASSWORD",
            'text' => "Password lama tidak sesuai.",
            'type' => "error"
          ]));
        }
        return back()->with('notif', json_encode([
          'title' => "UBAH PASSWORD",
          'text' => "Berhasil mengubah password.",
          'type' => "success"
      ]));
      } catch (\Exception $e) {
        return back()->with('notif', json_encode([
          'title' => "UBAH PASSWORD",
          'text' => "Gagal mengubah password, ".$e->getMessage(),
          'type' => "error"
        ]));
      }

    }

    public function delete(Request $request)
    {
      try {
        User::where('id',$request->id)->delete();
        return back()->with('notif', json_encode([
          'title' => "HAPUS USER",
          'text' => "Berhasil menghapus user.",
          'type' => "success"
      ]));
      } catch (\Exception $e) {
        return back()->with('notif', json_encode([
          'title' => "HAPUS USER",
          'text' => "Gagal menghapus user, ".$e->getMessage(),
          'type' => "error"
        ]));
      }
    }

    public function generateuserpegawai(Request $request)
    {
      $role = $request->role;
      $j = '';
      if ($role == 1) {
        $j = 'pegawai';
      }elseif ($role == 2) {
        $j = 'guru';
      }
      $user = User::where('role',$role)->select('link');
      $pegawai = Pegawai::where('idstatus',1)->where('jenis',$request->jenispegawai)->where('email','!=',null)->wherenotin('id',$user)->get();
      if (count($pegawai) == 0) {
        return back()->with('notif', json_encode([
          'title' => "GENERATE USER",
          'text' => "Proses generate user tidak dijalankan, semua $j aktif telah memiliki user.",
          'type' => "warning"
        ]));
      }
      foreach ($pegawai as $p) {
        $username = User::where('username',$p->email)->count();
        if ($username == 0) {
          User::create([
            'username' => $p->email,
            'password' => bcrypt($p->email),
            'remember_token' => Str::random(40),
            'role' => $role,
            'link' => $p->id
          ]);
        }
      }
      return back()->with('notif', json_encode([
        'title' => "GENERATE USER",
        'text' => "Berhasil membuat user baru untuk ". count($pegawai)." $j aktif.",
        'type' => "success"
      ]));
    }

    public function generateusersiswa(Request $request)
    {
      $user = User::where('role',3)->select('link');
      $siswa = Siswa::where('idstatus',1)->wherenotin('id',$user)->get();
      if (count($siswa) == 0) {
        return back()->with('notif', json_encode([
          'title' => "GENERATE USER",
          'text' => "Proses generate user tidak dijalankan, semua siswa aktif telah memiliki user.",
          'type' => "warning"
        ]));
      }
      foreach ($siswa as $s) {
        $username = User::where('username',$s->nis)->count();
        if ($username == 0) {
          User::create([
            'username' => $s->nis,
            'password' => bcrypt($s->nis),
            'remember_token' => Str::random(40),
            'role' => 3,
            'link' => $s->id
          ]);
        }
      }
      return back()->with('notif', json_encode([
        'title' => "GENERATE USER",
        'text' => "Berhasil membuat user baru untuk ". count($siswa)." siswa aktif.",
        'type' => "success"
      ]));
    }
}
