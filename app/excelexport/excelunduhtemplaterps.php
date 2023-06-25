<?php
namespace App\excelexport;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Illuminate\Console\Command;
use auth;
class excelunduhtemplaterps extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromView, WithColumnFormatting, ShouldAutoSize, WithCustomValueBinder
{
  use Exportable;

    public function __construct($data,$pertemuan,$rps)
    {
        $this->data = $data;
        $this->pertemuan = $pertemuan;
        $this->rps = $rps;
    }

    public function view(): View
    {
      $data = $this->data;
      $pertemuan = $this->pertemuan;
      $rps = $this->rps;
      return view('guru.pembelajaran.templaterps',compact('data','pertemuan','rps'));
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            // 'H' => NumberFormat::FORMAT_TEXT,
            // 'I' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function handle()
    {
        $this->output->title('Starting import');
        (new view)->withOutput($this->output)->import('users.xlsx');
        $this->output->success('Import successful');
    }
}
