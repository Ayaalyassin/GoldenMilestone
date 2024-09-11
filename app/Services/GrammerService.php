<?php


namespace App\Services;

use App\Http\Requests\GrammerRequest;
use App\Repositories\GrammerRepository;
use Illuminate\Http\Exceptions\HttpResponseException;

class GrammerService
{
    protected $grammerRepository;

    public function __construct(GrammerRepository $grammerRepository)
    {
        $this->grammerRepository=$grammerRepository;
    }
    public function index($level_id)
    {
        $true=$this->grammerRepository->getById($level_id);
        if(!$true)
        {
            throw new HttpResponseException(response()->json("error"));
        }

        $grammers=$this->grammerRepository->answers($level_id);
        if(count($grammers)<0)
        {
            throw new HttpResponseException(response()->json("grammers not found"));
        }
        return $grammers;
    }


    public function store(GrammerRequest $request)
    {
        $level=$this->grammerRepository->getLevel($request);

        if(is_null($level))
        {
            throw new HttpResponseException(response()->json("level not found"));
        }

        $grammer=$this->grammerRepository->createGrammar($level,$request);

        return $grammer;
    }


    public function show($id)
    {
        $grammer=$this->grammerRepository->grammarById($id);

        if(is_null($grammer))
        {
            throw new HttpResponseException(response()->json("grammer not found"));
        }

        return $grammer;
    }


    public function update(GrammerRequest $request,$id)
    {
        $level=$this->grammerRepository->getLevel($request);

        if(is_null($level))
        {
            throw new HttpResponseException(response()->json("the level not found"));
        }

        $grammer=$this->grammerRepository->grammarById($id);

        if(is_null($grammer))
        {
            throw new HttpResponseException(response()->json("grammer not found"));
        }
        $this->grammerRepository->update($level,$request);

    }

    public function destroy($id)
    {
        $grammer=$this->grammerRepository->grammarById($id);
        if(is_null($grammer))
        {
            throw new HttpResponseException(response()->json("not found"));
        }
        $grammer->delete();
    }

}
