<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use Session;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if($user->save()){
            return response()->json([
                'success'=>true,
                'status'=>200,
            ]);
        }else{
            return response()->json([
                'success'=>false,
                'status'=>200,
            ]);
        }
    }

    public function login(Request $request){
     
        $data = ['email' => $request->email, 'password' => $request->password];
        if(!Auth::attempt($data)){
            return response()->json([
                'success'=>false,
            ]);
        }else{
            $user = auth()->user();
            $token = $user->createToken('token');
            return response()->json([
                'success'=>true,
                'token' => $token->plainTextToken,
                'user'=>$user
            ]);
        }
    }
}
