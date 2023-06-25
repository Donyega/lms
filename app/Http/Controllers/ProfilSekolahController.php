<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Profil;
;
use App\Helper;
use auth;
use DataTables;
use DateTime;
use Session;
class ProfilSekolahController extends Controller
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

  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Contracts\Support\Renderable
  */
  public function index() {
    $data = Profil::where('id',1)->first();
    $favicon = Profil::where('id',1)->first();
    $logo = Profil::where('id',1)->first();
    return view('pengaturan.profilsekolah.index', compact('data', 'favicon', 'logo'));
  }

  public function store(Request $request)
  {
    try {
      
      if ($request->file('favicon') != null) {
        $favicon = $request->file('favicon')->store('pengaturan');
      }
      if ($request->file('logo') != null) {
        $logo = $request->file('logo')->store('pengaturan');
      }

      $cek = Profil::where('id',$request->id)->first();
      if ($cek == null) {
        Profil::create($request->all());
      }else {
        Profil::where('id',$request->id)->update($request->except('id','_token'));
      }

      return back()->with('notif', json_encode([
        'title' => "PROFIL SEKOLAH",
        'text' => "Berhasil memperbarui profil sekolah.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PROFIL SEKOLAH",
        'text' => "Gagal memperbarui profil sekolah, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

  public function favicon(Request $request)
  {
    try {
      $detil = Profil::find(1);
      $favicon = $detil->favicon;
      if ($request->file('favicon') != null) {
          $favicon = $request->file('favicon')->store('pengaturan/gambar');
      }
      
      Profil::where('id',$request->id)->update([
        'favicon' => $favicon,
      ]);

      return back()->with('notif', json_encode([
        'title' => "PROFIL SEKOLAH",
        'text' => "Berhasil memperbarui favicon.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PROFIL SEKOLAH",
        'text' => "Gagal memperbarui favicon, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }
  
  public function logo(Request $request)
  {
    try {
      $detil = Profil::find(1);
      $logo = $detil->logo;
      if ($request->file('logo') != null) {
          $logo = $request->file('logo')->store('pengaturan/gambar');
      }
      
      Profil::where('id',$request->id)->update([
        'logo' => $logo,
      ]);

      return back()->with('notif', json_encode([
        'title' => "PROFIL SEKOLAH",
        'text' => "Berhasil memperbarui logo.",
        'type' => "success"
      ]));
    } catch (\Exception $e) {
      return back()->with('notif', json_encode([
        'title' => "PROFIL SEKOLAH",
        'text' => "Gagal memperbarui logo, ".$e->getMessage(),
        'type' => "error"
      ]));
    }
  }

}
