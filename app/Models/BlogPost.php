<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
      public function admin_name(){

        return  $this->belongsTo('App\Models\Admin','admin_id','id') ;
      }
}
