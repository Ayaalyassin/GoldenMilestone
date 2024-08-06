<?php


namespace App\Services;

use App\Models\Appointment;
use App\Models\Order;
use App\Traits\GeneralTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    use GeneralTrait;

    public function index()
    {

        $orders=DB::table('orders')->join('appointments','orders.appointment_id','=','appointments.id')->join('users','orders.user_id','=','users.id')->select('time_appointment','date_appointment','place_appointment','name')->get();

        if(is_null($orders))
        {
            throw new HttpResponseException(response()->json("not found"));
        }
        return $orders;

    }

    public function store($ap_id)
    {
        $appointment=Appointment::find($ap_id);
        if(!$appointment)
        {
            throw new HttpResponseException($this->returnError("404", "appointment not found!"));
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
            throw new HttpResponseException(response()->json('You have reached the maximum number of appointments for today'));
        }

        $order=$appointment->orders()->create([
            'user_id'=>$user_id,
            'date_order'=>$date
        ]);

        return $order;
    }


    public function show($id)
    {
        $order=Order::find($id);

        if(is_null($order))
        {
            throw new HttpResponseException(response()->json("order not found"));
        }

        return $order;
    }


    public function destroy($id)
    {
        $order=Order::find($id);
        if(!$order)
        {
            throw new HttpResponseException(response()->json("not found"));
        }
        $order->delete();
    }

}
