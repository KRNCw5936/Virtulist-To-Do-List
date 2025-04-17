@extends('layouts.app')

@section('title', 'Task Selesai')

@section('content')
<div class="container py-5 px-4">
    <h2 class="text-black mb-4 w-100">✅ Task yang Sudah Selesai</h2>

    @if ($completedTasks->isEmpty())
        <p class="text-muted text-center mt-4">Belum ada tugas yang selesai!</p>
    @else
        <div class="row g-4 justify-content-start">
            @foreach ($completedTasks as $task)
                @php
                    $taskColors = [
                        'sekolah' => ['#1E90FF', '#104E8B', '🎓'],
                        'pribadi' => ['#32CD32', '#228B22', '🌱'],
                        'pekerjaan' => ['#00CED1', '#008B8B', '💼'],
                    ];
                    $color = $taskColors[$task->project_type][0] ?? '#808080';
                    $darkColor = $taskColors[$task->project_type][1] ?? '#505050';
                    $icon = $taskColors[$task->project_type][2] ?? '📝';

                    $startDate = \Carbon\Carbon::parse($task->start_date)->format('d/m/Y');
                    $endDate = \Carbon\Carbon::parse($task->end_date)->format('d/m/Y');
                @endphp

                <div class="col-md-3 col-sm-4 col-6 d-flex justify-content-center">
                    <div class="card border-0 rounded-4 position-relative custom-card"
                         style="background: linear-gradient(135deg, {{ $color }}, {{ $darkColor }}); max-width: 260px;">
                        
                        <!-- Dropdown opsi -->
                        <div class="position-absolute top-0 end-0 p-2">
                         <div class="dropdown">
                             <button class="btn btn-light btn-sm" type="button" 
                                        id="dropdownMenuButton{{ $task->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                 <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" 
                                    aria-labelledby="dropdownMenuButton{{ $task->id }}">
                                 <li>
                                        <a class="dropdown-item" href="{{ route('task-lists.tasks.index', $task->id) }}">
                                         <i class="bi bi-eye me-2"></i> Lihat
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('task-lists.edit', $task->id) }}">
                                            <i class="bi bi-pencil me-2"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('task-lists.destroy', $task->id) }}" method="POST" 
                                            onsubmit="return confirm('Yakin ingin menghapus?');">
                                         @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                             <i class="bi bi-trash me-2"></i> Hapus
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                         </div>
                        </div>

                        <div class="card-body text-center px-3 py-4">
                            <h5 class="fw-bold mb-2" style="font-family: 'Poppins', sans-serif; font-size: 16px;">
                                <span style="font-size: 22px;">{{ $icon }}</span> {{ $task->name }}
                            </h5>

                            <p class="project-type-label mb-2">{{ ucfirst($task->project_type) }}</p>
                            
                            <p class="text-white fw-medium mb-3" style="font-size: 12px;">
                                {{ $startDate }} - {{ $endDate }}
                            </p>
                            
                            {{-- <a href="{{ route('task-lists.toggle-status', $task->id) }}" 
                               class="btn btn-success rounded-pill btn-sm px-3 py-1 task-done-btn"
                               onclick="event.preventDefault(); document.getElementById('toggle-status-{{ $task->id }}').submit();">
                                Selesai
                            </a> --}}

                            <form id="toggle-status-{{ $task->id }}" 
                                  action="{{ route('task-lists.toggle-status', $task->id) }}" 
                                  method="POST" style="display: none;">
                                @csrf
                                @method('PATCH')
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .custom-card {
        padding: 18px;
        border-radius: 16px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        height: auto;
        width: 100%;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .custom-card:hover {
        transform: translateY(-4px);
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15);
    }

    .project-type-label {
        background-color: rgba(255, 255, 255, 0.25);
        color: #fff;
        font-size: 13px;
        display: inline-block;
        padding: 3px 12px;
        border-radius: 14px;
        font-weight: 500;
        font-family: 'Poppins', sans-serif;
        backdrop-filter: blur(2px);
    }

    .task-done-btn {
        background-color: #28a745;
        font-size: 13px;
        padding: 6px 14px;
        font-weight: 500;
        color: #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        transition: all 0.2s ease-in-out;
    }

    .task-done-btn:hover {
        background-color: #218838;
        transform: scale(1.03);
    }

    .menu-icon {
        font-size: 16px;
    }
</style>
@endsection
