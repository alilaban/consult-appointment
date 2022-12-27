<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Reservation;
class ReservationController extends Controller
{
    public function time(Request $request)
    {
        $request->validate([
            'availabe_time'=>['required','date'],
        ]);

        $reservation=Reservation::create([
            'availabe_time'      =>$request->availabe_time,
        ]);
        return response()->json([
            'success' => '1',
            'user' => $reservation,
            'message'=>'Reserved  successfully !!'
        ], 200);

    }

    public function index(Request $request)
    {

        $experts_time = $request->query('time');//or reservations instead of time
        $reservations=Reservation::query();


        if ($experts_time) {
            $reservations = $reservations->where('time', $experts_time);
        }

        return   $reservations=$reservations->get();
        return response()->json([
            'success' => '1',
            'message' => 'reserved successfully !!',
            'data' => $reservations,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'availabe_time' => ['required', 'date'],
        ]);

        $reservation = Reservation::query()->create([
            'availabe_time' => $request['availabe_time'],
        ]);

        return response()->json([
            'success' => '1',
            'message' => 'Reservation stored successfully !!',
            'data' => $reservation
        ], 200);


    }

    public function show($id,Reservation $reservation)
    {
        $reservation = Reservation::query();
        $reservation = $reservation->find($id);
        if( $reservation)
        {
            return response()->json([
                'success' => '1',
                'message' => 'successfuly showed !!',
                'data' => $reservation
            ], 200);
        }
        else{
            return response()->json([
                'success' => '0',
                'message' => 'Invalid id',
            ], 404);
        }
    }

    public function update(Request $request, $id,Reservation $reservation)
    {
        $reservation = $reservation->find($id);
        $request->validate([
            'availabe_time' => ['required', 'date'],

           ]);

           $reservation->experts=$request['availabe_time'];
           $reservation->save();

        return response()->json([
            'success' => '1',
            'message' => 'Updated successfully !!',
            'data' => $reservation
        ], 200);
    }

    public function destroy($id,Reservation $reservation)
    {
        $reservation = $reservation->find($id);
        $reservation->delete();

        return response()->json([
            'success' => '1',
            'message' => 'reservation deleted successfully !!',
        ], 200);
    }
}
