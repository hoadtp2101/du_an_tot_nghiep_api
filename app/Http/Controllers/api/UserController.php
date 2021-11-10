<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserCreateRequest;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    public  function index(){
        return User::all();
    }

    public function show(User $user){
        return $user;
    }

    public function store(UserCreateRequest $request){
        $password = Hash::make($request->password);
        $user = User::create(array_merge($request->all(), ['password' => $password]));

        $user->roles()->attach(!empty($request->roleIds) ? $request->roleIds : []);

        return response()->json([
            'status'=> 200,
            'message'=> 'User created successfully',
            'data'=> $user
        ]);
    }

    public function update(User $user, Request $request){
        $user->update($request->all());
        $user->roles()->sync(!empty($request->roleIds) ? $request->roleIds : []);
        return $user;
    }

    public function destroy(User $user){
        $user->roles()->detach();
        $user->delete();
        return response()->json('delete_success');
    }

}
