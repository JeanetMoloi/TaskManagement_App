@extends('layouts.app')

@section('title', 'Edit Task')

@section('topbar-actions')
    <a href="{{ route('tasks.show', $task) }}" class="btn btn-ghost">← Back</a>
@endsection

@section('content')

<div style="max-width:680px;">
    <div class="card">
        <form method="POST" action="{{ route('tasks.update', $task) }}">
            @csrf @method('PUT')

            <div class="form-group">
                <label class="form-label">Task Title *</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $task->title) }}" required>
                @error('title')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $task->description) }}</textarea>
                @error('description')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div class="form-group">
                    <label class="form-label">Priority *</label>
                    <select name="priority" class="form-control" required>
                        <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>🟢 Low</option>
                        <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                        <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>🔴 High</option>
                    </select>
                    @error('priority')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-control" required>
                        <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div class="form-group">
                    <label class="form-label">Deadline *</label>
                    <input type="date" name="deadline" class="form-control" value="{{ old('deadline', \Carbon\Carbon::parse($task->deadline)->format('Y-m-d')) }}" required>
                    @error('deadline')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-control">
                        <option value="">No category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $task->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Assign To</label>
                <select name="assigned_to" class="form-control">
                    <option value="">Unassigned</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_to', $task->assigned_to) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display:flex;gap:10px;margin-top:8px;">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('tasks.show', $task) }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
