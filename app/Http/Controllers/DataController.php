<?php

namespace App\Http\Controllers;

use App\Data;

class DataController extends Controller
{
    public function getPayment(){
        return view('payment');
    }

    public function getRegister(){
        return view('register');
    }

}
