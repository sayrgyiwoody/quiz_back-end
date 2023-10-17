@extends('user.layout.master')
@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<style>
    .swiper {
      width: 100%;
      height: 100%;
    }

    .swiper-slide {
      text-align: center;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .swiper-slide {
      width: 80%;
      transition: .5s;
      cursor: pointer;
    }

    .swiper-slide:hover{
        color: #222222;
        background-color: #4790d2;
    }

    .info-card {
        font-weight: 600;
        transition: .5s;
        cursor: pointer;
    }

    .info-card:hover {
        color: #222222;
        background-color: #4790d2;
    }

    .search-card {
        width:50%;
    }

    .rules {
        transition: .5s;
        cursor: pointer;
    }

    .rules:hover {
        color: #222222;
        background-color: #5588d7;
    }
    .rules:hover .rules small{
        color: #fff !important;
        opacity: 1 !important;
    }

    .copyright{
        position: absolute;
        bottom: 15px;
        width: 100%;
        display: flex;
        justify-content: center;
    }
</style>
@endsection
@section('vue-id')
<div id="answer">
@endsection
@section('content')
    <div class="row">

        <div class="col-md-6 offset-md-3 swiper-container" style="height: 40vh;margin-top: 100px;">
            <div class="row pe-3">
                <div class="input-gp col-8 mb-3">
                    <input v-model="search_input" @input="search" required="" name="" id="search_input" type="text" :class="{'login-input':darkModeStatus,'input':!darkModeStatus}" value="">
                    <label style="left:30px" for="" :class="{'login-label':darkModeStatus,'label':!darkModeStatus}">Search Quizzes Here</label>
                    <i class="bi eye-icon bi-search " v-if="search_input===''" style="right:30px"></i>
                    <i  class="bi eye-icon bi-x-circle " v-if="search_input" style="right:30px"></i>

                </div>
                <div @click="showRules" class="col-4 mb-3 card card-body rules d-flex justify-content-center align-items-center" :class="{'card-body-dark':darkModeStatus,'border border-2':!darkModeStatus}">
                    <div class="text-center " >
                        <span><i class="fa-solid fa-scale-balanced me-2"></i><span class="d-none d-md-inline">Quiz</span> Rules</span>

                    </div>
                </div>
            </div>
            @if (Auth::user())


            @else
            <div v-if="search_input===''" class="alert alert-dismissible fade show" :class="{'card-body-dark':darkModeStatus,'bg-white border border-2':!darkModeStatus}" role="alert">
                <div class="d-flex align-items-center h4 " :class="{'text-dark':!darkModeStatus,'text-white':darkModeStatus}">
                    <span class="me-3"><i class="fa-solid fa-rocket txt-primary"></i></span>
                    <span class="fw-semibold txt-primary fw-bold">Hello Welcome to Quiz Plus,</span>
                </div>
                <span class="" :class="{'text-muted':!darkModeStatus,'text-white':darkModeStatus}">You can play Quiz games for free with your friend or on your own. Enjoy a variety of quizzes and unleash your creativity. Let's start quizzing!</span>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            <div class="mt-3" v-if="search_input">
                <div class="row g-2 flex-wrap">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-2 fs-5" :class="{'text-light':darkModeStatus,}"><i class="fa-solid fa-magnifying-glass txt-primary me-2"></i>Searched Quizzes : <span class="text-success fw-semibold">@{{searched_quizzes.length}}</span></p>
                      </div>
                    <div style="width:45%;" class="col-6 me-2 text-center mb-2 card card-body d-flex justify-content-center align-item-center" v-for="SQ in paginatedQuestions" :class="{'card-body-dark':darkModeStatus,'bg-white border border-2':!darkModeStatus}">
                        <div>
                            <div class="d-flex justify-content-center border-bottom border-2 pb-2 mb-1 w-100">
                              <i class="fa-solid fa-user-astronaut"></i>
                              <span class="fw-semibold">@{{SQ.user_name }}</span>
                            </div>
                            <h3 class="my-1">@{{SQ.title}}</h3>
                            <p class=" mb-1" :class="{'text-muted':!darkModeStatus,'text-light opacity-50':darkModeStatus}">@{{truncatedDesc(SQ.desc)}}</p>
                            <a @click="changeURL(SQ.id)" class="btn btn-light my-2" :class="{'btn-answer-check-dark' : darkModeStatus}"><i class="fa-solid fa-play me-2"></i>Play now</a>
                          </div>
                    </div>
                </div>
                <div  class="float-end me-md-2" :class="{'text-white':darkModeStatus}">
                    <button @click="changePage(currentPage -1)" :disabled="currentPage === 1" class="btn border-0" :class="{'text-white':darkModeStatus}"><i class="bi bi-arrow-left-square fs-3"></i></button>
                  Page @{{currentPage}}/@{{totalPages}}
                  <button  @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages" class="btn border-0" :class="{'text-white':darkModeStatus}"><i class="bi bi-arrow-right-square fs-3"></i></button>
                  </div>
              </div>
              <div class="popular-card">
                <div  class="swiper mySwiper mt-4">
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="mb-3 fs-5" :class="{'text-light':darkModeStatus,}"><i class="fa-solid fa-bell txt-primary me-2"></i>Latest Quizzes</p>
                      <a href="{{route('user.allQuizzes')}}" class="text-decoration-none" style="cursor: pointer;" :class="{'text-light':darkModeStatus,}">See all<i class="fa-solid fa-angles-right txt-primary ms-2"></i></a>
                    </div>
                      <div class="swiper-wrapper">
                          @foreach ($question as $q)
                                  <div :class="{'card-body-dark':darkModeStatus,'bg-white border border-2':!darkModeStatus}" class="swiper-slide card card-body">
                                    <div class=" border-bottom border-2 pb-2 mb-1 w-75">
                                      <i class="fa-solid fa-user-astronaut"></i>
                                      <span class="fw-semibold">{{$q->user_name}}</span>
                                      | <span class="fw-semibold">{{$q->created_at->format('M d ')}}</span>
                                    </div>
                                    <h3 class="my-1">{{$q->title}}</h3>
                                    <p class=" mb-1" :class="{'text-muted':!darkModeStatus,'text-light opacity-50':darkModeStatus}">{{ Str::limit($q->desc, 80, ' ...') }}</p>
                                    <a href="{{route('quiz.answerCheckPage',$q->id)}}" class="btn btn-light my-2" :class="{'btn-answer-check-dark' : darkModeStatus}"><i class="fa-solid fa-play me-2"></i>Play now</a>
                                  </div>
                              </a>
                          @endforeach

                      </div>
                    </div>

              </div>



        </div>
        <div class="copyright">
            <div :class="{'text-light':darkModeStatus}">
                <i class="fa-solid fa-copyright"></i> 2023 Wai Yan Tun , All Rights Reserved
            </div>
        </div>
    </div>


  @endsection

  @section('scriptSource')
  <script src="{{asset('js/answer.js')}}"></script>
  <!-- Swiper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/10.0.4/swiper-bundle.min.js"></script>
  <script>
    var swiper = new Swiper(".mySwiper", {
      slidesPerView: "auto",
      spaceBetween: 30,
      pagination: {
        el: ".swiper-pagination",
        clickable: false,
      },
    });
  </script>

<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function(){
        $('#search_input').focus(function(){
            $('.popular-card').css('display','none');

        })

        $('#search_input').focusout(function(){
            if($('#search_input').val() === '') {
                $('.popular-card').css('display','block');
            }
        })


    })
</script>
@endsection
