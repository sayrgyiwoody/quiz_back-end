<?php

namespace App\Http\Controllers\api;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuizController extends Controller
{

    //get all quiz list
    public function getAllQuizzes(Request $request){
        $quizzes = Question::select('questions.*' ,'users.name as user_name')
        ->leftJoin('users','users.id','questions.user_id')
        ->orderBy('questions.created_at','desc')->paginate(6);
        return response()->json([
            'status' => true,
            'quizzes' => $quizzes
        ], 200);
    }

    //get latest quiz list
    public function getLatestQuizzes(Request $request){
        $quizzes = Question::select('questions.*' ,'users.name as user_name')
        ->leftJoin('users','users.id','questions.user_id')
        ->orderBy('questions.created_at','desc')->paginate(8);
        return response()->json([
            'status' => true,
            'quizzes' => $quizzes
        ], 200);
    }

    //get most played quiz list
    public function getMostPlayedQuizzes(Request $request){
        $quizzes = Question::select('questions.*' ,'users.name as user_name')
        ->leftJoin('users','users.id','questions.user_id')
        ->orderBy('questions.view_count','desc')
        ->where('questions.view_count','>',0)
        ->paginate(8);
        return response()->json([
            'status' => true,
            'quizzes' => $quizzes
        ], 200);
    }

    // search quiz
    public function search(Request $request){
        $quizzes = Question::select('questions.*' ,'users.name as user_name')
        ->leftJoin('users','users.id','questions.user_id')
        ->orderBy('questions.created_at','desc')
        ->where('questions.title','like','%'.$request->searchKey.'%')->orWhere('questions.desc','like','%'.$request->searchKey.'%')
        ->paginate(6);
        return response()->json([
            'status' => true,
            'searched_quiz' => $quizzes
        ], 200);
    }

    //get detail about quiz
    public function getDetail($id){
        $quiz = Question::select('questions.*' ,'users.name as user_name')
        ->leftJoin('users','users.id','questions.user_id')
        ->orderBy('questions.created_at','desc')
        ->where('questions.id',$id)
        ->first();
        $question_list = unserialize($quiz->question_list);
        $question_count = count($question_list);
        return response()->json([
            'status' => true,
            'quiz' => $quiz,
            'question_count' => $question_count,
        ], 200);
    }

    //get questionList of the quiz
    public function getQuestionList(Request $request) {
        $quiz = Question::where('id',$request->id)->first();
        $question_list = unserialize($quiz->question_list);
        $dbViewCount = $quiz->view_count;
        Question::where('id',$request->id)->update(['view_count'=>($dbViewCount+1)]);
        return response()->json([
            'status' => true,
            'quiz' => $quiz,
            'question_list' => $question_list,
        ], 200);
    }

    //check answer with id
    public function checkAnswer(Request $request){
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

    // get user request answer
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
}
