@extends('layouts.app')

@section('title', 'Task Lists')

@section('content')
<div class="container py-5 px-4">
    <h2 class="text-black mb-4">📋 Daftar Tugas</h2>

    @php
        $taskCategories = [
            '📅 Hari Ini' => $todayTasks,
            '📆 Kemarin' => $yesterdayTasks,
            '📖 2–7 Hari Lalu' => $lastWeekTasks,
            '🗂️ 8–30 Hari Lalu' => $lastMonthTasks,
            '📚 Lebih dari 30 Hari Lalu' => $olderTasks
        ];

        $taskColors = [
            'sekolah' => ['#1E90FF', '#104E8B', '🎓'],
            'pribadi' => ['#32CD32', '#228B22', '🌱'],
            'pekerjaan' => ['#00CED1', '#008B8B', '💼'],
        ];
    @endphp

    @foreach ($taskCategories as $title => $tasks)
        @if ($tasks->isNotEmpty())
            <h4 class="mt-5 fw-bold text-primary">{{ $title }}</h4>
            <div class="row g-4">
                @foreach ($tasks as $task)
                    @php
                        $color = $taskColors[$task->project_type][0] ?? '#808080';
                        $darkColor = $taskColors[$task->project_type][1] ?? '#505050';
                        $icon = $taskColors[$task->project_type][2] ?? '📝';
                        $startDate = \Carbon\Carbon::parse($task->start_date)->format('d/m/Y');
                        $endDate = \Carbon\Carbon::parse($task->end_date)->format('d/m/Y');
                    @endphp

                    <div class="col-lg-3 col-md-4 col-sm-6 d-flex justify-content-center">
                        <div class="card shadow-lg border-0 rounded-3 hover-effect w-100"
                             style="background: linear-gradient(135deg, {{ $color }}, {{ $darkColor }});">
                            <div class="card-body text-center text-white px-3 py-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title text-truncate text-white fw-bold mb-0" style="max-width: 70%;">
                                        {{ $icon }} {{ $task->name }}
                                    </h5>
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm" type="button" 
                                            id="dropdownMenuButton{{ $task->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" 
                                            aria-labelledby="dropdownMenuButton{{ $task->id }}">
                                            <li><a class="dropdown-item" href="{{ route('task-lists.tasks.index', $task->id) }}">
                                                <i class="bi bi-eye me-2"></i> Lihat</a></li>
                                            <li><a class="dropdown-item" href="{{ route('task-lists.edit', $task->id) }}">
                                                <i class="bi bi-pencil me-2"></i> Edit</a></li>
                                            <li>
                                                <form action="{{ route('task-lists.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
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

                                <p class="fw-light text-white" style="font-size: 13px;">
                                    {{ $startDate }} - {{ $endDate }}
                                </p>

                                <a href="{{ route('task-lists.toggle-status', $task->id) }}"
                                   class="badge {{ $task->is_complete ? 'bg-success' : 'bg-warning' }} text-decoration-none"
                                   onclick="event.preventDefault(); document.getElementById('toggle-status-{{ $task->id }}').submit();">
                                    {{ $task->is_complete ? 'Selesai' : 'Progres' }}
                                </a>

                                <form id="toggle-status-{{ $task->id }}" action="{{ route('task-lists.toggle-status', $task->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('PATCH')
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endforeach

    @if ($todayTasks->isEmpty() && $yesterdayTasks->isEmpty() && $lastWeekTasks->isEmpty() && $lastMonthTasks->isEmpty() && $olderTasks->isEmpty())
        <p class="text-muted text-center mt-5">🚀 Tidak ada tugas yang tersedia.</p>
    @endif
</div>

<style>
    .hover-effect {
        transition: all 0.3s ease-in-out;
    }

    .hover-effect:hover {
        transform: translateY(-5px);
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        font-size: 16px;
    }

    .card-body {
        padding: 1.25rem;
    }
</style>
@endsection
