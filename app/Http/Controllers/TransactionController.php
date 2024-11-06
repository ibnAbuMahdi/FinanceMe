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
            'amount'=>['required']
            
        ]);
        $tenants = ['personal' => 1, 'corporate' => 2];
        $data['tenant'] = $tenants[$tenant];
        $response = Http::withToken(session('token'))->post("$tenant.localhost:8000/transactions/", $data);
        if(!$response->successful()){
            $response->throw();
            return back()->withErrors("An error was encountered.");
        }
        return redirect('dashboard');
    }

    public function view(){

    }

    public function destroy(){

    }
}
