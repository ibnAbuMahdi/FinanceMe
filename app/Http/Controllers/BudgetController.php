<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BudgetController extends Controller
{
    public function list(){
        $tenant = session('tenant');
        $response = Http::withToken(session('token'))->get("$tenant.localhost:8000/budgets/");
        if($response->status() != 200){
            return back()->withErrors("An error was encountered.");
        }
        return view('budgets', $response->json());
    }

    

    public function create(){
        
    }

    public function view(){

    }

    public function destroy(){

    }

    public function update(){
        
    }
}
