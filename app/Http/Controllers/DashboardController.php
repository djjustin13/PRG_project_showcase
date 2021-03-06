<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use App\User;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if($user->role == 1){
            $projects = Project::all();

            return view('dashboard.admin')->with('projects', $projects);
        }else{
            return view('dashboard.index')->with('projects', $user->projects);
        }
    }
}
