<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ExpertController extends Controller
{

    public function index(Request $request)
    {
        $experts = Expert::query();

        $image         = $request->query('image');
        $full_name     = $request->query('full_name');
       // $user_id       = $request->query('user_id');
        $email         = $request->query('email');
        $age           = $request->query('age');
        $address       = $request->query('address');
        $session_price = $request->query('session_price');
        $phone_number  = $request->query('phone_number');


        if($image)
        {
            $experts = $experts->where('image',$image);
        }
        else
        {
            return response()->json([
                'success' => '1',
                'message' => 'no image',
                ], 200);
        }
        if ($full_name) {
            $experts = $experts->where('full_name',$full_name);
        }
       /* if ($user_id) {
            $experts = $experts->where('user_id', $user_id);
        }*/
        if ($email) {
            $experts = $experts->where('email', $email);
        }
        if ($address) {
            $experts = $experts->where('address', $address);
        }
        if ($age) {
            $experts = $experts->where('age', $age);
        }
        if ($phone_number) {
            $experts = $experts->where('phone_number', $phone_number);
        }
        if ($session_price) {
            $experts = $experts->where('session_price', $session_price);
        }
        $experts = $experts->get();

        return response()->json([
            'success' => '1',
            'message' => 'Indexed successfully !!',
            'date'    => $experts,
            ], 200);
    }


    public function show($id)
    {
        $expert = Expert::find($id);
      if($expert)
            {
            return response()->json([
            'success' => '1',
            'message' => 'Expert showed successfully !!',
            'date'=> $expert,
            ], 200);
            }
    else
        {
            return response()->json([
            'success' => '0',
            'message' => 'There is no such id',
            'date'    => $expert,
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $expert = Expert::find($id);
        $request->validate([
            'full_name'     =>['required','string' ,'max:255'],
            'age'           =>['required','integer','max:3'],
            'email'         =>['required','string' ,'email' , Rule::unique('users')],
            'phone_number'  =>['required','integer','min:9' ,'max:10',Rule::unique('users')],
            'address'       =>['required','string' ],
            'session_price' =>['required','integer'],
            'password'      =>['required','string' ,'min:7'],
            'c_password'    =>['required','string' ,'same:password'],

    ]);

        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $profileImage    = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image']  = "$profileImage";
        }
        if($request->hasFile('image'))
        {
             $filename = $request->image->getClientOriginalName();
             $request->image->storeAs('images',$filename,'public');
        }

         $expert->update(['image'=>$filename]);
        //or // $expert->image=$request->update(['image'=>$filename]);
        $expert->full_name    =$request['full_name'];
        $expert->age          =$request['age'];
        $expert->email        =$request['email'];
        $expert->phone_number =$request['phone_number'];
        $expert->password     =$request['password'];
        $expert->c_password   =$request['c_password'];
        $expert->save();
        return response()->json([
            'success' => '1',
            'message' => 'Updated successfully !!',
            'data'    => $expert,
                     ], 200);

    }

    public function destroy($id)
    {
        $id=auth()->id();
        $expert = Expert::find($id);
        if( $expert->expert = Auth:: id())
        {
        $expert->delete;
        return response()->json([
            'success' => '1',
            'message' => 'Expert Destroyed successfully !!',
            ], 200);
        }
        else
        {
        return response()->json([
            'success' => '0',
            'message' => 'You are not authorized to delete !!',
            ], 404);
        }
    }
}
