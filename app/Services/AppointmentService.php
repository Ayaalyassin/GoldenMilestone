<?php


namespace App\Services;

use App\Http\Requests\AppointmentRequest;
use App\Repositories\AppointmentRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Carbon;

class AppointmentService
{

    protected $appointmentRepository;

    public function __construct(AppointmentRepository $appointmentRepository)
    {
        $this->appointmentRepository=$appointmentRepository;
    }

    public function index()
    {
        $currentDatetime = Carbon::now();
        $currentDate = $currentDatetime->format('Y-m-d');

        $appointments = $this->appointmentRepository->appointments($currentDate);

        foreach($appointments as $appointment)
        {
            $count=$this->appointmentRepository->count($appointment);
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
        $appointment=$this->appointmentRepository->createAppointment($request);

        return $appointment;
    }


    public function show($id)
    {
        $appointment=$this->appointmentRepository->getById($id);

        if(is_null($appointment))
        {
            throw new HttpResponseException(response()->json("appontment not found"));
        }

        return $appointment;
    }


    public function update(AppointmentRequest $request,$id)
    {
        $appointments=$this->appointmentRepository->getById($id);

        if(is_null($appointments))
        {
            throw new HttpResponseException(response()->json("not found"));
        }

        $this->appointmentRepository->update($appointments,$request);
        return $appointments;
    }


    public function destroy($id)
    {
        $appointments=$this->appointmentRepository->getById($id);
        if(is_null($appointments))
        {
            throw new HttpResponseException(response()->json("not found"));
        }
        $this->appointmentRepository->delete($appointments);
    }
}
