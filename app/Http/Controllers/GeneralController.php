<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

class GeneralController extends Controller
{
    public function dashboard(){
        $tenant = session('tenant');
        $response = Http::withToken(session('token'))->get("$tenant.localhost:8000/dashboard/");
        if($response->status() != 200){
            return back()->withErrors("An error was encountered.");
        }
        
        session(['budgets' => $response->json()[0]['budgets']]);
        return view('dashboard', ['data' => $response->json()]);
    }

    public function history(){
        return view('history');
    }
}
