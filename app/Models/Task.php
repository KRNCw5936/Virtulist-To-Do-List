<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_list_id',
        'name',
        'priority',
        'start_date',
        'end_date',
        'status',
        'is_completed',
        'in_progress',
        'user_id', // Tambahkan kolom user_id
    ];

    // Relasi ke tabel task_lists
    public function taskList()
    {
        return $this->belongsTo(TaskList::class);
    }

    // Relasi ke tabel users (User yang membuat task)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
