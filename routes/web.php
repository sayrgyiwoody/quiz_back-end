<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserHomeController;
use App\Http\Controllers\AdminHomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if(Auth::user() && Auth::user()->role == 'user'){
        return redirect()->route('user.home');
    }elseif(Auth::user() && Auth::user()->role == 'admin') {
        return redirect()->route('admin.home');
    }
    return redirect()->route('user.home');
});

Auth::routes();

Route::redirect('register', 404);
Route::get('home',[UserHomeController::class,'home'])->name('user.home');
Route::get('allQuizzes',[UserHomeController::class,'all'])->name('user.allQuizzes');

Route::get('quiz/search',[UserHomeController::class,'search'])->name('quiz.search');

Route::group(['prefix'=>'answerCheck'],function(){
    Route::post('getQuestionList',[QuestionController::class,'getQuestionList'])->name('quiz.getQuestionList');
    Route::get('{id}',[QuestionController::class,'answerCheckPage'])->name('quiz.answerCheckPage');
    Route::post('getAnswer',[QuestionController::class,'getAnswer'])->name('quiz.getAnswer');
    Route::post('checkAnswer',[QuestionController::class,'checkAnswer'])->name('quiz.checkAnswer');
});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'])->group(function () {
    Route::get('/dashboard',[AuthController::class,'dashboard'])->name('dashboard');

    //admin
    Route::group(['prefix'=>'admin','middleware'=>'admin_auth'],function(){
        Route::get('home',[AdminHomeController::class,'home'])->name('admin.home');
    });

    //user
    Route::group(['prefix'=>'user','middleware'=>'user_auth'],function(){

        Route::group(['prefix'=>'quiz'],function(){
            Route::get('create',[QuestionController::class,'createPage'])->name('user.quizCreatePage');
            Route::post('create',[QuestionController::class,'create'])->name('quiz.create');
            Route::get('edit',[QuestionController::class,'editPage'])->name('user.quizEditPage');
            Route::post('delete',[QuestionController::class,'delete']);


        });
        Route::group(['prefix'=>'setting'],function(){
            Route::get('/',[UserController::class,'settingPage'])->name('setting.main');
        });
    });
});
