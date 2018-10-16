<?php

namespace App\Http\Controllers;

use App\Category;
use App\Rating;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Project;

class ProjectsController extends Controller
{
    /**
     * ProjectsController constructor.
     *
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of resource
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects = new Project();
        $rateSort = false;

        $projects = $projects->with(['images', 'ratings'])->where('active', '=', '1');

        //Check search
        if($request->has('search')){
            $projects = $projects->search($request->get('search'));
        }

        //Check for sorting
        if($request->has('category') && $request->get('category') != 1){

            $projects = $projects->join('category_project', 'projects.id', '=', 'category_project.project_id')
                ->where('category_project.category_id', '=', $request->get('category'));

        }

        //Check for filtering
        if($request->has('sort')){
            if($request->get('sort') == 'rating'){
                $rateSort = true;
            }else{
                $projects = $projects->orderBy($request->get('sort'),'desc');
            }
        }else{
            $projects = $projects->orderBy('created_at','desc');
        }

        //Run query
        $projects = $projects->get();

        $data = [];
        //Add average rating to object
        foreach ($projects as $project){
            $avgRating = round(Rating::where('project_id', $project->id)->avg('rating'), 1);
            $project->avgRating = $avgRating;
            $data[] = $project;
        }

        $projects = collect($data);

        if($rateSort)$projects = $projects->sortBy('avgRating')->reverse();

        $categories = Category::pluck('name', 'id');

        return view('projects/index')->with(compact('projects','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');

        return view('projects.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'text' => 'required',

        ]);

//        'images' => 'required|image|nullable|max:1999'

        //Handle file upload
        if($request->hasFile('images')){
            $files = $request->file('images');
            foreach ($files as $file){
                //Get filesize
                $fileSize = $file->getSize();
                //Get filename with extension
                $filenameWithExt = $file->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //Get just extension
                $extension = $file->getClientOriginalExtension();
                //Filename to store
                $fileNameToStore = $filename.'_'.time().'.'.$extension;

                //Upload image
                $path = $file->storeAs('public/cover_images', $fileNameToStore);

                $fileInfo[] = ['fileName' => $fileNameToStore, 'fileSize' => $fileSize];
            }
        }else{
            $fileNameToStore = 'noimage.jpg';
        }

        //Create project

        $project = new Project();

        $project->title = $request->input('title');
        $project->text = $request->input('text');
        $project->active = 1;
        $project->user_id = auth()->user()->id;

        $project->save();
        foreach ($request->input('categories') as $catId){
            $project->categories()->attach($catId);
        }


        //Create image

        foreach($fileInfo as $i){
            $image = new Image();
            $image->project_id = $project->id;
            $image->filename = $i['fileName'];
            $image->size = $i['fileSize'];

            $image->save();
        }

        return redirect('/projects')->with('succes', 'Project aangemaakt!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::with(['images', 'categories'])->find($id);

        return view('projects.show')->with('project', $project);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);

        //Check for correct user
        if(auth()->user()->id !== $project->user_id){
            return redirect('/projects')->with('error', 'Geen toegang tot deze pagina');
        }

        return view('projects.edit')->with('project', $project);
    }

    /**
     * Update the specified resource in storage.
     *
     * Todo Create more elegant image management system
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'text' => 'required'
        ]);

        $project = Project::find($id);

        $fileInfo = [];

        //Handle file upload
        if($request->hasFile('images')){

            //Delete all old files
            foreach ($project->image as $image) {
                Storage::delete('public/cover_images/' . $image->filename);

                $image->delete();
            }

            $files = $request->file('images');
            foreach ($files as $file){
                //Get filesize
                $fileSize = $file->getSize();
                //Get filename with extension
                $filenameWithExt = $file->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //Get just extension
                $extension = $file->getClientOriginalExtension();
                //Filename to store
                $fileNameToStore = $filename.'_'.time().'.'.$extension;

                //Upload image
                $path = $file->storeAs('public/cover_images', $fileNameToStore);

                $fileInfo[] = ['fileName' => $fileNameToStore, 'fileSize' => $fileSize];
            }
        }

        $project->title = $request->input('title');
        $project->text = $request->input('text');
        $project->save();

        if($request->hasFile('images')){
            //Create image
            foreach($fileInfo as $i){
                $image = new Image();
                $image->project_id = $project->id;
                $image->filename = $i['fileName'];
                $image->size = $i['fileSize'];

                $image->save();
            }
        }

        return redirect('/projects')->with('succes', 'Project geupdate!');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function changeState(Request $request, $id){
        $project = Project::find($id);

        $project->active =  $request->input('state') ? 0:1;
        $project->save();


        return redirect('/dashboard')->with('succes', 'Project geupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        //Check for correct user
        if(auth()->user()->id !== $project->user_id && auth()->user()->role == 0){
            return redirect('/projects')->with('error', 'Geen toegang tot deze pagina');
        }

        foreach ($project->images as $image) {
            Storage::delete('public/cover_images/' . $image->filename);

            $image->delete();
        }

        $project->delete();

        return redirect('/projects')->with('succes', 'Project verwijderd!');
    }
}
