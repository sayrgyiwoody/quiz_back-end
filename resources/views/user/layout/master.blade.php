<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Quizzes Plus</title>
  <!-- bootstrap 5 cdn  -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->

  <!-- custom bootstrap 5  -->
  <link rel="stylesheet" href="{{asset('./css/custom.css')}}">
  <!-- style css  -->
  <link rel="stylesheet" href="{{asset('./css/style.css')}}">

  <!-- button css  -->
  <link rel="stylesheet" href="{{asset('./css/button.css')}}">
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
  <link rel="icon" href="{{asset('./images/logo.png')}}">
  <!-- vue js 2 cdn  -->
  <script src="https://cdn.jsdelivr.net/npm/vue@2.7.14/dist/vue.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/axios@0.21.1/dist/axios.min.js"></script>
  <!-- sweet alert cdn  -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  {{-- login css --}}
  <link rel="stylesheet" href="{{asset('./css/login.css')}}">

</head>
@yield('style')
<body>
    @yield('vue-id')
    <div class="container-fluid" :class="{'bg-image-dark':darkModeStatus,'bg-image-light':!darkModeStatus}" style="min-height: 100vh;padding-bottom: 80px;">
    <div class="row">
      <nav class="navbar fixed-top" :class="{'card-body-dark border-bottom':darkModeStatus,'bg-white shdw border-bottom border-2 border-primary' :!darkModeStatus}">
        <div class="container">
          <a class="navbar-brand ms-2" href="#">
            <img src="{{asset('./images/logo.png')}}" alt="Bootstrap" width="50">
          </a>
          <span class="me-auto fw-bold" style="color:#3e79d5;">QUIZ PLUS</span>
          @if (!Auth::user())
            <button @click="toggleDarkMode" class="btn rounded-circle border border-2 fs-5" :class="{'btn-outline-light':darkModeStatus,'text-dark ':!darkModeStatus}"><i :class="{'bi bi-moon-stars-fill ':darkModeStatus,'bi bi-sun-fill':!darkModeStatus}"></i></button>
            <a href="{{route('login')}}" class="btn btn-primary ms-3 px-3 py-2">Login</a>
          @endif
          @yield('previewDiv')


        </div>
      </nav>
    </div>
    @if (Auth::user())
    <div class="row">
        <nav class="navbar pb-0 pb-lg-1 navbar-expand pt-0 pt-md-2 fixed-bottom" :class="{'card-body-dark border-top':darkModeStatus,'bg-white shdw border-top border-2 border-primary':!darkModeStatus}">
          <div class="container d-flex justify-content-center">
            <ul class="navbar-nav fw-semibold px-5 justify-content-center">
              <li class="nav-item mx-3"><a href="{{route('user.home')}}" class="nav-link d-flex align-items-center" :class="{'text-primary':!darkModeStatus,'text-white':darkModeStatus}"><i
                    class="bi" :class="{'bi-house-fill':isCurrentRoute('/home'),'bi-house':!isCurrentRoute('/home')}"></i><span class="d-none d-md-inline ms-2">Home</span></a></li>
              <li class="nav-item mx-3"><a href="{{route('user.quizCreatePage')}}" class="nav-link d-flex align-items-center" :class="{'text-primary':!darkModeStatus,'text-white':darkModeStatus}"><i
                    class="bi" :class="{'bi-plus-square-fill':isCurrentRoute('/user/quiz/create'),'bi-plus-square':!isCurrentRoute('/user/quiz/create')}"></i><span class="d-none d-md-inline ms-2">Create</span></a></li>
              <li class="nav-item mx-3"><a href="{{route('user.quizEditPage')}}" class="nav-link d-flex align-items-center" :class="{'text-primary':!darkModeStatus,'text-white':darkModeStatus}"><i
                    class="bi bi-pencil-square"></i><span class="d-none d-md-inline ms-2">Edit</span></a></li>
              <li class="nav-item mx-3"><a href="{{route('setting.main')}}" class="nav-link d-flex align-items-center" :class="{'text-primary':!darkModeStatus,'text-white':darkModeStatus}"><i
                  class="bi" :class="{'bi-gear-fill':isCurrentRoute('/user/setting'),'bi-gear':!isCurrentRoute('/user/setting')}"></i><span class="d-none d-md-inline ms-2">Setting</span></a></li>
            </ul>
          </div>
        </nav>
      </div>
    @endif
    @yield('content')
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
  </script>



  @yield('scriptSource')

</body>

</html>
