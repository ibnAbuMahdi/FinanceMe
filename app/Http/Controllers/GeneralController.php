<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Exceptions\HttpResponseException;

class GeneralController extends Controller
{
    public function dashboard(){
        return view('dashboard');
    }

    public function budgets(){
        $tenant = session('tenant');
        $response = Http::withToken(session('token'))->get("$tenant.localhost:8000/budgets/");
        if($response->status() != 200){
            return back()->withErrors("An error was encountered.");
        }
        return view('budgets', $response->json());
    }

    public function transactions(){
        $tenant = session('tenant');
        $response = Http::withToken(session('token'))->get("$tenant.localhost:8000/transactions/");
        if($response->status() != 200){
            return back()->withErrors("An error was encountered.");
        }
        return view('transactions', $response->json());
    }

    public function history(){
        return view('history');
    }
}
