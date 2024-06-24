<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GeneralTrait;

use App\Http\Requests\QuestionRequest;
use App\Http\Requests\QuestionWithAnswerRequest;
use App\Models\Question;
use Illuminate\Support\Facades\Validator;
use App\Models\Grammer;
use Illuminate\Support\Facades\DB;

class QuestionGrammerController extends Controller
{
    use GeneralTrait;
    public function getAll($grammer_id){
        $grammer=Grammer::find($grammer_id);
        if(!$grammer)
        {
            return response()->json("grammer not found");
        }
        $questions = Question::where('grammer_id',$grammer_id)->with('answers')->get();


        return $this->returnData("questions", $questions);
    }



    public function getById($question_id)
    {

        $question=Question::find($question_id);

        if(!$question)
        {
            return $this->returnError("404", "There is no question with id:" . $question_id . " not found!");
        }

        $answers=Question::with('answers')->where('id', $question_id)->get();


            return $this->returnData("question", $answers);
    }


    public function save(Request $request){
        $request->validate([
            'grammer'=>['required','string'],
            'question_text'=>['required','string'],
            'answers'=>['required','array'],
            'answers.*.answer_text'=>['string','required'],
            'answers.*.status'=>['boolean','required'],
        ]);

        $grammer=Grammer::where('text','=',$request->grammer)->first();
        if(is_null($grammer))
        {
            return response()->json("grammer not found");
        }

        $question=$grammer->questions()->create([
            'question_text'=>$request->question_text,
        ]);

        $question->answers()->createMany($request->answers);
        return $this->returnSuccessMessage("save successfully");
    }



    public function update(Request $request,$id){
        $question = Question::find($id);
        if(is_null($question))
        {
            return response()->json("not found");
        }

        $validator=Validator::make($request->all(),[
            'question_text'=>['required','string'],
            'grammer'=>['required','string'],
        ]);

        $grammer=Grammer::where('text','=', $request->grammer)->first();
        if(is_null($grammer))
        {
            return response()->json("the grammer not found");
        }

        $grammer->questions()->update([
            'question_text'=>$request->question_text,
        ]);
        return $this->returnSuccessMessage("update successfully");

    }




    public function delete($id){
        $question = Question::find($id);
        if ($question) {
            $question->delete();
            return $this->returnSuccessMessage("delete successfully");
        } else
            return $this->returnError("404", "There is no question with id:" . $id . " not found!");

    }
}

