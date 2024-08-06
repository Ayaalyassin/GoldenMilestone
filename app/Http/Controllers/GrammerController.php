<?php

namespace App\Http\Controllers;

use App\Http\Requests\GrammerRequest;
use App\Services\GrammerService;

class GrammerController extends Controller
{

    protected $grammerService;

    public function __construct(GrammerService $grammerService)
    {
        $this->grammerService=$grammerService;
    }

    public function index($level_id)
    {
        $grammers=$this->grammerService->index($level_id);
        return response()->json($grammers);
    }


    public function store(GrammerRequest $request)
    {
        $grammer=$this->grammerService->store($request);

        return response()->json($grammer);
    }


    public function show($id)
    {
        $grammer=$this->grammerService->show($id);
        return response()->json($grammer);
    }


    public function update(GrammerRequest $request,$id)
    {
        $this->grammerService->update($request,$id);
        return response()->json("updated successfully");
    }

    public function destroy($id)
    {
        $this->grammerService->destroy($id);
        return response()->json("deleted");
    }
}
