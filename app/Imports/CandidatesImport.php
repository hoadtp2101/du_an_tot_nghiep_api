<?php

namespace App\Imports;

use App\Models\Candidate;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing as WorksheetDrawing;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

class CandidatesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $spreadsheet = IOFactory::load(request()->file('import'));
        $i = 0;
        foreach ($spreadsheet->getActiveSheet()->getDrawingCollection() as $drawing) {
            if ($drawing instanceof MemoryDrawing) {
                ob_start();
                call_user_func(
                    $drawing->getRenderingFunction(),
                    $drawing->getImageResource()
                );
                $imageContents = ob_get_contents();
                ob_end_clean();
                switch ($drawing->getMimeType()) {
                    case MemoryDrawing::MIMETYPE_PNG:
                        $extension = 'png';
                        break;
                    case MemoryDrawing::MIMETYPE_GIF:
                        $extension = 'gif';
                        break;
                    case MemoryDrawing::MIMETYPE_JPEG:
                        $extension = 'jpg';
                        break;
                }
            } else if ($drawing instanceof WorksheetDrawing) {
                $zipReader = fopen($drawing->getPath(), 'r');
                $imageContents = '';
                while (!feof($zipReader)) {
                    $imageContents .= fread($zipReader, 1024);
                }
                fclose($zipReader);
                $extension = $drawing->getExtension();
            }
            $myFileName = time() . ++$i . '.' . $extension;
            file_put_contents('storage/images/candidate/' . $myFileName, $imageContents);
            $img = [
                'image' => $myFileName
              ];
        }
        Candidate::create([
            'name'       => $row['name'],
            'image'      => $img,
            'phone'      => $row['phone'],
            'source'     => $row['source'],
            'experience' => $row['experience'],
            'school'     => $row['school'],
            'cv'         => $row['cv'],
            'job_id'     => $row['job_id'],
            'status'     => $row['status'],
        ]);
        // $candidate = Candidate::create([
        //     'name'       => $row['name'],
        //     'image'      => $row['image'],
        //     'phone'      => $row['phone'],
        //     'source'     => $row['source'],
        //     'experience' => $row['experience'],
        //     'school'     => $row['school'],
        //     'cv'         => $row['cv'],
        //     'job_id'     => $row['job_id'],
        //     'status'     => $row['status'],
        // ]);
        // return $candidate;


    }

    public function headingRow(): int
    {
        return 1;
    }
}
