<?php


namespace App\Services;

use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use App\Models\Order;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Carbon;

class AppointmentService
{

    public function index()
    {
        $currentDatetime = Carbon::now();
        $currentDate = $currentDatetime->format('Y-m-d');

        $appointments = Appointment::where('date_appointment', '>', $currentDate)
            ->where('status','=',true)
            ->get();

        foreach($appointments as $appointment)
        {
            $count=Order::where('appointment_id','=',$appointment->id)->count();
            if($count >20)
            {
                $appointment->status=false;
                $appointment->save();
            }
        }

        if(is_null($appointments))
        {
            throw new HttpResponseException(response()->json("not found"));
        }
        return $appointments;

    }


    public function store(AppointmentRequest $request)
    {
        $appointment=Appointment::create([
            'date_appointment'=>$request->date_appointment,
            'time_appointment'=>$request->time_appointment,
            'place_appointment'=>$request->place_appointment,

        ]);

        return $appointment;
    }


    public function show($id)
    {
        $appointment=Appointment::find($id);

        if(is_null($appointment))
        {
            throw new HttpResponseException(response()->json("appontment not found"));
        }

        return $appointment;
    }


    public function update(AppointmentRequest $request,$id)
    {
        $appointments=Appointment::find($id);

        if(is_null($appointments))
        {
            throw new HttpResponseException(response()->json("not found"));
        }

        $appointments->update([

            'date_appointment'=>$request->date_appointment,
            'time_appointment'=>$request->time_appointment,
            'place_appointment'=>$request->place_appointment,

        ]);
        return $appointments;
    }


    public function destroy($id)
    {
        $appointments=Appointment::find($id);
        if(is_null($appointments))
        {
            throw new HttpResponseException(response()->json("not found"));
        }
        $appointments->delete();
    }
}
