<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class AuthApi extends Controller
{
    public function register(){

        $req_validator =
        Validator::make(request()->all(),[
            'name'=>'required|min:5',
            'email'=>'required|min:6',
            'password'=>'required|min:5',
            
        ]);

        if($req_validator->fails()){
            return response()->json([
                'status'=>500,
                'message'=>'fail',
                'data'=>$req_validator->errors()
            ]);
        }

        $name = request()->name;
        $email = request()->email;
        $password = request()->password;
        $image = request()->image;

        
       

        $user = User::create([
            'name'=>$name,
            'email'=>$email,
            'password'=>bcrypt($password),  
        ]);

        $token = $user->createToken('social')->accessToken;
        return response()->json([
            'status'=>200,
            'message'=>'success',
            'data'=>$user,
            'token'=>$token
        ]);
    }

    public function login(){
        $req_validator =
        Validator::make(request()->all(),[
            'email'=>'required',
            'password'=>'required',
            
        ]);

        if($req_validator->fails()){
            return response()->json([
                'status'=>500,
                'message'=>'fail',
                'data'=>$req_validator->errors()
            ]);
        }

        $email = request()->email;
        $password = request()->password;
        $login  =['email'=>$email,'password'=>$password];
        if(Auth::attempt($login)){
            $user = Auth::user();
            $token = $user->createToken('social')->accessToken;
            return response()->json([
                'status'=>200,
                'message'=>'success',
                'data'=>$user,
                'token'=>$token
            ]);
        }

        return response()->json([
            'status'=>500,
            'message'=>'fail',
            'data'=>[
                'error'=>'email_and_password_dont_match'
            ]
            ]);
    }
}
