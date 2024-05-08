<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

use DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tasks = Task::join('projects', 'tasks.project_id', '=', 'projects.id')
                    ->join('users', 'tasks.user_id', '=', 'users.id')
                    ->where('users.id', auth()->id())
                    ->whereNull('tasks.stop_date')
                    ->orderBy('tasks.start_date', 'desc')
                    ->get(['tasks.id', 'tasks.name', 'tasks.start_date  as start', 'tasks.description', 'projects.name  as projectName', 'projects.id as projectid', 'users.name as userName', 'users.id as userId', DB::raw('ROUND((TIMESTAMPDIFF(MINUTE, tasks.start_date, NOW())/60),2) as difference')]);

        return view('task.index', [
            'projects'  => Project::all(),
            'tasks'     => $tasks,
            'total'     => count($tasks)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id'    => ['required', 'numeric', 'min:1'],
            'name'          => 'required',
            'description'   => 'required'
        ]);

        Task::create([
            'project_id'    => $request->get('project_id'),
            'name'          => $request->get('name'),
            'description'   => $request->get('description'),
            'user_id'       => auth()->id()
        ]);

        return to_route('tasks.create')->with('status', __('The task was created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($task)
    {
        $task = Task::findOrFail($task);
       
        return view('task.edit', [
            'task' => $task,
            'projects' => Project::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $task)
    {
        $request->validate([
            'project_id'    => 'required',
            'name'          => ['required', 'min:3'],
            'description'   => ['required', 'min:3', 'max:255']
        ]);
        
        if($request->start_date == 1)
            $startDate = Carbon::now();
        else if(strlen($request->start_date) > 1)
            $startDate = Carbon::create(str_replace('T',' ',$request->get('start_date')));
        else
            $startDate = null;

        if($request->stop_date == 1)
            $stopDate = Carbon::now();
        else if(strlen($request->stop_date) > 1)
            $stopDate = Carbon::create(str_replace('T',' ',$request->get('stop_date')));
        else
            $stopDate = null;
        
        Task::where('id', $task)
            ->update([
            'name'  => $request->get('name'),
            'description' => $request->get('description'),
            'project_id'  => $request->get('project_id'),
            'start_date'  => $startDate,
            'stop_date'   => $stopDate
        ]);

        return to_route('tasks.create')->with('status', 'The task was finished successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($task)
    {
        $task = Task::findOrFail($task);

        $task->delete();

        return to_route('tasks.create')->with('status', 'The task has been deleted successfully');
    }

    public function start(Request $request, $id){
        
        Task::whereId($id)->update([
                                'start_date' => Carbon::now()
                            ]);

        return to_route('tasks.create')->with('status', 'The task has started successfully');
    }

    public function stop(Request $request, $id){

        Task::whereId($id)->update([
                                'stop_date' => Carbon::now()
                            ]);

        return to_route('tasks.create')->with('status', 'The task has finished successfully');
    }
}
