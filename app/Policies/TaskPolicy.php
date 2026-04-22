<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        // Only the person who created the task can see it
        return $user->id === $task->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        // Only the person who created the task can edit it
        return $user->id === $task->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        // Only the person who created the task can delete it
        return $user->id === $task->user_id;
    }
    
    // You can leave the other functions like 'create' as true or just leave them alone
    public function create(User $user): bool
    {
        return true; 
    }
}
