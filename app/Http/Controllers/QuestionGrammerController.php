<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionGrammerRequest;
use App\Http\Requests\UpQueGRaRequest;
use App\Services\QuestionGrammerService;
use App\Traits\GeneralTrait;

class QuestionGrammerController extends Controller
{
    use GeneralTrait;

    protected $questionGrammerService;

    public function __construct(QuestionGrammerService $questionGrammerService)
    {
        $this->questionGrammerService=$questionGrammerService;
    }

    public function getAll($grammer_id){

        $questions = $this->questionGrammerService->getAll($grammer_id);

        return $this->returnData("questions", $questions);
    }



    public function getById($question_id)
    {
        $answers=$this->questionGrammerService->getById($question_id);
        return $this->returnData("question", $answers);
    }


    public function save(QuestionGrammerRequest $request){
        $this->questionGrammerService->save($request);
        return $this->returnSuccessMessage("save successfully");
    }


    public function update(UpQueGRaRequest $request,$id){
        $this->questionGrammerService->update($request,$id);
        return $this->returnSuccessMessage("update successfully");

    }


    public function delete($id){
        $this->questionGrammerService->delete($id);
        return $this->returnSuccessMessage("delete successfully");
    }
}

