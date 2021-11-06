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
        if (Auth::check() && Auth::user()->status != 0) {
            $job = JobRequest::where('status', 'like', '0')->get();            
            return response()->json($job);
        } else if (Auth::check() && Auth::user()->status == 0) {
            $job = JobRequest::all();            
            return response()->json($job);
        } else {
            return response()->json(['message' => 'Chua dang nhap']);
        }
    }

    public function create(Request $request)
    {
        $jobrequest = JobRequest::create($request->all());
        return $jobrequest;
    }

    public function edit(Request $request, $id)
    {
        $jobrequest = JobRequest::find($id)->update($request->all());
        return $jobrequest;
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
