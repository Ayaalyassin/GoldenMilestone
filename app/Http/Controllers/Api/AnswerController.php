<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnswerRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;


class AnswerController extends Controller
{
    use GeneralTrait;

    public function getAll(){
        $answers = Answer::all();
        return $this->returnData("answers", $answers);
    }



    public function getById($id)
    {
        $answer = Answer::find($id);
        if ($answer)
            return $this->returnData("answer", $answer);
        else
            return $this->returnError("404", "There is no answer with id:" . $id . " not found!");

    }



    public function save(Request  $request)
    {

        $validator=Validator::make($request->all(),[
            'text'=>['required','string'],
            'status'=>['boolean|required',],
            'question'=>['required','string']

        ]);

        $question_id = Question::
        select('id')
        ->where('text','=', $request->question)
        ->first()['id'];

        //return response()->json($question_id);

        //$question = Question::find($question_id);

        if(is_null($question_id))
        {
            return $this->returnError("404", "There is no question with id:" . $question_id . " not found!");
        }

        //if ($question_id) {
            Answer::create([
            'text'=>$request->text,
            'status'=>$request->status,
            'question_id'=>$question_id
        ]);
            return $this->returnSuccessMessage("save successfully");
        //}
        //else{
            //if(!$question_id)
            //return response()->json("false");
            //return $this->returnError("404", "There is no question with id:" . $question_id . " not found!");
        //}
    }


    public function update(Request  $request,$id){

                $validator=Validator::make($request->all(),[
                'text'=>['required','string'],
                'status'=>['boolean|required',],
                'question'=>['required','string']

            ]);


            $answer_old = Answer::find($id);
            if(is_null($answer_old))
            {
                return response()->json("answer not found");
            }

            $question_id = Question::
            select('id')
            ->where('text','=', $request->question)
            ->first()['id'];



        $answer_old->update(['text'=>$request->text,
        'status'=>$request->status,
        'question_id'=>$question_id]);

        return response()->json($answer_old);
        //"id":13,

    }


    public function answer(Request $request,$question_id)
    {
        $request->validate([

            'answer'=>['required','string'],

        ]);
        $answers= Question::find($question_id)->answers;

        $an=$request->answer;

        $questions=DB::table('answers')->join('questions','answers.question_id','=','questions.id')
        ->where('answers.status','=',1)->pluck('answers.text');

        $ans=Str::slug($questions);

        if($request->answer == $ans)
        return response()->json("true");
        else
        {
            return response()->json("false");
        }


    }




    public function delete($id){
        $answer = Answer::find($id);
        if ($answer) {
            $answer->delete();
            return $this->returnSuccessMessage("delete successfully");
        } else
            return $this->returnError("404", "There is no answer with id:" . $id . " not found!");
    }



}
