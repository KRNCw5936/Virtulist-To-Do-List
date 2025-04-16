<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskList extends Model {
    protected $fillable = [
        'name',
        'project_type',
        'description',
        'start_date',
        'end_date',
        'is_complete',
        'is_pinned',
        'user_id', // Tambahkan kolom user_id
    ];

    // Relasi ke tabel tasks
    public function tasks() {
        return $this->hasMany(Task::class);
    }

    // Relasi ke tabel users (User yang membuat task list)
    public function user() {
        return $this->belongsTo(User::class);
    }
}
