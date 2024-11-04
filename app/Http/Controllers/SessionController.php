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
        return view('auth.login');
    }

    public function store(){
        // validate
        $creds = request()->validate([
            'username' => ['required', 'email'],
            'password' => ['required'],
            'account_type' => ['required']
        ]);
        // attempt to login user
        $tenant = strtolower($creds['account_type']);

        $response = Http::post("$tenant.localhost:8000/login/", $creds);
        // dd($response->status());
        //! Auth::attempt($creds)
        if($response->status() != 200){
            throw ValidationException::withMessages([
                'username' => 'Sorry, these credentials do not match.'
            ]);
        }
        Session::put('token', $response->json()->token);
        // regenerate the token
        request()->session()->regenerate();
        //todo: dashboard view
        return redirect('/dashboard');
    }


    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Auth::logout();
        return redirect('/');
    }
}
