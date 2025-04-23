@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .clickable-item {
        transition: background-color 0.3s ease, transform 0.2s ease;
        border: 1px solid #000000;
        border-radius: 0.5rem;
        background-color: #ffffff;
        padding: 1rem;
    }

    .clickable-item:hover {
        background-color: #e9ecef;
        transform: translateX(5px);
    }

    .arrow-icon {
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .clickable-item:hover .arrow-icon {
        opacity: 1;
    }

    .notification-wrapper {
        margin-bottom: 10px;
    }
</style>

<div class="container">
    <h2 class="bi bi-bell mb-4">Upcoming Deadline Notifications</h2>

    @if($notifTasks->count() > 0)
        @foreach($notifTasks as $taskList)
            <div class="d-flex align-items-center justify-content-between notification-wrapper">
                <a href="{{ route('task-lists.tasks.index', $taskList->id) }}" 
                   class="d-flex justify-content-between align-items-center flex-grow-1 clickable-item text-decoration-none text-dark">
                    <div>{{ $taskList->name }}</div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-danger">{{ \Carbon\Carbon::parse($taskList->end_date)->format('d M Y') }}</span>
                        <i class="arrow-icon bi bi-arrow-right-short fs-4"></i>
                    </div>
                </a>

                <form action="{{ route('task-lists.update-status', $taskList->id) }}" method="POST" class="ms-3">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="bi bi-check-circle"></i> Done
                    </button>
                </form>
            </div>
        @endforeach
    @else
        <div class="alert alert-info">
            There are no upcoming deadline notifications at the moment.
        </div>
    @endif
</div>
@endsection
