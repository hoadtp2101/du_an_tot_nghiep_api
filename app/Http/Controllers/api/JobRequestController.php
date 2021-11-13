<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Interview;
use App\Models\JobRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobRequestController extends Controller
{
    public function list()
    {
        $job = JobRequest::with('petitioner:id,name')->get();
        return response()->json($job);
    }

    public function show($id)
    {
        $job = JobRequest::with('petitioner:id,name')->find($id);
        return response()->json($job);
    }

    public function create(Request $request)
    {
        $model = new JobRequest();
        $model->fill($request->all());
        $model->petitioner = Auth::user()->id;
        $model->save();
        return $model;
    }

    public function update(Request $request, JobRequest $jobRequest)
    {
        $model = JobRequest::find($jobRequest->id);
        $model->fill($request->all());
        $model->petitioner = Auth::user()->id;
        $model->save();
        return $model;
    }

    public function remove($id)
    {
        Candidate::where('job_id', 'like', $id)->delete();
        Interview::where('job_id', 'like', $id)->delete();
        $jobrequest = JobRequest::destroy($id);
        return $jobrequest;
    }

    public function approve(Request $request, $id)
    {
        $jobrequest = JobRequest::find($id)->update($request->all());
        return $jobrequest;
    }
}
