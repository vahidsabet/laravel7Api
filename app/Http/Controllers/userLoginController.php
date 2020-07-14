<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Auth;

use Laravel\Passport\HasApiTokens;
use App\User;

class userLoginController extends Controller
{

    public function login(UserLoginRequest $request)
    {

        $email = $request->email;
        $password = $request->password;
        $login =['email' => $email, 'password' => $password];

        if (!Auth::attempt($login)){
            $response = array('errors' => 'نام کاربری یا پسورد اشتباه است', 'success' => false);
            return response()->json($response, 401);  
        }
      
        $accessToken = Auth::user()->createToken('authToken')->accessToken;
        $response = array('user'=>Auth::user(),'access_token'=>$accessToken, 'success' => true);

        return response()->json($response , 201);  
    }

}
