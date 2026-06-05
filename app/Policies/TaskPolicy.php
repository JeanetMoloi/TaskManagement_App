<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Determine if the user can view the task.
     */
    public function view(User $user, Task $task): bool
    {
        // Admin can view any task
        if ($user->role === 'admin') {
            return true;
        }

        // Task creator or assigned user can view
        return $user->id === $task->created_by || $user->id === $task->assigned_to;
    }

    /**
     * Determine if the user can update the task.
     */
    public function update(User $user, Task $task): bool
    {
        // Admin can update any task
        if ($user->role === 'admin') {
            return true;
        }

        // Only creator or assigned user can update
        return $user->id === $task->created_by || $user->id === $task->assigned_to;
    }

    /**
     * Determine if the user can delete the task.
     */
    public function delete(User $user, Task $task): bool
    {
        // Only admin or task creator can delete
        return $user->role === 'admin' || $user->id === $task->created_by;
    }
}