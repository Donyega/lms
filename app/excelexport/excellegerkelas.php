<?php
namespace App\excelexport;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Illuminate\Console\Command;
use auth;
class excellegerkelas extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromView, ShouldAutoSize, WithCustomValueBinder
{
  use Exportable;

    public function __construct($ta,$semester,$kelas,$maping,$siswa,$nilai)
    {
        $this->ta = $ta;
        $this->semester = $semester;
        $this->kelas = $kelas;
        $this->maping = $maping;
        $this->siswa = $siswa;
        $this->nilai = $nilai;
    }

    public function view(): View
    {
      $ta = $this->ta;
      $semester = $this->semester;
      $kelas = $this->kelas;
      $maping = $this->maping;
      $siswa = $this->siswa;
      $nilai = $this->nilai;
      return view('akademik.rapor.legerkelas', compact('ta','semester','kelas','maping','siswa','nilai'));
    }

    public function handle()
    {
        $this->output->title('Starting import');
        (new view)->withOutput($this->output)->import('users.xlsx');
        $this->output->success('Import successful');
    }
}
