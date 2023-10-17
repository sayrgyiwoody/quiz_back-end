@extends('user.layout.master')

@section('style')
<link rel="stylesheet" href="{{asset('css/spinner.css')}}">
@endsection

@section('vue-id')
<div id="answer">
@endsection

@section('content')
<div class="row justify-content-center" style="margin-top: 120px;">
    <div class="col-md-4">
        <div class="px-4">
            <a href="{{route('user.home')}}" v-if="questionList=== '' " :class="{'text-primary':!darkModeStatus,'text-light':darkModeStatus}" class="text-decoration-none fs-5 fw-semibold"><i class="fa-solid fa-arrow-left me-2" style="cursor: pointer;"></i>Back</a>
            <a v-if="questionList" @click="backToHome" :class="{'text-primary':!darkModeStatus,'text-light':darkModeStatus}" class="text-decoration-none fs-5 fw-semibold"><i class="fa-solid fa-arrow-left me-2" style="cursor: pointer;"></i>Back</a>
        </div>
    </div>
</div>
<div class="row justify-content-center" >
    <div class="col-md-4" v-if="questionList">

        <div class="preview-form px-4 mt-3"  >
          <h5 class="mb-3 fw-semibold card p-3" :class="{'card-body-dark':darkModeStatus}">@{{ formTitle }}</h5>
          <div class="progress mb-1 bg-white shdw" style="height: 10px;" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar bg-success" :style="{width: currentQuiz / (questionList.length/100) + '%'}" ></div>
          </div>
          <p class="mb-3 text-end" :class="{'text-light':darkModeStatus}"><b class="text-success">@{{currentQuiz}}</b><b> / @{{questionList.length}}</b></p>
          <div v-if="loading" class="spinner-container"><div class="spinner"></div><span class="fw-semibold ms-2" :class="{'text-light':darkModeStatus}">Loading..</span></div>
          <div  v-html="answerMessage" v-if="answerStatus !== null" class="alert text-light fw-semibold" :class="{'bg-right':answerStatus,'bg-wrong':answerStatus === false,'d-none':answerMessage===null}" role="alert">
          </div>
          <div class="" v-for="question in paginatedQuizzes" :key="question.id">
              <div class="d-flex align-items-center justify-content-between">
                <button class="btn rounded-bottom-0 me-1 fw-bold" :class="{'btn-primary':!darkModeStatus,'btn-light text-dark':darkModeStatus}">
                  Quiz @{{question.id + 1}}
                </button>
                <button @click="showAnswer(question.id)" class="btn" :class="{'text-light':darkModeStatus}">need answer<i class="fa-solid fa-question text-danger fs-5"></i></button>
              </div>
              <div class="form-box card card-body mb-3 border rounded-top-0 rounded-end" :class="{'card-body-dark border-1 border-light':darkModeStatus,'border-primary border-2':!darkModeStatus}">

                <div class="d-flex justify-content-between">
                  <div class="mb-2">
                    <p class="fw-semibold mb-1" v-if="question.questionText">@{{question.questionText}}</p>
                    <div v-if="question.multipleText">
                      <p class="mb-0 fw-semibold">@{{question.multipleText}}</p>
                    </div>
                  </div>
                </div>
                <div v-for="(choice, choiceIndex) in question.choices" :key="choiceIndex" class="form-check">
                  <input class="form-check-input me-2" :name="'choice'+question.id"
                    :id="'choice' + question.id + choiceIndex" type="radio" v-model="selectedChoice"
                    :value="choice">
                  <label class="form-check-label" :for="'choice' + question.id + choiceIndex">
                    @{{ choice }}
                  </label>
                </div>
                <input @keyup.enter="checkAnswer(question.id)" :class="{'answer-input-dark':darkModeStatus,'answer-input':!darkModeStatus}" v-if="question.questionText" placeholder="Your answer here" v-model="answer" name="userAnswer" type="text">
              </div>
            <button :disabled="answerStatus" @click="checkAnswer(question.id)" class="btn btn-primary mb-4 w-100" :class="{'btn-answer-check-dark' : darkModeStatus}"><i class="bi bi-journal-check me-2"></i>Check Answer</button>
            </div>


            <div class="d-flex justify-content-between">
              <!-- <button @click="changeQuiz(currentQuiz - 1)" :disabled="currentQuiz === 1" class="btn btn-outline-primary"><i class="bi bi-caret-left-fill me-2"></i>Prev</button> -->
              <button :class="{'text-light':darkModeStatus}" @click="changeQuiz(currentQuiz + 1)" :hidden="currentQuiz === (questionList.length + 1) || !answerStatus" class="btn ms-auto">@{{nextQuiz}}<i class="bi bi-caret-right-fill ms-2"></i></button>
            </div>
          </div>
    </div>

    <div class="col-md-4" v-if="questionList === ''">
        <div class="px-4 mt-3">
            <div class="card card-body" :class="{'card-body-dark':darkModeStatus}">
                <h4 class=""><span class="fw-bold text-success">Quiz Title : </span><span>{{$question->title}}</span></h4>
                <hr class="mt-0">
                <div class="d-flex flex-column">
                    <span class="me-2 fw-bold text-success">Description:</span><span>{{$question->desc}}</span>
                </div>
            <button @click="getQuestionList" class="btn mt-4" :class="{'btn-answer-check-dark':darkModeStatus,'btn-primary':!darkModeStatus}">Start the Quiz</button>
            </div>
        </div>
    </div>

</div>


@endsection

@section('scriptSource')
<script src="{{asset('js/answer.js')}}"></script>
<script>
    var appData = @json(compact('question'));
</script>
@endsection
