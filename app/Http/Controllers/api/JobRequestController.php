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
        $data = array_merge($request->all(), ['status' => '0', 'petitioner' => Auth::id()]);
        return JobRequest::create($data);
    }

    public function update(Request $request, JobRequest $jobRequest)
    {
        $model = JobRequest::find($jobRequest->id);
        $model->fill($request->except('status'));
        $model->save();
        return $model;
    }

    public function remove(JobRequest $jobRequest)
    {
        Candidate::where('job_id', $jobRequest->id)->delete();
        Interview::where('job_id', $jobRequest->id)->delete();
        $jobrequest = JobRequest::destroy($jobRequest->id);
        return $jobrequest;
    }

    public function approve(Request $request, JobRequest $jobRequest)
    {
        $jobrequest = $jobRequest->update(['status' => $request->status]);
        return response()->json('successful_status_change', 200);
    }
}
