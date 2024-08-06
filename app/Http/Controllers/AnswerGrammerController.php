<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnsRequest;
use App\Http\Requests\AnswerGrammerRequest;
use App\Services\AnswerGrammerService;
use App\Traits\GeneralTrait;


class AnswerGrammerController extends Controller
{
    use GeneralTrait;

    protected $answerGrammerService;

    public function __construct(AnswerGrammerService $answerGrammerService)
    {
        $this->answerGrammerService=$answerGrammerService;
    }

    public function ret_true($grammer_id)
    {
        $ansewrs=$this->answerGrammerService->ret_true($grammer_id);
        return response()->json($ansewrs);
    }



    public function getAll($grammer_id)
    {
        $answers=$this->answerGrammerService->getAll($grammer_id);
        return $this->returnData("answers", $answers);
    }



    public function getById($id)
    {
        $answer =$this->answerGrammerService->getById($id);
        return $this->returnData("answer", $answer);

    }



    public function save(AnswerGrammerRequest $request)
    {
        $this->answerGrammerService->save($request);
        return response()->json("save successfully");
    }


    public function update(AnswerGrammerRequest $request,$id)
    {
        $this->answerGrammerService->update($request,$id);
        return response()->json("updated successfully");

    }


    public function answer(AnsRequest $request,$question_id)
    {
        $result=$this->answerGrammerService->answer($request,$question_id);
        return response()->json($result);
    }


    public function delete($id)
    {
        $this->answerGrammerService->delete($id);
        return $this->returnSuccessMessage("delete successfully");
    }

}
