<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function images(){
        return $this->hasMany('App\Image');
    }

    public function ratings(){
        return $this->hasMany('App\Rating');
    }
}
