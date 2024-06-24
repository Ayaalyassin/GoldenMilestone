<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AnswerRequest;
use App\Models\Answerlevel;
use App\Models\Questionlevel;
use App\Models\Levelchoice;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AnswerLevelController extends Controller
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
           return response()->json("B6");
        elseif($number==21 | $number==22)
           return response()->json("A6");
        elseif($number==19 | $number==20)
           return response()->json("B5");
        elseif($number==17 | $number==18)
           return response()->json("A5");
        elseif($number==15 | $number==16)
           return response()->json("B4");
        elseif($number==13 | $number==14)
           return response()->json("A4");
        elseif($number==11 | $number==12)
           return response()->json("B3");
        elseif($number==9 | $number==10)
           return response()->json("A3");
        elseif($number==7 | $number==8)
           return response()->json("B2");
        elseif($number==5 | $number==6)
           return response()->json("A2");
        elseif($number==3 | $number==4)
           return response()->json("B1");
        else
           return response()->json("A1");




    }

    public function getAll()
    {


        $answers =Answerlevel::all();
        if(count($answers)<0)
        {
            return $this->returnError("404", "not found!");
        }
        return $this->returnData("answers", $answers);


    }



    public function getById($id)
    {
        $answer = Answerlevel::find($id);
        if ($answer)
            return $this->returnData("answer", $answer);
        else
            return $this->returnError("404", "There is no answer with id:" . $id . " not found!");

    }



    public function save(Request  $request)
    {

        $validator=Validator::make($request->all(),[
            'answer_text'=>['required','string'],
            'status'=>['required'],
            'question'=>['required','string']

        ]);
        if($validator->fails())
        {
               return response()->json($validator->errors()->all());
        }


        $questionlevel = Questionlevel::where('level_text',$request->question)->first();

        if(is_null($questionlevel))
        {
            return $this->returnError("404", "questionlevel not found!");
        }

        //Answerlevel::create([
        $questionlevel->answers()->create([
            'answer_text'=>$request->answer_text,
            'status'=>$request->status,
            //'questionlevel_id'=>$questionlevel->id
        ]);
            return $this->returnSuccessMessage("save successfully");

    }


    public function update(Request  $request,$id){

            $validator=Validator::make($request->all(),[
                'answer_text'=>['required','string'],
                'status'=>['required',],
                'question'=>['required','string']

            ]);
            if($validator->fails())
            {
               return response()->json($validator->errors()->all());
            }

            $questionlevel = Questionlevel::where('level_text','=', $request->question)
            ->first('id');

            if(is_null($questionlevel))
            {
                return response()->json("question not found");
            }

            $answer_old = Answerlevel::find($id);
            if(is_null($answer_old))
            {
                return response()->json("answer not found");
            }


        $answer_old->update([
            'answer_text'=>$request->answer_text,
            'status'=>$request->status,
            'questionlevel_id'=>$questionlevel->id
        ]);

        return response()->json($answer_old);

    }


    public function answer(Request $request,$questionlevel_id)
    {
        $request->validate([

            'answer'=>['required','string'],

        ]);
        //$answers= Questionlevel::find($questionlevel_id)->answers;

        $an=$request->answer;

        $questions=DB::table('answerlevels')->join('questionlevels','answerlevels.questionlevel_id','=','questionlevels.id')
        ->where('answerlevels.status','=',1)->value('answerlevels.answer_text');
        //return response()->json($questions);

        $ans=Str::slug($questions);

        $user_id=Auth::id();
        if($request->answer == $ans)
        {

            Levelchoice::create([
                'answer_text'=>$request->answer,
                'status'=>true,
                'user_id'=>$user_id,
                'questionlevel_id'=>$questionlevel_id

            ]);
            return response()->json("true");
        }
        else
        {

            Levelchoice::create([
                'answer_text'=>$request->answer,
                'status'=>false,
                'user_id'=>$user_id,
                'questionlevel_id'=>$questionlevel_id

            ]);
            return response()->json("false");
        }


    }




    public function delete($id){
        $answer = Answerlevel::find($id);
        if ($answer) {
            $answer->delete();
            return $this->returnSuccessMessage("delete successfully");
        } else
            return $this->returnError("404", "There is no answer with id:" . $id . " not found!");
    }




}

