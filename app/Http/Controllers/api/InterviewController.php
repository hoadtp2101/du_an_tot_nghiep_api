<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\sendCandidate;
use App\Mail\sendMail;
use App\Models\Candidate;
use App\Models\Interview;
use App\Models\JobRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InterviewController extends Controller
{
    public function index()
    {
        $interview = Interview::all();
        return $interview;
    }

    public function store(Request $request)
    {        
        $toMail = explode(',', $request->receiver);
        $user = [];
        foreach ($toMail as $key => $mail) {
            $u = User::where('email', 'like', $mail)->get();
            foreach ($u as $value) {
                $user[$key] = $value->name;
            }
        }
        $job = JobRequest::find($request->job_id);
        $candidate_id = explode(',', $request->name_candidate);
        $candidates = [];
        foreach ($candidate_id as $key => $value) {
            $u = Candidate::find($value);
            $candidates[$key] = $u->name;    
            $senditem = new \stdClass();
            $senditem->name = $u->name;
            $senditem->position = $job->position;
            $senditem->location = $request->location;
            $senditem->time_start = $request->time_start;
            $senditem->time_end = $request->time_end;
            Mail::to($u->email)->send(new sendCandidate($senditem, $request->title));     
            $model = new Interview();
            $model->fill($request->all());
            $model->name_candidate = $value;
            $model->save();
        }
       
        foreach ($user as $key => $user) {
            $senditem = new \stdClass();
            $senditem->receiver = $user;
            $senditem->name = implode(', ', $candidates);
            $senditem->position = $job->position;
            $senditem->location = $request->location;
            $senditem->job = $job->title;
            $senditem->time_start = $request->time_start;
            $senditem->time_end = $request->time_end;
            Mail::to($toMail[$key])->send(new sendMail($senditem, $request->title));
        }
    }

    public function show(Interview $interview)
    {
        return $interview;
    }

    public function update(Request $request, Interview $interview)
    {
        return $interview->update($request->all());
    }

    public function destroy(Interview $interview)
    {
        return $interview->delete();
    }
}
