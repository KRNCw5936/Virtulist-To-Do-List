<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskList;
use Illuminate\Support\Facades\Auth; 

class CalendarController extends Controller
{
    public function index()
    {
        $tasks = TaskList::where('user_id', Auth::id()) // ⬅️ filter berdasarkan user login
                         ->select('id', 'name', 'start_date', 'end_date', 'project_type')
                         ->get();
    
        $events = $tasks->map(function ($task) {
            $colors = [
                'school' => ['#1E90FF', '#104E8B', '🎓 '],
                'private' => ['#32CD32', '#228B22', '🌱 '],
                'work' => ['#00CED1', '#008B8B', '💼 '],
            ];
        
            $type = strtolower($task->project_type);
            $color = $colors[$type] ?? ['#000000', '#333333', '📌 '];
        
            return [
                'id' => $task->id,
                'title' => $color[2] . $task->name,
                'start' => $task->start_date,
                'end' => date('Y-m-d', strtotime($task->end_date . ' +1 day')),
                'url' => route('task-lists.tasks.index', $task->id),
                'color' => $color[0],
                'borderColor' => $color[1],
            ];
        });
        
        return view('calendar.index', compact('events'));
    }    
}