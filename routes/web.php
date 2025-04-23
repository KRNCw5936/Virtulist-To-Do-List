<?php

use App\Http\Controllers\TaskListController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

// ========================
// AUTHENTICATION ROUTES
// ========================
// Register & Login
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google Authentication Routes
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);


Route::get('/forgot-password', [ForgotPasswordController::class, 'showRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'handleRequest']);

Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);

// ========================
// PROTECTED ROUTES (REQUIRES LOGIN)
// ========================
Route::middleware('auth')->group(function () {
    // Home Page
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('homepage.dashboard');
    Route::get('/home', [HomeController::class, 'index'])->name('homepage.home');

    // ========================
    // TASK LIST ROUTES
    // ========================
    // Route::resource('task-lists', TaskListController::class);
    Route::resource('task-lists', TaskListController::class)->except(['show']);

    // Tambahan Routes untuk Task List (update dan revert status)
    Route::patch('/task-lists/{taskList}/update-status', [TaskListController::class, 'updateStatus'])->name('task-lists.updateStatus');
    Route::patch('/task-lists/{taskList}/revert-status', [TaskListController::class, 'revertStatus'])->name('task-lists.revertStatus');

    // ========================
    // TASK ROUTES (Dalam Task List)
    // ========================
    Route::prefix('task-lists/{taskList}/tasks')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('task-lists.tasks.index');
        Route::get('/create', [TaskController::class, 'create'])->name('task-lists.tasks.create');
        Route::post('/', [TaskController::class, 'store'])->name('task-lists.tasks.store');
        Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('task-lists.tasks.edit');
        Route::put('/{task}', [TaskController::class, 'update'])->name('task-lists.tasks.update');
        Route::delete('/{task}', [TaskController::class, 'destroy'])->name('task-lists.tasks.destroy');

        Route::patch('{task}/update-status', [TaskController::class, 'updateStatus'])
        ->name('tasks.updateStatus');
    });
    Route::get('/notifikasi', [TaskListController::class, 'notif'])->name('homepage.notif');
    Route::patch('/task-lists/{taskList}/status', [TaskListController::class, 'updateStatus'])->name('task-lists.update-status');
    Route::patch('/task-lists/{taskList}/toggle-pin', [TaskListController::class, 'togglePin'])->name('task-lists.togglePin');
    Route::patch('/task-lists/{taskList}/toggle-status', [TaskListController::class, 'toggleStatus'])->name('task-lists.toggle-status');
    Route::get('/task-lists/completed', [TaskListController::class, 'completedTasks'])->name('task-lists.completed');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    

});

// ========================
// ROOT REDIRECT
// ========================
Route::get('/', function () {
    return redirect()->route('login');
})->name('root');

