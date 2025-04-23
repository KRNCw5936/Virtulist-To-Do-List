@extends('layouts.app')

@section('title', 'Edit Task List')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-warning text-white text-center py-3">
            <h4 class="mb-0">Edit Task List</h4>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('task-lists.update', $taskList->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Task List Name</label>
                    <input type="text" class="form-control shadow-sm" id="name" name="name" value="{{ $taskList->name }}" required placeholder="Masukkan nama task list...">
                </div>

                <div class="mb-3">
                    <label for="project_type" class="form-label fw-semibold">Project Type</label>
                    <select class="form-select shadow-sm" id="project_type" name="project_type" required>
                        <option value="" disabled>Select a project type</option>
                        <option value="School" {{ $taskList->project_type == 'School' ? 'selected' : '' }}>School</option>
                        <option value="Work" {{ $taskList->project_type == 'Work' ? 'selected' : '' }}>Work</option>
                        <option value="Private" {{ $taskList->project_type == 'Private' ? 'selected' : '' }}>Private</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea class="form-control shadow-sm" id="description" name="description" rows="3" placeholder="Tambahkan deskripsi tugas...">{{ old('description', $taskList->description) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label fw-semibold">Start Date</label>
                        <input type="date" class="form-control shadow-sm" id="start_date" name="start_date" value="{{ $taskList->start_date }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label fw-semibold">End Date</label>
                        <input type="date" class="form-control shadow-sm" id="end_date" name="end_date" value="{{ $taskList->end_date }}" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('task-lists.index') }}" class="btn btn-outline-secondary px-4 py-2">
                        <i class="bi bi-arrow-left"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-success px-4 py-2 shadow-sm">
                        <i class="bi bi-check-circle"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
