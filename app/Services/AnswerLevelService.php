<?php


namespace App\Services;

use App\Http\Requests\AnsRequest;
use App\Http\Requests\AnswerLevelRequest;
use App\Repositories\AnswerLevelRepository;
use App\Traits\GeneralTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AnswerLevelService
{

    use GeneralTrait;

    protected $answerLevelRepository;

    public function __construct(AnswerLevelRepository $answerLevelRepository)
    {
        $this->answerLevelRepository=$answerLevelRepository;
    }


    public function clac_lev()
    {
        $user_id=Auth::id();

        $number=$this->answerLevelRepository->number($user_id);

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
        $answers =$this->answerLevelRepository->getAll();
        if(count($answers)<0)
        {
            throw new HttpResponseException($this->returnError("404", "not found!"));
        }
        return $answers;

    }


    public function getById($id)
    {
        $answer = $this->answerLevelRepository->getById($id);
        if ($answer)
            return $answer;
        else
            throw new HttpResponseException($this->returnError("404", "There is no answer with id:" . $id . " not found!"));

    }



    public function save(AnswerLevelRequest  $request)
    {

        $questionlevel = $this->answerLevelRepository->questionlevel($request);

        if(is_null($questionlevel))
        {
            throw new HttpResponseException($this->returnError("404", "questionlevel not found!"));
        }

        $this->answerLevelRepository->createAnswers($request,$questionlevel);

    }


    public function update(AnswerLevelRequest $request,$id){

        $questionlevel = $this->answerLevelRepository->questionlevelid($request);

        if(is_null($questionlevel))
        {
            throw new HttpResponseException(response()->json("question not found"));
        }

        $answer_old = $this->answerLevelRepository->getById($id);
        if(is_null($answer_old))
        {
            throw new HttpResponseException(response()->json("answer not found"));
        }

        $this->answerLevelRepository->updateAnswer($answer_old, [
            'answer_text' => $request->answer_text,
            'status' => $request->status,
            'question_id' => $questionlevel->id
        ]);

        return $answer_old;

    }


    public function answer(AnsRequest $request,$questionlevel_id)
    {

        $questions=$this->answerLevelRepository->questions();

        $ans=Str::slug($questions);

        $user_id=Auth::id();
        $levelChoice=$this->answerLevelRepository->levelchoice($request,$user_id,$questionlevel_id);
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
        $answer = $this->answerLevelRepository->getById($id);
        if ($answer) {
            $this->answerLevelRepository->deleteAnsweer($answer);
        } else
            throw new HttpResponseException($this->returnError("404", "There is no answer with id:" . $id . " not found!"));
    }
}
