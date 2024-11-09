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
        return view('budgets', ['data' => $response->json()]);
    }

    public function create(Request $request){
        $tenant = session('tenant');
        $data = $request->validate([
            'title'=>['required'],
            'category'=>[],
            'amount'=>['required'],
            'period' => ['required']
        ]);
        $data['period'] = strtolower($data['period']);
        $tenants = ['personal' => 1, 'corporate' => 2];
        $data['tenant'] = $tenants[$tenant];
        $response = Http::withToken(session('token'))->post("$tenant.localhost:8000/budgets/", $data);
        if(!$response->successful()){
            $response->throw();
            return back()->withErrors("An error was encountered.");
        }
        return redirect('dashboard')->with('budget-add', 'Budget added successfully!');
    }

    public function view(){

    }

    public function destroy(){

    }

    public function update(){
        
    }
}
