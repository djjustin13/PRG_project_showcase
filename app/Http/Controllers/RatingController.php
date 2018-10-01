<?php

namespace App\Http\Controllers;

use App\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    public function get($project){
        return round(Rating::where('project_id', $project)->avg('rating'), 1);
    }

    public function create($project, $number){

        $request = new Request([
            'userid' => auth()->user()->id
        ]);

        $validator = Validator::make($request->all(), [
            'userid' => 'unique:ratings,user_id'
        ]);

        if($validator->fails()){
            $messages = $validator->messages();
            return 'Je kunt maar 1 rating geven!';

        }else{
            $rating = new Rating();
            $rating->rating = $number;
            $rating->project_id = $project;
            $rating->user_id = $request->userid;

            $rating->save();

            return round(Rating::where('project_id', $project)->avg('rating'), 1);
        }
    }
}
