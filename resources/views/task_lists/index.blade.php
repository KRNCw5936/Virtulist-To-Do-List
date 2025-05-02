@extends('layouts.app')

@section('title', 'Task Lists')

@section('content')
<div class="container py-5 px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-black fw-bold">📋 To-Do List</h2>
    </div>

    @php
        $taskCategories = [
            '📅 Today' => $todayTasks,
            '📆 Yesterday' => $yesterdayTasks,
            '📖 2–7 Days Ago' => $lastWeekTasks,
            '🗂️ 8–30 Days Ago' => $lastMonthTasks,
            '📚 More than 30 Days Ago' => $olderTasks
        ];

        $taskColors = [
            'School' => ['bg-blue-gradient', '🎓'],
            'Private' => ['bg-green-gradient', '🌱'],
            'Work' => ['bg-teal-gradient', '💼'],
        ];
    @endphp

    @foreach ($taskCategories as $title => $tasks)
        @if ($tasks->isNotEmpty())
            <div class="section-header mb-3 mt-5 d-flex align-items-center">
                <h4 class="fw-bold mb-0 text-muted">{{ $title }}</h4>
                <span class="badge bg-light text-dark ms-2">{{ $tasks->count() }}</span>
            </div>
            
            <div class="row g-4">
                @foreach ($tasks as $task)
                    @php
                        $colorClass = $taskColors[$task->project_type][0] ?? 'bg-gray-gradient';
                        $icon = $taskColors[$task->project_type][1] ?? '📝';
                        $startDate = \Carbon\Carbon::parse($task->start_date)->format('d M Y');
                        $endDate = \Carbon\Carbon::parse($task->end_date)->format('d M Y');
                    @endphp

                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="card task-card border-0 shadow-sm h-100">
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="task-icon {{ $colorClass }} rounded-circle d-flex align-items-center justify-content-center">
                                        {{ $icon }}
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-link text-muted dropdown-toggle no-caret" 
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2">
                                            <li>
                                                <a class="dropdown-item rounded-2 d-flex align-items-center py-2 px-3" 
                                                   href="{{ route('task-lists.tasks.index', $task->id) }}">
                                                    <i class="bi bi-eye me-3"></i>View Details
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item rounded-2 d-flex align-items-center py-2 px-3" 
                                                   href="{{ route('task-lists.edit', $task->id) }}">
                                                    <i class="bi bi-pencil me-3"></i>Edit Task
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item rounded-2 d-flex align-items-center py-2 px-3" 
                                                   href="{{ route('task-lists.toggle-status', $task->id) }}"
                                                   onclick="event.preventDefault(); document.getElementById('toggle-status-{{ $task->id }}').submit();">
                                                    <i class="bi bi-check-circle me-3"></i>
                                                    {{ $task->is_complete ? 'Mark as Progress' : 'Mark as Complete' }}
                                                </a>
                                                <form id="toggle-status-{{ $task->id }}" 
                                                      action="{{ route('task-lists.toggle-status', $task->id) }}" 
                                                      method="POST" style="display: none;">
                                                    @csrf
                                                    @method('PATCH')
                                                </form>
                                            </li>
                                            <li><hr class="dropdown-divider my-2"></li>
                                            <li>
                                                <form action="{{ route('task-lists.destroy', $task->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="dropdown-item rounded-2 d-flex align-items-center py-2 px-3 text-danger"
                                                            onclick="return confirm('Are you sure you want to delete this task?');">
                                                        <i class="bi bi-trash me-3"></i>Delete Task
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <h5 class="card-title fw-bold mb-2 text-truncate">{{ $task->name }}</h5>
                                
                                <div class="task-dates text-muted mb-3">
                                    <small class="d-flex align-items-center">
                                        <i class="bi bi-calendar3 me-2"></i>
                                        {{ $startDate }} - {{ $endDate }}
                                    </small>
                                </div>
                                
                                <div class="mt-auto">
                                    <span class="badge {{ $task->is_complete ? 'bg-success' : 'bg-warning' }} text-white rounded-pill">
                                        {{ $task->is_complete ? 'Completed' : 'In Progress' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endforeach

    @if ($todayTasks->isEmpty() && $yesterdayTasks->isEmpty() && $lastWeekTasks->isEmpty() && $lastMonthTasks->isEmpty() && $olderTasks->isEmpty())
        <div class="empty-state text-center py-5 my-5">
            <div class="empty-state-icon bg-light rounded-circle p-4 d-inline-block mb-3">
                <i class="bi bi-clipboard2-check fs-1 text-muted"></i>
            </div>
            <h4 class="fw-bold text-muted mb-3">No Tasks Found</h4>
            <p class="text-muted mb-4">You don't have any tasks yet. Start by creating a new task!</p>
            <a href="{{ route('task-lists.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-plus-lg me-2"></i>Create Task
            </a>
        </div>
    @endif
</div>

<style>
    .task-card {
        transition: all 0.2s ease;
        border-radius: 12px !important;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .task-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    
    .task-icon {
        width: 40px;
        height: 40px;
        font-size: 18px;
    }
    
    .bg-blue-gradient {
        background: linear-gradient(135deg, #1E90FF, #104E8B);
        color: white;
    }
    
    .bg-green-gradient {
        background: linear-gradient(135deg, #32CD32, #228B22);
        color: white;
    }
    
    .bg-teal-gradient {
        background: linear-gradient(135deg, #00CED1, #008B8B);
        color: white;
    }
    
    .bg-gray-gradient {
        background: linear-gradient(135deg, #808080, #505050);
        color: white;
    }
    
    .section-header {
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 8px;
    }
    
    .dropdown-toggle.no-caret::after {
        display: none !important;
    }
    
    .dropdown-menu {
        border-radius: 12px !important;
        min-width: 220px;
    }
    
    .empty-state-icon {
        background-color: #f8f9fa;
    }
    
    .card-title {
        font-size: 1.1rem;
        line-height: 1.4;
    }
    
    .task-dates small {
        font-size: 0.85rem;
    }
</style>
@endsection