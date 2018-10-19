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

    public function categories(){
        return $this->belongsToMany('App\Category');
    }

    public static function scopeRating($query){
       return $query->selectRaw('projects.* ,(SELECT AVG(ratings.rating) FROM ratings WHERE ratings.project_id = projects.id) avgRating');
    }

    public static function scopeSearch($query, $searchTerm)
    {
        return $query->where('title', 'like', '%' .$searchTerm. '%')
            ->orWhere('text', 'like', '%' .$searchTerm. '%');
    }
}
