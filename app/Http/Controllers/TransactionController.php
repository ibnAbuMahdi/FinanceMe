<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransactionController extends Controller
{
    public function list(){
        $tenant = session('tenant');
        $response = Http::withToken(session('token'))->get("$tenant.localhost:8000/transactions/");
        if($response->status() != 200){
            return back()->withErrors("An error was encountered.");
        }
        return view('transactions', ['data' => $response->json()]);
    }

    public function create(Request $request){
        $tenant = session('tenant');
        $data = $request->validate([
            'title'=>['required'],
            'category'=>[],
            'description'=>[],
            'amount'=>['required'],
            'budget' => []
        ]);
        $tenants = ['personal' => 1, 'corporate' => 2];
        $data['tenant'] = $tenants[$tenant];
        $budgets_array = [];
        foreach(session('budgets') as $budget){
            $budgets_array[$budget['id']] = $budget['title'];
        }
        $data['budget'] = array_search($data['budget'], $budgets_array);
        $response = Http::withToken(session('token'))->post("$tenant.localhost:8000/transactions/", $data);
        if(!$response->successful()){
            return back()->withErrors("An error was encountered.");
        }
        return redirect('dashboard')->with('transaction-add', 'Transaction added successfully!');;
    }

    public function view(){

    }

    public function destroy(){

    }
}
