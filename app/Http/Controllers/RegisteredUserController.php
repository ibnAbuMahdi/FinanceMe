<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userAttributes =$request->validate([
            'username'=>['required'],
            'email'=>['required', 'email', 'unique:users,email'],
            'password'=>['required', 'confirmed', Password::min(6)],
            'account_type'=>['required']
        ]);
        $tenant = strtolower($userAttributes['account_type']);
        $tenants = ['personal' => 1, 'corporate' => 2];
        $userAttributes['tenant'] = $tenants[$tenant];
        $response = Http::post("$tenant.localhost:8000/register/", $userAttributes);

        dd($response->status());

        // Auth::login($user);

        return redirect('/');
    }
    
}
