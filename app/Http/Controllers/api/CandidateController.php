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

    public function listid($id)
    {
        $candidate = Candidate::find($id);
        return response()->json($candidate);
    }

    public function create(Request $request)
    {
        $candidate = new Candidate();
        $candidate->fill($request->all());
        $candidate->save();
        return response()->json($candidate);
    }

    public function edit(Request $request, $id)
    {
        
    }

    public function remove($id)
    {
        Candidate::destroy($id);
        return redirect(route('candidate'));
    }
}
