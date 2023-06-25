<?php
namespace App\excelimport;
use App\Models\LmsMateri;
use App\Models\MdLmsJenispertemuan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Helper;
use Session;
use auth;
class unggahrps implements ToCollection
{
  public function __construct($idjadwal)
  {
    $this->idjadwal = $idjadwal;
  }

  public function collection(Collection $rows)
  {
    $no = 0;
    $pertemuan = LmsMateri::where('idjadwal',$this->idjadwal)->count();
    $j = MdLmsJenispertemuan::all();
    $j = count($j);
    $success = 0;
    foreach ($rows as $row)
    {
      if ($no > $j+4) {
        if ($row[0] != null) {
          LmsMateri::where('id',$row[0])->update([
            'idjenis' => $row[1],
            'materi'  => $row[2],
            'capaian' => $row[3],
          ]);
        }else {
          $pertemuan++;
          $idjenis = $row[1];
          if ($row[1] == '' || $row[1] == null || $row[1] == 0 || $row[1] > 4) {
            $idjenis = 1;
          }
          LmsMateri::create([
            'idjadwal' => $this->idjadwal,
            'idjenis' => $idjenis,
            'pertemuan' => $pertemuan,
            'materi' => $row[2],
            'capaian' => $row[3],
            'iduser' => auth::user()->id
          ]);
        }
      }
      $no++;
    }
  }
}
