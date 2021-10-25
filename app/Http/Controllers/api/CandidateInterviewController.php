<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\CandidateInterview;
use Illuminate\Http\Request;

class CandidateInterviewController extends Controller
{
    public function list()
    {
        $judge = CandidateInterview::all();
        return response()->json($judge);
    }

    public function create(Request $request)
    {
        
        $judge = CandidateInterview::all();
        return response()->json($judge);
    }
}
