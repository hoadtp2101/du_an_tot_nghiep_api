<?php

namespace App\Exports;

use App\Models\Candidate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;


class CandidatesExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Image',
            'Phone',
            'Source',
            'Experience',
            'School',
            'CV',
            'Job_id',
            'Status',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $candidate = Candidate::all();

                //Freeze frist row
                $event->sheet->freezePane('A2', 'A2');
                $event->sheet->getStyle('A1:I1')->ApplyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => '14',
                    ]
                ]);
                $event->sheet->getStyle('G2:G' . count($candidate))->ApplyFromArray([
                    'font' => [
                        'color' => ['rgb' => '0000FF'],
                        'underline' => 'single'
                    ]
                ]);

                $columnindex = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I');                

                //Set row height
                for ($i = 0; $i < count($candidate); $i++) //iterate based on row count
                {
                    $event->sheet->getRowDimension($i + 2)->setRowHeight(60);
                }

                for ($i = 0; $i < count($columnindex); $i++) //iterate based on column count
                {
                    if ($i == 1) // Exception for image column, if there are images
                        $event->sheet->getColumnDimension('B')->setWidth(17);
                    else
                        $event->sheet->getColumnDimension($columnindex[$i])->setAutoSize(true);
                }

                $loop = 2;
                foreach ($candidate as $candidate) {
                    $drawing = new Drawing();
                    $drawing->setName('image');
                    $drawing->setDescription('image');
                    $drawing->setPath(public_path('storage/images/candidate/' . $candidate->image));
                    $drawing->setHeight(70);
                    $drawing->setOffsetX(5);
                    $drawing->setOffsetY(5);
                    $drawing->setCoordinates('B' . $loop);
                    $drawing->setWorksheet($event->sheet->getDelegate());

                    $event->sheet->getCell('G' . $loop)
                        ->getHyperlink()
                        ->setUrl($candidate->cv);
                    $loop++;
                }
            }
        ];
    }

    public function map($candidate): array
    {
        return [
            $candidate->name,
            '',
            $candidate->phone,
            $candidate->source,
            $candidate->experience,
            $candidate->school,
            'link CV',
            $candidate->job_id,
            $candidate->status,
        ];
    }

    public function collection()
    {
        return collect($this->data);
    }
}
