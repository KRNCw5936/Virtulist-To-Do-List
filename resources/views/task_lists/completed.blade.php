@extends('layouts.app')

@section('title', 'Completed Tasks')

@section('content')
<div class="container py-5 px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-black fw-bold">✅ Completed Tasks</h2>
        <div class="d-flex align-items-center">
            <span class="badge bg-primary rounded-pill me-2 p-2 fs-6">{{ $completedTasks->count() }} tasks</span>
        </div>
    </div>

    @if ($completedTasks->isEmpty())
        <div class="text-center py-5">
            <div class="empty-state">
                <img src="{{ asset('images/empty-state.svg') }}" alt="No tasks" class="img-fluid" style="max-width: 300px;">
                <h4 class="mt-4 text-muted">No tasks completed yet!</h4>
                <p class="text-muted">All your completed tasks will appear here</p>
                <a href="{{ route('task-lists.create') }}" class="btn btn-primary mt-3 px-4">
                    <i class="bi bi-plus-circle me-2"></i>Create New Task
                </a>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach ($completedTasks as $task)
                @php
                    $taskColors = [
                        'School' => ['#1E90FF', '#104E8B', '🎓'],
                        'Private' => ['#32CD32', '#228B22', '🌱'],
                        'Work' => ['#00CED1', '#008B8B', '💼'],
                    ];
                    $color = $taskColors[$task->project_type][0] ?? '#808080';
                    $darkColor = $taskColors[$task->project_type][1] ?? '#505050';
                    $icon = $taskColors[$task->project_type][2] ?? '📝';

                    $startDate = \Carbon\Carbon::parse($task->start_date)->format('d M Y');
                    $endDate = \Carbon\Carbon::parse($task->end_date)->format('d M Y');
                @endphp

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card task-card border-0 rounded-4 shadow-sm overflow-hidden h-100"
                         style="border-left: 4px solid {{ $darkColor }};">
                        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center p-3">
                            <span class="badge rounded-pill p-2" style="background-color: {{ $color }}; color: white; font-size: 0.875rem;">
                                {{ ucfirst($task->project_type) }}
                            </span>
                            
                            <!-- Improved Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-sm btn-link text-muted p-0" type="button" 
                                    id="taskDropdown{{ $task->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical fs-5"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm" 
                                    aria-labelledby="taskDropdown{{ $task->id }}" style="min-width: 180px;">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" 
                                           href="{{ route('task-lists.tasks.index', $task->id) }}">
                                            <i class="bi bi-eye me-2"></i> View Details
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" 
                                           href="{{ route('task-lists.edit', $task->id) }}">
                                            <i class="bi bi-pencil me-2"></i> Edit Task
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('task-lists.destroy', $task->id) }}" method="POST" 
                                            onsubmit="return confirm('Are you sure you want to delete this task?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item d-flex align-items-center text-danger">
                                                <i class="bi bi-trash me-2"></i> Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="card-body p-3">
                            <div class="d-flex align-items-start mb-3">
                                <span class="display-6 me-3">{{ $icon }}</span>
                                <h5 class="card-title fw-bold mb-0" style="font-size: 1.1rem;">{{ $task->name }}</h5>
                            </div>
                            
                            <div class="task-meta mb-3">
                                <div class="d-flex align-items-center text-muted mb-2">
                                    <i class="bi bi-calendar-event me-2"></i>
                                    <small>Started: {{ $startDate }}</small>
                                </div>
                                <div class="d-flex align-items-center text-muted">
                                    <i class="bi bi-calendar-check me-2"></i>
                                    <small>Completed: {{ $endDate }}</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-white border-0 p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-light text-dark rounded-pill p-2 fs-6">
                                    <i class="bi bi-check-circle-fill text-success me-1 fs-5"></i>
                                    Completed
                                </span>
                                <div class="text-end">
                                    <small class="text-muted">Created {{ $task->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .task-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .task-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .dropdown-menu {
        border-radius: 10px;
        border: none;
    }
    
    .dropdown-item {
        padding: 8px 16px;
        border-radius: 6px;
        transition: all 0.2s;
    }
    
    .dropdown-item:hover {
        background-color: #f8f9fa;
    }
    
    .empty-state {
        padding: 40px 0;
    }
    
    .task-meta {
        background-color: #f8fafc;
        border-radius: 8px;
        padding: 12px;
    }
    
    .card-title {
        word-break: break-word;
    }
    
    .dropdown-toggle::after {
        display: none;
    }
</style>

<script>
    // Ensure dropdowns work properly
    document.addEventListener('DOMContentLoaded', function() {
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                    menu.classList.remove('show');
                });
            }
        });
    });
</script>
@endsection