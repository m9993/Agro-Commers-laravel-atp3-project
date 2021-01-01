<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Socialite;
use App\Users;
use App\Products;
use App\Orders;
use App\Invoice;
use App\Order_history;

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
                if(count($product)!=0){
                    $title=$product[0]->title;
                    $shop_name=$product[0]->shop_name;
                    $price=$product[0]->price;

                    $qty=$cart[$i][1];
                    $totalPrice= $totalPrice + ($qty*$price);
                    $item=[$pid, $title, $shop_name, $qty, $price];
                    array_push($cartData,$item); 
                }           
            }
            // print_r($cartData);
            // echo $totalPrice;
        }  
        return view('customer.cart')->with('cartData',$cartData)->with('totalPrice',$totalPrice);
        
    }
    public function addToCart(Request $req, $pid)
    {   
               //[[pid,qty]]
        // $cart=[[1,2],[8,9]];
        
        if($req->session()->get('cart')==null){
            $c= new Cart(null);
            $newCart=$c->add($pid);
            $req->session()->put('cart',$newCart);
        }else{
            $oldCart=$req->session()->get('cart');
            $c= new Cart($oldCart);
            $newCart=$c->add($pid);
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
            $c= new Cart(null);
            $newCart=$c->add($pid);
            $req->session()->put('cart',$newCart);
        }else{
            $oldCart=$req->session()->get('cart');
            $c= new Cart($oldCart);
            $newCart=$c->add($pid);
            $req->session()->put('cart',$newCart);
        }
        
        $req->session()->flash('msg', 'Product Id('.$pid.') added by one.');
        $req->session()->flash('type','warning');
        return redirect()->route('customer.cart');            
        
    }
    // the method addByOne is same as addToCart. but return view is in cart page
    
    public function reduceByOne(Request $req, $pid)
    {   
               //[[pid,qty]]
        // $cart=[[1,2],[8,9]];        
        
        $oldCart=$req->session()->get('cart');
        $c= new Cart($oldCart);
        $newCart=$c->reduce($pid);
        $req->session()->put('cart',$newCart);
        
        
        $req->session()->flash('msg', 'Product Id('.$pid.') reduced by one.');
        $req->session()->flash('type','warning');
        return redirect()->route('customer.cart'); 
        
    }

    public function remove(Request $req, $pid)
    {   
               //[[pid,qty]]
        // $cart=[[1,2],[8,9]];        
        
        $oldCart=$req->session()->get('cart');
        $c= new Cart($oldCart);
        $newCart=$c->remove($pid);
        $req->session()->put('cart',$newCart);
        
        
        $req->session()->flash('msg', 'Product Id('.$pid.') removed.');
        $req->session()->flash('type','warning');
        return redirect()->route('customer.cart');        
    }
    public function order(Request $req)
    {  
        $req->validate([
            'shipping_method' => 'required'          
        ]); 
        


        $cart=$req->session()->get('cart');
        $order=[];
        $totalPrice=0;
        if($cart!=null){
            for($i=0; $i<count($cart); $i++){
                $pid=$cart[$i][0];

                $product=Products::where('pid', $pid)->get();
                if(count($product)!=0){
                    $sellerid=$product[0]->sellerid;
                    $price=$product[0]->price;

                    $qty=$cart[$i][1];
                    $totalPrice= $totalPrice + ($qty*$price);
                    $purchase=[$sellerid, $qty, $price];
                    array_push($order,$purchase); 
                }           
            }
            
            // checking items available or not
            if($totalPrice==0){
                $req->session()->flash('msg', 'Failed. No items selected.');
                $req->session()->flash('type','danger');
                return back();
            }
            // checking items available or not


            $newOrder = new Orders();
            $newOrder->customerid = $req->session()->get('profile')->uid;
            $newOrder->date = NOW();
            $newOrder->subtotal = $totalPrice;
            $newOrder->shipping_method = $req->shipping_method;
            $newOrder->status = 'pending';
            $newOrder->save();
            $lastOrder=DB::table('orders')
                ->select('oid')
                ->where('customerid',$req->session()->get('profile')->uid)
                ->where('status', 'pending')
                ->orderBy('oid', 'desc')
                ->first();

            $oid=$lastOrder->oid;

            //adding to invoice
            for($i=0; $i<count($order); $i++){
                $newInvoice = new Invoice();
                $newInvoice->oid = $oid;
                $newInvoice->sellerid = $order[$i][0];
                $newInvoice->quantity = $order[$i][1];
                $newInvoice->price = $order[$i][2];
                $newInvoice->save();
            }
            
            $req->session()->forget('cart');
        }
        
        $req->session()->flash('msg', 'Order confirmed.');
        $req->session()->flash('type','success');
        return redirect()->route('customer.cart');        
    }
    public function history(Request $req)
    {
        $orders=Orders::all()->where('customerid', $req->session()->get('profile')->uid);
        return view('customer.history')->with('orders',$orders);
        
    }  
    public function order_details(Request $req, $oid)
    {
        $orderDetails = DB::select("SELECT orders.oid, title, invoice.sellerid, shop_name, quantity, invoice.price, subtotal, date, shipping_method, orders.status FROM invoice,orders,products where invoice.oid=orders.oid and invoice.sellerid=products.sellerid and orders.oid=?", [$oid]);
        // print_r ($users[0]->title);
        return view('customer.orderDetails')->with('orderDetails',$orderDetails);
        
    }  
    
}
