<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Team;
use Illuminate\Support\Carbon;
use App\Traits\GeneralTrait;

class OrderController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user=Auth::user();
        $orders=DB::table('orders')->join('appointments','orders.appointment_id','=','appointments.id')->join('users','orders.user_id','=','users.id')->select('time_appointment','date_appointment','place_appointment','name')->get();
        /*$orders=Order::whereHas('appointment',function($query){
            $query->get();
        })->whereHas('user',function($query) use ($user){
            $query->where('users.id',$user->id)->select('name');
        })->get();*/
        if(is_null($orders))
        {
               return response()->json("not found");
        }
        return response()->json($orders);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    //public function store(Request $request,$ap_id)
    //public function store(Request $request,Appointment $appointment)
    //public function store(Appointment $appointment)
    public function store($ap_id)
    {
        $appointment=Appointment::find($ap_id);
        if(!$appointment)
        {
            return $this->returnError("404", "appointment not found!");
        }
        $user_id = Auth::id();
        $currentDatetime=now();
        $date=Carbon::parse($currentDatetime)->format('Y-m-d');

                    $notAllow = Order::query()
                    ->where('user_id','=',$user_id)
                    ->select('date_order')
                    ->where('date_order', '=', $date)
                    ->exists();


        if ($notAllow) {
            return response()->json('You have reached the maximum number of appointments for today');
        }

                $order=$appointment->orders()->create([
                  'user_id'=>$user_id,
                  'date_order'=>$date
            ]);

             return response()->json($order);
        }





    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order=Order::find($id);

        if(is_null($order))
        {
            return "order not found";
        }

        return response()->json($order);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order,$id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order,$id)
    {

        /*$validator=Validator::make($request->all(),[

        ]);


        if($validator->fails())
        {
            return response()->json($validator->errors()->all());
        }*/



        //$order=Order::find($id);
        /*$order->update([

        ]);*/
        //return response()->json($order);



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order,$id)
    {
        $order=Order::find($id);
        if(is_null($order))
        {
            return "not found";
        }
        $order->delete();
        return response()->json("deleted");
    }


}

