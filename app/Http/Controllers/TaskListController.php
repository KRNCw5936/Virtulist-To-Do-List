<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskList;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TaskListController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // ✔️ cek user login

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $twoDaysAgo = Carbon::now()->subDays(2);
        $sevenDaysAgo = Carbon::now()->subDays(7);
        $eightDaysAgo = Carbon::now()->subDays(8);
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        $todayTasks = TaskList::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->orderByDesc('is_pinned')
            ->orderBy('name')
            ->get();

        $yesterdayTasks = TaskList::where('user_id', $userId)
            ->whereDate('created_at', $yesterday)
            ->orderByDesc('is_pinned')
            ->orderBy('name')
            ->get();

        $lastWeekTasks = TaskList::where('user_id', $userId)
            ->whereBetween('created_at', [$sevenDaysAgo, $twoDaysAgo])
            ->orderByDesc('is_pinned')
            ->orderBy('name')
            ->get();

        $lastMonthTasks = TaskList::where('user_id', $userId)
            ->whereBetween('created_at', [$thirtyDaysAgo, $eightDaysAgo])
            ->orderByDesc('is_pinned')
            ->orderBy('name')
            ->get();

        $olderTasks = TaskList::where('user_id', $userId)
            ->where('created_at', '<', $thirtyDaysAgo)
            ->orderByDesc('is_pinned')
            ->orderBy('name')
            ->get();

        return view('task_lists.index', compact(
            'todayTasks',
            'yesterdayTasks',
            'lastWeekTasks',
            'lastMonthTasks',
            'olderTasks'
        ));
    }

    public function create()
    {
        return view('task_lists.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'project_type' => 'required',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        TaskList::create([
            'user_id' => Auth::id(), // ✅ Simpan id user
            'name' => $request->name,
            'project_type' => $request->project_type,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_complete' => false,
        ]);

        return redirect()->route('homepage.home')->with('success', 'Task berhasil ditambahkan!');
    }

    public function edit(TaskList $taskList)
    {
        // Opsional: validasi apakah user berhak mengedit
        abort_if($taskList->user_id !== Auth::id(), 403);
        return view('task_lists.edit', compact('taskList'));
    }

    public function update(Request $request, TaskList $taskList)
    {
        abort_if($taskList->user_id !== Auth::id(), 403);

        $request->validate([
            'name' => 'required',
            'project_type' => 'required',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $taskList->update($request->all());

        return redirect()->route('task-lists.index')->with('success', 'Task berhasil diperbarui!');
    }

    public function updateStatus(TaskList $taskList)
    {
        abort_if($taskList->user_id !== Auth::id(), 403);

        $taskList->update(['is_complete' => true]);

        return redirect()->route('task-lists.index')->with('success', 'Task berhasil diselesaikan!');
    }

    public function revertStatus(TaskList $taskList)
    {
        abort_if($taskList->user_id !== Auth::id(), 403);

        $taskList->update(['is_complete' => false]);

        return redirect()->route('task-lists.index')->with('success', 'Task dikembalikan ke Progress!');
    }

    public function destroy(TaskList $taskList)
    {
        abort_if($taskList->user_id !== Auth::id(), 403);

        $taskList->delete();
        return redirect()->route('task-lists.index')->with('success', 'Task berhasil dihapus!');
    }

    public function togglePin(TaskList $taskList)
    {
        abort_if($taskList->user_id !== Auth::id(), 403);

        $taskList->update(['is_pinned' => !$taskList->is_pinned]);

        return redirect()->route('homepage.home')->with('success', 'Status pin berhasil diperbarui!');
    }

    public function toggleStatus(TaskList $taskList)
    {
        abort_if($taskList->user_id !== Auth::id(), 403);

        $taskList->update(['is_complete' => !$taskList->is_complete]);

        return redirect()->route('task-lists.index')->with('success', 'Status task diperbarui!');
    }

    public function completedTasks()
    {
        $completedTasks = TaskList::where('user_id', Auth::id())
            ->where('is_complete', true)
            ->orderByDesc('is_pinned')
            ->orderBy('name')
            ->get();

        return view('task_lists.completed', compact('completedTasks'));
    }

    public static function countUpcomingNotifications()
    {
        return TaskList::where('user_id', Auth::id())
            ->where('is_complete', false)
            ->whereDate('end_date', '<=', Carbon::now()->addDay())
            ->whereDate('end_date', '>=', Carbon::now())
            ->count();
    }

    public function notif()
    {
        $userId = Auth::id();

        // Ambil semua task yang mendekati deadline
        $notifTasks = TaskList::where('user_id', $userId)
            ->where('is_complete', false)
            ->whereBetween('end_date', [
                Carbon::today()->startOfDay(),
                Carbon::today()->addDays(2)->endOfDay()
            ])
            ->get();

        // Simpan flag bahwa notifikasi sudah "dilihat"
        session(['notif_viewed' => true]);

        return view('homepage.notif', compact('notifTasks'));
    }
    
}
