<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $stats = [
            'total'       => Task::where('user_id', $userId)->count(),
            'todo'        => Task::where('user_id', $userId)->where('status', 'todo')->count(),
            'in_progress' => Task::where('user_id', $userId)->where('status', 'in_progress')->count(),
            'done'        => Task::where('user_id', $userId)->where('status', 'done')->count(),
        ];

        $recentTasks = Task::where('user_id', $userId)
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recentTasks'));
    }
}