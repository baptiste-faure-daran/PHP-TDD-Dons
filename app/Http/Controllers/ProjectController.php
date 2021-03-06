<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use App\Mail\DonationReceived;
use App\Mail\DonationSent;
use App\Models\Donation;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use app\Providers\AuthServiceProvider;
use function GuzzleHttp\Promise\all;

class ProjectController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('project', ['projects' => Project::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      //  if (Auth::check())
      //  {
            return view('createProject', ['projects' => Project::all()]);
      //  }
      //  else return redirect('\dashboard');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required | string | max:70',
            'description' => 'required | string | max:200',
            'published_at' => 'date'
        ]);

        Project::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'published_at'=>now(),
            'author'=>Auth::id()
        ]);
        return redirect('/project');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
        public function show($id)
    {
        $project = Project::findOrFail($id);
        return view('projectDetails', ['projects'=> $project]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::check()) {
            $project = Project::findOrFail($id);
            Gate::authorize('update-project', $project);
            $project_u = User::all();

            return view('editProject', ['projects' => $project, 'project_u' => $project_u]);
        }
        else redirect('/dashboard');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=> 'required | string | max:70',
            'description'=> 'required'
        ]);
        $project = Project::find($id);
        if (Gate::allows('update-project', $project)){
            $project->name = $request->input('name');
            $project->description = $request->input('description');

            $project->save();
            return view('projectDetails', ['projects'=>$project]);
        }
        abort(401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project_id=Project::where('id',$id)->delete();
        return redirect('/project');
    }

    public function showDonation($id)
    {
        $project = Project::findOrFail($id);
        return view('projectDonation', ['projects'=> $project]);
    }

    public function storeDonation(Request $request, $id)
    {
        $request->validate([
            'amount'=> 'required',
        ]);

        $project = Project::findOrFail($id)->update($request->all());
        return redirect('/projectDonation/{id}');
    }

    public function confirmDonation(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'donation'=>'required | numeric',
        ]);

        $project = Project::findOrFail($id);
        $projectOwner = Project::findOrFail($project->author);

        Mail::to(Auth::user()->email)->send(new DonationSent($request->input('donation')));

        Mail::to($projectOwner->email)->send(new DonationReceived($request->input('donation')));

        return view('project', ['projects' => $project], ['request' => $request]);

    }}
