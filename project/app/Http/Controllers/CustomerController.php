<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Users;
use App\Products;
use App\Cart;

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
        $req->session()->put('role',$getUser[0]->role);
        return redirect()->route('customer.home');
    }
    public function home(Request $req)
    {
        $products=Products::all();
        return view('customer.home')->with('products',$products);
    }
    public function searchProducts(Request $req)
    {
        $searchKey = $req->get('searchKey');
        if($req->ajax()){
            $products=Products::where('title','like', '%'.$searchKey.'%')->get();
            echo json_encode($products); 
        }   
    }
    public function cart(Request $req)
    {
        $cart=$req->session()->get('cart');
        $cartData=[];
        $totalPrice=0;
        if($cart!=null){
            for($i=0; $i<count($cart); $i++){
                $pid=$cart[$i][0];

                $product=Products::where('pid', $pid)->get();
                $title=$product[0]->title;
                $shop_name=$product[0]->shop_name;
                $price=$product[0]->price;

                $qty=$cart[$i][1];
                $totalPrice= $totalPrice + ($qty*$price);
                $item=[$pid, $title, $shop_name, $qty, $price];
                array_push($cartData,$item);            
            }
            // print_r($cartData);
            // echo $totalPrice;
        }else{
        }   
        return view('customer.cart')->with('cartData',$cartData)->with('totalPrice',$totalPrice);
        
    }
    public function addToCart(Request $req, $pid)
    {   
               //[[pid,qty]]
        // $cart=[[1,2],[8,9]];
        
        if($req->session()->get('cart')==null){
            $p= new Cart(null);
            $newCart=$p->add($pid);
            $req->session()->put('cart',$newCart);
        }else{
            $oldCart=$req->session()->get('cart');
            $p= new Cart($oldCart);
            $newCart=$p->add($pid);
            $req->session()->put('cart',$newCart);
        }
        
        $req->session()->flash('msg', 'Product added to cart.');
        $req->session()->flash('type','success');
        return redirect()->route('customer.home');            
        
    }
    // the method addByOne is same as addToCart. but return view is in cart page
    public function addByOne(Request $req, $pid)
    {   
               //[[pid,qty]]
        // $cart=[[1,2],[8,9]];
        
        if($req->session()->get('cart')==null){
            $p= new Cart(null);
            $newCart=$p->add($pid);
            $req->session()->put('cart',$newCart);
        }else{
            $oldCart=$req->session()->get('cart');
            $p= new Cart($oldCart);
            $newCart=$p->add($pid);
            $req->session()->put('cart',$newCart);
        }
        
        $req->session()->flash('msg', 'Product Id('.$pid.') added by one.');
        $req->session()->flash('type','success');
        return redirect()->route('customer.cart');            
        
    }
    // the method addByOne is same as addToCart. but return view is in cart page
    
}
