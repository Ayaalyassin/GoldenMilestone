<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\QuestionRequest;
use App\Http\Requests\QuestionWithAnswerRequest;
use App\Models\Questionlevel;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;


class QuestionLevelController extends Controller
{
    use GeneralTrait;
    public function getAll(){
        $questions = Questionlevel::with('answers')->get();
        return $this->returnData("questions", $questions);
    }



    public function getById($question_id)
    {

        $question=Questionlevel::find($question_id);
        if(!$question)
        {
            return $this->returnError("404", "There is no question with id:" . $question_id . " not found!");
        }
        $answers=Questionlevel::with('answers')->where('id', $question_id)->get();
        return $this->returnData("question", $answers);

    }



    public function save(Request $request){
        $request->validate([
            'level_text'=>['required','string'],
            'answers'=>['required','array'],
            'answers.*.answer_text'=>['string','required'],
            'answers.*.status'=>['boolean','required'],
        ]);


        $question=Questionlevel::create([

            'level_text'=>$request->level_text,

        ]);
        $question->answers()->createMany($request->answers);
        return $this->returnSuccessMessage("save successfully");
    }



    public function update(Request $request,$id){
        $question = Questionlevel::find($id);

        $validator=Validator::make($request->all(),[
            'level_text'=>['required','string'],

        ]);


        if(is_null($question))
        {
            return $this->returnError("404", "There is no question with id:" . $id . " not found!");
        }

            $question->update([
                'level_text'=>$request->level_text,

            ]);
            return response()->json($question);

    }




    public function delete($id){
        $question = Questionlevel::find($id);
        if ($question) {
            $question->delete();
            return $this->returnSuccessMessage("delete successfully");
        } else
            return $this->returnError("404", "There is no question with id:" . $id . " not found!");

    }
}

