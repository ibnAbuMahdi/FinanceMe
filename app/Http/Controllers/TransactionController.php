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
        return view('transactions', ['data' => $response->json(), 'title' => null]);
    }

    public function create(Request $request){
        $tenant = session('tenant');
        $data = $request->validate([
            'title'=>['required'],
            'date' => ['required'],
            'time' => ['required'],
            'category'=>[],
            'description'=>[],
            'amount'=>['required'],
            'budget' => []
        ]);
        $tenants = ['personal' => 1, 'corporate' => 2];
        $data['tenant'] = $tenants[$tenant];
        $data['date'] = "{$data['date']} {$data['time']}";
        unset($data['time']);
        // dd($data);
        $budgets_array = [];
        foreach(session('budgets') as $budget){
            $budgets_array[$budget['id']] = $budget['title'];
        }
        $data['budget'] = array_search($data['budget'], $budgets_array);
        $response = Http::withToken(session('token'))->post("$tenant.localhost:8000/transactions/", $data);
        if(!$response->successful()){
            $response->throw();
            return back()->withErrors("An error was encountered.");
        }
        return redirect('dashboard')->with('success-alert', 'Transaction added successfully!');;
    }

    public function update(Request $request){
        $data = $request->validate([
            'id' => ['required'],
            'title'=>['required'],
            'date' => ['required'],
            'time' => ['required'],
            'category'=>[],
            'description'=>[],
            'amount'=>['required'],
        ]);
        $data['date'] = "{$data['date']} {$data['time']}";
        $tenant = session('tenant');
        // dd($data);
        $response = Http::withToken(session('token'))->patch("$tenant.localhost:8000/transactions/{$data['id']}/", $data);
        if(!$response->successful()){
            $response->throw();
            return back()->withErrors("An error was encountered.");
        }
        return back()->with('success-alert', 'Transaction updated successfully!');
    }

    public function destroy(string $id){
            $tenant = session('tenant');
            $response = Http::withToken(session('token'))->delete("$tenant.localhost:8000/transactions/$id/");
            if(!$response->successful()){
                return back()->withErrors("An error was encountered.");
            }
            $data = $response->json();
            return back()->with('success-alert',"Transaction deleted successfully.");
    }
}
