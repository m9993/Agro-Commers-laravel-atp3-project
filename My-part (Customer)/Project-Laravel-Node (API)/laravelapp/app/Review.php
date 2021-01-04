<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = "review";
    protected $primaryKey = "rid";
    public $timestamps = false;

   //const CREATED_AT = 'creation_date';
   //const UPDATED_AT = 'last_update';
}
