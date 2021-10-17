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
        $model = new Candidate();
        $model->fill($request->all());
        if ($request->hasFile('image')) {
            $newFileName = uniqid() . '-' . $request->image->getClientOriginalName();
            $path = $request->image->storeAs('public/images/candidate', $newFileName);
            $model->image = $newFileName;
        }
        if ($request->hasFile('cv')) {
            $newFileName = uniqid() . '-' . $request->cv->getClientOriginalName();
            $path = $request->cv->storeAs('public/cv', $newFileName);
            $model->cv = $newFileName;
        }
        $model->save();      
        return response()->json($model);        
    }

    public function edit(Request $request, $id)
    {        
        $model = Candidate::find($id);
        $model->fill($request->all());
        if ($request->hasFile('image')) {
            $newFileName = uniqid() . '-' . $request->image->getClientOriginalName();
            $path = $request->image->storeAs('public/images/candidate', $newFileName);
            $model->image = $newFileName;
        }
        if ($request->hasFile('cv')) {
            $newFileName = uniqid() . '-' . $request->cv->getClientOriginalName();
            $path = $request->cv->storeAs('public/cv', $newFileName);
            $model->cv = $newFileName;
        }
        $model->save(); 
        return redirect(route('candidate'));         
    }

    public function remove($id)
    {
        Candidate::destroy($id);
        return redirect(route('candidate'));
    }
}
