<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('project_type', ['sekolah', 'pekerjaan', 'pribadi']);
            $table->text('description')->nullable(); // Tambahkan kolom deskripsi
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_complete')->default(false);
            $table->boolean('is_pinned')->default(false);
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Kolom user_id untuk menghubungkan dengan pengguna
            $table->timestamps();
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_lists');
    }
};
