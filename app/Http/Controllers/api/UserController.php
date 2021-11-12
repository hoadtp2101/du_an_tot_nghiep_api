<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
// use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserCreateRequest;
use App\Models\Role;
use App\Models\UserRole;

class UserController extends Controller
{
    public  function index(){          
        return User::with('roles')->get();
    }

    public function show(User $user){        
        return User::with('roles')->where('id', $user->id)->first();
    }

    public function store(UserCreateRequest $request){    
        $password = Hash::make($request->password);
        $user = User::create(array_merge($request->all(), ['password' => $password]));

        $user->roles()->attach(!empty($request->roleIds) ? $request->roleIds : []);
        
        return response()->json([
            'status'=> 200,
            'message'=> 'User created successfully',
            'data'=>$user
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
