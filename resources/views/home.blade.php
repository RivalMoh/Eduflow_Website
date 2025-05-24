@extends('layouts.main')

@section('title', 'Home - EduFlow')

@push('styles')
<style>
    .room-card {
        @apply bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-100;
    }
    
    .post-card {
        @apply bg-white rounded-lg p-5 shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-100;
    }
    
    .action-btn {
        @apply flex items-center justify-center p-2 rounded-lg hover:bg-gray-100 text-gray-600 hover:text-indigo-600 transition-colors duration-200;
    }
    
    .pomodoro-timer {
        @apply bg-gradient-to-br from-indigo-600 to-indigo-500 text-white rounded-xl p-5 shadow-lg;
    }
    
    .todo-item {
        @apply flex items-center justify-between py-2 border-b border-gray-100 last:border-0;
    }
</style>
@endpush

@section('content')
<!-- Horizontal Room Recommendations -->
<div class="mb-6">
    <div class="flex items-center justify-between mb-3 px-1">
        <h3 class="text-xs font-semibold text-gray-700 uppercase tracking-wider flex items-center">
            <i class="fas fa-users mr-2 text-indigo-600"></i>
            Recommended Rooms
        </h3>
        <button class="text-xs text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 px-2 py-1 rounded transition-colors">
            See all
        </button>
    </div>
    <div class="relative">
        <div class="flex space-x-3 overflow-x-auto pb-3 -mx-1 px-1" style="scrollbar-width: thin;">
            <button class="flex-shrink-0 w-32 bg-white rounded-lg p-3 shadow-xs border border-gray-100 hover:shadow-sm transition-shadow">
                <div class="flex items-center space-x-2">
                <div class="w-6 h-6 rounded bg-gray-200 flex-shrink-0 overflow-hidden">
                        <img 
                            src="{{ asset('images/icons/number_theory.png') }}" 
                            alt="Room" 
                            class="w-full h-full object-cover"
                            style="width: 24px; height: 24px; object-fit: contain;"
                        >
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-xs font-medium text-gray-900 truncate">Create Room</h4>
                    </div>
                </div>
            </button>
            @for($i = 1; $i <= 7; $i++)
            <button class="flex-shrink-0 w-32 bg-white rounded-lg p-3 shadow-xs border border-gray-100 hover:shadow-sm transition-shadow">
                <div class="flex items-center space-x-2">
                    <div class="w-6 h-6 rounded bg-gray-200 flex-shrink-0 overflow-hidden">
                        <img 
                            src="{{ asset('images/icons/game.png') }}" 
                            alt="Room" 
                            class="w-full h-full object-cover"
                            style="width: 24px; height: 24px; object-fit: contain;"
                        >
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-xs font-medium text-gray-900 truncate">Room {{ $i }}</h4>
                    </div>
                </div>
            </button>
            @endfor
        </div>
    </div>
</div>

