<?php


namespace App\Repositories;


use App\Models\Answerlevel;
use App\Models\Levelchoice;
use App\Models\Questionlevel;
use Illuminate\Support\Facades\DB;

class AnswerLevelRepository
{

    public function number($user_id)
    {
        return DB::table('questionlevels')->join('levelchoices','questionlevels.id','=','levelchoices.questionlevel_id')
            ->where('levelchoices.status','=',true)
            ->where('levelchoices.user_id','=',$user_id)
            ->distinct()
            ->count();
    }

    public function getAll()
    {
        return Answerlevel::all();
    }

    public function getById($id)
    {
        return Answerlevel::find($id);
    }

    public function questionlevel($request)
    {
        return Questionlevel::where('level_text',$request->question)->first();
    }

    public function createAnswers($request,$questionlevel)
    {
        $questionlevel->answers()->create([
            'answer_text'=>$request->answer_text,
            'status'=>$request->status
        ]);
    }

    public function questionlevelid($request)
    {
        return Questionlevel::where('level_text','=', $request->question)
            ->first('id');
    }

    public function updateAnswer($answer, $data)
    {
        return $answer->update($data);
    }

    public function levelchoice($request,$user_id,$questionlevel_id)
    {
        return Levelchoice::create([
            'answer_text'=>$request->answer,
            'user_id'=>$user_id,
            'questionlevel_id'=>$questionlevel_id

        ]);
    }

    public function deleteAnsweer($answer)
    {
        $answer->delete();
    }

    public function questions()
    {
        return DB::table('answerlevels')->join('questionlevels','answerlevels.questionlevel_id','=','questionlevels.id')
            ->where('answerlevels.status','=',1)->value('answerlevels.answer_text');
    }
}
