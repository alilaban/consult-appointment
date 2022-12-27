<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class UserController extends Controller
{

    public function index(Request $request)
    {
        $users = User::query();

        $image = $request->query('image');
        $full_name = $request->query('full_name');
        $email = $request->query('email');
        $age = $request->query('age');
        $phone_number = $request->query('phone_number');

        if($image)
        {
            $users = $users->where('image',$image);
        }
        else
        {
            return response()->json([
                'success' => '1',
                'message' => 'no image',
            ], 200);
        }
        if ($full_name) {
            $users = $users->where('full_name',$full_name);
        }
        if ($email) {
            $users = $users->where('email', $email);
        }
        if ($age) {
            $users = $users->where('age', $age);
        }
        if ($phone_number) {
            $users = $users->where('phone_number', $phone_number);
        }


        $users = $users->get();

        return response()->json([
            'success' => '1',
            'message' => 'Indexed successfully !!',
            'date'=> $users,
        ], 200);
    }


    public function show($id)
    {
        $user = User::find($id);
      if($user)
            {
            return response()->json([
            'success' => '1',
            'message' => 'User showed successfully !!',
            'date'=> $user,
            ], 200);
            }
            else
            {
                return response()->json([
                    'success' => '0',
                    'message' => 'There is no such id',
                    'date'=> $user,
                ], 404);
            }
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $request->validate([
            'full_name'     =>['required','string' ,'max:255'],
            'age'           =>['required','integer'],
            'email'         =>['required','string' ,'email' , Rule::unique('users')],
            'phone_number'  =>['required','min:9','max:10',Rule::unique('users')],
            'password'      =>['required','string' ,'min:7'],
            'c_password'    =>['required','string' ,'same:password']
        ]);

        if($request->hasFile('image'))
        {
             $filename = $request->image->getClientOriginalName();
             $request->image->storeAs('images',$filename,'public');
         }

         $user->update(['image'=>$filename]);
        //or // $user->image=$request->update(['image'=>$filename]);
        $user->full_name=$request['full_name'];
        $user->age=$request['age'];
        $user->email=$request['email'];
        $user->phone_number=$request['phone_number'];
        $user->password=$request['password'];
        $user->c_password=$request['c_password'];
        $user->save();
        return response()->json([
            'success' => '1',
            'message' => 'Updated successfully !!',
            'data'    => $user,
             ], 200);

    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete;
        return response()->json([
            'success' => '1',
            'message' => 'User Destroyed successfully !!',
            ], 200);
        }

    }


/*
        $id=auth()->id();
        $user = User::find($id);
        if( $user->user_id = Auth:: id())
        {
        $user->delete;
        return response()->json([
            'success' => '1',
            'message' => 'User Destroyed successfully !!',
            ], 200);
        }
        else
        {
        return response()->json([
            'success' => '0',
            'message' => 'You are not authorized to delete !!',
            ], 404);
        }*/
