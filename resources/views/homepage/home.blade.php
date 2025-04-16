@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <div class="container">
        <h3 class="fw-bold mt-4 mb-3"><i class="bi bi-lightbulb"></i> Ayo buat to-do list mu!</h3>
        <!-- SECTION: RECENT TASK LISTS -->
        <h5 class="mt-4">Recent Task Lists</h5>
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
                    'sekolah' => ['#1E90FF', '#104E8B', '🎓'], // Biru (Sekolah)
                    'pribadi' => ['#32CD32', '#228B22', '🌱'], // Hijau (Pribadi)
                    'pekerjaan' => ['#00CED1', '#008B8B', '💼'], // Cyan (Pekerjaan)
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
                                    <li><a class="dropdown-item" href="{{ route('task-lists.tasks.index', $taskList->id) }}"><i class="bi bi-eye"></i> Lihat Task</a></li>
                                    <li><a class="dropdown-item" href="{{ route('task-lists.edit', $taskList->id) }}"><i class="bi bi-pencil"></i> Edit Task List</a></li>
                                    <li>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#taskListModal{{ $taskList->id }}">
                                            <i class="bi bi-info-circle"></i> Lihat Task List
                                        </button>
                                    </li>
                                    <li>
                                        <form action="{{ route('task-lists.destroy', $taskList->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus task list ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash"></i> Hapus Task List</button>
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
                                <h5 class="modal-title" id="taskListModalLabel{{ $taskList->id }}">Detail Task List</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Nama Task List:</strong> {{ $taskList->name }}</p>
                                <p><strong>Jenis Proyek:</strong> {{ $taskList->project_type ?? '-' }}</p>
                                <p><strong>Deskripsi:</strong> {{ $taskList->description ?? 'Tidak ada deskripsi' }}</p>
                                <p><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($taskList->start_date)->format('d/m/Y') }}</p>
                                <p><strong>Tanggal Selesai:</strong> {{ \Carbon\Carbon::parse($taskList->end_date)->format('d/m/Y') }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach

            <!-- Jika Tidak Ada Task List -->
            @if ($taskLists->isEmpty())
                <div class="w-100 text-center">
                    <p class="text-muted">Belum ada Task List yang Dibuat</p>
                </div>
            @endif
        </div>        
    </div>
@endsection
