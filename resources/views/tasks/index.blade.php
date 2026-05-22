@extends('layouts.app')

@section('title', 'All Tasks')

@section('topbar-actions')
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Task
    </a>
@endsection

@section('content')

<!-- FILTERS -->
<div class="card" style="margin-bottom:20px;">
    <form method="GET" action="{{ route('tasks.index') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
        <div style="flex:1;min-width:160px;">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
        <div style="flex:1;min-width:160px;">
            <label class="form-label">Priority</label>
            <select name="priority" class="form-control">
                <option value="">All Priorities</option>
                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
            </select>
        </div>
        <div style="display:flex;gap:8px;">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-ghost">Clear</a>
        </div>
    </form>
</div>

<!-- TASKS TABLE -->
<div class="card">
    @if($tasks->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">✅</div>
            <div class="empty-title">No tasks found</div>
            <div class="empty-text">Try changing your filters or create a new task</div>
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
                    <th>Assigned To</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr>
                    <td>
                        <div class="task-title">{{ $task->title }}</div>
                        @if($task->category)
                            <div style="font-size:12px;color:var(--text3);margin-top:2px;">
                                📁 {{ $task->category->name }}
                            </div>
                        @endif
                    </td>
                    <td><span class="badge badge-{{ $task->priority }}">{{ ucfirst($task->priority) }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('tasks.update-status', $task) }}">
                            @csrf @method('PATCH')
                            <select name="status" class="form-control" style="padding:5px 10px;font-size:12px;width:auto;" onchange="this.form.submit()">
                                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </form>
                    </td>
                    <td style="font-size:13px;">
                        @if($task->deadline < now() && $task->status !== 'completed')
                            <span style="color:var(--danger);">⚠ {{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y') }}</span>
                        @else
                            {{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y') }}
                        @endif
                    </td>
                    <td style="font-size:13px;">
                        {{ $task->assignedUser?->name ?? '—' }}
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-ghost btn-sm">View</a>
                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-ghost btn-sm">Edit</a>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- PAGINATION -->
        @if($tasks->hasPages())
        <div style="padding:16px 0 0;display:flex;justify-content:center;">
            {{ $tasks->links() }}
        </div>
        @endif
    @endif
</div>

@endsection
