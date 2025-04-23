@extends('layouts.app')

@section('content')
<div class="container">
    <header>
        <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
        <div class="date-display">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</div>
    </header>
    <div class="card shadow-sm position-relative" style="border-radius: 15px; overflow: hidden;">
        <div class="card-body d-flex flex-column align-items-center justify-content-center text-white position-relative"
            style="background: url('{{ asset('assets/image/background-to-do.jpg') }}') center/cover; height: 300px; width: 100%; border-radius: 15px;">
            
            <div class="position-absolute top-0 start-0 w-100 h-100" 
                style="background: rgba(0, 0, 0, 0.5); padding-right: 20px; border-radius: 15px;">
            </div>            
    
            <h3 class="fw-bold fs-2 position-relative">Welcome to VIRTULIST</h3>
            <p class="fs-2 position-relative">{{ Auth::user()->username }}!</p>
        </div>
    </div>        

    <!-- Statistik Ringkas -->
    <section class="mt-4">
        <h2>Concise Statistics</h2>
        <div class="card-container">
            <div class="card">
                <div class="card-title">Task List Total</div>
                <div class="card-value">{{ $totalTaskList }}</div>
                <div class="card-info">
                </div>
            </div>

            <div class="card">
                <div class="card-title">Task List Completed</div>
                <div class="card-value">{{ $completedTaskList }}</div>
                <div class="card-info up">
                </div>
            </div>

            <div class="card">
                <div class="card-title">Total Task</div>
                <div class="card-value">{{ $totalTask }}</div>
                <div class="card-info">
                </div>
            </div>

            <div class="card">
                <div class="card-title">Task Completed</div>
                <div class="card-value">{{ $completedTask }}</div>
                <div class="card-info up">
                </div>
            </div>

            <div class="card">
                <div class="card-title">Task in Progress</div>
                <div class="card-value">{{ $ongoingTask }}</div>
                <div class="card-info down">
                </div>
            </div>
        </div>
    </section>

    <!-- Statistik Berdasarkan Status -->
    <section class="chart-container">
        <div class="chart-box">
            <h3 class="chart-title">Statistics Based on Status</h3>
            <div class="chart">
                @foreach($statusCounts as $label => $count)
                <div class="bar" style="height: {{ min(100, $count) }}%; background-color: {{ $loop->index === 3 ? '#2ecc71' : '#4361ee' }};">
                    <span class="bar-value">{{ $count }}</span>
                    <span class="bar-label">{{ ucfirst($label) }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="chart-box">
            <h3 class="chart-title">Task Distribution</h3>
            <div class="chart">
                @foreach($distributionCounts as $label => $count)
                <div class="bar" style="height: {{ min(100, $count) }}%; background-color: #{{ dechex(rand(100000, 999999)) }}">
                    <span class="bar-value">{{ $count }}</span>
                    <span class="bar-label">{{ ucfirst($label) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
@endsection