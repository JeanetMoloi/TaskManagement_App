<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * UpdateTaskRequestPTJ
 *
 * Form Request for validating task update input.
 * Slightly different from store: deadline can be today or future (not just future),
 * and status is now an editable field.
 */
class UpdateTaskRequestPTJ extends FormRequest
{
    /**
     * Only authenticated non-guest users may update tasks.
     * The controller also runs a Policy check for ownership/role.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role !== 'guest';
    }

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
                'exists:categories,id',
            ],
            'assigned_to' => [
                'nullable',
                'exists:users,id',
            ],
            'priority' => [
                'required',
                'in:low,medium,high',
            ],
            'status' => [
                'required',
                'in:pending,in_progress,completed',
            ],
            'deadline' => [
                'required',
                'date',
                'after_or_equal:today', // Allow keeping today's deadline on edit
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'        => 'Please give your task a title.',
            'title.min'             => 'The task title must be at least 3 characters.',
            'status.required'       => 'Please set a status for this task.',
            'status.in'             => 'Status must be: Pending, In Progress, or Completed.',
            'priority.required'     => 'Please set a priority for this task.',
            'priority.in'           => 'Priority must be: Low, Medium, or High.',
            'deadline.required'     => 'Please set a deadline for this task.',
            'deadline.after_or_equal' => 'The deadline cannot be in the past.',
            'category_id.exists'    => 'The selected category does not exist.',
            'assigned_to.exists'    => 'The selected user does not exist.',
        ];
    }

    public function attributes(): array
    {
        return [
            'category_id' => 'category',
            'assigned_to' => 'assigned user',
        ];
    }
}
