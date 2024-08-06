<?php


namespace App\Services;


use App\Models\Answer;
use App\Models\Choice;
use App\Models\Question;
use App\Traits\GeneralTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AnswerGrammerService
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
            throw new HttpResponseException(response()->json("not found"));
        }
        return $ansewrs;
    }


    public function getAll($grammer_id){

        $questions=Question::where('grammer_id','=',$grammer_id)->get();
        $answers=$questions->answers()->get();
        return $answers;

    }



    public function getById($id)
    {
        $answer =DB::table('answers')->where('id','=',$id)->first();
        if ($answer)
            return $answer;
        else
            throw new HttpResponseException($this->returnError("404", "There is no answer with id:" . $id . " not found!"));

    }


    public function save(Request  $request)
    {

        $question = Question::where('question_text','=', $request->question)->first();

        if(is_null($question))
        {
            throw new HttpResponseException($this->returnError("404", "question not found!"));
        }

        $question->answers()->create([
            'answer_text'=>$request->answer_text,
            'status'=>$request->status,
        ]);

    }


    public function update(Request $request,$id)
    {
        $question = Question::where('question_text','=', $request->question)
            ->first();

        if(is_null($question))
        {
            throw new HttpResponseException(response()->json("question not found"));
        }

        $answer_old = Answer::find($id);
        if(is_null($answer_old))
        {
            throw new HttpResponseException(response()->json("answer not found"));
        }

        $answer_old->update([
            'answer_text'=>$request->answer_text,
            'status'=>$request->status,
            'question_id'=>$question->id
        ]);

        return response()->json("updated successfully");

    }



    public function answer($request,$question_id)
    {

        $questions=DB::table('answers')->join('questions','answers.question_id','=','questions.id')
            ->where('answers.status','=',1)->value('answers.answer_text');

        $ans=Str::slug($questions);

        $user_id=Auth::id();
        $choice=Choice::create([
            'answer_text'=>$request->answer,
            'user_id'=>$user_id,
            'question_id'=>$question_id

        ]);
        if($request->answer == $ans)
        {
            $choice->update(['status'=>true]);
            return "true";
        }
        else
        {
            $choice->update(['status'=>false]);
            return "false";
        }

    }


    public function delete($id)
    {
        $answer = Answer::find($id);
        if ($answer) {
            $answer->delete();
        } else
            throw new HttpResponseException($this->returnError("404", "There is no answer with id:" . $id . " not found!"));
    }

}
