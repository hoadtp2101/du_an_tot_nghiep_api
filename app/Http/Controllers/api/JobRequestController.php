<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Interview;
use App\Models\JobRequest;
use Illuminate\Http\Request;

class JobRequestController extends Controller
{
    public function list()
    {
        $job = JobRequest::all();
        return response()->json($job);
    }

    public function create(Request $request)
    {
        JobRequest::create($request->all());
        return redirect(route('jobrequest'));
    }

    public function edit(Request $request, $id)
    {
        JobRequest::find($id)->update($request->all());
        return redirect(route('jobrequest'));
    }
    
    public function remove($id)
    {
        Candidate::where('job_id', 'like', $id)->delete();
        Interview::where('job_id', 'like', $id)->delete();
        JobRequest::destroy($id);
        return redirect(route('jobrequest'));
    }

    public function approve($id, Request $request)
    {
        JobRequest::find($id)->update($request->all());
    }
}
