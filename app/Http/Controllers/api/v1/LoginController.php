<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\customReq;
use App\Http\Requests\UserChPasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


use Laravel\Passport\Client as OClient;
use GuzzleHttp\Exception\ClientException;
use App\User;

class LoginController extends Controller
{
   // public $successStatus = 200;
   const SUCCUSUS_STATUS_CODE = 200;
   const UNAUTHORISED_STATUS_CODE = 401;

  /*      public function __construct(Client $client) {
                $this->http = $client;
            }

    public function login(UserLoginRequest $request) {
        $response = $this->userRepository->login($request);
        return response()->json($response["data"], $response["statusCode"]);
    }*/

    public function login(UserLoginRequest $request)
    {

     /*   $login =$request->validate( [            
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);*/

        $email = $request->email;
        $password = $request->password;
        $login =['email' => $email, 'password' => $password];

        if (!Auth::attempt($login)){
            return response()->json(['error'=>'نام کاربری یا پسورد اشتباه است'], 401);  
        }
        /*if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $response = $this->getTokenAndRefreshToken($email, $password);
            $data = $response["data"];
            $statusCode =  $response["statusCode"];
        } else {
            $data = ['error'=>'Unauthorised'];
            $statusCode =  self::UNAUTHORISED_STATUS_CODE;
        }

        return $this->response($data, $statusCode);*/
        $accessToken = Auth::user()->createToken('authToken')->accessToken;
        return response()->json(['user'=>Auth::user(),'access_token'=>$accessToken], 201);  

     /*   
        $data=$request->all();
        $validator = validator($data);

        if ($validator) {
            $User = new User;
            $User->name = $request->input('name');
            $User->email = $request->input('email');
            $User->password = Hash::make($request->input('password'));            
            $User->save();
            $response = array( 'success' => true,"user"=>$User);
            return response()->json($response, 201);
            //   $order =  Orders::create($request->all());
        }

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) { 
            $oClient = OClient::where('password_client', 1)->first();
            return $this->getTokenAndRefreshToken($oClient, request('email'), request('password'));
        } 
        else { 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } */
    }

    public function logout(Request $request) {
        //Auth::logout();
        //$request->user()->token()->revoke();
        if (Auth::check()) {
              $request->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
         $response = array('success' => true,'message' => 'با موفقیت خارج شدید');
         $code=200;
    }else{
           $response = array('success' => true,'message' => 'دسترسی غیر مجاز');
         $code=401;
    }

       /* DB::table('oauth_access_tokens')
        ->where('user_id', Auth::user()->id)
        ->update([
            'revoked' => true
        ]);*/
        //$response = array('success' => true,'message' => 'با موفقیت خارج شدید',"user"=>$User);
        return response()->json($response,  $code);
     // return  response()->json(['message' => 'Successfully logged out'], 200);
    }

    public function change_password(UserChPasswordRequest $request)
    {
    /* $input = $request->all();
        $userid = Auth::guard('api')->user()->id;
        $rules = array(
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array());
        } else {*/
            $userid = Auth::guard('api')->user()->id;
            $old_password = $request->old_password;
            $new_password = $request->new_password;
            //$login =['email' => $email, 'password' => $password];
        
                if ((Hash::check($old_password, Auth::user()->password)) == false) {
                   // $arr = array("status" => 400, "message" => "Check your old password.", "data" => array());
                    $response = array('success' => false,'message' => 'پسورد قبلی صحیح نیست');
                    return response()->json($response,  400);
                } else if ((Hash::check($new_password, Auth::user()->password)) == true) {
                   // $arr = array("status" => 400, "message" => "Please enter a password which is not similar then current password.", "data" => array());
                    $response = array('success' => false,'message' => 'پسورد به جز پسورد کنونی وارد نمایید');
                    return response()->json($response,  400);
                } else {
                    User::where('id', $userid)->update(['password' => Hash::make($new_password/*$input['new_password']*/)]);
                    //$arr = array("status" => 200, "message" => "Password updated successfully.", "data" => array());
                    $response = array('success' => true, "message" => "پسورد با موفقیت تغییر کرد");
                    return response()->json($response, 200);
                }             
    }

    public function register(customReq $request)
    {

        /*$name = $request->name;
        $email = $request->email;
        $password = $request->password;
        */
      
            $User = new User;
            $User->name = $request->input('name');
            $User->email = $request->input('email');
            $User->password = Hash::make($request->input('password'));            
            $User->save();
            $response = array('success' => true,"user"=>$User);
            return response()->json($response, 201);
            //   $order =  Orders::create($request->all());
        
    }
   /* public function userRefreshToken(Request $request)
    {
    $client = DB::table('oauth_clients')
        ->where('password_client', true)
        ->first();
    
    $data = [
        'grant_type' => 'refresh_token',
        'refresh_token' => $request->refresh_token,
        'client_id' => $client->id,
        'client_secret' => $client->secret,
        'scope' => ''
    ];
    $request = Request::create('/oauth/token', 'POST', $data);
    $content = json_decode(app()->handle($request)->getContent());
    
    return response()->json([
        'error' => false,
        'data' => [
            'meta' => [
                'token' => $content->access_token,
                'refresh_token' => $content->refresh_token,
                'type' => 'Bearer'
            ]
        ]
    ], Response::HTTP_OK);
    }*/
}
