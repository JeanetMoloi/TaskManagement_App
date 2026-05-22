<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

/**
 * DashboardControllerPTJ
 *
 * Serves the correct dashboard view based on the authenticated user's role.
 * Roles: admin, team_member, guest
 */
class DashboardControllerPTJ extends Controller
{
    

    /**
     * Route: GET /dashboard
     * Redirects to the role-specific dashboard method.
     */
    public function index()
    {
        $user = Auth::user();

        return match ($user->role) {
            'admin'       => $this->adminDashboard(),
            'team_member' => $this->teamMemberDashboard(),
            default       => $this->guestDashboard(),
        };
    }

    /**
     * Admin sees app-wide stats: all tasks, users, overdue items.
     */
    private function adminDashboard()
    {
        $stats = [
            'total_tasks'     => Task::count(),
            'pending'         => Task::where('status', 'pending')->count(),
            'in_progress'     => Task::where('status', 'in_progress')->count(),
            'completed'       => Task::where('status', 'completed')->count(),
            'overdue'         => Task::where('deadline', '<', now())
                                     ->where('status', '!=', 'completed')->count(),
            'total_users'     => User::count(),
            'total_categories'=> Category::count(),
        ];

        $recentTasks = Task::with(['assignedUser', 'category'])
            ->latest()->take(5)->get();

        $overdueTasks = Task::with(['assignedUser'])
            ->where('deadline', '<', now())
            ->where('status', '!=', 'completed')
            ->orderBy('deadline')
            ->take(5)->get();

        return view('dashboard.admin', compact('stats', 'recentTasks', 'overdueTasks'));
    }

    /**
     * Team Member sees only their own assigned/created tasks.
     */
    private function teamMemberDashboard()
    {
        $user = Auth::user();

        $myTasks = Task::with(['category'])
            ->where('assigned_to', $user->id)
            ->orderBy('deadline')
            ->get();

        $stats = [
            'pending'     => $myTasks->where('status', 'pending')->count(),
            'in_progress' => $myTasks->where('status', 'in_progress')->count(),
            'completed'   => $myTasks->where('status', 'completed')->count(),
            'overdue'     => $myTasks->where('deadline', '<', now())
                                     ->where('status', '!=', 'completed')->count(),
        ];

        return view('dashboard.team_member', compact('myTasks', 'stats'));
    }

    /**
     * Guest only sees tasks they created (read-only view, no edit).
     */
    private function guestDashboard()
    {
        $tasks = Task::with(['assignedUser', 'category'])
            ->where('created_by', Auth::id())
            ->orderBy('deadline')
            ->get();

        return view('dashboard.guest', compact('tasks'));
    }
}
