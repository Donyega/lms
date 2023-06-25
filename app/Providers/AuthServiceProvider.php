<?php

namespace App\Providers;
use App\Helper;
use App\Models\Ta;
use App\Models\MdKelas;
use App\Models\RiwayatPejabat;
use App\Models\JadwalPelajaran;
use App\Models\RiwayatPembinaEkskul;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
  /**
  * The policy mappings for the application.
  *
  * @var array
  */
  protected $policies = [
    // 'App\Model' => 'App\Policies\ModelPolicy',
  ];

  /**
  * Register any authentication / authorization services.
  *
  * @return void
  */
  public function boot()
  {
    $this->registerPolicies();
    $idta = Helper::idta();

    Gate::define('pegawai', function ($user) {
      if (Auth::user()->role == 1) {
        return true;
      }
    });

    Gate::define('guru', function ($user) {
      if (Auth::user()->role == 2) {
        return true;
      }
    });

    Gate::define('siswa', function ($user) {
      if (Auth::user()->role == 3) {
        return true;
      }
    });

    Gate::define('adminakademik', function ($user) {
      $cekktu = RiwayatPejabat::where('idjabatan',6)->where('status',1)->where('idpegawai',Auth::user()->link)->first();
      if ($cekktu != null) {
        return true;
      }

      if (Auth::user()->admin != null) {
        if (in_array(Auth::user()->admin->roleadmin,[1])) {
          return true;
        }
      }
    });

    Gate::define('superadmin', function ($user) {
      if (Auth::user()->admin != null) {
        if (Auth::user()->admin->roleadmin == 3) {
          return true;
        }
      }
    });

    Gate::define('masterdata', function ($user) {
      if (Auth::user()->role == 1) {
        $cek = RiwayatPejabat::where('idjabatan',6)->where('status',1)->where('idpegawai',Auth::user()->link)->first();
        if ($cek != null) {
          return true;
        }
      }
      
      if (Auth::user()->admin != null) {
        if (in_array(Auth::user()->admin->roleadmin,[1])) {
          return true;
        }
      }
    });
    

    Gate::define('akademik', function ($user) {
      if (Auth::user()->role == 1) {
        $cek = RiwayatPejabat::where('idjabatan',6)->where('status',1)->where('idpegawai',Auth::user()->link)->first();
        if ($cek != null) {
          return true;
        }
      }

      if (Auth::user()->role == 2) {
        $cek = RiwayatPejabat::wherein('idjabatan',[1,2,3,4,5])->where('status',1)->where('idpegawai',Auth::user()->link)->first();
        if ($cek != null) {
          return true;
        }
      }
      
      if (Auth::user()->admin != null) {
        if (Auth::user()->admin->roleadmin == 1) {
          return true;
        }
      }
    });

    Gate::define('pengajaran', function ($user) {
      $idta = Helper::idta();
      if (Auth::user()->role == 1) {
        $cek = RiwayatPejabat::where('idjabatan',6)->where('status',1)->where('idpegawai',Auth::user()->link)->first();
        if ($cek != null) {
          return true;
        }
      }

      if (Auth::user()->role == 2) {
        $cekpejabat = RiwayatPejabat::wherein('idjabatan',[1,2,3,4,5])->where('status',1)->where('idpegawai',Auth::user()->link)->first();
        if ($cekpejabat != null) {
          return true;
        }
      }
      
      if (Auth::user()->admin != null) {
        if (in_array(Auth::user()->admin->roleadmin,[1])) {
          return true;
        }
      }
    });

    Gate::define('pengumuman', function ($user) {
      $cek = RiwayatPejabat::wherein('idjabatan',[1,2,3,4,5,6])->where('status',1)->where('idpegawai',Auth::user()->link)->first();
      if ($cek != null) {
        return true;
      }
      
      if (Auth::user()->admin != null) {
        if (in_array(Auth::user()->admin->roleadmin,[1,3,4])) {
          return true;
        }
      }
    });

    Gate::define('laporan', function ($user) {
      if (Auth::user()->role == 1) {
        $cek = RiwayatPejabat::where('idjabatan',6)->where('status',1)->where('idpegawai',Auth::user()->link)->first();
        if ($cek != null) {
          return true;
        }
      }

      if (Auth::user()->role == 2) {
        $cek = RiwayatPejabat::wherein('idjabatan',[1,2,3,4,5])->where('status',1)->where('idpegawai',Auth::user()->link)->first();
        if ($cek != null) {
          return true;
        }
      }

      if (Auth::user()->admin != null) {
        if (in_array(Auth::user()->admin->roleadmin,[1])) {
          return true;
        }
      }
    });

    Gate::define('statistik', function ($user) {
      if (Auth::user()->role == 1) {
        $cek = RiwayatPejabat::where('idjabatan',6)->where('status',1)->where('idpegawai',Auth::user()->link)->first();
        if ($cek != null) {
          return true;
        }
      }

      if (Auth::user()->role == 2) {
        $cek = RiwayatPejabat::wherein('idjabatan',[1,2,3,4,5])->where('status',1)->where('idpegawai',Auth::user()->link)->first();
        if ($cek != null) {
          return true;
        }
      }

      if (Auth::user()->admin != null) {
        if (in_array(Auth::user()->admin->roleadmin,[1])) {
          return true;
        }
      }
    });
  }
}
