<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\api\ActivityLogController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

//     return $request->user();
// });


//Quiz api

Route::get('/quiz/all',[QuizController::class,'getAllQuizzes']);

Route::get('/quiz/latest',[QuizController::class,'getLatestQuizzes']);
Route::get('/quiz/mostPlayed',[QuizController::class,'getMostPlayedQuizzes']);


Route::post('/search',[QuizController::class,'search']);

Route::get('/quiz/{id}',[QuizController::class,'getDetail']);

Route::post('/questionList',[QuizController::class,'getQuestionList']);

Route::post('/checkAnswer',[QuizController::class,'checkAnswer']);

Route::post('/getAnswer',[QuizController::class,'getAnswer']);


