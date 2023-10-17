@extends('user.layout.master')


@section('vue-id')
<div id="setting">
@endsection
@section('content')
    <div class="row p-3">

        <div class="col-md-4 offset-md-4 py-4 px-2 rounded" :class="{'card-body-dark':darkModeStatus,'card':!darkModeStatus}" style="margin-top: 100px;">
            <div class="profile-container d-flex justify-content-center">
                <img class="rounded-circle border border-2" src="{{asset('images/default-avatar.jpg')}}" width="60" alt="">
            </div>
            <p class="text-center mt-2 mb-1 txt-primary fw-semibold fs-4">{{Auth::user()->name}}</p>
            <p class="text-center" :class="{'text-light opacity-50':darkModeStatus,'text-muted':!darkModeStatus}">{{Auth::user()->email}}</p>
            <div class="border-bottom border-2 mb-3"></div>
            <div :class="{'setting-card-dark':darkModeStatus,'setting-card-light':!darkModeStatus}" class="setting-card d-flex  justify-content-between align-items-center">
                <div class="p-2 fw-semibold"><button class="btn me-2" :class="{'text-dark bg-light':!darkModeStatus,'text-white bg-dark':darkModeStatus}"><i class="bi bi-moon-fill"></i></button> Dark Mode</div>
                <div class="form-check form-switch me-2" @change="toggleDarkMode">
                    <input class="form-check-input form-check-input-lg" :checked="darkModeStatus" type="checkbox" role="switch" id="flexSwitchCheckDefault">
              </div>
            </div>
            <div :class="{'setting-card-dark':darkModeStatus,'setting-card-light':!darkModeStatus}" class="setting-card d-flex  justify-content-between align-items-center ">
                <div class="p-2 fw-semibold"><button class="btn me-2" :class="{'text-dark bg-light':!darkModeStatus,'text-white bg-dark':darkModeStatus}"><i class="fa-solid fa-user-astronaut"></i></button> Personal Information</div>
                <i class="fa-solid fa-chevron-right cursor-pointer me-4"></i>
            </div>
            <div :class="{'setting-card-dark':darkModeStatus,'setting-card-light':!darkModeStatus}" class="setting-card d-flex  justify-content-between align-items-center ">
                <div class="p-2 fw-semibold"><button class="btn me-2" :class="{'text-dark bg-light':!darkModeStatus,'text-white bg-dark':darkModeStatus}"><i class="fa-solid fa-shield-halved"></i></button> Account Security</div>
                <i class="fa-solid fa-chevron-right cursor-pointer me-4"></i>
            </div>
            <div class="mt-2">
                    <form method="POST" action="{{route('logout')}}" class="p-2 d-flex justify-content-center">
                        @csrf
                        <button type="submit" class="btn w-75 rounded " :class="{'text-light bg-warning':!darkModeStatus,'text-dark bg-info':darkModeStatus}">
                            <i class="fa-solid fa-arrow-right-from-bracket me-2"></i>
                            <span class="fw-semibold">Logout</span>
                        </button>
                    </form>


            </div>
        </div>
    </div>
@endsection

@section('scriptSource')
<script src="{{asset('js/setting.js')}}"></script>
@endsection
