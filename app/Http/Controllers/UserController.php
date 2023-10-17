<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //setting page
    public function settingPage(){
        return view('user.setting.main');
    }
}
