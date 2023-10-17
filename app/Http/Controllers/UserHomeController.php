<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class UserHomeController extends Controller
{
    public function home() {
        $question = Question::select('questions.*','users.name as user_name')->leftJoin('users','questions.user_id','users.id')
        ->orderBy('questions.created_at','desc')->paginate(8);
        return view('user.home',compact('question'));
    }

    public function search(Request $request) {
        $searched_quizzes = Question::select('questions.*','users.name as user_name')
        ->leftJoin('users','questions.user_id','users.id')
        ->where('title', 'LIKE', '%' . $request->search_key . '%')
        ->orWhere('desc','LIKE' , '%' . $request->search_key . '%')
        ->get();
        return response()->json($searched_quizzes, 200);
    }

    public function all(){
        $question =  Question::select('questions.*','users.name as user_name')
        ->leftJoin('users','questions.user_id','users.id')
        ->orderBy('created_at','desc')->paginate(4);
        $total_question = count($question);
        return view('user.seeAll',compact('question','total_question'));
    }

}
