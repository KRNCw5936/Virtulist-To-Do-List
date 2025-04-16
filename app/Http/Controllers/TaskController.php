<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskList;
use Illuminate\Support\Facades\Auth; // Import Auth facade

class TaskController extends Controller
{
    /**
     * Tampilkan daftar tugas berdasarkan Task List yang dipilih.
     */
    public function index(TaskList $taskList)
    {
        // Menampilkan tugas hanya yang terkait dengan user yang sedang login
        $tasks = $taskList->tasks()->where('user_id', Auth::id())->orderBy('start_date')->get();
        return view('tasks.index', compact('taskList', 'tasks'));
    }

    /**
     * Tampilkan form untuk membuat tugas baru dalam Task List.
     */
    public function create(TaskList $taskList)
    {
        return view('tasks.create', compact('taskList'));
    }

    /**
     * Simpan tugas baru yang terkait dengan Task List dan user yang sedang login.
     */
    public function store(Request $request, TaskList $taskList)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'priority' => 'required|in:Rendah,Sedang,Tinggi',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Menambahkan user_id yang sedang login
        $validatedData['user_id'] = Auth::id();
        $validatedData['status'] = 'Tugas';
        $validatedData['is_completed'] = false;
        $validatedData['in_progress'] = false;

        try {
            // Menyimpan tugas yang terkait dengan TaskList dan user
            $taskList->tasks()->create($validatedData);
            return redirect()->route('task-lists.tasks.index', $taskList->id)
                             ->with('success', 'Tugas berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menambahkan tugas: ' . $e->getMessage()]);
        }
    }

    /**
     * Tampilkan form untuk mengedit tugas.
     */
    public function edit(TaskList $taskList, Task $task)
    {
        // Pastikan tugas yang diedit milik user yang sedang login
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }
        
        return view('tasks.edit', compact('taskList', 'task'));
    }

    /**
     * Perbarui tugas berdasarkan data dari form edit.
     */
    public function update(Request $request, TaskList $taskList, Task $task)
    {
        // Pastikan tugas yang diperbarui milik user yang sedang login
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'priority' => 'required|in:Rendah,Sedang,Tinggi',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $task->update($validatedData);

        return redirect()->route('task-lists.tasks.index', $taskList->id)
                         ->with('success', 'Tugas berhasil diperbarui.');
    }

    /**
     * Hapus tugas dari Task List.
     */
    public function destroy(TaskList $taskList, Task $task)
    {
        // Pastikan tugas yang dihapus milik user yang sedang login
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $task->delete();
        return redirect()->route('task-lists.tasks.index', $taskList->id)
                         ->with('success', 'Tugas berhasil dihapus.');
    }

    /**
     * Mengubah status tugas antara "Selesai" dan "Belum Selesai".
     */
    public function toggleStatus(Task $task)
    {
        // Pastikan tugas milik user yang sedang login
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $task->update(['is_completed' => !$task->is_completed]);

        return back()->with('success', 'Status tugas berhasil diperbarui.');
    }

    /**
     * Memperbarui status tugas berdasarkan input user.
     */
    public function updateStatus(Request $request, TaskList $taskList, Task $task)
    {
        // Pastikan tugas milik user yang sedang login
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        try {
            // Validasi input
            $validated = $request->validate([
                'status' => 'required|string|in:pending,progress,completed',
            ]);
    
            // Log request untuk debugging
            \Log::info("Update Status: Task ID {$task->id}, Status Baru: {$validated['status']}");
    
            // Reset status
            $task->is_completed = false;
            $task->in_progress = false;
    
            // Sesuaikan status berdasarkan input
            if ($validated['status'] === 'progress') {
                $task->in_progress = true;
            } elseif ($validated['status'] === 'completed') {
                $task->is_completed = true;
            }
    
            // Simpan perubahan
            $task->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui',
                'data' => [
                    'id' => $task->id,
                    'status' => $validated['status'],
                    'is_completed' => $task->is_completed,
                    'in_progress' => $task->in_progress
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Gagal memperbarui status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui status'
            ], 500);
        }
    }
}
