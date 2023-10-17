<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Answer Quizzes</title>
  <!-- bootstrap 5 cdn  -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->

  <!-- custom bootstrap 5  -->
  <link rel="stylesheet" href="{{asset('css/custom.css')}}">
  <!-- style css  -->
  <link rel="stylesheet" href="{{asset('css/style.css')}}">

  <!-- button css  -->
  <link rel="stylesheet" href="{{asset('css/button.css')}}">
  <!-- answer input css  -->
  <!-- <link rel="stylesheet" href="./css/answer-input.css"> -->
  <!-- fontawesome  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- bootstrap icon  -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- google font link -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,400;1,500;1,700;1,1000&display=swap"
    rel="stylesheet">
  <!-- icon link  -->
  <link rel="icon" href="{{asset('images/logo.png')}}">
  <!-- vue js 2 cdn  -->
  <script src="https://cdn.jsdelivr.net/npm/vue@2.7.14/dist/vue.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios@0.21.1/dist/axios.min.js"></script>

  <!-- sweet alert cdn  -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body >
  <section id="answer" >
    <div class="container-fluid" :class="{'bg-image-dark':darkModeStatus,'bg-image-light':!darkModeStatus}" style="min-height: 100vh;">
      <div class="row">
        <nav class="navbar fixed-top" :class="{'card-body-dark border-bottom':darkModeStatus,'bg-white shdw border-bottom border-2 border-primary' :!darkModeStatus}">
          <div class="container">
            <a class="navbar-brand ms-2" href="#">
              <img src="{{asset('./images/logo.png')}}" alt="Bootstrap" width="50">
            </a>
            <span class="me-auto fw-bold" style="color:#3e79d5;">QUIZ PLUS</span>
            <button @click="toggleDarkMode" class="btn rounded-circle border border-2 fs-5" :class="{'btn-outline-light':darkModeStatus,'text-dark ':!darkModeStatus}"><i :class="{'bi bi-moon-stars-fill ':darkModeStatus,'bi bi-sun-fill':!darkModeStatus}"></i></button>
            <div class=" ms-4">
                <a href="{{route('login')}}" class="text-decoration-none fw-semibold" :class="{'text-light':darkModeStatus}">Login</a>
                <span class="fs-4 mx-2 fw-semibold" :class="{'text-light':darkModeStatus}">|</span>
                <a href="{{route('register')}}" class="text-decoration-none fw-semibold" :class="{'text-light':darkModeStatus}">Register</a>
            </div>

        </div>
        </nav>
      </div>
      <div class="row pt-md-5 justify-content-center" style="margin-top: 60px;">
    </div>
      {{-- <div class="row pt-md-5 justify-content-center" style="margin-top: 60px;">
          <div class="col-md-4">

              <div class="preview-form px-4 mt-5"  >
                <h5 class="mb-3 fw-semibold card p-3" :class="{'card-body-dark':darkModeStatus}">{{formTitle}}</h5>
                <div class="progress mb-1 bg-white shdw" style="height: 10px;" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-success" :style="{width: currentQuiz / (questionList.length/100) + '%'}" ></div>
                </div>
                <p class="mb-3 text-end" :class="{'text-light':darkModeStatus}"><b class="text-success">{{currentQuiz}}</b><b> / {{questionList.length}}</b></p>
                <div v-html="answerMessage" v-if="answerStatus !== null" class="alert text-light fw-semibold" :class="{'bg-right':answerStatus,'bg-wrong':answerStatus === false}" role="alert">
                </div>
                <div class="" v-for="question in paginatedQuizzes" :key="question.id">
                    <div class="d-flex align-items-center justify-content-between">
                      <button class="btn rounded-bottom-0 me-1 fw-bold" :class="{'btn-primary':!darkModeStatus,'btn-light text-dark':darkModeStatus}">
                        Quiz {{question.id + 1}}
                      </button>
                      <button @click="showAnswer(question.id)" class="btn" :class="{'text-light':darkModeStatus}">help<i class="fa-solid fa-question text-danger fs-5"></i></button>
                    </div>
                    <div class="form-box card card-body mb-3 border rounded-top-0 rounded-end" :class="{'card-body-dark border-1 border-light':darkModeStatus,'border-primary border-2':!darkModeStatus}">

                      <div class="d-flex justify-content-between">
                        <div class="mb-2">
                          <p class="fw-semibold mb-1" v-if="question.questionText">{{question.questionText}}</p>
                          <div v-if="question.multipleText">
                            <p class="mb-0 fw-semibold">{{question.multipleText}}</p>
                          </div>
                        </div>
                      </div>
                      <div v-for="(choice, choiceIndex) in question.choices" :key="choiceIndex" class="form-check">
                        <input class="form-check-input me-2" :name="'choice'+question.id"
                          :id="'choice' + question.id + choiceIndex" type="radio" v-model="selectedChoice"
                          :value="choice">
                        <label class="form-check-label" :for="'choice' + question.id + choiceIndex">
                          {{ choice }}
                        </label>
                      </div>
                      <input @keyup.enter="checkAnswer(question.id)" :class="{'answer-input-dark':darkModeStatus,'answer-input':!darkModeStatus}" v-if="question.questionText" placeholder="Your answer here" v-model="answer" name="userAnswer" type="text">
                    </div>
                  <button :disabled="answerStatus" @click="checkAnswer(question.id)" class="btn btn-primary mb-4 w-100" :class="{'btn-answer-check-dark' : darkModeStatus}"><i class="bi bi-journal-check me-2"></i>Check Answer</button>
                  </div>


                  <div class="d-flex justify-content-between">
                    <!-- <button @click="changeQuiz(currentQuiz - 1)" :disabled="currentQuiz === 1" class="btn btn-outline-primary"><i class="bi bi-caret-left-fill me-2"></i>Prev</button> -->
                    <button :class="{'text-light':darkModeStatus}" @click="changeQuiz(currentQuiz + 1)" :hidden="currentQuiz === (questionList.length + 1) || !answerStatus" class="btn ms-auto">{{nextQuiz}}<i class="bi bi-caret-right-fill ms-2"></i></button>
                  </div>
                </div>
          </div>

      </div> --}}

    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
  </script>

  <script src="{{asset('js/answer.js')}}"></script>


</body>

</html>
