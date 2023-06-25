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
class excelsiswa extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromView, WithColumnFormatting, ShouldAutoSize, WithCustomValueBinder
{
  use Exportable;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
      $data = $this->data;
      return view('masterdata.siswa.excel', compact('data'));
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
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
