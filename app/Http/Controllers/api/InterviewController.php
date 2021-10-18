<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Models\JobRequest;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function list()
    {
        $interview = Interview::all();
        return response()->json($interview);
    }

    public function create(Request $request)
    {
        $job = JobRequest::all();
        $interview = Interview::create($request->all());       
        return redirect(route('interview'));
    }

    public function edit(Request $request, $id)
    {
        $job = JobRequest::all();
        Interview::find($id)->update($request->all());
        return redirect(route('interview'));
    }

    public function remove($id)
    {
        Interview::destroy($id);
        return redirect(route('interview'));
    }
}
