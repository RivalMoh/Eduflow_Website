<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Authentication Routes
Auth::routes();

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Home Route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Task Routes
Route::prefix('tasks')->name('tasks.')->middleware(['web', 'auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\TasksController::class, 'index'])->name('index');
    Route::post('/', [App\Http\Controllers\TasksController::class, 'store'])->name('store');
    Route::put('/{task}', [App\Http\Controllers\TasksController::class, 'update'])->name('update');
    Route::delete('/{task}', [App\Http\Controllers\TasksController::class, 'destroy'])->name('destroy');
    Route::get('/task-boards', function() {
        return \App\Models\TaskBoard::where('user_id', auth()->id())
            ->select('id', 'name')
            ->get();
    })->middleware('auth');
    
    // Task status update
    Route::post('/{task}/status', [App\Http\Controllers\TasksController::class, 'updateStatus'])->name('status.update');
    
    // Notes routes
    Route::post('/notes', [App\Http\Controllers\TasksController::class, 'storeNote'])->name('notes.store');
    Route::put('/notes/{note}', [App\Http\Controllers\TasksController::class, 'updateNote'])->name('notes.update');
    Route::delete('/notes/{note}', [App\Http\Controllers\TasksController::class, 'destroyNote'])->name('notes.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Toggle task status
    Route::post('/tasks/{task}/toggle', [\App\Http\Controllers\TasksController::class, 'toggleStatus'])
        ->name('tasks.toggle');
});

// Forum Routes
Route::prefix('forums')->name('forums.')->group(function () {
    // Public forum routes
    Route::get('/', function () {
        return view('forums.index', ['activeTab' => 'all']);
    })->name('index');
    
    Route::get('/media', function () {
        return view('forums.media', ['activeTab' => 'media']);
    })->name('media');
    
    // Protected forum routes (require authentication)
    Route::middleware(['auth'])->group(function () {
        // Store a new post
        Route::post('/posts', [App\Http\Controllers\ForumController::class, 'storePost'])
            ->name('posts.store');
            
        // Store a new reply
        Route::post('/posts/{post}/replies', [App\Http\Controllers\ForumController::class, 'storeReply'])
            ->name('replies.store');
            
        // Delete a post
        Route::delete('/posts/{post}', [App\Http\Controllers\ForumController::class, 'deletePost'])
            ->name('posts.delete');
    });
});

// Add a route for replying to forum posts from the home page
Route::post('/forum/{post}/reply', [App\Http\Controllers\ForumController::class, 'storeReply'])
    ->name('forum.reply')
    ->middleware('auth');
