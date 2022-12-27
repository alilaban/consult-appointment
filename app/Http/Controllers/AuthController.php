<?php

namespace App\Http\Controllers;


use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Expert;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Symfony\Contracts\Service\Attribute\Required;
//use App\Http\Controllers\Store;
use Illuminate\Contracts\Cache\Store;
//use Auth;
//use App\Http\Controllers\BaseController as BaseController;
//use Iluminate\Support\Str;
class AuthController extends Controller
{

    public function createUser(Request $request)
    {
           $request->validate([
            'full_name'     =>['required','string' ,'max:255'],
            'age'           =>['required','integer'],
            'email'         =>['required','string' ,'email' , Rule::unique('users')],
            'phone_number'  =>['required',Rule::unique('users')],
            'password'      =>['required','string' ,'min:7'],
            'c_password'    =>['required','string' ,'same:password'],
            'is_expert'     =>['required']

    ]);

          $request['password'] = Hash::make($request['password']);

       if($request->hasFile('image'))
       {
            $filename = $request->image->getClientOriginalName();
            $request->image->storeAs('images',$filename,'public');

        }

    $user=User::create([
        'full_name'      =>$request->full_name,
        'image'          =>$request->image,
        'age'            =>$request->age,
        'email'          =>$request->email,
        'phone_number'   =>$request->phone_number,
        'password'       =>$request->password,
        'c_password'     =>$request->c_password,
        'is_expert'      =>$request->is_expert,
    ]);
    $token=$user->createToken('sjdhiehfie')->accessToken;
    return response()->json([
        'success' => '1',
        'user' => $user,
        'token'=> $token,
        'message'=>'User created successfully'
    ], 200);

    }

    public function createExpert(Request $request)
    {

        $request->validate([

            'user_id'               =>['required','integer'],
            'consulting'            =>['required','string'],
            'address'               =>['required','string' ],
            'session_price'         =>['required','integer'],
            'available_time_start'  =>['required'],
            'available_time_end'    =>['required'],
    ]);



    $expert=Expert::create([
        'user_id'                =>$request->user_id,
        'consulting'             =>$request->consulting,
        'address'                =>$request->address,
        'session_price'          =>$request->session_price,
        'available_time_start'   =>$request->available_time_start,
        'available_time_end'     =>$request->available_time_end,
    ]);
   // $success['token']=$expert::createToken('qazwsxedcrfvtgbyhnujmik,ol.p;/')->accessToken;
   $token=$expert->createToken('sjdhiehfiehdcbkbck')->accessToken;
    return response()->json([
        'success' => '1',
        'expert' => $expert,
        'token'=>$token,
        'message'=>'Expert created successfully'
    ], 200);

    }

    public function login(Request $request)
    {
        $request->validate([

            'email'    =>['required','email'],
            'password' =>['required','min:7'],
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            /** @var \App\Models\MyUserModel $user **/
            $user=Auth::user();
            $token=$user->createToken('sjdhiehfie')->accessToken;
            //$success['token']=$user::createToken('qazwsxedcrfvtgbyhnujmik,ol.p;/')->accessToken;
            return response()->json([
                'success' => '1',
                'user' => $user,
                'token'=> $token,
                'message'=>'User logged in successfully'
            ], 200);

        }
        else
        {
            return response()->json(
                [
                    'success' => '0',
                    'message' => ('you can not login please create new account')
                ]    , 422);
        }

    }



    public function logout(Request $request)
    {

        $request->user()->token()->revoke();


        return response()->json([
            "success" => "1",
            "message" => "logged out successfully"
        ],200);
    }


    public function userDetails()
    {
        $user = auth()->user();

        return response()->json([
            'success' => '1',
            'user' => $user,
        ], 200);
    }
    public function expertDetails()
    {
        $expert = Auth::expert();

        return response()->json([
            'success' => '1',
            'expert' => $expert,
        ], 200);
    }


}
