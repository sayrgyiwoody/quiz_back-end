{{-- <!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register Form</title>
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

  <!-- login css link -->
  <link rel="stylesheet" href="{{asset('./css/login.css')}}">
</head>

<body>

    <div id="register-form" class="login-bg">
        <div class="container-fluid">
          <div class="row p-4 p-lg-5 mt-5 mt-lg-0">
              <div id="login-box" class="col-md-4 offset-md-4 px-2 py-4 p-lg-4 shdw rounded rounded-3">
                <div class="img-container d-flex justify-content-center mb-2">
                  <img src="./images/logo.png" style="cursor: pointer;" width="60" >
                </div>
              <h2 class="fw-bold text-center text-white">Register</h2>
                  <p class="text-center text-white">Register and Create your own Quizzes.</p>
                  <hr class="mb-0 text-white">

                  <form method="POST" action="{{route('register')}}" class="px-2">
                    @csrf
                      <div class="input-gp my-4">
                        <input value="{{old('name')}}" required="" name="name" type="text" class="login-input">
                        <label for="" class="login-label">Enter Name</label>
                      </div>
                      @error('name')
                          <span class="text-danger">{{$message}}</span>
                      @enderror
                      <div class="input-gp my-4">
                          <input value="{{old('email')}}" required="" name="email" type="text" class="login-input">
                          <label for="" class="login-label">Enter Email</label>
                      </div>
                      @error('email')
                          <span class="text-danger">{{$message}}</span>
                      @enderror
                      <div class="input-gp my-4">
                        <input required="" name="password" :type="passwordFieldType" class="login-input" v-model="password" @input="validatePassword">
                        <label for="" class="login-label">Enter Password</label>
                        <i class="bi eye-icon" @click="togglePasswordVisibility" :class="{'bi-eye':passwordFieldType == 'password','bi-eye-slash':passwordFieldType == 'text'}" ></i>
                      </div>
                      @error('password')
                          <span class="text-danger">{{$message}}</span>
                      @enderror
                      <div v-if="password" class="card p-3 validation-text card-body-dark">
                        <span>Your password must contain:</span>
                        <span class="d-flex align-items-center" :class="{'txt-success' : passwordLengthValid}"><i class="fa-solid me-2" :class="{'fa-check' : passwordLengthValid , 'fa-circle' : !passwordLengthValid}"></i>At least 8 characters</span>
                        <span class="d-flex align-items-center" :class="{'txt-success' : atLeast3}"><i class="fa-solid me-2" :class="{'fa-check' : atLeast3 , 'fa-circle' : !atLeast3}"></i>At least 3 of the following: </span>
                        <span class="ms-3 d-flex align-items-center" :class="{'txt-success' : passwordLowerValid}"><i class="fa-solid me-2" :class="{'fa-check' : passwordLowerValid , 'fa-circle' : !passwordLowerValid}"></i>Lower case letters</span>
                        <span class="ms-3 d-flex align-items-center" :class="{'txt-success' : passwordUpperValid}"><i class="fa-solid me-2" :class="{'fa-check' : passwordUpperValid , 'fa-circle' : !passwordUpperValid}"></i>Upper case letters(A-Z)</span>
                        <span class="ms-3 d-flex align-items-center" :class="{'txt-success' : passwordNumberValid}"><i class="fa-solid me-2" :class="{'fa-check' : passwordNumberValid , 'fa-circle' : !passwordNumberValid}"></i>Numbers (0-9)</span>
                        <span class="ms-3 d-flex align-items-center" :class="{'txt-success' : passwordSpecialValid}"><i class="fa-solid me-2" :class="{'fa-check' : passwordSpecialValid , 'fa-circle' : !passwordSpecialValid}"></i>Special characters (e.g. !@#$%^&*)</span>
                    </div>
                      <div class="input-gp my-4">
                        <input required="" name="password_confirmation" :type="confirmPasswordFieldType" class="login-input" v-model="password_confirmation">
                        <label for="" class="login-label">Enter Confirm Password</label>
                        <i class="bi eye-icon" @click="toggleConfirmPasswordVisibility" :class="{'bi-eye':confirmPasswordFieldType == 'password','bi-eye-slash':confirmPasswordFieldType == 'text'}" ></i>
                    </div>
                      <div class="d-flex justify-content-center">
                          <button :disabled="(!atLeast3 || !passwordLengthValid)" type="submit" class="btn btn-lg btn-primary w-100 btn-login">Register</button>
                      </div>
                  </form>
              </div>
              <span class="text-center mt-2 text-white fw-semibold">Already have an account ? <a href="{{route('login')}}" style="color:#3e79d5;" >Login</a></span>
          </div>
      </div>
      </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
  </script>

  <script src="{{asset('./js/register.js')}}"></script>

  <!-- vue js codes here  -->



</body>

</html> --}}
