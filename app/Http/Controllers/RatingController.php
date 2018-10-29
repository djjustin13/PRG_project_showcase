<?php

namespace App\Http\Controllers;

use App\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'get']);
    }

    public function get($project){
        return round(Rating::where('project_id', $project)->avg('rating'), 1);
    }

    public function create($project, $number){
        $check = Rating::where(['project_id' => $project, 'user_id' => auth()->user()->id])->count();

        if($check > 0){
            return 'Je kunt maar 1 rating geven!';
        }else{
            $rating = new Rating();
            $rating->rating = $number;
            $rating->project_id = $project;
            $rating->user_id = auth()->user()->id;

            $rating->save();

            return round(Rating::where('project_id', $project)->avg('rating'), 1);
        }
    }
}
