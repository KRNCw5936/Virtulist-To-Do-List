{{-- @extends('layouts.app')

@section('title', 'Create To-Do')

@section('content')
    <div class="container">
        <h3 class="mt-4 mb-3"><i class="bi bi-lightbulb"></i> Come on, do your homework!</h3>
        <!-- SECTION: RECENT TASK LISTS -->
        <h5 class="mt-4">Make Your Task Here!</h5>
        <div class="row g-3"> 
            <!-- Tombol Tambah Task List -->
            <div class="col-6 col-md-4 col-lg-2"> 
                <div class="card p-3 text-center shadow-sm d-flex align-items-center justify-content-center" 
                    style="height: 150px; background: linear-gradient(135deg, #FFA500, #800080, #00BFFF); color: white;">
                    <a href="{{ route('task-lists.create') }}" class="btn btn-outline-light">+ Create To-Do</a>
                </div>
            </div>
            
            @php
                $taskColors = [
                    'school' => ['#1E90FF', '#104E8B', '🎓'], // Biru (Sekolah)
                    'private' => ['#32CD32', '#228B22', '🌱'], // Hijau (Pribadi)
                    'work' => ['#00CED1', '#008B8B', '💼'], // Cyan (Pekerjaan)
                ];
            @endphp

            <!-- Menampilkan Semua Task List -->
            @foreach ($taskLists as $taskList)
                @php
                    $category = strtolower($taskList->project_type ?? 'default'); // Default jika tidak ada kategori
                    $color = $taskColors[$category][0] ?? '#CCCCCC'; // Warna utama
                    $darkColor = $taskColors[$category][1] ?? '#999999'; // Warna gelap
                    $icon = $taskColors[$category][2] ?? '📋'; // Default icon
                @endphp

                <div class="col-6 col-md-4 col-lg-2"> 
                    <div class="card shadow-sm position-relative p-3 d-flex flex-column align-items-center text-center"
                        style="height: 150px; background: linear-gradient(135deg, {{ $color }}, {{ $darkColor }}); color: white;">

                        @if ($taskList->is_pinned)
                            <i class="bi bi-pin-fill text-dark position-absolute" style="top: 8px; left: 8px; font-size: 1.2rem;"></i>
                        @endif
                        
                        <!-- Nama Task List -->
                        <div class="d-flex justify-content-center align-items-center w-100" style="height: 100%; min-height: 100px;">
                            <a href="{{ route('task-lists.tasks.index', $taskList->id) }}" 
                               class="text-decoration-none text-dark fw-bold text-truncate d-block" 
                               style="max-width: 90%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                {{ $icon }} {{ $taskList->name }}
                            </a>
                        </div>                                                            

                        <!-- Tanggal Pembuatan -->
                        <small class="text-muted position-absolute text-truncate"
                            style="bottom: 8px; white-space: nowrap; font-size: 0.8rem; max-width: 90%;">
                            {{ \Carbon\Carbon::parse($taskList->created_at)->format('d/m/Y') }}
                        </small>

                        <!-- Dropdown -->
                        <div class="position-absolute" style="top: 8px; right: 8px;">
                            <div class="dropdown">
                                <button class="btn btn-light p-0 border-0" type="button" 
                                    id="dropdownMenu{{ $taskList->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('assets/image/three-dots-icon.png') }}" alt="Menu" width="20" height="20">
                                </button>                            
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenu{{ $taskList->id }}">
                                    <li><a class="dropdown-item" href="{{ route('task-lists.tasks.index', $taskList->id) }}"><i class="bi bi-eye"></i> See Task</a></li>
                                    <li><a class="dropdown-item" href="{{ route('task-lists.edit', $taskList->id) }}"><i class="bi bi-pencil"></i> Edit Task</a></li>
                                    <li>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#taskListModal{{ $taskList->id }}">
                                            <i class="bi bi-info-circle"></i> See To-Do
                                        </button>
                                    </li>
                                    <li>
                                        <form action="{{ route('task-lists.destroy', $taskList->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus task list ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash"></i> Delete Task</button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('task-lists.togglePin', $taskList->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="dropdown-item">
                                                <i class="bi {{ $taskList->is_pinned ? 'bi-pin-fill' : 'bi-pin' }}"></i>
                                                {{ $taskList->is_pinned ? 'Unpin' : 'Pin' }}
                                            </button>
                                        </form>
                                    </li>                        
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal untuk Melihat Detail Task List -->
                <div class="modal fade" id="taskListModal{{ $taskList->id }}" tabindex="-1" aria-labelledby="taskListModalLabel{{ $taskList->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="taskListModalLabel{{ $taskList->id }}">Details Task</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Task Name:</strong> {{ $taskList->name }}</p>
                                <p><strong>Project Type:</strong> {{ $taskList->project_type ?? '-' }}</p>
                                <p><strong>Description:</strong> {{ $taskList->description ?? 'Tidak ada deskripsi' }}</p>
                                <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($taskList->start_date)->format('d/m/Y') }}</p>
                                <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($taskList->end_date)->format('d/m/Y') }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach

            <!-- Jika Tidak Ada Task List -->
            @if ($taskLists->isEmpty())
                <div class="w-100 text-center">
                    <p class="text-muted">No Task List Created Yet</p>
                </div>
            @endif
        </div>        
    </div>
