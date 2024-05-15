<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $tasks = Task::where('user_id', auth()->id())
                        ->whereNull('stop_date')
                        ->get();

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

        return to_route('task.create')->with('status', __('The task was created successfully'));
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
    public function edit(Task $task)
    {       
        if(auth()->user()->id != $task->user_id)
            abort(403);

        return view('task.edit', [
            'task' => $task,
            'projects' => Project::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'project_id'    => 'required',
            'name'          => ['required', 'min:3'],
            'description'   => ['required', 'min:3', 'max:255']
        ]);
        
        Task::where('id', $task->id)
            ->update([
            'name'  => $request->get('name'),
            'description' => $request->get('description'),
            'project_id'  => $request->get('project_id'),
            'start_date'  => $this->determineDate($request->start_date),
            'stop_date'   => $this->determineDate($request->stop_date)
        ]);

        return to_route('task.create')->with('status', 'The task was finished successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if(auth()->user()->id != $task->user_id)
            abort(403);
        
        $task->delete();

        return to_route('task.create')->with('status', 'The task has been deleted successfully');
    }

    public function start(Request $request, $id){
        
        Task::whereId($id)->update([
                                'start_date' => Carbon::now()
                            ]);

        return to_route('task.create')->with('status', 'The task has started successfully');
    }

    public function stop(Request $request, $id){

        Task::whereId($id)->update([
                                'stop_date' => Carbon::now()
                            ]);

        return to_route('task.create')->with('status', 'The task has finished successfully');
    }

    private function determineDate($dateForm){
        if($dateForm == 1)
            $date = Carbon::now();
        else if(strlen($dateForm) > 1)
            $date = Carbon::create(str_replace('T',' ',$dateForm));
        else
            $date = null;
        return $date;
    }
}
