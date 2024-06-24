<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Http\Requests\QuestionWithAnswerRequest;
use App\Models\Question;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    use GeneralTrait;
    public function getAll(){
        $questions = Question::with('answers')->get();

        return $this->returnData("questions", $questions);
    }



    public function getById($id)
    {
        //$question = Question::find($id);
        $question=Question::where('id','=',$id)->with('answers')->get();

        if ($question){
            $question->answers;
            return $this->returnData("question", $question);
        }
        else
            return $this->returnError("404", "There is no question with id:" . $id . " not found!");


    }



    public function save(QuestionWithAnswerRequest $request){
        $question=Question::create(["text"=>$request->text]);
        $question->answers()->createMany($request->answers);
        return $this->returnSuccessMessage("save successfully");
    }



    public function update(Request $request,$id){
        $question = Question::find($id);

        $validator=Validator::make($request->all(),[
            'text'=>['required','string'],
            //'status'=>['boolean|required',],
            //'question'=>['required','string']

        ]);


        if ($question) {
            $question->update($request->all());
            return $this->returnSuccessMessage("update successfully");
        } else
            return $this->returnError("404", "There is no question with id:" . $id . " not found!");

    }




    public function delete($id){
        $question = Question::find($id)->where('grammer_id','!=',null);
        if ($question) {
            $question->delete();
            return $this->returnSuccessMessage("delete successfully");
        } else
            return $this->returnError("404", "There is no question with id:" . $id . " not found!");

    }
}
