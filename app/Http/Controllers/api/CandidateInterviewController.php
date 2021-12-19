<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewsFormRequest;
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

    public function create(ReviewsFormRequest $request)
    {
        $reviews = CandidateInterview::all();
//         foreach ($reviews as $review) {
//             if($review->user_id == Auth::user()->id && $review->candidate_id == $request->candidate_id) {
//                 return response()->json([
//                     'status'=> 440,
//                     'message'=> 'Đã đánh giá',
//                 ]);
//             }
//         }
        $model = new CandidateInterview();
        $model->fill($request->all());
        $model->user_id = Auth::user()->id;
        $model->save();
        return $model;
    }

    public function show($id)
    {        
        $reviews = CandidateInterview::find($id);
        return response()->json($reviews);
    }

    public function edit(ReviewsFormRequest $request, $id)
    {
        $model = CandidateInterview::find($id);
        $model->fill($request->all());
        $model->user_id = Auth::user()->id;
        $model->save();
        return $model;
    }

    public function remove($id)
    {
        $reviews = CandidateInterview::destroy($id);
        return $reviews;
    }
}
