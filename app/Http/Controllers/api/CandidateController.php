<?php

namespace App\Http\Controllers\api;

use App\Exports\CandidatesExport;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\CandidateInterview;
use App\Models\Interview;
use App\Models\JobRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing as WorksheetDrawing;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

class CandidateController extends Controller
{
    public function list()
    {
        $candidate = Candidate::all();
        return response()->json($candidate);
    }

    public function create(Request $request)
    {        
        $model = new Candidate();
        $model->fill($request->all());
        if ($request->hasFile('image')) {
            $newFileName = uniqid() . '-' . $request->image->getClientOriginalName();
            $path = $request->image->storeAs('public/images/candidate', $newFileName);
            $model->image = $newFileName;
        }
        if ($request->hasFile('cv')) {
            $newFileName = uniqid() . '-' . $request->cv->getClientOriginalName();
            $path = $request->cv->storeAs('public/cv', $newFileName);           
            $model->cv = "http://127.0.0.1:8000/storage/cv/" . $newFileName;
        }
        $model->save();
        return $model;
    }

    public function edit(Request $request, $id)
    {
        $job = JobRequest::all();
        $model = Candidate::find($id);
        $model->fill($request->all());
        if ($request->hasFile('image')) {
            $newFileName = uniqid() . '-' . $request->image->getClientOriginalName();
            $path = $request->image->storeAs('public/images/candidate', $newFileName);
            $model->image = $newFileName;
        }
        if ($request->hasFile('cv')) {
            $newFileName = uniqid() . '-' . $request->cv->getClientOriginalName();
            $path = $request->cv->storeAs('public/cv', $newFileName);
            $model->cv = "http://127.0.0.1:8000/storage/cv/" . $newFileName;
        }
        $model->save();
        return $model;
    }

    public function remove($id)
    {
        $interview = Interview::where('name_candidate', 'like', $id)->get();        
        foreach($interview as $i){            
            CandidateInterview::where('interview_id', 'like', $i->id)->delete();
        }        
        Interview::where('name_candidate', 'like', $id)->delete();        
        Candidate::where('job_id', 'like', $id)->delete();
        $candidate = Candidate::destroy($id);        
        return $candidate;
    }

    public function export()
    {
        $candidate = Candidate::all();
        return Excel::download(new CandidatesExport($candidate), 'candidates.xlsx');
    }

    public function import(Request $request)
    {
        $spreadsheet = IOFactory::load($request->file('import'));
        $sheet = $spreadsheet->setActiveSheetIndex(0);
        $i = 0;
        foreach ($sheet->getDrawingCollection() as $drawing) {
            if ($drawing instanceof MemoryDrawing) {
                ob_start();
                call_user_func(
                    $drawing->getRenderingFunction(),
                    $drawing->getImageResource()
                );
                $imageContents = ob_get_contents();
                ob_end_clean();
            } else if ($drawing instanceof WorksheetDrawing) {
                $zipReader = fopen($drawing->getPath(), 'r');
                $imageContents = '';
                while (!feof($zipReader)) {
                    $imageContents .= fread($zipReader, 1024);
                }
                fclose($zipReader);
                $extension = $drawing->getExtension();
            }
            $myFileName = time() . $i . '.' . $extension;
            file_put_contents('storage/images/candidate/' . $myFileName, $imageContents);   
            $arr[$i] = ([
                'name'       => $sheet->getCellByColumnAndRow(1, ($i + 2))->getValue(),
                'image'      => $myFileName,
                'email'      => $sheet->getCellByColumnAndRow(3, ($i + 2))->getValue(),
                'phone'      => $sheet->getCellByColumnAndRow(4, ($i + 2))->getValue(),
                'source'     => $sheet->getCellByColumnAndRow(5, ($i + 2))->getValue(),
                'experience' => $sheet->getCellByColumnAndRow(6, ($i + 2))->getValue(),
                'school'     => $sheet->getCellByColumnAndRow(7, ($i + 2))->getValue(),
                'cv'         => $sheet->getCellByColumnAndRow(8, ($i + 2))->getValue(),
                'job_id'     => $sheet->getCellByColumnAndRow(9, ($i + 2))->getValue(),
                'status'     => $sheet->getCellByColumnAndRow(10, ($i + 2))->getValue(),
                'created_at'     => date('Y-m-d'),
            ]);
            $i++;
        }
        Candidate::insert($arr);
        return back();
    }
}
