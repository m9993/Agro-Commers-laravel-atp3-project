<?php

namespace App;


class Cart
{
    public $oldCart;

    public function __construct($oldCart) {
        if($oldCart==null){
            $this->oldCart=[];
        }else{
            $this->oldCart = $oldCart;
        }
    }
    public function add($pid){
        $exists=false;
        $storedItem=0;
        $storedQty=0;
        for($i=0; $i<count($this->oldCart);$i++){
            if($this->oldCart[$i][0]==$pid){
                $exists=true;
                $storedItem=$i;
                $storedQty=$this->oldCart[$i][1];
            }                
        }

        if($exists){
            $this->oldCart[$storedItem][1]=$storedQty+1;
        }else{
            array_push($this->oldCart,[$pid,1]);
        }
        
        return $this->oldCart; 
    }

}
