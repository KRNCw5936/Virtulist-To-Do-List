<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_list_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('priority', ['Tinggi', 'Sedang', 'Rendah']);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['Tugas', 'Progres', 'Selesai'])->default('Tugas');
            $table->boolean('is_completed')->default(false); // Tambahkan
            $table->boolean('in_progress')->default(false);  // Tambahkan
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Kolom user_id untuk menghubungkan dengan pengguna
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
