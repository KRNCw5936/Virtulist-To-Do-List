<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ Tambahkan ini

class TaskCompleteController extends Controller
{
    public function completedTasks()
    {
        $completedTasks = TaskList::where('user_id', Auth::id()) // ✅ Filter berdasarkan user
            ->where('is_complete', true)
            ->orderByDesc('is_pinned')
            ->orderBy('name')
            ->get();

        return view('task_lists.completed', compact('completedTasks'));
    }
}