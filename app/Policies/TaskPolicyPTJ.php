<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

/**
 * TaskPolicyPTJ
 *
 * Defines authorization rules for task actions.
 * Used in the controller via Gate::allows/denies.
 * Naming convention: suffixed with PTJ (Pertunia, Thandeka, Jeanet).
 */
class TaskPolicyPTJ
{
    /**
     * Admins bypass all checks.
     * Called first before any other policy method.
     */
    public function before(User $user): ?bool
    {
        if ($user->role === 'admin') {
            return true;
        }
        return null;
    }

    /**
     * All authenticated users can view the task list.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    
    public function view(User $user, Task $task): bool
{
    // Admin can see all (handled by before())
    // Team members can see tasks assigned to them, created by them, or any task
    if ($user->role === 'team_member' || $user->role === 'member') {
        return true;
    }

    // Guests can only see tasks they created
    return $user->id === $task->created_by;
}

    /**
     * Guests cannot create tasks.
     */
    public function create(User $user): bool
    {
        return $user->role !== 'guest';
    }

    /**
     * User can update a task if they created it or are assigned to it.
     * Supports both 'team_member' and 'member' role names.
     */
    public function update(User $user, Task $task): bool
    {
        $allowedRoles = ['team_member', 'member'];

        return in_array($user->role, $allowedRoles)
            && ($user->id === $task->assigned_to
                || $user->id === $task->created_by);
    }

    /**
     * Only the creator or admin can delete a task.
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->created_by;
    }
}