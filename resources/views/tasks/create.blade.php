@extends('layouts.app')

@section('title', 'Create Task')

@section('topbar-actions')
    <a href="{{ route('tasks.index') }}" class="btn btn-ghost">← Back to Tasks</a>
@endsection

@section('content')

<div style="max-width:680px;">
    <div class="card">
        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Task Title *</label>
                <input type="text" name="title" class="form-control" placeholder="What needs to be done?" value="{{ old('title') }}" required>
                @error('title')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Add more details about this task...">{{ old('description') }}</textarea>
                @error('description')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div class="form-group">
                    <label class="form-label">Priority *</label>
                    <select name="priority" class="form-control" required>
                        <option value="">Select priority</option>
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>🟢 Low</option>
                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>🔴 High</option>
                    </select>
                    @error('priority')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Deadline *</label>
                    <input type="date" name="deadline" class="form-control" value="{{ old('deadline') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                    @error('deadline')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-control">
                        <option value="">No category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Assign To</label>
                    <select name="assigned_to" class="form-control">
                        <option value="">Unassigned</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_to')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div style="display:flex;gap:10px;margin-top:8px;">
                <button type="submit" class="btn btn-primary">Create Task</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
