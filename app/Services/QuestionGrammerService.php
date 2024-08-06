<?php


namespace App\Services;

use App\Models\Grammer;
use App\Models\Question;
use App\Traits\GeneralTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class QuestionGrammerService
{

    use GeneralTrait;


    public function getAll($grammer_id){
        $grammer=Grammer::find($grammer_id);
        if(!$grammer)
        {
            throw new HttpResponseException(response()->json("grammer not found"));
        }
        $questions = $grammer->questions()->get();
        return $questions;
    }



    public function getById($question_id)
    {

        $question=Question::find($question_id);

        if(!$question)
        {
            throw new HttpResponseException($this->returnError("404", "There is no question with id:" . $question_id . " not found!"));
        }

        $answers=Question::with('answers')->where('id', $question_id)->get();


        return $answers;
    }


    public function save($request){

        $grammer=Grammer::where('text','=',$request->grammer)->first();
        if(is_null($grammer))
        {
            throw new HttpResponseException(response()->json("grammer not found"));
        }

        $question=$grammer->questions()->create([
            'question_text'=>$request->question_text,
        ]);

        $question->answers()->createMany($request->answers);
    }



    public function update($request,$id){
        $question = Question::find($id);
        if(is_null($question))
        {
            throw new HttpResponseException(response()->json("not found"));
        }

        $grammer=Grammer::where('text','=', $request->grammer)->first();
        if(is_null($grammer))
        {
            throw new HttpResponseException(response()->json("the grammer not found"));
        }

        $grammer->questions()->update([
            'question_text'=>$request->question_text,
        ]);

    }


    public function delete($id){
        $question = Question::find($id);
        if ($question) {
            $question->delete();
        } else
            throw new HttpResponseException($this->returnError("404", "There is no question with id:" . $id . " not found!"));

    }

}
