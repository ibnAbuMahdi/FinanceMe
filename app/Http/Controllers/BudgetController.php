<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BudgetController extends Controller
{
    public function list(){
        $tenant = session('tenant');
        $response = Http::withToken(session('token'))->get("{$this->base_url}budgets/");
        if(!$response->successful()){
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
        $data['tenant'] = $tenant;
        $response = Http::withToken(session('token'))->post("{$this->base_url}budgets/", $data);
        if(!$response->successful()){
            return back()->withErrors("An error was encountered.");
        }
        return redirect('dashboard')->with('success-alert', 'Budget added successfully!');
    }

    public function view(string $id, string $status = null){
        $response = $status ? 
            Http::withToken(session('token'))->get("{$this->base_url}budgets/$id/?active=false")
        :
            Http::withToken(session('token'))->get("{$this->base_url}budgets/$id/");

        if(!$response->successful()){
            $response->throw();
            return back()->withErrors("An error was encountered.");
        }
        $data = $response->json();
        return view('transactions', ['data' => $data['transactions'], 'title' => $data['budget']['title']]);
    }

    public function destroy(string $id){
        $response = Http::withToken(session('token'))->delete("{$this->base_url}budgets/$id/");
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
            'period' => ['required'],
            'status' => [],
        ]);
        $data['period'] = strtolower($data['period']);
        if(in_array($data['status'], ['Active', 'Inactive'])){
            $data['active'] = $data['status'] == 'Active' ? true : false;
        }
        unset($data['status']);
        $response = $request->query('status') == 'inactive' ?
            Http::withToken(session('token'))->patch("{$this->base_url}budgets/inactive/{$data['id']}/", $data)
        :
            Http::withToken(session('token'))->patch("{$this->base_url}budgets/{$data['id']}/", $data);

        if(!$response->successful()){
            $response->throw();
            return back()->withErrors("An error was encountered.");
        }
        return back()->with('success-alert', 'Budget updated successfully!');
    }
}
