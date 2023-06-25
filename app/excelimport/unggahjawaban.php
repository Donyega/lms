<?php
namespace App\excelimport;
use App\Models\LmsEvaluasiJawaban;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Helper;
use Session;
use auth;
class unggahjawaban implements ToCollection
{
  public function __construct($idevaluasi,$idjenis)
  {
    $this->idevaluasi = $idevaluasi;
    $this->idjenis = $idjenis;
  }

  public function collection(Collection $rows)
  {
    $no = 0;
    $success = 0;
    foreach ($rows as $row)
    {
      if ($no > 4 && $row[0] != '') {
        LmsEvaluasiJawaban::create([
          'idevaluasi' => $this->idevaluasi,
          'idjenis' => $this->idjenis,
          'kode' => $row[0],
          'jawaban' => $row[1],
          'benar' => $row[2]
        ]);
      }
      $no++;
    }
  }
}
