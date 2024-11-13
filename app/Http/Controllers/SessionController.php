<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(session('token')) {
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    public function store(){
        // validate
        $creds = request()->validate([
            'username' => ['required'],
            'password' => ['required'],
            'account_type' => ['required']
        ]);
        // attempt to login user
        $tenant = strtolower($creds['account_type']);
        $tenants = ['personal' => 1, 'corporate' => 2];
        $creds['tenant'] = $tenants[$tenant];
        $response = Http::post("{$this->base_url}login/", $creds);
        // dd($response->status());
        //! Auth::attempt($creds)
        if(!$response->successful()){
            throw ValidationException::withMessages([
                'username' => 'Sorry, these credentials do not match.'
            ]);
        }
        session()->forget(['tenant', 'token', 'username', 'email']);
        session(['tenant' => $tenants[$tenant], 'token' => $response->json()['token'], 'username' => $response->json()['username'], 'email' => $response->json()['email']]);
        // regenerate the token
        request()->session()->regenerate();
        return redirect('/dashboard');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        // Auth::logout();
        session()->forget(['tenant', 'token', 'username', 'email', 'selected_budget']);
        return redirect('/');
    }
}
