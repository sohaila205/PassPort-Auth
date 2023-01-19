<?php

namespace App\Http\Controllers;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;
class UserController extends Controller
{
    //
    public function register(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'name' => ['required','string'],
            'email' => ['required','string','email','unique:users'],
            'password' =>['required','string','min:9']
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'code' => 201], 201);
        } 
     
            $user =User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => hash::make($request->password)
            ]);

        
        $accessToken=$user->createToken('authToken')->accessToken;    
        return response()->json([
            'message' => 'Successfully registered',
            'user'=>$user,
            'accessToken'=>$accessToken,
            'code'=>200
        ], 200);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'code' => 201], 201);
        }
     
            $request->get('email');
            $log= ['email' => $request->get('email'), 'password'=>$request->get('password')];
          

            if(!Auth::attempt($log)){
                return response()->json([
                'message' => 'Unauthorized',
                'code'=>201
            ], 201);
        }
        $accessToken=Auth::user()->createToken('authToken')->accessToken;
     //   dd(auth()->guard());
        return response()->json([
            'user'=>Auth::user(),
            'accessToken'=>$accessToken,
            'code'=>200
        ],200);
    }

    public function logout(Request $request)
    {
       // dd(auth()->guard('web')->check());
        
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out',
            'code'=>200
        ],200);
    }

}
