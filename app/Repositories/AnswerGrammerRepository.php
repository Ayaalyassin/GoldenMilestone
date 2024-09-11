<?php


namespace App\Repositories;


use App\Models\Answer;
use App\Models\Choice;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class AnswerGrammerRepository
{

    public function ret_true($user_id,$grammer_id)
    {
        $ansewrs=DB::table('questions')->join('choices','choices.question_id','=','questions.id')
            ->join('answers','answers.question_id','=','questions.id')
            ->where('choices.user_id','=',$user_id)
            ->where('questions.grammer_id','=',$grammer_id)
            ->where('choices.status','=',false)
            ->select('questions.question_text','answers.answer_text')
            ->where('answers.status','=',true)
            ->get();
        return $ansewrs;
    }


    public function getAll($grammer_id){

        $questions=Question::where('grammer_id','=',$grammer_id)->get();
        $answers=$questions->answers()->get();
        return $answers;

    }

    public function getById($id)
    {
        $answer = DB::table('answers')->where('id', $id)->first();
        return $answer;
    }

    public function findQuestionByText($questionText)
    {
        return Question::where('question_text', $questionText)->first();
    }

    public function saveAnswer($question, $answerData)
    {
        return $question->answers()->create($answerData);
    }

    public function findAnswerById($id)
    {
        return Answer::find($id);
    }


    public function updateAnswer($answer, $data)
    {
        return $answer->update($data);
    }

    public function questions()
    {
        $questions=DB::table('answers')->join('questions','answers.question_id','=','questions.id')
            ->where('answers.status','=',1)->value('answers.answer_text');
        return $questions;
    }

    public function createChoice($request,$user_id,$question_id)
    {
        $choice=Choice::create([
            'answer_text'=>$request->answer,
            'user_id'=>$user_id,
            'question_id'=>$question_id
            ]);
        return $choice;
    }

}
