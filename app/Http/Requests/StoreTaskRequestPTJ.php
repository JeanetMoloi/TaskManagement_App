<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * StoreTaskRequestPTJ
 *
 * Form Request class for validating new task creation input.
 * Keeps validation logic out of the controller (Single Responsibility Principle).
 *
 * Laravel automatically injects this into the controller method and runs
 * validation BEFORE the controller code even executes.
 */
class StoreTaskRequestPTJ extends FormRequest
{
    /**
     * Only authenticated users who are not guests may create tasks.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role !== 'guest';
    }

    /**
     * Validation rules applied to the incoming request data.
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'category_id' => [
                'nullable',
                'exists:categories,id', // Must be a real category
            ],
            'assigned_to' => [
                'nullable',
                'exists:users,id',      // Must be a real user
            ],
            'priority' => [
                'required',
                'in:low,medium,high',   // Only these three values accepted
            ],
            'deadline' => [
                'required',
                'date',
                'after:today',          // Deadline must be in the future
            ],
        ];
    }

    /**
     * Custom human-readable error messages for each rule.
     * Overrides Laravel's default "The field must be..." messages.
     */
    public function messages(): array
    {
        return [
            'title.required'      => 'Please give your task a title.',
            'title.min'           => 'The task title must be at least 3 characters.',
            'title.max'           => 'The task title may not exceed 255 characters.',
            'description.max'     => 'The description may not exceed 2000 characters.',
            'category_id.exists'  => 'The selected category does not exist.',
            'assigned_to.exists'  => 'The selected user does not exist.',
            'priority.required'   => 'Please set a priority for this task.',
            'priority.in'         => 'Priority must be one of: Low, Medium, or High.',
            'deadline.required'   => 'Please set a deadline for this task.',
            'deadline.date'       => 'The deadline must be a valid date.',
            'deadline.after'      => 'The deadline must be a future date.',
        ];
    }

    /**
     * Custom attribute names used in error messages.
     * e.g., "category_id" becomes "category" in error messages.
     */
    public function attributes(): array
    {
        return [
            'category_id' => 'category',
            'assigned_to' => 'assigned user',
        ];
    }
}
