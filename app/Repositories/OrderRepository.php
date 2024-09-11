<?php


namespace App\Repositories;


use App\Models\Appointment;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderRepository
{

    public function orders()
    {
        return DB::table('orders')->join('appointments','orders.appointment_id','=','appointments.id')->join('users','orders.user_id','=','users.id')->select('time_appointment','date_appointment','place_appointment','name')->get();
    }

    public function appointmentById($ap_id)
    {
        return Appointment::find($ap_id);
    }

    public function orderExists($user_id,$date)
    {
        return Order::query()
            ->where('user_id','=',$user_id)
            ->select('date_order')
            ->where('date_order', '=', $date)
            ->exists();
    }
    public function createOrder($appointment,$user_id,$date)
    {
        return $appointment->orders()->create([
            'user_id'=>$user_id,
            'date_order'=>$date
        ]);
    }

    public function getById($id)
    {
        return Order::find($id);
    }
}
