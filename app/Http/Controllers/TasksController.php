<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Note;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TasksController extends Controller
{
    use AuthorizesRequests;
    
    /**
     * Display the tasks dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Initialize tasks with all possible statuses as collections
        $tasks = collect([
            'todo' => collect(),
            'in_progress' => collect(),
            'in_review' => collect(),
            'done' => collect(),
        ]);
        
        // Get and group tasks by status
        $userTasks = Task::where('user_id', Auth::id())
            ->with('taskBoard') // Eager load the taskBoard relationship
            ->orderBy('status')
            ->orderBy('due_date')
            ->get()
            ->groupBy('status');
            
        // Merge the actual tasks with the initialized collections
        $tasks = $tasks->merge($userTasks);
        
        $notes = Note::where('user_id', Auth::id())
            ->latest()
            ->get();
            
        return view('tasks.index', [
            'tasks' => $tasks,
            'notes' => $notes
        ]);
    }
    
    /**
     * Store a newly created task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated',
                'redirect' => route('login')
            ], 401);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,in_review,done',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'user_id' => 'sometimes|exists:users,id'
        ]);
        
        try {
            // Create task with the authenticated user's ID
            $task = new Task([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'status' => $validated['status'],
                'priority' => $validated['priority'],
                'due_date' => $validated['due_date'] ?? null,
                'user_id' => Auth::id(), // Always use the authenticated user's ID
                'position' => 0 // Default position
            ]);
            
            // Save the task
            $task->save();
            
            return response()->json([
                'success' => true,
                'task' => $task->load('taskBoard'),
                'message' => 'Task created successfully!'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Task creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create task. Please try again.'
            ], 500);
        }
    }
    
    /**
     * Update the specified task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,in_review,done',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'task_board_id' => 'nullable|exists:task_boards,id',
        ]);
        
        // Convert empty string to null for task_board_id
        if (isset($validated['task_board_id']) && $validated['task_board_id'] === '') {
            $validated['task_board_id'] = null;
        }
        
        $task->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully!',
            'task' => $task->load('taskBoard') // Load the task board relationship in the response
        ]);
    }
    
    /**
     * Remove the specified task from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        
        $task->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully!'
        ]);
    }
    
    /**
     * Update the status of the specified task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        
        $validated = $request->validate([
            'status' => 'required|in:todo,in_progress,in_review,done',
            'position' => 'nullable|integer'
        ]);
        
        $task->update(['status' => $validated['status']]);
        
        // Update position if provided (for drag and drop sorting)
        if (isset($validated['position'])) {
            // You may want to implement position logic here
            // This is a simplified example
            $task->update(['position' => $validated['position']]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Task status updated successfully!',
            'task' => $task
        ]);
    }
    
    /**
     * Toggle task status between todo and done
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus(Task $task)
    {
        $this->authorize('update', $task);
        
        $task->status = $task->status === 'done' ? 'todo' : 'done';
        $task->save();
        
        return response()->json([
            'success' => true,
            'status' => $task->status
        ]);
    }
    
    /**
     * Store a newly created note in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeNote(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tag' => 'nullable|string|max:50',
        ]);
        
        $note = Auth::user()->notes()->create($validated);
        
        return response()->json([
            'success' => true,
            'note' => $note,
            'message' => 'Note created successfully!'
        ]);
    }
    
    /**
     * Update the specified note in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateNote(Request $request, Note $note)
    {
        $this->authorize('update', $note);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tag' => 'nullable|string|max:50',
        ]);
        
        $note->update($validated);
        
        return response()->json([
            'success' => true,
            'note' => $note,
            'message' => 'Note updated successfully!'
        ]);
    }
    
    /**
     * Remove the specified note from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyNote(Note $note)
    {
        $this->authorize('delete', $note);
        
        $note->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Note deleted successfully!'
        ]);
    }
}
