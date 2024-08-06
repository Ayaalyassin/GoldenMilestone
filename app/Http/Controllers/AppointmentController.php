<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
use App\Services\AppointmentService;

class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService=$appointmentService;
    }

    public function index()
    {
        $appointments = $this->appointmentService->index();
        return response()->json($appointments);

    }


    public function store(AppointmentRequest $request)
    {
        $appointments=$this->appointmentService->store($request);

        return response()->json($appointments);
    }


    public function show($id)
    {
        $appointments=$this->appointmentService->show($id);

        return response()->json($appointments);
    }


    public function update(AppointmentRequest $request,$id)
    {
        $appointment=$this->appointmentService->update($request,$id);
        return response()->json($appointment);
    }


    public function destroy($id)
    {
        $this->appointmentService->destroy($id);
        return response()->json("deleted");
    }


}
