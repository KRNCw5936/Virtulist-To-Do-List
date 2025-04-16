<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskList;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public static function middleware() {
        return ['auth'];
    }

    public function index() {
        $taskLists = TaskList::where('user_id', Auth::id()) // ⬅️ filter berdasarkan user
                              ->orderBy('created_at', 'desc')
                              ->get();
    
        return view('homepage.home', compact('taskLists'));
    }    
}