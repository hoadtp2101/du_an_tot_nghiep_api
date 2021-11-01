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
            foreach ($job as $j) {
                $j->deadline = date("d-m-Y", strtotime($j->deadline));
            }
            return response()->json($job);
        } else if (Auth::check() && Auth::user()->status == 0) {
            $job = JobRequest::all();
            foreach ($job as $j) {
                $j->deadline = date("d-m-Y", strtotime($j->deadline));
            }
            return response()->json($job);
        } else {
            return response()->json(['message' => 'Chua dang nhap']);
        }
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

    public function approve(Request $request, $id)
    {
        JobRequest::find($id)->update($request->all());
        return redirect(route('jobrequest'));
    }
}
