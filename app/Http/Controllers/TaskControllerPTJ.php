<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequestPTJ;
use App\Http\Requests\UpdateTaskRequestPTJ;
use App\Models\Task;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * TaskControllerPTJ
 *
 * Handles all task-related HTTP logic for the Task Management App.
 * Covers: listing, creating, editing, updating, deleting, and status changes.
 *
 * Naming convention: suffixed with group member initials (PTJ ).
 */
class TaskControllerPTJ extends Controller
{
    /**
     * Apply auth middleware to all routes in this controller.
     * Guest users cannot access any task functionality.
     */
    public function __construct()
    {
        $this->middleware('auth');
        
        $this->middleware('role:admin,team_member')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of tasks.
     * Admins see all tasks; team
     *
     * Route: GET /tasks
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Base query — admins see all, team members see assigned or own tasks
        $query = Task::with(['assignedUser', 'category', 'creator'])
            ->when($user->role !== 'admin', function ($q) use ($user) {
                $q->where('assigned_to', $user->id)
                  ->orWhere('created_by', $user->id);
            });

        // Filter by status (optional query param: ?status=pending)
        $query->when($request->filled('status'), fn($q) =>
            $q->where('status', $request->status)
        );

        // Filter by priority (optional query param: ?priority=high)
        $query->when($request->filled('priority'), fn($q) =>
            $q->where('priority', $request->priority)
        );

        // Filter by category (optional query param: ?category_id=2)
        $query->when($request->filled('category_id'), fn($q) =>
            $q->where('category_id', $request->category_id)
        );

        // Sort by deadline ascending by default
        $tasks = $query->orderBy('deadline')->paginate(10)->withQueryString();

        $categories = Category::all();

        return view('tasks.index', compact('tasks', 'categories'));
    }

    /**
     * Show the form for creating a new task.
     *
     * Route: GET /tasks/create
     */
    public function create()
    {
        // Pass all users (for assignment) and categories to the view
        $users      = User::where('role', '!=', 'guest')->get();
        $categories = Category::all();

        return view('tasks.create', compact('users', 'categories'));
    }

    /**
     * Store a newly created task in the database.
     * Validation is handled by StoreTaskRequestPTJ (Form Request class).
     *
     * Route: POST /tasks
     */
    public function store(StoreTaskRequestPTJ $request)
    {
        // Validated data from the Form Request (safe to use directly)
        $validated = $request->validated();

        // Attach the logged-in user as the creator
        $validated['created_by'] = Auth::id();
        $validated['status']     = 'pending'; // New tasks always start as pending

        $task = Task::create($validated);

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'Task created successfully!');
    }

    /**
     * Display a single task.
     *
     * Route: GET /tasks/{task}
     */
    public function show(Task $task)
    {
        // Eager-load relationships needed on the detail page
        $task->load(['assignedUser', 'category', 'creator']);

        $this->authorize('view', $task); // Policy check

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing an existing task.
     *
     * Route: GET /tasks/{task}/edit
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task); // Policy check

        $users      = User::where('role', '!=', 'guest')->get();
        $categories = Category::all();

        return view('tasks.edit', compact('task', 'users', 'categories'));
    }

    /**
     * Update an existing task in the database.
     * Validation handled by UpdateTaskRequestPTJ.
     *
     * Route: PUT /tasks/{task}
     */
    public function update(UpdateTaskRequestPTJ $request, Task $task)
    {
        $this->authorize('update', $task); // Policy check

        $task->update($request->validated());

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'Task updated successfully!');
    }

    /**
     * Remove a task from the database.
     *
     * Route: DELETE /tasks/{task}
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task); // Policy check

        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task deleted successfully!');
    }

    /**
     * Update only the status of a task.
     * Useful for quick status toggles (e.g., Kanban-style drag-drop or buttons).
     *
     * Route: PATCH /tasks/{task}/status
     */
    public function updateStatus(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'status' => ['required', 'in:pending,in_progress,completed'],
        ]);

        $task->update(['status' => $request->status]);

        return back()->with('success', 'Task status updated!');
    }
}
