<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskList;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // ⬅️ ambil ID user yang sedang login
    
        return view('homepage.dashboard', [
            'totalTaskList' => TaskList::where('user_id', $userId)->count(),
            'completedTaskList' => TaskList::where('user_id', $userId)->where('is_complete', true)->count(),
            'totalTask' => Task::where('user_id', $userId)->count(),
            'completedTask' => Task::where('user_id', $userId)->where('is_completed', true)->count(),
            'ongoingTask' => Task::where('user_id', $userId)->where('in_progress', true)->count(),
    
            'statusCounts' => [
                'tugas' => Task::where('user_id', $userId)->where('status', 'tugas')->count(),
                'progress' => Task::where('user_id', $userId)->where('in_progress', true)->count(),
                'completed' => Task::where('user_id', $userId)->where('is_completed', true)->count(),
            ],
    
            'distributionCounts' => [
                'Tinggi' => Task::where('user_id', $userId)->where('priority', 'Tinggi')->count(),
                'Sedang' => Task::where('user_id', $userId)->where('priority', 'Sedang')->count(),
                'Rendah' => Task::where('user_id', $userId)->where('priority', 'Rendah')->count(),
            ],
        ]);
    }
    
}