@endsection --}}

@extends('layouts.app')

@section('title', 'Create To-Do')

@section('content')
    <div class="container py-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-0"><i class="bi bi-lightbulb text-warning"></i> Come on, do your homework!</h3>
                <p class="text-muted mb-0">Organize your tasks efficiently</p>
            </div>
            <a href="{{ route('task-lists.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Create To-Do
            </a>
        </div>

        <!-- Task Lists Section -->
        <div class="mb-5">
            <h5 class="mb-3">Your Task Collections</h5>
            
            @php
                $taskColors = [
                    'school' => ['#6366f1', '#4f46e5', '🎓'], // Indigo (School)
                    'private' => ['#10b981', '#059669', '🌱'], // Emerald (Personal)
                    'work' => ['#f59e0b', '#d97706', '💼'], // Amber (Work)
                    'default' => ['#64748b', '#475569', '📋'] // Slate (Default)
                ];
            @endphp

            <div class="row g-3">
                @foreach ($taskLists as $taskList)
                    @php
                        $category = strtolower($taskList->project_type ?? 'default');
                        $color = $taskColors[$category][0] ?? $taskColors['default'][0];
                        $darkColor = $taskColors[$category][1] ?? $taskColors['default'][1];
                        $icon = $taskColors[$category][2] ?? $taskColors['default'][2];
                        $completionPercentage = $taskList->tasks->count() > 0 
                            ? ($taskList->tasks->where('is_completed', true)->count() / $taskList->tasks->count()) * 100 
                            : 0;
                    @endphp

                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm overflow-hidden position-relative">
                            <!-- Card Header with Pinned Indicator -->
                            <div class="card-header d-flex justify-content-between align-items-center" 
                                 style="background: linear-gradient(135deg, {{ $color }}, {{ $darkColor }});">
                                <div class="d-flex align-items-center">
                                    @if ($taskList->is_pinned)
                                        <i class="bi bi-pin-fill text-white me-2"></i>
                                    @endif
                                    <span class="text-white fw-semibold text-truncate" style="max-width: 150px;">
                                        {{ $icon }} {{ $taskList->name }}
                                    </span>
                                </div>
                                
                                <!-- Dropdown Menu -->
                                <div class="dropdown">
                                    <button class="btn btn-sm p-0 border-0 bg-transparent" type="button" 
                                        id="dropdownMenu{{ $taskList->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical text-white"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow dropdown-menu-scrollable" 
                                        aria-labelledby="dropdownMenu{{ $taskList->id }}">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center" 
                                               href="{{ route('task-lists.tasks.index', $taskList->id) }}">
                                                <i class="bi bi-list-check me-2"></i> View Tasks
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center" 
                                               href="{{ route('task-lists.edit', $taskList->id) }}">
                                                <i class="bi bi-pencil-square me-2"></i> Edit Task List
                                            </a>
                                        </li>
                                        <li>
                                            <button class="dropdown-item d-flex align-items-center" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#taskListModal{{ $taskList->id }}">
                                                <i class="bi bi-info-circle me-2"></i> Details
                                            </button>
                                        </li>
                                        <li>
                                            <form action="{{ route('task-lists.togglePin', $taskList->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="dropdown-item d-flex align-items-center w-100">
                                                    <i class="bi {{ $taskList->is_pinned ? 'bi-pin-angle' : 'bi-pin' }} me-2"></i>
                                                    {{ $taskList->is_pinned ? 'Unpin' : 'Pin' }}
                                                </button>
                                            </form>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('task-lists.destroy', $taskList->id) }}" method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to delete this task list?');">
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
                            
                            <!-- Card Body -->
                            <div class="card-body">
                                <!-- Progress Bar -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between small mb-1">
                                        <span>Progress</span>
                                        <span>{{ round($completionPercentage) }}%</span>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar" 
                                             role="progressbar" 
                                             style="width: {{ $completionPercentage }}%; background-color: {{ $color }}"
                                             aria-valuenow="{{ $completionPercentage }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Task Count -->
                                <div class="d-flex justify-content-between small text-muted mb-2">
                                    <span>Tasks:</span>
                                    <span>{{ $taskList->tasks->count() }}</span>
                                </div>
                                
                                <!-- Completed Count -->
                                <div class="d-flex justify-content-between small text-muted mb-2">
                                    <span>Completed:</span>
                                    <span>{{ $taskList->tasks->where('is_completed', true)->count() }}</span>
                                </div>
                                
                                <!-- Date Range -->
                                <div class="d-flex justify-content-between small text-muted">
                                    <span>Date Range:</span>
                                    <span>
                                        {{ \Carbon\Carbon::parse($taskList->start_date)->format('M d') }} - 
                                        {{ \Carbon\Carbon::parse($taskList->end_date)->format('M d') }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Card Footer -->
                            <div class="card-footer bg-transparent border-top-0 pt-0">
                                <small class="text-muted">
                                    Created: {{ \Carbon\Carbon::parse($taskList->created_at)->format('M d, Y') }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Task List Details -->
                    <div class="modal fade" id="taskListModal{{ $taskList->id }}" tabindex="-1" 
                         aria-labelledby="taskListModalLabel{{ $taskList->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header" 
                                     style="background: linear-gradient(135deg, {{ $color }}, {{ $darkColor }});">
                                    <h5 class="modal-title text-white" id="taskListModalLabel{{ $taskList->id }}">
                                        {{ $icon }} {{ $taskList->name }}
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <h6 class="fw-semibold">Description</h6>
                                        <p>{{ $taskList->description ?? 'No description provided' }}</p>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <h6 class="fw-semibold">Project Type</h6>
                                            <p>{{ $taskList->project_type ?? '-' }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6 class="fw-semibold">Status</h6>
                                            <p>
                                                @if($taskList->end_date < now())
                                                    <span class="badge bg-danger">Overdue</span>
                                                @elseif($completionPercentage == 100)
                                                    <span class="badge bg-success">Completed</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">In Progress</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <h6 class="fw-semibold">Start Date</h6>
                                            <p>{{ \Carbon\Carbon::parse($taskList->start_date)->format('M d, Y') }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6 class="fw-semibold">End Date</h6>
                                            <p>{{ \Carbon\Carbon::parse($taskList->end_date)->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <h6 class="fw-semibold">Task Summary</h6>
                                        <div class="d-flex justify-content-between small mb-1">
                                            <span>Total Tasks</span>
                                            <span>{{ $taskList->tasks->count() }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between small mb-1">
                                            <span>Completed</span>
                                            <span>{{ $taskList->tasks->where('is_completed', true)->count() }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between small">
                                            <span>Remaining</span>
                                            <span>{{ $taskList->tasks->where('is_completed', false)->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <a href="{{ route('task-lists.tasks.index', $taskList->id) }}" class="btn btn-primary">
                                        <i class="bi bi-list-check me-1"></i> View Tasks
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if ($taskLists->isEmpty())
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center py-5">
                                <i class="bi bi-clipboard2-x text-muted" style="font-size: 2.5rem;"></i>
                                <h5 class="mt-3 mb-2">No Task Lists Created Yet</h5>
                                <p class="text-muted">Get started by creating your first task list</p>
                                <a href="{{ route('task-lists.create') }}" class="btn btn-primary mt-2">
                                    <i class="bi bi-plus-lg"></i> Create Task List
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-radius: 10px;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        /* Enhanced Dropdown Styles */
        .dropdown-menu {
            border-radius: 8px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            padding: 0;
            overflow: hidden;
        }
        
        .dropdown-menu-scrollable {
            max-height: 300px;
            overflow-y: auto;
        }
        
        .dropdown-menu-scrollable::-webkit-scrollbar {
            width: 6px;
        }
        
        .dropdown-menu-scrollable::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 0 8px 8px 0;
        }
        
        .dropdown-menu-scrollable::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        
        .dropdown-menu-scrollable::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        .dropdown-item {
            padding: 0.5rem 1rem;
            border-radius: 0;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        
        .dropdown-divider {
            margin: 0;
        }
        
        .progress {
            border-radius: 3px;
            background-color: #e9ecef;
        }
        
        .modal-header {
            border-radius: 10px 10px 0 0 !important;
        }
    </style>
@endsection