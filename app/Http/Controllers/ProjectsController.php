<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Project;

class ProjectsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::with('image')->orderBy('created_at', 'desc')->paginate(10);
        return view('projects/index')->with('projects', $projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
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
            'cover_image' => 'image|nullable|max:1999'
        ]);

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
        $project->user_id = auth()->user()->id;

        $project->save();

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
        $project = Project::with('image')->find($id);

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        //Check for correct user
        if(auth()->user()->id !== $project->user_id){
            return redirect('/projects')->with('error', 'Geen toegang tot deze pagina');
        }

        foreach ($project->image as $image) {
            Storage::delete('public/cover_images/' . $image->filename);

            $image->delete();
        }

        $project->delete();

        //Cleaner way
//        Project::destroy($id);
        return redirect('/projects')->with('succes', 'Project verwijderd!');
    }
}
