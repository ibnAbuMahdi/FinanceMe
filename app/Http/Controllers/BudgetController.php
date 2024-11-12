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
            return back()->withErrors("An error was encountered.");
        }
        return redirect('dashboard')->with('success-alert', 'Budget added successfully!');
    }

    public function view(string $id){
        $tenant = session('tenant');
        $response = Http::withToken(session('token'))->get("$tenant.localhost:8000/budgets/$id/");
        if(!$response->successful()){
            return back()->withErrors("An error was encountered.");
        }
        $data = $response->json();
        return view('transactions', ['data' => $data['transactions'], 'title' => $data['budget']['title']]);
    }

    public function destroy(string $id){
        $tenant = session('tenant');
        $response = Http::withToken(session('token'))->delete("$tenant.localhost:8000/budgets/$id/");
        if(!$response->successful()){
            return back()->withErrors("An error was encountered.");
        }
        $data = $response->json();
        return back()->with('success-alert',"Budget deleted successfully.");
    }

    public function update(Request $request){
        $data = $request->validate([
            'id' => ['required'],
            'title'=>['required'],
            'category'=>[],
            'amount'=>['required'],
            'period' => ['required']
        ]);
        $tenant = session('tenant');
        $data['period'] = strtolower($data['period']);
        // dd($data);
        $response = Http::withToken(session('token'))->patch("$tenant.localhost:8000/budgets/{$data['id']}/", $data);
        if(!$response->successful()){
            $response->throw();
            return back()->withErrors("An error was encountered.");
        }
        return back()->with('success-alert', 'Budget updated successfully!');
    }
}
