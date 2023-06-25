<?php

namespace App;
use App\Models\MdHari;
use App\Models\MdBulan;
use App\Models\MdKurikulum;
use App\Models\TagihanSiswa;
use App\Models\Ta;
use Illuminate\Support\Facades\Http;
use DateTime;
use auth;
class Helper
{

  public static function idta()
  {
    $idta = Ta::where('isAktif',1)->pluck('id')->first();
    return $idta;
  }

  public static function idkurikulum()
  {
    $idkurikulum = MdKurikulum::where('status',1)->pluck('id')->first();
    return $idkurikulum;
  }

  public static function ta()
  {
    $ta = Ta::where('isAktif',1)->first();
    return $ta;
  }

  public static function tunggakan($nis)
  {
    $tunggakan = TagihanSiswa::where('nis',$nis)->sum('sisa');
    return $tunggakan;
  }

  public static function tanggal($tgl)
  {
    if ($tgl == null) {
      return '';
    }
    $bulan = date('n',strtotime($tgl));
    $b = MdBulan::where('id',$bulan)->pluck('nama')->first();
    $t = date('j',strtotime($tgl));
    $ta = date('Y',strtotime($tgl));
    return $t.' '.$b.' '.$ta;
  }

  public static function bulan($bulan)
  {
      if ($bulan == null) {
          return '';
      }
      $bulan = date('n', strtotime($bulan));
      $b = MdBulan::where('id', $bulan)->pluck('nama')->first();
      return $b;
  }

  public static function haritanggal($tgl)
  {
    if ($tgl == null) {
      return '';
    }
    $hari = date('w',strtotime($tgl));
    $bulan = date('n',strtotime($tgl));
    $h = MdHari::where('id',$hari)->pluck('nama')->first();
    $b = MdBulan::where('id',$bulan)->pluck('nama')->first();
    $t = date('j',strtotime($tgl));
    $ta = date('Y',strtotime($tgl));
    return $h.', '.$t.' '.$b.' '.$ta;
  }

  public static function periodeabsen($tgl)
  {
    if ($tgl == null) {
      return '';
    }
    $bulan = date('n',strtotime($tgl));
    $b = MdBulan::where('id',$bulan)->pluck('nama')->first();
    $ta = date('Y',strtotime($tgl));
    return $b.' '.$ta;
  }

  public static function lamamengajar($data)
  {
    if ($data == '') {
      return 'Belum ditentukan';
    }
    $date1 = new DateTime($data);
    $date2 = new DateTime(date('Y-n-d'));
    $diff  = $date1->diff($date2);
    if ($diff->format('%y') == 0) {
      $lama = $diff->format('%m').' Bulan';
    }else {
      $lama = $diff->format('%y').' Tahun '.$diff->format('%m').' Bulan';
    }

    return $lama;
  }

  public static function romawi($number)
  {
    $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    $returnValue = '';
    while ($number > 0) {
      foreach ($map as $roman => $int) {
        if($number >= $int) {
          $number -= $int;
          $returnValue .= $roman;
          break;
        }
      }
    }
    return $returnValue;
  }

  public static function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = self::penyebut($nilai - 10). " Belas";
		} else if ($nilai < 100) {
			$temp = self::penyebut($nilai/10)." Puluh". self::penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " Seratus" . self::penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = self::penyebut($nilai/100) . " Ratus" . self::penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " Seribu" . self::penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = self::penyebut($nilai/1000) . " Ribu" . self::penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = self::penyebut($nilai/1000000) . " Juta" . self::penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = self::penyebut($nilai/1000000000) . " Milyar" . self::penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = self::penyebut($nilai/1000000000000) . " Trilyun" . self::penyebut(fmod($nilai,1000000000000));
		}
		return $temp;
	}

	public static function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(self::penyebut($nilai));
		} else {
			$hasil = trim(self::penyebut($nilai));
		}
		return $hasil;
	}

}
