<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;
use Tymon\JWTAuth\JWTAuth;
use Validator;
use Carbon\Carbon;


class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('auth.jwt', ['except' => ['login', 'register']]);
    }

    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    // public function register(Request $request){
    //     $user = $this->user->create([
    //         'name' => $request->get('name'),
    //         'employee_code' => $request->get('employee_code'),
    //         'email' => $request->get('email'),
    //         'password' => Hash::make($request->get('password')),
    //         'position' => $request->get('position'),
    //         'status' => $request->get('status'),
    //     ]);

    //     return response()->json([
    //         'status'=> 200,
    //         'message'=> 'User created successfully',
    //         'data'=>$user
    //     ]);
    // }

    public function logout() {

        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    public function userProfile()
    {
        return response()->json(auth()->user());
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    public function changePassword(ChangePasswordRequest $request){
        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            // The passwords matches
            return $this->getResponse(false, "CURRENT_PASSWORD_NOT_MATCH", 422);
        }

        if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
            //Current password and new password are same
            return $this->getResponse(false, "CURRENT_PASSWORD_AND_NEW_PASSWORD_CAN_NOT_SAME", 422);
        }
        //Change Password
        $data['password'] = $request->get('new_password');
        $data['password_changed_at'] = App\Http\Controllers\Carbon::now();
        $update_status = User::update(Auth::id(), $data);

        return $update_status ? $this->getResponse(true, 'SUCCESS_CHANGE_PASSWORD') 
            : $this->getResponse(false, 'FAILED_CHANGE_PASSWORD', 500);
    }
}
