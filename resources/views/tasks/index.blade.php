@extends('layouts.app')

@section('title', 'Task')

@section('content')
<div class="container">
    <!-- Tombol Kembali -->
    <div class="mb-3">
        <a href="{{ route('homepage.home') }}" class="btn btn-outline-secondary d-inline-flex align-items-center">
            <i class="bi bi-arrow-left me-2"></i> Back
        </a>
    </div>

    <!-- Header -->
    <div class="card shadow-sm position-relative rounded-4 overflow-hidden">
        <div class="card-body d-flex flex-column align-items-center justify-content-center text-dark position-relative rounded-4"
            style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); padding: 20px; width: 100%; border-radius: 16px; box-shadow: inset 0 0 20px rgba(0,0,0,0.05);">
            
            <div class="text-center position-relative w-100">
                <h2 class="fw-bold">{{ $taskList->name }}</h2>
                <p class="text-muted">{{ $taskList->description }}</p>
                <p class="text-muted">{{ $taskList->start_date }} - {{ $taskList->end_date }}</p>
                <div class="d-flex justify-content-center gap-3">
                    <!-- Tombol Tambah Tugas tanpa background -->
                    <a href="{{ route('task-lists.tasks.create', $taskList->id) }}" class="btn btn-outline-success d-flex align-items-center px-4 py-2 rounded-3">
                        <i class="bi bi-plus-circle me-2"></i>Add Tasks
                    </a>
                    <!-- Tombol Edit Task List tanpa background -->
                    <a href="{{ route('task-lists.edit', $taskList->id) }}" class="btn btn-outline-warning d-flex align-items-center px-4 py-2 rounded-3">
                        <i class="bi bi-pencil-square me-2"></i>Edit To-Do
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid Layout -->
    <div class="row mt-4">
        <!-- Kolom Tugas -->
        <div class="col-md-4">
            <div class="bg-white shadow-sm rounded-4 p-3 mb-3 text-center border-start border-4 border-primary">
                <h5 class="mb-0 text-primary fw-semibold">📋 New Tasks</h5>
            </div>
            <div id="task-pending" class="task-container bg-body-secondary p-3 rounded-4 border border-primary-subtle" data-task-list-id="{{ $taskList->id }}">
                @foreach($tasks->where('is_completed', false)->where('in_progress', false) as $task)
                    <div class="card mb-3 border-0 shadow-sm task-item rounded-4" data-id="{{ $task->id }}" draggable="true" style="transition: all 0.3s ease;">
                        <div class="card-body position-relative">
                            <div class="dropdown position-absolute top-0 end-0 mt-2 me-2">
                                <button class="btn bg-transparent btn-sm border-0 shadow-none p-0 text-dark" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical fs-5"></i>
                                </button>                        
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('task-lists.tasks.edit', [$taskList->id, $task->id]) }}">
                                            <i class="bi bi-pencil-square me-2"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('task-lists.tasks.destroy', [$taskList->id, $task->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tugas ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-trash3 me-2"></i> Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            <h5 class="card-title">{{ $task->name }}</h5>
                            <p class="text-muted">
                                <i class="bi bi-calendar-event me-2"></i> 
                                {{ \Carbon\Carbon::parse($task->start_date)->format('d - m - Y') }} 
                                Hingga 
                                {{ \Carbon\Carbon::parse($task->end_date)->format('d - m - Y') }}
                            </p>               
                            <p>
                                @if($task->priority === 'Tinggi')
                                    <span class="text-danger"><i class="bi bi-flag-fill me-1"></i> High</span>
                                @elseif($task->priority === 'Sedang')
                                    <span class="text-warning"><i class="bi bi-flag-fill me-1"></i> Medium</span>
                                @else
                                    <span class="text-success"><i class="bi bi-flag-fill me-1"></i> Low</span>
                                @endif
                            </p>                    
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Kolom Progres -->
        <div class="col-md-4">
            <div class="bg-white shadow-sm rounded-4 p-3 mb-3 text-center border-start border-4 border-warning">
                <h5 class="mb-0 text-warning fw-semibold">⚙️ In Progress</h5>
            </div>
            <div id="task-progress" class="task-container bg-body-secondary p-3 rounded-4 border border-warning-subtle" data-task-list-id="{{ $taskList->id }}">
                @foreach($tasks->where('is_completed', false)->where('in_progress', true) as $task)
                    <div class="card mb-3 border-0 shadow-sm task-item rounded-4" data-id="{{ $task->id }}" draggable="true" style="transition: all 0.3s ease;">
                        <div class="card-body position-relative">
                            <div class="dropdown position-absolute top-0 end-0 mt-2 me-2">
                                <button class="btn bg-transparent btn-sm border-0 shadow-none p-0 text-dark" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical fs-5"></i>
                                </button>                        
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('task-lists.tasks.edit', [$taskList->id, $task->id]) }}">
                                            <i class="bi bi-pencil-square me-2"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('task-lists.tasks.destroy', [$taskList->id, $task->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tugas ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-trash3 me-2"></i> Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            <h5 class="card-title">{{ $task->name }}</h5>
                            <p class="text-muted">
                                <i class="bi bi-calendar-event me-2"></i> 
                                {{ \Carbon\Carbon::parse($task->start_date)->format('d - m - Y') }} 
                                Hingga 
                                {{ \Carbon\Carbon::parse($task->end_date)->format('d - m - Y') }}
                            </p>               
                            <p>
                                @if($task->priority === 'Tinggi')
                                    <span class="text-danger"><i class="bi bi-flag-fill me-1"></i> High</span>
                                @elseif($task->priority === 'Sedang')
                                    <span class="text-warning"><i class="bi bi-flag-fill me-1"></i> Medium</span>
                                @else
                                    <span class="text-success"><i class="bi bi-flag-fill me-1"></i> Low</span>
                                @endif
                            </p>                    
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Kolom Selesai -->
        <div class="col-md-4">
            <div class="bg-white shadow-sm rounded-4 p-3 mb-3 text-center border-start border-4 border-success">
                <h5 class="mb-0 text-success fw-semibold">✅ Completed</h5>
            </div>
            <div id="task-completed" class="task-container bg-body-secondary p-3 rounded-4 border border-success-subtle" data-task-list-id="{{ $taskList->id }}">
                @foreach($tasks->where('is_completed', true) as $task)
                    <div class="card mb-3 border-0 shadow-sm task-item rounded-4" data-id="{{ $task->id }}" draggable="true" style="transition: all 0.3s ease;">
                        <div class="card-body position-relative">
                            <div class="dropdown position-absolute top-0 end-0 mt-2 me-2">
                                <button class="btn bg-transparent btn-sm border-0 shadow-none p-0 text-dark" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical fs-5"></i>
                                </button>                        
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('task-lists.tasks.edit', [$taskList->id, $task->id]) }}">
                                            <i class="bi bi-pencil-square me-2"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('task-lists.tasks.destroy', [$taskList->id, $task->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tugas ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-trash3 me-2"></i> Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            <h5 class="card-title">{{ $task->name }}</h5>
                            <p class="text-muted">
                                <i class="bi bi-calendar-event me-2"></i> 
                                {{ \Carbon\Carbon::parse($task->start_date)->format('d - m - Y') }} 
                                Hingga 
                                {{ \Carbon\Carbon::parse($task->end_date)->format('d - m - Y') }}
                            </p>                            
                            <p>
                                @if($task->priority === 'Tinggi')
                                    <span class="text-danger"><i class="bi bi-flag-fill me-1"></i> High</span>
                                @elseif($task->priority === 'Sedang')
                                    <span class="text-warning"><i class="bi bi-flag-fill me-1"></i> Medium</span>
                                @else
                                    <span class="text-success"><i class="bi bi-flag-fill me-1"></i> Low</span>
                                @endif
                            </p>                    
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
