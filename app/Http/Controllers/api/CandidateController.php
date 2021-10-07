<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;
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
        $candidate = Candidate::create($request->all());        
        return response()->json($candidate);
    }

    public function edit(Request $request, $id)
    {
        Candidate::find($id)->update($request->all());
        return redirect(route('candidate'));
    }

    public function remove($id)
    {
        Candidate::destroy($id);
        return redirect(route('candidate'));
    }
}
