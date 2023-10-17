<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function createPage() {
        return view('user.quiz.create');
    }

    public function create(Request $request) {
        // logger($request->question_list);
        $question_list = serialize($request->question_list);
        $answer_list = serialize($request->answer_list);
        $question = Question::create(['desc'=>$request->desc,'title'=>$request->formTitle,'question_list'=>$question_list,'user_id'=>Auth::user()->id]);
        $question_id = $question->id;
        Answer::create(['question_id'=>$question_id,'answer_list'=>$answer_list]);
        return response()->json(200);
    }

    public function answerCheckPage($id) {
        $question = Question::where('id',$id)->first();
        return view('user.quiz.answerCheck',compact('question'));
    }

    public function getQuestionList(Request $request) {
        $question = Question::where('id',$request->id)->first();
        $question_list = unserialize($question->question_list);
        // logger($question_list);
        return response()->json([
            'question_list' => $question_list,
            'question' => $question,
        ], 200);
    }

    public function getAnswer(Request $request){

        $answer = Answer::where('question_id',$request->quiz_id)->first();
        $answer_list = unserialize($answer->answer_list);
        $quiz_answer = null;
        foreach($answer_list as $a) {
            if($a['id'] == $request->question_id) {
                $quiz_answer = $a['answer'];
                break;
            }
        }
        return response()->json($quiz_answer, 200);
    }

    public function checkAnswer(Request $request){
        logger($request->all());
        $answer = Answer::where('question_id',$request->quiz_id)->first();
        $answer_list = unserialize($answer->answer_list);
        $quiz_answer = null;
        $answerStatus = null;
        foreach($answer_list as $a) {
            if($a['id'] == $request->question_id) {
                $quiz_answer = $a['answer'];
                break;
            }
        }

        if($request->user_answer == $quiz_answer || $request->user_choice == $quiz_answer) {
            $answerStatus = true;
            return response()->json($answerStatus, 200,);
        }else {
            $answerStatus = false;
            return response()->json($answerStatus, 200,);
        }

    }

    public function editPage(){
        $question = Question::orderBy('created_at','desc')->get();
        return view('user.quiz.edit',compact('question'));
    }

    public function delete(Request $request){
        $question = Question::where('id',$request->question_id)->first();
        Question::where('id',$request->question_id)->delete();
        return response()->json(200);
    }


}
