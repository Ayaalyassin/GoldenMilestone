<?php


namespace App\Services;

use App\Http\Requests\AnsRequest;
use App\Http\Requests\AnswerLevelRequest;
use App\Models\Answerlevel;
use App\Models\Levelchoice;
use App\Models\Questionlevel;
use App\Traits\GeneralTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AnswerLevelService
{

    use GeneralTrait;


    public function clac_lev()
    {
        $user_id=Auth::id();

        $number=DB::table('questionlevels')->join('levelchoices','questionlevels.id','=','levelchoices.questionlevel_id')
            ->where('levelchoices.status','=',true)
            ->where('levelchoices.user_id','=',$user_id)
            ->distinct()
            ->count();

        if($number==24 | $number==23)
            return "B6";
        elseif($number==21 | $number==22)
            return "A6";
        elseif($number==19 | $number==20)
            return "B5";
        elseif($number==17 | $number==18)
            return "A5";
        elseif($number==15 | $number==16)
            return "B4";
        elseif($number==13 | $number==14)
            return "A4";
        elseif($number==11 | $number==12)
            return "B3";
        elseif($number==9 | $number==10)
            return "A3";
        elseif($number==7 | $number==8)
            return "B2";
        elseif($number==5 | $number==6)
            return "A2";
        elseif($number==3 | $number==4)
            return "B1";
        else
            return "A1";

    }

    public function getAll()
    {
        $answers =Answerlevel::all();
        if(count($answers)<0)
        {
            throw new HttpResponseException($this->returnError("404", "not found!"));
        }
        return $answers;

    }


    public function getById($id)
    {
        $answer = Answerlevel::find($id);
        if ($answer)
            return $answer;
        else
            throw new HttpResponseException($this->returnError("404", "There is no answer with id:" . $id . " not found!"));

    }



    public function save(AnswerLevelRequest  $request)
    {

        $questionlevel = Questionlevel::where('level_text',$request->question)->first();

        if(is_null($questionlevel))
        {
            throw new HttpResponseException($this->returnError("404", "questionlevel not found!"));
        }

        $questionlevel->answers()->create([
            'answer_text'=>$request->answer_text,
            'status'=>$request->status
        ]);

    }


    public function update(AnswerLevelRequest $request,$id){

        $questionlevel = Questionlevel::where('level_text','=', $request->question)
            ->first('id');

        if(is_null($questionlevel))
        {
            throw new HttpResponseException(response()->json("question not found"));
        }

        $answer_old = Answerlevel::find($id);
        if(is_null($answer_old))
        {
            throw new HttpResponseException(response()->json("answer not found"));
        }

        $answer_old->update([
            'answer_text'=>$request->answer_text,
            'status'=>$request->status,
            'questionlevel_id'=>$questionlevel->id
        ]);

        return $answer_old;

    }


    public function answer(AnsRequest $request,$questionlevel_id)
    {

        $questions=DB::table('answerlevels')->join('questionlevels','answerlevels.questionlevel_id','=','questionlevels.id')
            ->where('answerlevels.status','=',1)->value('answerlevels.answer_text');

        $ans=Str::slug($questions);

        $user_id=Auth::id();
        $levelChoice=Levelchoice::create([
            'answer_text'=>$request->answer,
            'user_id'=>$user_id,
            'questionlevel_id'=>$questionlevel_id

        ]);
        if($request->answer == $ans)
        {
            $levelChoice->update(['status'=>true]);
            return response()->json("true");
        }
        else
        {
            $levelChoice->update(['status'=>true]);
            return response()->json("false");
        }

    }


    public function delete($id){
        $answer = Answerlevel::find($id);
        if ($answer) {
            $answer->delete();
        } else
            throw new HttpResponseException($this->returnError("404", "There is no answer with id:" . $id . " not found!"));
    }
}
