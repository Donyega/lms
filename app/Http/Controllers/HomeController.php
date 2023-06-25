<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Session;
use DateTime;
use App\Helper;
use App\Models\Siswa;
use App\Models\LmsMateri;
use App\Models\LmsPenugasan;
use App\Models\MdJamPelajaran;
use App\Models\JadwalPelajaran;
use App\Models\JadwalPelajaranGuru;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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

  public function sessiontema($id)
  {
    Session::put('tema',$id);
  }

  public function index()
  {
    // return  self::publikasi();

    if (Auth::user()->role == 1) {
      return  self::admin();
    }

    if (Auth::user()->role == 2) {
      return  self::guru();
    }

    if (Auth::user()->role == 3) {
      return  self::siswa();
    }

  }

  public static function admin()
  {
    return view('admin');
  }

  public function jmlsiswa()
  {
    $data = Siswa::with('kelas')->where('idstatus',1)->where('idkelas','!=',null)->get();
    $x = 0;
    $xi = 0;
    $xii = 0;
    $labmia = 0;
    $labiis = 0;
    $regmia = 0;
    $regiis = 0;
    $xlab = 0;
    $xreg = 0;
    $xilabmia = 0;
    $xilabiis = 0;
    $xiregmia = 0;
    $xiregiis = 0;
    $xiilabmia = 0;
    $xiilabiis = 0;
    $xiiregmia = 0;
    $xiiregiis = 0;
    foreach($data as $d) {
      if($d->kelas->idtingkat == 1) {
        $x = $x + 1;
      }elseif($d->kelas->idtingkat == 2) {
        $xi = $xi + 1;
      }elseif($d->kelas->idtingkat == 3) {
        $xii = $xii + 1;
      }
      if($d->kelas->idjenis == 1 && $d->kelas->idminat == 1) {
        $labmia = $labmia + 1;
      }elseif($d->kelas->idjenis == 1 && $d->kelas->idminat == 2) {
        $labiis = $labiis + 1;
      }elseif($d->kelas->idjenis == 2 && $d->kelas->idminat == 1) {
        $regmia = $regmia + 1;
      }elseif($d->kelas->idjenis == 2 && $d->kelas->idminat == 2) {
        $regiis = $regiis + 1;
      }
      if($d->kelas->idtingkat == 1 && $d->kelas->idjenis == 1) {
        $xlab = $xlab + 1;
      }elseif($d->kelas->idtingkat == 1 && $d->kelas->idjenis == 2) {
        $xreg = $xreg + 1;
      }
      if($d->kelas->idtingkat == 2 && $d->kelas->idjenis == 1 && $d->kelas->idminat == 1) {
        $xilabmia = $xilabmia + 1;
      }elseif($d->kelas->idtingkat == 2 && $d->kelas->idjenis == 1 && $d->kelas->idminat == 2) {
        $xilabiis = $xilabiis + 1;
      }elseif($d->kelas->idtingkat == 2 && $d->kelas->idjenis == 2 && $d->kelas->idminat == 1) {
        $xiregmia = $xiregmia + 1;
      }elseif($d->kelas->idtingkat == 2 && $d->kelas->idjenis == 2 && $d->kelas->idminat == 2) {
        $xiregiis = $xiregiis + 1;
      }
      if($d->kelas->idtingkat == 3 && $d->kelas->idjenis == 1 && $d->kelas->idminat == 1) {
        $xiilabmia = $xiilabmia + 1;
      }elseif($d->kelas->idtingkat == 3 && $d->kelas->idjenis == 1 && $d->kelas->idminat == 2) {
        $xiilabiis = $xiilabiis + 1;
      }elseif($d->kelas->idtingkat == 3 && $d->kelas->idjenis == 2 && $d->kelas->idminat == 1) {
        $xiiregmia = $xiiregmia + 1;
      }elseif($d->kelas->idtingkat == 3 && $d->kelas->idjenis == 2 && $d->kelas->idminat == 2) {
        $xiiregiis = $xiiregiis + 1;
      }
    }

    $dashboard = '
    <div class="col-12">
      <div class="row match-height">
        <div class="col-lg-3">    
          <div class="card">
            <div class="card-body row mx-0 align-items-start">            
              <div class="avatar bg-light-primary p-1">
                <div class="avatar-content">
                  <i data-feather="users" class="font-medium-5"></i>
                </div>
              </div>
              <div class="col">
                <p class="card-text mb-50">Jumlah Siswa</p>
                <h2 class="font-weight-bolder text-primary my-25">'.count($data).'</h2>
              </div>
              <div class="col-12 mt-1 px-0">
                <div class="dropdown-divider mt-0"></div>
                <div class="d-flex align-items-center my-25">
                  <span class="col px-0">Laboratorium MIA</span>
                  <div class="avatar bg-primary text-right ml-50">
                    <div class="avatar-content">'.$labmia.'</div>
                  </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="d-flex align-items-center my-25">
                  <span class="col px-0">Laboratorium IIS</span>
                  <div class="avatar bg-primary text-right ml-50">
                    <div class="avatar-content">'.$labiis.'</div>
                  </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="d-flex align-items-center my-25">
                  <span class="col px-0">Reguler MIA</span>
                  <div class="avatar bg-light-primary text-right ml-50">
                    <div class="avatar-content">'.$regmia.'</div>
                  </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="d-flex align-items-center my-25">
                  <span class="col px-0">Reguler IIS</span>
                  <div class="avatar bg-light-primary text-right ml-50">
                    <div class="avatar-content">'.$regiis.'</div>
                  </div>
                </div>
                <div class="dropdown-divider"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="card">
            <div class="card-body row mx-0 align-items-start">
              <div class="avatar bg-light-success p-1">
                <div class="avatar-content">
                  <i data-feather="user-check" class="font-medium-5"></i>
                </div>
              </div>
              <div class="col">
                <p class="card-text mb-50">Siswa Kelas X</p>
                <h2 class="font-weight-bolder text-success my-25">'.$x.'</h2>
              </div>
              <div class="col-12 mt-1 px-0">
                <div class="dropdown-divider mt-0"></div>
                <div class="d-flex align-items-center my-25">
                  <span class="col px-0">X Laboratorium</span>
                  <div class="avatar bg-success text-right ml-50">
                    <div class="avatar-content">'.$xlab.'</div>
                  </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="d-flex align-items-center my-25">
                  <span class="col px-0">X Reguler</span>
                  <div class="avatar bg-light-success text-right ml-50">
                    <div class="avatar-content">'.$xreg.'</div>
                  </div>
                </div>
                <div class="dropdown-divider"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="card">
            <div class="card-body row mx-0 align-items-start">
              <div class="avatar bg-light-danger p-1">
                <div class="avatar-content">
                  <i data-feather="user-check" class="font-medium-5"></i>
                </div>
              </div>
              <div class="col">
                <p class="card-text mb-50">Siswa Kelas XI</p>
                <h2 class="font-weight-bolder text-danger my-25">'.$xi.'</h2>
              </div>
              <div class="col-12 mt-1 px-0">
                <div class="dropdown-divider mt-0"></div>
                <div class="d-flex align-items-center my-25">
                  <span class="col px-0">XI Laboratorium MIA</span>
                  <div class="avatar bg-danger text-right ml-50">
                    <div class="avatar-content">'.$xilabmia.'</div>
                  </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="d-flex align-items-center my-25">
                  <span class="col px-0">XI Laboratorium IIS</span>
                  <div class="avatar bg-danger text-right ml-50">
                    <div class="avatar-content">'.$xilabiis.'</div>
                  </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="d-flex align-items-center my-25">
                  <span class="col px-0">XI Reguler MIA</span>
                  <div class="avatar bg-light-danger text-right ml-50">
                    <div class="avatar-content">'.$xiregmia.'</div>
                  </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="d-flex align-items-center my-25">
                  <span class="col px-0">XI Reguler IIS</span>
                  <div class="avatar bg-light-danger text-right ml-50">
                    <div class="avatar-content">'.$xiregiis.'</div>
                  </div>
                </div>
                <div class="dropdown-divider"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="card">
            <div class="card-body row mx-0 align-items-start">
              <div class="avatar bg-light-info p-1">
                <div class="avatar-content">
                  <i data-feather="user-check" class="font-medium-5"></i>
                </div>
              </div>
              <div class="col">
                <p class="card-text mb-50">Siswa Kelas XII</p>
                <h2 class="font-weight-bolder text-info my-25">'.$xii.'</h2>
              </div>
              <div class="col-12 mt-1 px-0">
                <div class="dropdown-divider mt-0"></div>
                <div class="d-flex align-items-center my-25">
                  <span class="col px-0">XII Laboratorium MIA</span>
                  <div class="avatar bg-info text-right ml-50">
                    <div class="avatar-content">'.$xiilabmia.'</div>
                  </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="d-flex align-items-center my-25">
                  <span class="col px-0">XII Laboratorium IIS</span>
                  <div class="avatar bg-info text-right ml-50">
                    <div class="avatar-content">'.$xiilabiis.'</div>
                  </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="d-flex align-items-center my-25">
                  <span class="col px-0">XII Reguler MIA</span>
                  <div class="avatar bg-light-info text-right ml-50">
                    <div class="avatar-content">'.$xiiregmia.'</div>
                  </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="d-flex align-items-center my-25">
                  <span class="col px-0">XII Reguler IIS</span>
                  <div class="avatar bg-light-info text-right ml-50">
                    <div class="avatar-content">'.$xiiregiis.'</div>
                  </div>
                </div>
                <div class="dropdown-divider"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    ';
    return $dashboard;
  }

  public static function guru()
  {
    $idta = Helper::idta();
    $tanggal = date('Y-m-d');
    $idhari = date('w', strtotime($tanggal));
    $hari = Helper::haritanggal($tanggal);
    $tgl = date('Y-m-d');
    $hari = Helper::haritanggal($tgl);
    $ta = Helper::ta();
    $jadwal = JadwalPelajaranGuru::with(['jadwal','jadwalagama','jampelajaran'])
              ->where('idguru', Auth::user()->link)->get();
    return view('guru', compact('jadwal'));
  }

  public static function siswa()
  {
    $ta = Helper::ta();
    $idta = $ta->id;
    $data = Siswa::with('kelas')->where('id', Auth::user()->link)->first();
    $jadwal = JadwalPelajaran::with(['hari','detil.jampelajaran','mapel'])->where('idta', $idta)->where('idkelas', $data->idkelas)->get();
    $jam = MdJamPelajaran::all();
    return view('siswa', compact('ta','data','jadwal','jam'));
  }

}
