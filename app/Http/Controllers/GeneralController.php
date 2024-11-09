<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function dashboard(){
        $tenant = session('tenant');
        $selected_budget = session('selected_budget');
        $response = $selected_budget ?
            Http::withToken(session('token'))->get("$tenant.localhost:8000/dashboard/budgets/$selected_budget/")
        :
            Http::withToken(session('token'))->get("$tenant.localhost:8000/dashboard/");
        
        if($response->status() != 200){
            $response->throw();
            return back()->withErrors("An error was encountered.");
        }
        $budget_title = false;
        $budgets = $response->json()[0]['budgets'];
        foreach($budgets as $budget){
            if ($selected_budget == $budget['id']) $budget_title = $budget['title']; 
        }
        if(!$budget_title && count($budgets)) $budget_title = $budgets[0]['title']; 
        session(['budgets' => $response->json()[0]['budgets']]);
        return view('/dashboard', ['data' => $response->json()[0], 'budget_title' => $budget_title]);
    }

    public function showTransactions(string $id){
        session('selected_budget', $id);
        return redirect('/dashboard');
    }
    public function history(){
        $tenant = session('tenant');
        $response = Http::withToken(session('token'))->get("$tenant.localhost:8000/budgets/history/");
        
        if($response->status() != 200){
            $response->throw();
            return back()->withErrors("An error was encountered.");
        }
        // dd($response->json());
        return view('history', ['data' => $response->json()]);
    }
}
