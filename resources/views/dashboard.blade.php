@extends('layouts.app')

@section('title', 'Dashboard')

@section('topbar-actions')
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Task
    </a>
@endsection

@section('content')

<!-- STATS -->
<div class="stats-grid">
    <div class="stat-card purple">
        <div class="stat-number">{{ \App\Models\Task::count() }}</div>
        <div class="stat-label">Total Tasks</div>
    </div>
    <div class="stat-card orange">
        <div class="stat-number">{{ \App\Models\Task::where('status', 'pending')->count() }}</div>
        <div class="stat-label">Pending</div>
    </div>
    <div class="stat-card pink">
        <div class="stat-number">{{ \App\Models\Task::where('status', 'in_progress')->count() }}</div>
        <div class="stat-label">In Progress</div>
    </div>
    <div class="stat-card green">
        <div class="stat-number">{{ \App\Models\Task::where('status', 'completed')->count() }}</div>
        <div class="stat-label">Completed</div>
    </div>
</div>

<!-- RECENT TASKS -->
<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <h2 style="font-family:'Syne',sans-serif;font-size:16px;font-weight:700;color:var(--text);">Recent Tasks</h2>
        <a href="{{ route('tasks.index') }}" class="btn btn-ghost btn-sm">View All</a>
    </div>

    @php $recentTasks = \App\Models\Task::with(['category'])->latest()->take(5)->get(); @endphp

    @if($recentTasks->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">📋</div>
            <div class="empty-title">No tasks yet</div>
            <div class="empty-text">Create your first task to get started</div>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create Task</a>
        </div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Deadline</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentTasks as $task)
                <tr>
                    <td>
                        <div class="task-title">{{ $task->title }}</div>
                        @if($task->category)
                            <div style="font-size:12px;color:var(--text3);margin-top:2px;">{{ $task->category->name }}</div>
                        @endif
                    </td>
                    <td><span class="badge badge-{{ $task->priority }}">{{ ucfirst($task->priority) }}</span></td>
                    <td><span class="badge badge-{{ $task->status }}">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span></td>
                    <td style="font-size:13px;">{{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y') }}</td>
                    <td><a href="{{ route('tasks.show', $task) }}" class="btn btn-ghost btn-sm">View</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
