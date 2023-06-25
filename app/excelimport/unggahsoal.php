<?php
namespace App\excelimport;
use App\Models\LmsEvaluasiSoal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Helper;
use Session;
use auth;
class unggahsoal implements ToCollection
{
  public function __construct($idmapel,$idjenis)
  {
    $this->idmapel = $idmapel;
    $this->idjenis = $idjenis;
  }

  public function collection(Collection $rows)
  {
    $no = 0;
    $success = 0;
    foreach ($rows as $row)
    {
      if ($no > 4 && $row[0] != '') {
        LmsEvaluasiSoal::create([
          'idmapel' => $this->idmapel,
          'idjenis' => $this->idjenis,
          'kode' => $row[0],
          'soal' => $row[1],
          'idguru' => auth::user()->link
        ]);
      }
      $no++;
    }
  }
}
