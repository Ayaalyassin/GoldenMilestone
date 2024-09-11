<?php


namespace App\Repositories;


use App\Models\Appointment;
use App\Models\Order;

class AppointmentRepository
{
    public function appointments($currentDate)
    {
        return Appointment::where('date_appointment', '>', $currentDate)
            ->where('status','=',true)
            ->get();
    }

    public function count($appointment)
    {
        return Order::where('appointment_id','=',$appointment->id)->count();
    }

    public function createAppointment($request)
    {
        return Appointment::create([
            'date_appointment'=>$request->date_appointment,
            'time_appointment'=>$request->time_appointment,
            'place_appointment'=>$request->place_appointment,

        ]);
    }

    public function getById($id)
    {
        return Appointment::find($id);
    }

    public function update($appointments,$request)
    {
        $appointments->update([

            'date_appointment'=>$request->date_appointment,
            'time_appointment'=>$request->time_appointment,
            'place_appointment'=>$request->place_appointment,

        ]);
    }

    public function delete($appointments)
    {
        $appointments->delete();
    }

}