<div class="flex flex-col lg:flex-row gap-6">
    <!-- Main Content - Discussion Feed -->
    <div class="flex-1 min-w-0">
        <!-- Create Post -->
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 mb-6">
            <form action="{{ route('forums.posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-medium flex-shrink-0">
                        @auth
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        @else
                            <i class="fas fa-user"></i>
                        @endauth
                    </div>
                    <div class="flex-1">
                        <input type="text" 
                               name="title" 
                               placeholder="Title" 
                               class="w-full text-sm p-2 mb-2 bg-gray-50 rounded-lg border border-gray-200 focus:ring-1 focus:ring-indigo-500 focus:border-transparent"
                               required>
                        <div class="flex items-center justify-between border border-gray-200 rounded-lg bg-gray-50">
                            <input type="text" 
                                   name="content" 
                                   placeholder="What's on your mind?" 
                                   class="flex-1 text-sm p-3 bg-transparent focus:outline-none"
                                   required>
                            <div class="flex items-center pr-2">
                                <label class="text-gray-400 hover:text-indigo-600 p-2 cursor-pointer">
                                    <i class="fas fa-paperclip"></i>
                                    <input type="file" 
                                           name="media" 
                                           class="hidden" 
                                           id="media-upload"
                                           accept="image/*,.pdf,.doc,.docx,.xls,.xlsx">
                                </label>
                                <button type="submit" class="bg-indigo-600 text-white text-sm font-medium px-4 py-1.5 rounded-lg hover:bg-indigo-700 transition-colors">
                                    Post
                                </button>
                            </div>
                        </div>
                        <!-- Selected file preview -->
                        <div id="file-preview" class="mt-2 hidden">
                            <div class="flex items-center justify-between bg-blue-50 p-2 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-paperclip text-blue-500 mr-2"></i>
                                    <span id="file-name" class="text-sm text-gray-700"></span>
                                </div>
                                <button type="button" id="remove-file" class="text-gray-400 hover:text-red-500">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Discussion Feed -->
        <div class="space-y-6 py-6">
            @forelse($posts as $post)
            <div class="post-card bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md" x-data="{ showComments: false }">
                <div class="p-5">
                    <!-- Post Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-medium">
                                @if($post->user)
                                    {{ strtoupper(substr($post->user->name ?? $post->user->username ?? 'U', 0, 1)) }}
                                @else
                                    U
                                @endif
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">
                                    @if($post->user)
                                        {{ $post->user->name ?? $post->user->username ?? 'Unknown User' }}
                                    @else
                                        Unknown User
                                    @endif
                                </h4>
                                <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <!-- more button -->
                        <button class="text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-gray-100">
                            <i class="fas fa-ellipsis-h text-sm"></i>
                        </button>
                    </div>
                    
                    <!-- Post Title -->
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $post->title }}</h3>
                    
                    <!-- Post Content -->
                    <p class="text-gray-700 mb-4 text-sm leading-relaxed">
                        {{ $post->content }}
                    </p>
                </div>
                
                @if($post->media_path)
                <!-- Post Media/Attachment -->
                <div class="bg-gray-50 border-t border-b border-gray-100">
                    @if(str_starts_with($post->media_type, 'image'))
                        <!-- Display Image -->
                        <div class="w-full flex justify-center">
                            <img src="{{ asset('storage/' . $post->media_path) }}" 
                                 alt="Post media" 
                                 class="max-h-96 w-auto object-contain">
                        </div>
                    @else
                        <!-- Display Document/Other File -->
                        <div class="p-4">
                            <a href="{{ asset('storage/' . $post->media_path) }}" 
                               target="_blank" 
                               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fas fa-file-download mr-2"></i>
                                {{ $post->media_name ?? 'Download Attachment' }}
                            </a>
                        </div>
                    @endif
                </div>
                @endif
                
                <div class="p-4">
                    <!-- Post Actions -->
                    <div class="flex items-center text-gray-500 py-2">
                        <!-- like and dislike button -->
                        <div class="flex items-center justify-center">
                            <div class="flex items-center space-x-2 border border-gray-200 rounded-full py-0.5 px-2">
                                <button class="flex items-center justify-center text-gray-500 hover:text-indigo-600 transition-colors duration-200 py-1.5 px-2">
                                    <i class="far fa-thumbs-up text-base"></i>
                                    <span class="text-sm px-2">0</span>
                                </button>
                                <div class="h-5 border-r border-gray-300 mx-1"></div>
                                <button class="group flex items-center justify-center py-1.5 px-2" onmouseover="this.querySelector('i').style.color='#DC2626'" onmouseout="this.querySelector('i').style.color='#6B7280'">
                                    <i class="far fa-thumbs-down fa-flip-horizontal text-base" style="color: #6B7280; transition: color 200ms;"></i>
                                </button>
                            </div>
                        </div>
                        <!-- comment button --> 
                        <button @click="showComments = !showComments" class="flex-0 flex items-center justify-center hover:text-indigo-600 transition-colors duration-200 px-2">
                            <i class="far fa-comment text-lg"></i>
                            <span class="ml-1 text-sm">{{ $post->replies->count() }}</span>
                        </button>
                        <!-- share button -->
                        <button class="flex-0 flex items-center justify-center hover:text-indigo-600 transition-colors duration-200 px-2">
                            <i class="fas fa-share text-lg"></i>
                        </button>
                    </div>
                    
                    <!-- Comments -->
                    <div x-show="showComments" x-transition class="space-y-3 mt-4 pt-4 border-t border-gray-100">
                        @forelse($post->replies as $reply)
                        <div class="flex items-start space-x-2">
                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 text-xs font-medium flex-shrink-0">
                                {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                            </div>
                            <div class="bg-gray-50 rounded-lg p-2 text-sm flex-1">
                                <div class="font-medium text-gray-900">{{ $reply->user->name }}</div>
                                <p class="text-gray-700">{{ $reply->content }}</p>
                                <div class="text-xs text-gray-400 mt-1">{{ $reply->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500 text-center py-2">No comments yet</p>
                        @endforelse
                        
                        <!-- Add Comment -->
                        <div class="flex items-center space-x-2 mt-3">
                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 text-xs font-medium flex-shrink-0">
                                @auth
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                @else
                                    <i class="fas fa-user text-xs"></i>
                                @endauth
                            </div>
                            <form action="{{ route('forum.reply', $post->postid) }}" method="POST" class="flex-1 relative">
                                @csrf
                                <input 
                                    type="text" 
                                    name="content"
                                    placeholder="Write a comment..." 
                                    class="w-full text-sm p-2 pr-8 bg-gray-50 rounded-full border border-gray-200 focus:ring-1 focus:ring-indigo-500 focus:border-transparent"
                                    @guest disabled @endguest
                                    @guest onclick="window.location.href='{{ route('login') }}'" @endguest
                                    required
                                >
                                <div class="absolute right-2 top-1/2 transform -translate-y-1/2 flex space-x-1">
                                    <button type="button" class="text-gray-400 hover:text-indigo-600">
                                        <i class="far fa-smile"></i>
                                    </button>
                                    <button type="button" class="text-gray-400 hover:text-indigo-600">
                                        <i class="fas fa-paperclip"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-10">
                <p class="text-gray-500">No forum posts found. Be the first to create one!</p>
            </div>
            @endforelse
        </div>
    </div>
    
    <!-- Right Sidebar -->
    <div class="lg:w-80 flex-shrink-0">
        <div class="sticky top-4 space-y-6">
            <!-- Quick Actions
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <h3 class="font-semibold text-gray-800 mb-3">Quick Actions</h3>
                <div class="space-y-2">
                    <button class="w-full flex items-center justify-between p-3 bg-indigo-50 text-indigo-600 rounded-lg font-medium">
                        <span>New Post</span>
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="w-full flex items-center justify-between p-3 bg-white border border-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors duration-200">
                        <span>Create Room</span>
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div> -->
            
            <!-- Pomodoro Timer
            <div class="pomodoro-timer">
                <h3 class="font-semibold mb-4 flex items-center">
                    <i class="fas fa-clock mr-2"></i>
                    Pomodoro Timer
                </h3>
                <div class="text-center mb-4">
                    <div class="text-4xl font-bold mb-2">25:00</div>
                    <div class="text-indigo-100 text-sm">Focus Time</div>
                </div>
                <div class="flex justify-center space-x-3">
                    <button class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center hover:bg-opacity-30 transition-all duration-200">
                        <i class="fas fa-play"></i>
                    </button>
                    <button class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center hover:bg-opacity-30 transition-all duration-200">
                        <i class="fas fa-pause"></i>
                    </button>
                    <button class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center hover:bg-opacity-30 transition-all duration-200">
                        <i class="fas fa-redo"></i>
                    </button>
                </div>
                <div class="mt-4 pt-3 border-t border-indigo-400 border-opacity-30">
                    <div class="flex items-center justify-between text-sm mb-2">
                        <span>Focus</span>
                        <span>25:00</span>
                    </div>
                    <div class="flex items-center justify-between text-sm text-indigo-100">
                        <span>Short Break</span>
                        <span>05:00</span>
                    </div>
                </div>
            </div> -->
            
            <!-- To-Do List -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold text-gray-800">To-Do List</h3>
                    <a href="{{ route('tasks.index') }}" class="text-indigo-600 hover:text-indigo-800">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
                <div class="space-y-2">
                    @forelse($recentTasks as $task)
                    <div class="todo-item flex items-center justify-between group">
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   class="rounded text-indigo-600 focus:ring-indigo-500 mr-2 task-checkbox" 
                                   data-task-id="{{ $task->id }}"
                                   {{ $task->status === 'done' ? 'checked' : '' }}>
                            <span class="text-sm {{ $task->status === 'done' ? 'line-through text-gray-400' : 'text-gray-700' }}">
                                {{ $task->title }}
                                @if($task->due_date)
                                    <span class="text-xs text-gray-500 ml-1">
                                        ({{ \Carbon\Carbon::parse($task->due_date)->diffForHumans() }})
                                    </span>
                                @endif
                            </span>
                        </div>
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('tasks.index') }}" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-ellipsis-h text-xs"></i>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-2">
                        <p class="text-sm text-gray-500">No tasks found</p>
                        <a href="{{ route('tasks.index') }}" class="text-indigo-600 text-sm hover:underline">
                            Create your first task
                        </a>
                    </div>
                    @endforelse
                </div>
                @if(count($recentTasks) > 0)
                <a href="{{ route('tasks.index') }}" class="block w-full mt-3 text-sm text-center text-indigo-600 hover:bg-indigo-50 py-1.5 rounded-md transition-colors duration-200">
                    View all tasks
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('post', () => ({
            showComments: false
        }))
    })
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mediaInput = document.getElementById('media-upload');
        const filePreview = document.getElementById('file-preview');
        const fileName = document.getElementById('file-name');
        const removeFileBtn = document.getElementById('remove-file');

        if (mediaInput) {
            mediaInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    fileName.textContent = this.files[0].name;
                    filePreview.classList.remove('hidden');
                }
            });
        }

        if (removeFileBtn) {
            removeFileBtn.addEventListener('click', function() {
                mediaInput.value = '';
                filePreview.classList.add('hidden');
            });
        }
    });
</script>
@endpush
