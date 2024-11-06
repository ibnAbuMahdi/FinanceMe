<?php

namespace App\Http\Controllers;

class GeneralController extends Controller
{
    public function dashboard(){
        return view('dashboard');
    }

    public function history(){
        return view('history');
    }
}
