<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewsFormRequest;
use App\Models\Candidate;
use App\Models\CandidateInterview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CandidateInterviewController extends Controller
{
    public function list()
    {
        $reviews = CandidateInterview::orderBy('updated_at', 'desc')->get();
        return response()->json($reviews);
    }


    public function show($id)
    {
        $reviews = CandidateInterview::find($id);
        return response()->json($reviews);
    }

    public function create(ReviewsFormRequest $request)
    {
        try {
            DB::beginTransaction();
            $reviews = CandidateInterview::all();
            foreach ($reviews as $review) {
                if($review->user_id == Auth::user()->id && $review->candidate_id == $request->candidate_id) {
                    return response()->json([
                        'status'=> 440,
                        'message'=> 'Đã đánh giá',
                    ]);
                }
            }
            $candidate = Candidate::where('id', $request->candidate_id)->fisrt();
            if($request->result == 'Fail'){
                if($candidate){
                    $candidate->update(['status' => Candidate::STATUS_FAIL]);
                }
            } else if($request->result == 'Pass'){
                if($candidate){
                    $candidate->update(['status' => Candidate::STATUS_ROUND_PASS]);
                }
            } else {
                if($candidate){
                    $status = $candidate->status == Candidate::STATUS_ROUND_PASS ? Candidate::STATUS_ROUND_PASS : $candidate->status++;
                    $candidate->update(['status' => $status]);
                }
            }

            $model = new CandidateInterview();
            $model->fill($request->all());
            $model->user_id = Auth::user()->id;
            $model->save();

            DB::commit();
            return $model;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            abort(400, $exception->getMessage());
        }

    }

    public function edit(ReviewsFormRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $candidate = Candidate::where('id', $request->candidate_id)->fisrt();
            if($request->result == 'Fail'){
                if($candidate){
                    $candidate->update(['status' => Candidate::STATUS_FAIL]);
                }
            } else if($request->result == 'Pass'){
                if($candidate){
                    $candidate->update(['status' => Candidate::STATUS_ROUND_PASS]);
                }
            } else {
                if($candidate){
                    $status = $candidate->status == Candidate::STATUS_ROUND_PASS ? Candidate::STATUS_ROUND_PASS : $candidate->status++;
                    $candidate->update(['status' => $status]);
                }
            }

            $model = CandidateInterview::find($id);
            $model->fill($request->all());
            $model->user_id = Auth::user()->id;
            $model->save();
            return $model;

            DB::commit();
            return $model;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            abort(400, $exception->getMessage());
        }
        
    }

    public function remove($id)
    {
        $reviews = CandidateInterview::destroy($id);
        return $reviews;
    }
}
