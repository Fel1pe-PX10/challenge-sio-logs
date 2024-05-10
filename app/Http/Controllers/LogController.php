<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Response;

use DB;
use Illuminate\Cache\RateLimiting\Limit;

class LogController extends Controller
{
    public function show(){

        // return $this->taskPerDay();

        return view('log.index', [
            'projects'  => $this->projectsPerHours(),
            'weekdays'  => $this->taskPerDay(),
            'months'    => $this->taskPerMonth(),
            'tasks'     => $this->tasksLogs(15),
        ]);
    }

    public function exportCsv(){
        $tasks = $this->tasksLogs();
        $csvFileName = 'task_logs.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['Project_name', 'Task_name', 'Task_description', 'Task_start_date', 'Task_stop_date', 'User', 'Hours', 'Day', 'Month']);

        foreach ($tasks as $task) {
            fputcsv($handle, [$task->projectName, $task->name, $task->description, $task->start, $task->stop, $task->userName, $task->difference, $task->day, $task->month]);
        }

        fclose($handle);

        return Response::make('', 200, $headers);
    }

    private function tasksLogs($limit = null){
        $tasks = Task::join('projects', 'tasks.project_id', '=', 'projects.id')
        ->join('users', 'tasks.user_id', '=', 'users.id')
        ->where('users.id', auth()->id());
        
        if($limit)
            $tasks = $tasks->take($limit);

        $tasks = $tasks->orderBy('tasks.start_date', 'desc')->get([
            'tasks.id', 
            'tasks.name', 
            'tasks.start_date as start', 
            'tasks.stop_date as stop', 
            'tasks.description', 
            'projects.name  as projectName', 
            'projects.id as projectid', 
            'users.name as userName', 
            'users.id as userId',
            DB::raw('ROUND((TIMESTAMPDIFF(MINUTE, start_date, stop_date)/60),2) as difference'),
            DB::raw('DAYNAME(DATE(start_date)) as day'),
            DB::raw('MONTHNAME(DATE(start_date)) as month')
        ]);

        return $tasks;
    }

    private function projectsPerHours(){
        $projects = Task::select(
            'projects.name',
            'projects.hours_estimated',
            DB::raw('ROUND((SUM(TIMESTAMPDIFF(MINUTE, start_date, stop_date))/60),2) as difference')
        )
        ->join('projects', 'tasks.project_id', '=', 'projects.id')
        ->whereNotNull('stop_date')
        ->groupBy('projects.name', 'projects.hours_estimated')
        ->orderBy('projects.name')
        ->get();

        return $projects;
    }

    private function taskPerDay(){
        $day = Task::select(
            DB::raw('ROUND((SUM(TIMESTAMPDIFF(MINUTE, start_date, stop_date))/60),2) as difference'),
            DB::raw('DAYNAME(DATE(start_date)) as day')
        )
        ->join('users', 'tasks.user_id', '=', 'users.id')
        ->whereNotNull('stop_date')
        ->where('users.id', auth()->id())
        ->orderBy('day')
        ->groupBy(DB::raw('DAYNAME(DATE(start_date))'))
        ->get();

        return $day;
    }

    private function taskPerMonth(){
        $months = Task::select(
            DB::raw('ROUND((SUM(TIMESTAMPDIFF(MINUTE, start_date, stop_date))/60),2) as difference'),
            DB::raw('MONTHNAME(DATE(start_date)) as month_year')
        )
        ->join('users', 'tasks.user_id', '=', 'users.id')
        ->whereNotNull('stop_date')
        ->where('users.id', auth()->id())
        ->orderBy('month_year')
        ->groupBy(DB::raw('MONTHNAME(DATE(start_date))'))
        ->get();

        return $months;
    }
}
