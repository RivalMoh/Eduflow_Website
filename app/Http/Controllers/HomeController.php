<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = ForumPost::with(['user' => function($query) {
                $query->select('id', 'username as name');
            }, 'replies.user' => function($query) {
                $query->select('id', 'username as name');
            }])
            ->latest()
            ->take(10)
            ->get();
            
        // Get recent tasks for the sidebar
        $recentTasks = [];
        if (Auth::check()) {
            $recentTasks = Task::where('user_id', Auth::id())
                ->with('taskBoard')
                ->orderBy('due_date', 'asc')
                ->take(5) // Get 5 most recent tasks
                ->get();
        }
            
        return view('home', [
            'posts' => $posts,
            'recentTasks' => $recentTasks
        ]);
    }
}
