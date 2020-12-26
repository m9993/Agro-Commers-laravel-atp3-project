<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Users;

class CustomerController extends Controller
{
    public function index(Request $req)
    {
        return view('customer.index');
    }
    public function github(Request $req)
    {
        return Socialite::driver('github')->redirect();
    }
    public function githubRedirect(Request $req)
    {
        $user= Socialite::driver('github')->user();    
        // shows data  
        // dd($user);
        // shows data  

        $getUsers=Users::all()->where('email', $user->email);
        if(count($getUsers)<1){   
            $newUser = new Users();
            $newUser->name = $user->name;
            $newUser->role = 'customer';
            $newUser->salary = 0;
            $newUser->phone = '';
            $newUser->email = $user->email;
            $newUser->address = $user->user['location'];
            $newUser->password = '123';
            $newUser->save();
        }
        return redirect()->route('customer.home');
    }
    public function home(Request $req)
    {
        return view('customer.home');
    }
}
