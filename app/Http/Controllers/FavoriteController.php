<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpertController;
use App\Models\Expert;
use App\Models\Favorite;
use Maize\Markable;
class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $id = $request->query('expert_id');
        $expert = Expert::find($id);

        if (!$expert) {
            return response()->json([
                'success' => '0',
                'message' => 'Invalid Expert ID',
                'data' => $expert
            ], 404);
        }
         //$likes = $product->likes()->get();
        $favorites = Favorite::where('user_id', auth()->user()->id)->with('expert')->get();


        if($favorites){
            return response()->json([
                'success' => '1',
                'message' => 'Indexed successfully',
                'data' => $favorites
            ], 200);
        }

    }

    public function like($id) {

        $expert = Expert::find($id);
        $user = auth()->user();
        Favorite::add($expert, $user);
        session()->flash('success', 'Expert is Added to Favorite Successfully !!');

        //return redirect()->route('wishlist');

    }

    public function dislike($id) {

        $expert = Expert::find($id);
        $user = auth()->user();
        Favorite::remove($expert, $user);
        session()->flash('success', 'Expert is Removed from Favorite Successfully !!');

     //   return redirect()->route('wishlist');

    }



}
//FavoriteController
