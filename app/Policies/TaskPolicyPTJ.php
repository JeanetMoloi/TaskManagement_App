<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

/**
 * TaskPolicyPTJ
 *
 * Defines authorization rules for task actions.
 * Used in the controller via $this->authorize('action', $task).
 *
 * Register in AuthServiceProvider (or auto-discovered in Laravel 12).
 */
class TaskPolicyPTJ
{
    /**
     * 
     * This method is called first before any other policy method.
     */
    public function before(User $user): ?bool
    {
        if ($user->role === 'admin') {
            return true; // Admin always allowed
        }
        return null; // null means "continue to the specific policy method"
    }

    /**
     * Can the user see the task list?
     * All authenticated users can view the index (controller filters by role).
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Can the user view a specific task?
     * Team members can see tasks assigned to them or created by them.
     * Guests can only see tasks they created.
     */
    public function view(User $user, Task $task): bool
    {
        return $user->id === $task->assigned_to
            || $user->id === $task->created_by;
    }

    /**
     * Can the user create tasks?
     * Guests cannot create tasks.
     */
    public function create(User $user): bool
    {
        return $user->role !== 'guest';
    }

    /**
     * Can the user edit/update a task?
     * Team members can edit tasks assigned to them or that they created.
     */
    public function update(User $user, Task $task): bool
    {
        return $user->role === 'team_member'
            && ($user->id === $task->assigned_to || $user->id === $task->created_by);
    }

    /**
     * Can the user delete a task?
     * Only admins (handled by before()) and the original creator can delete.
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->created_by;
    }
}
