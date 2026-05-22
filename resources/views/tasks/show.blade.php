@extends('layouts.app')

@section('title', $task->title)

@section('topbar-actions')
    <a href="{{ route('tasks.index') }}" class="btn btn-ghost">← All Tasks</a>
    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary">Edit Task</a>
@endsection

@section('content')

<div style="max-width:720px;">

    <!-- TASK HEADER -->
    <div class="card" style="margin-bottom:16px;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;">
            <div style="flex:1;">
                <h2 style="font-family:'Syne',sans-serif;font-size:24px;font-weight:700;color:var(--text);margin-bottom:8px;">
                    {{ $task->title }}
                </h2>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    <span class="badge badge-{{ $task->priority }}">{{ ucfirst($task->priority) }} Priority</span>
                    <span class="badge badge-{{ $task->status }}">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
                    @if($task->category)
                        <span class="badge" style="background:var(--surface2);color:var(--text2);">📁 {{ $task->category->name }}</span>
                    @endif
                </div>
            </div>

            <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')" style="margin-left:16px;">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </div>

        @if($task->description)
            <p style="color:var(--text2);font-size:15px;line-height:1.7;border-top:1px solid var(--border);padding-top:16px;">
                {{ $task->description }}
            </p>
        @endif
    </div>

    <!-- TASK DETAILS -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
        <div class="card">
            <div style="font-size:11px;font-weight:600;letter-spacing:1px;text-transform:uppercase;color:var(--text3);margin-bottom:12px;">Details</div>
            <div style="display:flex;flex-direction:column;gap:12px;">
                <div style="display:flex;justify-content:space-between;">
                    <span style="font-size:13px;color:var(--text3);">Deadline</span>
                    <span style="font-size:13px;color:{{ $task->deadline < now() && $task->status !== 'completed' ? 'var(--danger)' : 'var(--text)' }};">
                        {{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y') }}
                        @if($task->deadline < now() && $task->status !== 'completed')
                            ⚠ Overdue
                        @endif
                    </span>
                </div>
                <div style="display:flex;justify-content:space-between;">
                    <span style="font-size:13px;color:var(--text3);">Created by</span>
                    <span style="font-size:13px;color:var(--text);">{{ $task->creator?->name ?? '—' }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;">
                    <span style="font-size:13px;color:var(--text3);">Assigned to</span>
                    <span style="font-size:13px;color:var(--text);">{{ $task->assignedUser?->name ?? 'Unassigned' }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;">
                    <span style="font-size:13px;color:var(--text3);">Created</span>
                    <span style="font-size:13px;color:var(--text);">{{ $task->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>

        <!-- QUICK STATUS UPDATE -->
        <div class="card">
            <div style="font-size:11px;font-weight:600;letter-spacing:1px;text-transform:uppercase;color:var(--text3);margin-bottom:12px;">Update Status</div>
            <form method="POST" action="{{ route('tasks.update-status', $task) }}">
                @csrf @method('PATCH')
                <div class="form-group" style="margin-bottom:12px;">
                    <select name="status" class="form-control">
                        <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                        <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>🔄 In Progress</option>
                        <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>✅ Completed</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;">Update Status</button>
            </form>
        </div>
    </div>

</div>

@endsection
