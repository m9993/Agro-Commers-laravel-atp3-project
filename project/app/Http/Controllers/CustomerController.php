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

        $getUser=Users::all()->where('email', $user->email);
        if(count($getUser)<1){   
            $newUser = new Users();
            $newUser->name = $user->name;
            $newUser->role = 'customer';
            $newUser->salary = 0;
            $newUser->phone = '';
            $newUser->email = $user->email;
            $newUser->address = $user->user['location'];
            $newUser->password = '123';
            $newUser->save();

            $req->session()->flash('msg',$newUser->name.' ('.$newUser->role.') is registered.');
            $req->session()->flash('type','success');
        }else{
            $req->session()->flash('msg', 'GitHub login successful.');
            $req->session()->flash('type','success');
        }
        $getUser=Users::all()->where('email', $user->email);
        $req->session()->put('profile',$getUser[0]);
        return view('customer.home');
        
    }
}
