<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\CandidateInterview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateInterviewController extends Controller
{
    public function list()
    {
        $reviews = CandidateInterview::all();
        return response()->json($reviews);
    }

    public function create(Request $request)
    {
        $model = new CandidateInterview();
        $model->fill($request->all());
        $model->user_id = Auth::user()->id;
        $model->save();
        return redirect(route('reviews'));
    }

    public function show($id)
    {        
        $reviews = CandidateInterview::find($id);
        return response()->json($reviews);
    }

    public function edit(Request $request, $id)
    {
        $model = CandidateInterview::find($id);
        $model->fill($request->all());
        $model->user_id = Auth::user()->id;
        $model->save();
        return redirect(route('reviews'));
    }

    public function remove($id)
    {
        CandidateInterview::destroy($id);
        return redirect(route('reviews'));
    }
}
