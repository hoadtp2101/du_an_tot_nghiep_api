<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\sendMail;
use App\Models\Interview;
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
        foreach ($user as $key => $user) {
            $senditem = new \stdClass();
            $senditem->receiver = $user;
            $senditem->name = $request->name_candidate;
            Mail::to($toMail[$key])->send(new sendMail($senditem));
        }

        $interview = Interview::create($request->all());
        return $interview;
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
