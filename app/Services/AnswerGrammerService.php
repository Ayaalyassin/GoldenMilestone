<?php


namespace App\Services;

use App\Repositories\AnswerGrammerRepository;
use App\Traits\GeneralTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AnswerGrammerService
{
    use GeneralTrait;

    protected $answerGrammerRepository;

    public function __construct(AnswerGrammerRepository $answerGrammerRepository)
    {
        $this->answerGrammerRepository=$answerGrammerRepository;
    }


    public function ret_true($grammer_id)
    {
        $user_id=Auth::id();

        $ansewrs=$this->answerGrammerRepository->ret_true($user_id,$grammer_id);

        if(is_null($ansewrs))
        {
            throw new HttpResponseException(response()->json("not found"));
        }
        return $ansewrs;
    }


    public function getAll($grammer_id){

        $answers=$this->answerGrammerRepository->getAll($grammer_id);
        return $answers;

    }



    public function getById($id)
    {
        $answer = $this->answerGrammerRepository->getById($id);
        if ($answer)
            return $answer;
        else
            throw new HttpResponseException($this->returnError("404", "There is no answer with id:" . $id . " not found!"));

    }


    public function save(Request  $request)
    {

        $question = $this->answerGrammerRepository->findQuestionByText($request->question);

        if(is_null($question))
        {
            throw new HttpResponseException($this->returnError("404", "question not found!"));
        }

        $this->answerGrammerRepository->saveAnswer($question, [
            'answer_text' => $request->answer_text,
            'status' => $request->status,
        ]);

    }


    public function update(Request $request,$id)
    {
        $question = $this->answerGrammerRepository->findQuestionByText($request->question);

        if(is_null($question))
        {
            throw new HttpResponseException(response()->json("question not found"));
        }

        $answer_old = $this->answerGrammerRepository->findAnswerById($id);
        if(is_null($answer_old))
        {
            throw new HttpResponseException(response()->json("answer not found"));
        }

        $this->answerGrammerRepository->updateAnswer($answer_old, [
            'answer_text' => $request->answer_text,
            'status' => $request->status,
            'question_id' => $question->id
        ]);

        return response()->json("updated successfully");

    }



    public function answer($request,$question_id)
    {

        $questions=$this->answerGrammerRepository->questions();

        $ans=Str::slug($questions);

        $user_id=Auth::id();
        $choice=$this->answerGrammerRepository->createChoice($request,$user_id,$question_id);
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
        $answer = $this->answerGrammerRepository->findAnswerById($id);
        if ($answer) {
            $answer->delete();
        } else
            throw new HttpResponseException($this->returnError("404", "There is no answer with id:" . $id . " not found!"));
    }

}
