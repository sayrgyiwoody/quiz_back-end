@extends('user.layout.master')

@section('vue-id')
<div id="answer">
@endsection

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3 swiper-container" style="height: 40vh;margin-top: 100px;">
        <div class="mt-3">
            <div class="mb-3">
                <a href="{{route('user.home')}}" :class="{'text-primary':!darkModeStatus,'text-light':darkModeStatus}" class="text-decoration-none fs-5 fw-semibold"><i class="fa-solid fa-arrow-left me-2" style="cursor: pointer;"></i>Back</a>
            </div>
            <div class="row g-2 flex-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="mb-2 fs-5" :class="{'text-light':darkModeStatus,}"><i class="fa-solid fa-dragon txt-primary me-2"></i>All Quizzes : <span class="text-success fw-semibold">{{$total_question}}</span></p>
                  </div>
                  @foreach ($question as $q)
                  <div style="width:45%;" class="col-6 me-2 text-center mb-2 card card-body d-flex justify-content-center align-item-center" :class="{'card-body-dark':darkModeStatus,'bg-white border border-2':!darkModeStatus}">
                    <div>
                        <div class="d-flex justify-content-center border-bottom border-2 pb-2 mb-1 w-100">
                          <i class="fa-solid fa-user-astronaut me-2"></i>
                          <span class="fw-semibold me-2">{{$q->user_name}}</span>
                          | <span class="fw-semibold ms-2">{{$q->created_at->format('M d ')}}</span>
                        </div>
                        <h3 class="my-1">{{$q->title}}</h3>
                        <p class=" mb-1" :class="{'text-muted':!darkModeStatus,'text-light opacity-50':darkModeStatus}">{{ Str::limit($q->desc, 80, ' ...') }}</p>
                        <a href="{{route('quiz.answerCheckPage',$q->id)}}" class="btn btn-light my-2" :class="{'btn-answer-check-dark' : darkModeStatus}"><i class="fa-solid fa-play me-2"></i>Play now</a>
                      </div>
                </div>
                  @endforeach

            </div>
            <div  class="float-end mt-2 me-md-2" :class="{'text-white':darkModeStatus}">
                {{$question->links()}}
            </div>
          </div>
    </div>
</div>
@endsection

@section('scriptSource')

<script src="{{asset('js/answer.js')}}"></script>

@endsection
