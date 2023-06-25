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
class excelunduhtemplatesoaljawaban extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromView, WithColumnFormatting, ShouldAutoSize, WithCustomValueBinder
{
  use Exportable;

    public function __construct($data,$jenis)
    {
        $this->data = $data;
        $this->jenis = $jenis;
    }

    public function view(): View
    {
      $evaluasi = $this->data;
      if($this->jenis == 1){
        return view('guru.pembelajaran.templatesoal',compact('evaluasi'));
      }else{
        return view('guru.pembelajaran.templatejawaban',compact('evaluasi'));
      }
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
