<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnsRequest;
use App\Http\Requests\AnswerLevelRequest;
use App\Services\AnswerLevelService;
use App\Traits\GeneralTrait;


class AnswerLevelController extends Controller
{
    use GeneralTrait;

    protected $answerLevelService;

    public function __construct(AnswerLevelService $answerLevelService)
    {
        $this->answerLevelService=$answerLevelService;
    }


    public function clac_lev()
    {
        $result=$this->answerLevelService->clac_lev();
        return response()->json($result);

    }

    public function getAll()
    {
        $answers=$this->answerLevelService->getAll();
        return $this->returnData("answers", $answers);

    }


    public function getById($id)
    {
        $answer = $this->answerLevelService->getById($id);
        return $this->returnData("answer", $answer);
    }



    public function save(AnswerLevelRequest  $request)
    {
        $this->answerLevelService->save($request);
        return $this->returnSuccessMessage("save successfully");

    }


    public function update(AnswerLevelRequest $request,$id){
        $answer_old=$this->answerLevelService->update($request,$id);
        return response()->json($answer_old);

    }


    public function answer(AnsRequest $request,$questionlevel_id)
    {
        $result=$this->answerLevelService->answer($request,$questionlevel_id);
        return response()->json($result);

    }



    public function delete($id){
        $this->answerLevelService->delete($id);
        return $this->returnSuccessMessage("delete successfully");
    }


}

