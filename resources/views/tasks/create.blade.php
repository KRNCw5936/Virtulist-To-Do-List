@extends('layouts.app')

@section('title', 'Add Task')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add Task</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('task-lists.tasks.store', $taskList->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Task Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="priority" class="form-label">Pritority</label>
                    <select class="form-select" id="priority" name="priority" required>
                        <option value="Tinggi">High</option>
                        <option value="Sedang">Medium</option>
                        <option value="Rendah">Low</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('task-lists.tasks.index', $taskList->id) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
