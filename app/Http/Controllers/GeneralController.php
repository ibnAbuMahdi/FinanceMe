<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

class GeneralController extends Controller
{
    public function dashboard(){
        $tenant = session('tenant');
        $selected_budget = session('selected_budget') ?? 1;
        $response = Http::withToken(session('token'))->get("$tenant.localhost:8000/dashboard/budgets/$selected_budget/");
        if($response->status() != 200){
            $response->throw();
            return back()->withErrors("An error was encountered.");
        }
        foreach($response->json()[0]['budgets'] as $budget){
            if ($selected_budget == $budget['id']) $budget_title = $budget['title']; 
        }
        session(['budgets' => $response->json()[0]['budgets']]);
        return view('/dashboard', ['data' => $response->json()[0], 'budget_title' => $budget_title]);
    }

    public function showTransactions(string $id){
        session('selected_budget', $id);
        return redirect('/dashboard');
    }
    public function history(){
        return view('history');
    }
}
