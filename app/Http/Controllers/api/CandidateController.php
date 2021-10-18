<?php

namespace App\Http\Controllers\api;

use App\Exports\CandidateImageExport;
use App\Exports\CandidatesExport;
use App\Http\Controllers\Controller;
use App\Imports\CandidatesImport;
use App\Models\Candidate;
use App\Models\JobRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Prophecy\Call\Call;

class CandidateController extends Controller
{
    public function list()
    {
        $candidate = Candidate::all();
        return response()->json($candidate);
    }

    public function create(Request $request)
    {
        $job = JobRequest::all();
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
            $model->cv = $newFileName;
        }
        $model->save();
        return redirect(route('candidate'));
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
            $model->cv = $newFileName;
        }
        $model->save();
        return redirect(route('candidate'));
    }

    public function remove($id)
    {
        Candidate::destroy($id);
        return redirect(route('candidate'));
    }

    public function export()
    {
        $candidate = Candidate::all();
        return Excel::download(new CandidatesExport($candidate), 'candidates.xlsx');
    }

    public function import(Request $request)
    {
        Excel::import(new CandidatesImport, $request->file('import')->store('import'));
        return back();
    }
}
