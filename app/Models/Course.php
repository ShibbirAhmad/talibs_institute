<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function category_name(){

         return $this->belongsTo('App\Models\Category','category_id','id');
    }
}
