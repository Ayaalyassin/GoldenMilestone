<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\AnswerRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Choice;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AnswerGrammerController extends Controller
{
    use GeneralTrait;


    public function ret_true($grammer_id)
    {
        $user_id=Auth::id();

        $ansewrs=DB::table('questions')->join('choices','choices.question_id','=','questions.id')
        ->join('answers','answers.question_id','=','questions.id')
        ->where('choices.user_id','=',$user_id)
        ->where('questions.grammer_id','=',$grammer_id)
        ->where('choices.status','=',false)
        ->select('questions.question_text','answers.answer_text')
        ->where('answers.status','=',true)
        ->get();


        if(is_null($ansewrs))
        {
             return response()->json("not found");
        }
        return response()->json($ansewrs);
    }



    public function getAll($grammer_id){

        $questions=Question::where('grammer_id','=',$grammer_id)->get();
        foreach($questions as $question)
        {
            $answers = Answer::where('question_id','=',$question->id)
            ->get();
            return $this->returnData("answers", $answers);
        }

    }



    public function getById($id)
    {
        $answer =DB::table('answers')->where('id','=',$id)->first();
        if ($answer)
            return $this->returnData("answer", $answer);
        else
            return $this->returnError("404", "There is no answer with id:" . $id . " not found!");

    }



    public function save(Request  $request)
    {

        $validator=Validator::make($request->all(),[
            'answer_text'=>['required','string'],
            'status'=>['required',],
            'question'=>['required','string']
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors()->all());
        }
        $question = Question::where('question_text','=', $request->question)->first();


        if(is_null($question))
        {
            return $this->returnError("404", "question not found!");
        }

        $question->answers()->create([
            'answer_text'=>$request->answer_text,
            'status'=>$request->status,
        ]);
        return response()->json("save successfully");
    }


    public function update(Request $request,$id)
    {

            $validator=Validator::make($request->all(),[
                'answer_text'=>['required','string'],
                'status'=>['required',],
                'question'=>['required','string']

            ]);
            if($validator->fails())
            {
               return response()->json($validator->errors()->all());
            }

            $question = Question::where('question_text','=', $request->question)
            ->first();

            if(is_null($question))
            {
                return response()->json("question not found");
            }


            $answer_old = Answer::find($id);
            if(is_null($answer_old))
            {
                return response()->json("answer not found");
            }


        $answer_old->update([
            'answer_text'=>$request->answer_text,
            'status'=>$request->status,
            'question_id'=>$question->id
        ]);

        return response()->json("updated successfully");


    }




    public function answer(Request $request,$question_id)
    {
        $request->validate([

            'answer'=>['required','string'],

        ]);
        $an=$request->answer;

        $questions=DB::table('answers')->join('questions','answers.question_id','=','questions.id')
        ->where('answers.status','=',1)->value('answers.answer_text');

        $ans=Str::slug($questions);

        $user_id=Auth::id();
        if($request->answer == $ans)
        {
            Choice::create([
                'answer_text'=>$request->answer,
                'status'=>true,
                'user_id'=>$user_id,
                'question_id'=>$question_id

            ]);
            return response()->json("true");
        }
        else
        {
            Choice::create([
                'answer_text'=>$request->answer,
                'status'=>false,
                'user_id'=>$user_id,
                'question_id'=>$question_id

            ]);
            return response()->json("false");
        }


    }





    public function delete($id)
    {
        $answer = Answer::find($id);
        if ($answer) {
            $answer->delete();
            return $this->returnSuccessMessage("delete successfully");
        } else
            return $this->returnError("404", "There is no answer with id:" . $id . " not found!");
    }

}
