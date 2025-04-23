@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">Edit Task</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('task-lists.tasks.update', [$taskList->id, $task->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Name Task</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $task->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="priority" class="form-label">Prioritas</label>
                    <select class="form-select" id="priority" name="priority" required>
                        <option value="Tinggi" {{ $task->priority == 'Tinggi' ? 'selected' : '' }}>High</option>
                        <option value="Sedang" {{ $task->priority == 'Sedang' ? 'selected' : '' }}>Medium</option>
                        <option value="Rendah" {{ $task->priority == 'Rendah' ? 'selected' : '' }}>Low</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $task->start_date }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $task->end_date }}" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('task-lists.tasks.index', $taskList->id) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
