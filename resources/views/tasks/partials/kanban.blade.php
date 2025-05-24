<div x-data="{
    isOpen: false,
    openModal() {
        console.log('Open modal called');
        this.isOpen = true;
        document.body.style.overflow = 'hidden';
        console.log('Modal opened', this.isOpen);
    },
    closeModal() {
        this.isOpen = false;
        document.body.style.overflow = 'auto';
    },
    async submitForm(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        
        try {
            const response = await fetch('{{ route("tasks.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });
            
            if (response.ok) {
                window.location.reload();
            } else {
                throw new Error('Failed to add task');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to add task. Please try again.');
        }
    }
}"> 
    <!-- Kanban Board -->
    <div class="kanban-board-container overflow-x-auto pb-6">
        <div class="flex space-x-4 min-w-max">
            <!-- To Do Column -->
            <div class="kanban-column bg-sky-50 rounded-lg shadow p-2 flex-shrink-0 flex flex-col" style="height: fit-content; max-height: calc(100vh - 200px);">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-medium text-sky-700">To Do</h3>
                    <span class="bg-sky-200 text-sky-800 text-xs font-semibold px-3 py-1 rounded-full">
                        {{ $tasks['todo']->count() ?? 0 }}
                    </span>
                </div>
                <div class="space-y-3 flex-1 overflow-y-auto pr-1" id="todo-tasks">
                    @foreach(($tasks['todo'] ?? []) as $task)
                        <div class="task-card bg-white border-l-4 border-sky-500 rounded-r-lg p-3 shadow-sm hover:shadow-md transition-all cursor-pointer h-32 flex flex-col group" 
                            data-task-id="{{ $task->id }}"
                            data-task='@json($task)'>
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="font-medium text-gray-800 text-sm" title="{{ $task->title }}">{{ $task->title }}</h4>
                                <button class="text-gray-400 hover:text-red-500 delete-task flex-shrink-0 ml-2 opacity-0 group-hover:opacity-100 transition-opacity" title="Delete task">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </div>
                            @if($task->description)
                                <p class="text-xs text-gray-500 mb-2" title="{{ $task->description }}">{{ $task->description }}</p>
                            @endif
                            <div class="flex justify-between items-center text-xs mt-auto">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-medium 
                                    {{ $task->priority === 'high' ? 'bg-red-100 text-red-800' : 
                                    ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                                @if($task->due_date)
                                    <span class="text-gray-500 text-[10px] whitespace-nowrap">
                                        <i class="far fa-calendar-alt mr-0.5"></i>
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    <button 
                        @click="openModal()"
                        class="add-task-btn w-full text-sm text-gray-500 hover:text-indigo-600 hover:bg-gray-50 py-2 rounded-md transition-colors text-left px-2 flex items-center"
                    >
                        <i class="fas fa-plus-circle mr-2 text-indigo-500"></i>
                        <span>Add Task</span>
                    </button>
                </div>
            </div>

            <!-- In Progress Column -->
            <div class="kanban-column bg-amber-50 rounded-lg shadow p-2 flex-shrink-0 flex flex-col" style="height: fit-content; max-height: calc(100vh - 200px);">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-medium text-amber-700">In Progress</h3>
                    <span class="bg-amber-200 text-amber-800 text-xs font-semibold px-3 py-1 rounded-full">
                        {{ $tasks['in_progress']->count() ?? 0 }}
                    </span>
                </div>
                <div class="space-y-3 flex-1 overflow-y-auto pr-1" id="in-progress-tasks">
                    @foreach(($tasks['in_progress'] ?? []) as $task)
                        <div class="task-card bg-white border-l-4 border-amber-500 rounded-r-lg p-3 shadow-sm hover:shadow-md transition-all cursor-pointer h-32 flex flex-col group" 
                            data-task-id="{{ $task->id }}"
                            data-task='@json($task)'>
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="font-medium text-gray-800 text-sm" title="{{ $task->title }}">{{ $task->title }}</h4>
                                <button class="text-gray-400 hover:text-red-500 delete-task flex-shrink-0 ml-2 opacity-0 group-hover:opacity-100 transition-opacity" title="Delete task">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </div>
                            @if($task->description)
                                <p class="text-xs text-gray-500 mb-2" title="{{ $task->description }}">{{ $task->description }}</p>
                            @endif
                            <div class="flex justify-between items-center text-xs mt-auto">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-medium 
                                    {{ $task->priority === 'high' ? 'bg-red-100 text-red-800' : 
                                    ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                                @if($task->due_date)
                                    <span class="text-gray-500 text-[10px] whitespace-nowrap">
                                        <i class="far fa-calendar-alt mr-0.5"></i>
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    <button 
                        @click="openModal()"
                        class="add-task-btn w-full text-sm text-gray-500 hover:text-indigo-600 hover:bg-gray-50 py-2 rounded-md transition-colors text-left px-2 flex items-center"
                    >
                        <i class="fas fa-plus-circle mr-2 text-indigo-500"></i>
                        <span>Add Task</span>
                    </button>
                </div>
            </div>

            <!-- In Review Column -->
            <div class="kanban-column bg-fuchsia-50 rounded-lg shadow p-2 flex-shrink-0 flex flex-col" style="height: fit-content; max-height: calc(100vh - 200px);">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-medium text-fuchsia-700">In Review</h3>
                    <span class="bg-fuchsia-200 text-fuchsia-800 text-xs font-semibold px-3 py-1 rounded-full">
                        {{ $tasks['in_review']->count() ?? 0 }}
                    </span>
                </div>
                <div class="space-y-3 flex-1 overflow-y-auto pr-1" id="in-review-tasks">
                    @foreach(($tasks['in_review'] ?? []) as $task)
                        <div class="task-card bg-white border-l-4 border-fuchsia-500 rounded-r-lg p-3 shadow-sm hover:shadow-md transition-all cursor-pointer h-32 flex flex-col group" 
                            data-task-id="{{ $task->id }}"
                            data-task='@json($task)'>
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="font-medium text-gray-800 text-sm" title="{{ $task->title }}">{{ $task->title }}</h4>
                                <button class="text-gray-400 hover:text-red-500 delete-task flex-shrink-0 ml-2 opacity-0 group-hover:opacity-100 transition-opacity" title="Delete task">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </div>
                            @if($task->description)
                                <p class="text-xs text-gray-500 mb-2" title="{{ $task->description }}">{{ $task->description }}</p>
                            @endif
                            <div class="flex justify-between items-center text-xs mt-auto">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-medium 
                                    {{ $task->priority === 'high' ? 'bg-red-100 text-red-800' : 
                                    ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                                @if($task->due_date)
                                    <span class="text-gray-500 text-[10px] whitespace-nowrap">
                                        <i class="far fa-calendar-alt mr-0.5"></i>
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    <button 
                        @click="openModal()"
                        class="add-task-btn w-full text-sm text-gray-500 hover:text-indigo-600 hover:bg-gray-50 py-2 rounded-md transition-colors text-left px-2 flex items-center"
                    >
                        <i class="fas fa-plus-circle mr-2 text-indigo-500"></i>
                        <span>Add Task</span>
                    </button>
                </div>
            </div>

            <!-- Done Column -->
            <div class="kanban-column bg-emerald-50 rounded-lg shadow p-2 flex-shrink-0 flex flex-col" style="height: fit-content; max-height: calc(100vh - 200px);">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-medium text-emerald-700">Done</h3>
                    <span class="bg-emerald-200 text-emerald-800 text-xs font-semibold px-3 py-1 rounded-full">
                        {{ $tasks['done']->count() ?? 0 }}
                    </span>
                </div>
                <div class="space-y-3 flex-1 overflow-y-auto pr-1" id="done-tasks">
                    @foreach(($tasks['done'] ?? []) as $task)
                        <div class="task-card bg-white border-l-4 border-emerald-500 rounded-r-lg p-3 shadow-sm hover:shadow-md transition-all cursor-pointer h-32 flex flex-col group" 
                            data-task-id="{{ $task->id }}"
                            data-task='@json($task)'>
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="font-medium text-gray-800 text-sm" title="{{ $task->title }}">{{ $task->title }}</h4>
                                <button class="text-gray-400 hover:text-red-500 delete-task flex-shrink-0 ml-2 opacity-0 group-hover:opacity-100 transition-opacity" title="Delete task">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </div>
                            @if($task->description)
                                <p class="text-xs text-gray-500 mb-2" title="{{ $task->description }}">{{ $task->description }}</p>
                            @endif
                            <div class="flex justify-between items-center text-xs mt-auto">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-medium 
                                    {{ $task->priority === 'high' ? 'bg-red-100 text-red-800' : 
                                    ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                                @if($task->due_date)
                                    <span class="text-gray-500 text-[10px] whitespace-nowrap">
                                        <i class="far fa-calendar-alt mr-0.5"></i>
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    <button 
                        @click="openModal()"
                        class="add-task-btn w-full text-sm text-gray-500 hover:text-indigo-600 hover:bg-gray-50 py-2 rounded-md transition-colors text-left px-2 flex items-center"
                    >
                        <i class="fas fa-plus-circle mr-2 text-indigo-500"></i>
                        <span>Add Task</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Detail Modal -->
    <div id="taskDetailModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4 text-center">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity duration-200" id="modalBackdrop"></div>
            
            <!-- Modal Panel -->
            <div class="relative w-full max-w-2xl transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all">
                <!-- Header -->
                <div class="flex items-center justify-between p-6 pb-4">
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-900">Task Details</h3>
                    </div>
                    <button id="closeTaskModal" class="rounded-lg p-1.5 text-gray-400 transition-colors hover:bg-gray-100 hover:text-gray-500">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="px-6 pb-6">
                    <!-- Title -->
                    <div class="mb-6">
                        <h2 id="modalTaskTitle" class="text-xl font-semibold text-gray-900"></h2>
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-8">
                        <h4 class="mb-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Description</h4>
                        <div id="modalTaskDescription" class="rounded-lg bg-gray-50 p-4 text-gray-700">
                            <!-- Content will be inserted here -->
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="space-y-6 py-6">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <!-- Priority -->
                            <div class="rounded-xl border border-gray-100 p-4">
                                <h4 class="mb-2 text-xs font-semibold uppercase tracking-wider text-gray-500">Priority</h4>
                                <div id="modalTaskPriority" class="inline-flex items-center">
                                    <span class="mr-2 inline-block h-2.5 w-2.5 rounded-full"></span>
                                    <span class="text-sm font-medium"></span>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="rounded-xl border border-gray-100 p-4">
                                <h4 class="mb-2 text-xs font-semibold uppercase tracking-wider text-gray-500">Status</h4>
                                <div id="modalTaskStatus" class="inline-flex items-center">
                                    <span class="mr-2 inline-block h-2.5 w-2.5 rounded-full"></span>
                                    <span class="text-sm font-medium"></span>
                                </div>
                            </div>

                            <!-- Due Date -->
                            <div class="rounded-xl border border-gray-100 p-4">
                                <h4 class="mb-2 text-xs font-semibold uppercase tracking-wider text-gray-500">Due Date</h4>
                                <div class="flex items-center text-gray-700">
                                    <svg class="mr-2 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span id="modalTaskDueDate" class="text-sm font-medium"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Details -->
                        <div class="space-y-4">
                            <!-- Task Board -->
                            <div class="flex items-start">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-50 text-gray-600">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-500">Board</p>
                                    <p id="modalTaskBoard" class="text-sm font-medium text-gray-900">
                                        <!-- Board name will be inserted here -->
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Created At -->
                            <div class="flex items-start">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-50 text-gray-600">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-500">Created</p>
                                    <p class="text-sm font-medium text-gray-900">
                                        <time id="modalTaskCreatedAt"></time>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex justify-end space-x-3 border-t border-gray-100 bg-gray-50 px-6 py-4">
                    <button id="closeModalBtn" type="button" class="rounded-lg px-4 py-3 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Close
                    </button>
                    <button type="button" id="editTaskBtn" class="rounded-lg bg-indigo-600 px-4 py-3 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Edit Task
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Task Modal -->
    <div id="editTaskModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4 text-center">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity duration-200" id="editModalBackdrop"></div>
            
            <!-- Modal Panel -->
            <div class="relative w-full max-w-2xl transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all">
                <!-- Header -->
                <div class="flex items-center justify-between p-6 pb-4">
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-900">Edit Task</h3>
                    </div>
                    <button id="closeEditModal" class="rounded-lg p-1.5 text-gray-400 transition-colors hover:bg-gray-100 hover:text-gray-500">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Form -->
                <form id="editTaskForm" method="POST" class="px-6 pb-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editTaskId" name="id">
                    
                    <div class="space-y-4">
                        <!-- Title -->
                        <div>
                            <label for="editTaskTitle" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input type="text" id="editTaskTitle" name="title" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="editTaskDescription" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea id="editTaskDescription" name="description" rows="3"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Due Date -->
                            <div>
                                <label for="editTaskDueDate" class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
                                <input type="date" id="editTaskDueDate" name="due_date"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <!-- Priority -->
                            <div>
                                <label for="editTaskPriority" class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                                <select id="editTaskPriority" name="priority" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="editTaskStatus" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select id="editTaskStatus" name="status" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="todo">To Do</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="in_review">In Review</option>
                                    <option value="done">Done</option>
                                </select>
                            </div>

                            <!-- Task Board -->
                            <div>
                                <label for="editTaskBoard" class="block text-sm font-medium text-gray-700 mb-1">Task Board</label>
                                <select id="editTaskBoard" name="task_board_id"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <!-- Will be populated by JavaScript -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" id="cancelEditTask"
                                class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Cancel
                        </button>
                        <button type="submit"
                                class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Update Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div x-show="isOpen" 
        x-transition:enter="ease-out duration-300" 
        x-transition:enter-start="opacity-0" 
        x-transition:enter-end="opacity-100" 
        x-transition:leave="ease-in duration-200" 
        x-transition:leave-start="opacity-100" 
        x-transition:leave-end="opacity-0" 
        class="fixed inset-0 z-50 overflow-y-auto" 
        style="display: none;"
        @keydown.escape.window="closeModal()">
        <div class="flex min-h-screen items-center justify-center p-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" @click="closeModal()"></div>
            
            <!-- Modal Container -->
            <div class="relative w-full max-w-2xl transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all" 
                x-transition:enter="ease-out duration-300" 
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                x-transition:leave="ease-in duration-200" 
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <!-- Modal Header -->
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-xl font-medium text-gray-900">Create New Task</h3>
                    <p class="mt-1 text-sm text-gray-500">Fill in the details below to create a new task.</p>
                </div>
            
                <!-- Modal Body -->
                <form id="addTaskForm" action="{{ route('tasks.store') }}" method="POST" class="space-y-6 p-6">
                    @csrf
                    <div>
                        <label for="taskTitle" class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                        <input type="text" id="taskTitle" name="title" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                
                    <div>
                        <label for="taskDescription" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea id="taskDescription" name="description" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>
                
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="taskPriority" class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                            <select id="taskPriority" name="priority" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                    
                        <div>
                            <label for="taskDueDate" class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
                            <input type="date" id="taskDueDate" name="due_date"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    
                        <div class="md:col-span-2">
                            <label for="taskStatus" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="taskStatus" name="status" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="todo">To Do</option>
                                <option value="in_progress">In Progress</option>
                                <option value="in_review">In Review</option>
                                <option value="done">Done</option>
                            </select>
                        </div>
                    </div>
                
                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" @click="closeModal()"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Add Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .task-card {
        min-width: 0; /* This allows the card to respect the parent's width */
    }
    
    .task-card h4 {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }

    .task-card p {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }

    /* Ensure columns maintain consistent width */
    .kanban-column {
        width: 16rem; /* w-64 */
        min-width: 16rem; /* Prevent shrinking */
        max-width: 16rem; /* Prevent growing */
    }

    /* Modal styles for full content */
    #taskDetailModal .modal-content {
        max-height: 80vh;
        overflow-y: auto;
    }
    [x-cloak] { display: none !important; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded');
    
    // Modal elements
    const taskDetailModal = document.getElementById('taskDetailModal');
    const modalBackdrop = document.getElementById('modalBackdrop');
    const modalPanel = taskDetailModal?.querySelector('.relative') || taskDetailModal?.querySelector('div > div:last-child');
    const closeButtons = [
        document.getElementById('closeTaskModal'),
        document.getElementById('closeModalBtn')
    ].filter(Boolean);
    
    // Get all modal elements with null checks
    const getElement = (id) => {
        const el = document.getElementById(id);
        if (!el) console.error(`Element with ID '${id}' not found`);
        return el;
    };
    
    const modalTitle = getElement('modalTaskTitle');
    const modalDescription = getElement('modalTaskDescription');
    const modalDueDate = getElement('modalTaskDueDate');
    const modalPriority = getElement('modalTaskPriority');
    const modalStatus = getElement('modalTaskStatus');
    const modalBoard = getElement('modalTaskBoard');
    const modalCreatedAt = getElement('modalTaskCreatedAt');
    
    let currentTask = null;
    
    // Debug: Log modal elements to console
    console.log('Modal elements:', {
        taskDetailModal: !!taskDetailModal,
        modalBackdrop: !!modalBackdrop,
        modalPanel: !!modalPanel,
        modalTitle: !!modalTitle,
        modalDescription: !!modalDescription,
        modalDueDate: !!modalDueDate,
        modalPriority: !!modalPriority,
        modalStatus: !!modalStatus,
        modalBoard: !!modalBoard,
        modalCreatedAt: !!modalCreatedAt
    });
    
    if (!taskDetailModal) console.error('Task detail modal not found');
    if (!modalPanel) console.error('Modal panel not found');

    // Function to close task detail modal
    function closeTaskDetailModal() {
        const taskDetailModal = document.getElementById('taskDetailModal');
        if (taskDetailModal) {
            taskDetailModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            currentTask = null;
        }
    }

    // Setup task detail modal close handlers
    function setupTaskDetailCloseHandlers() {
        // Close with X button
        const closeDetailModal = document.getElementById('closeTaskModal');
        if (closeDetailModal) {
            closeDetailModal.addEventListener('click', closeTaskDetailModal);
        }

        // Close with backdrop click
        const detailModalBackdrop = document.getElementById('modalBackdrop');
        if (detailModalBackdrop) {
            detailModalBackdrop.addEventListener('click', closeTaskDetailModal);
        }
    }

    // Show modal with animation
    function showModal() {
        if (!taskDetailModal) {
            console.error('Cannot show modal: taskDetailModal is not defined');
            return;
        }
        
        document.body.style.overflow = 'hidden';
        taskDetailModal.classList.remove('hidden');
        
        if (modalBackdrop) modalBackdrop.style.opacity = '1';
        
        if (modalPanel) {
            // Reset transform for animation
            modalPanel.style.opacity = '0';
            modalPanel.style.transform = 'translateY(-20px)';
            
            // Trigger reflow
            void modalPanel.offsetHeight;
            
            // Animate in
            setTimeout(() => {
                modalPanel.style.opacity = '1';
                modalPanel.style.transform = 'translateY(0)';
                modalPanel.style.transition = 'opacity 200ms ease-out, transform 200ms ease-out';
            }, 10);
        }
    }

    // Function to open task detail modal
    function openTaskDetailModal(taskData) {
        if (!taskData) {
            console.error('No task data provided');
            return;
        }
        
        if (!taskDetailModal) {
            console.error('Task detail modal not found');
            return;
        }
        
        currentTask = taskData;
        
        try {
            console.log('Opening task detail modal with data:', taskData);
            
            // Update modal content with task data
            if (modalTitle) modalTitle.textContent = taskData.title || 'No title';
            if (modalDescription) modalDescription.textContent = taskData.description || 'No description';
            if (modalDueDate) {
                modalDueDate.textContent = taskData.due_date ? new Date(taskData.due_date).toLocaleDateString() : 'No due date';
            }
            
            // Set priority with improved styling
            if (modalPriority) {
                const priorityText = taskData.priority ? taskData.priority.charAt(0).toUpperCase() + taskData.priority.slice(1) : 'Not set';
                modalPriority.innerHTML = `
                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-medium">
                        <span class="h-1.5 w-1.5 rounded-full ${getPriorityColor(taskData.priority, 'bg')}"></span>
                        ${priorityText}
                    </span>
                `;
            } else {
                console.warn('Priority element not found in modal');
            }
            
            // Set status with improved styling
            if (modalStatus) {
                const statusText = taskData.status ? formatStatusText(taskData.status) : 'Not set';
                modalStatus.innerHTML = `
                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-medium ${getStatusColor(taskData.status, 'bg')} ${getStatusColor(taskData.status, 'text')} bg-opacity-10">
                        <span class="h-1.5 w-1.5 rounded-full ${getStatusColor(taskData.status, 'bg')}"></span>
                        ${statusText}
                    </span>
                `;
            } else {
                console.warn('Status element not found in modal');
            }

            // Set task board if available
            if (modalBoard) {
                if (taskData.task_board && taskData.task_board.name) {
                    modalBoard.textContent = taskData.task_board.name;
                } else if (taskData.board) {
                    modalBoard.textContent = taskData.board.name || 'No board';
                } else {
                    modalBoard.textContent = 'No board';
                }
            } else {
                console.warn('Task board element not found in modal');
            }
            
            // Set up close handlers
            setupTaskDetailCloseHandlers();
            
            // Show the modal with animation
            showModal();
            
        } catch (error) {
            console.error('Error in openTaskDetailModal:', error);
        }
    }

    // Helper function to format status text
    function formatStatusText(status) {
        if (!status) return 'Not Set';
        return status.split('_').map(word => 
            word.charAt(0).toUpperCase() + word.slice(1)
        ).join(' ');
    }

    // Helper function to get status colors
    function getStatusColor(status, type = 'bg') {
        const colors = {
            'todo': { bg: 'bg-gray-500', text: 'text-gray-800' },
            'in_progress': { bg: 'bg-blue-500', text: 'text-blue-800' },
            'in_review': { bg: 'bg-purple-500', text: 'text-purple-800' },
            'done': { bg: 'bg-green-500', text: 'text-green-800' }
        };
        return colors[status]?.[type] || 'bg-gray-100 text-gray-800';
    }

    // Helper function to get priority colors
    function getPriorityColor(priority, type = 'bg') {
        const colors = {
            'low': { bg: 'bg-green-500', text: 'text-green-800' },
            'medium': { bg: 'bg-yellow-500', text: 'text-yellow-800' },
            'high': { bg: 'bg-red-500', text: 'text-red-800' }
        };
        return colors[priority]?.[type] || 'bg-gray-100 text-gray-800';
    }

    // Store the currently selected task data

    // Handle task card clicks
    document.addEventListener('click', function(e) {
        // Check if we're clicking on a task card or its direct content (but not buttons or interactive elements)
        const taskCard = e.target.closest('.task-card');
        if (!taskCard) return;
        
        // Check if we're clicking on an interactive element
        const interactiveElements = ['BUTTON', 'A', 'INPUT', 'SELECT', 'TEXTAREA'];
        if (e.target.closest('button, a, [role="button"], input, select, textarea, .modal')) {
            // Let the default action happen for interactive elements
            return;
        }
        
        e.preventDefault();
        e.stopPropagation();
        
        try {
            // Get the task data from the data-task attribute
            const taskDataString = taskCard.getAttribute('data-task');
            if (!taskDataString) {
                console.warn('No data-task attribute found on task card');
                return;
            }
            
            console.log('Raw task data string:', taskDataString);
            
            // Parse the JSON data
            let taskData;
            try {
                taskData = JSON.parse(taskDataString);
                console.log('Parsed task data:', taskData);
                
                if (!taskData || typeof taskData !== 'object') {
                    console.error('Invalid task data format:', taskData);
                    throw new Error('Invalid task data');
                }
                
                // Store the task data for potential editing
                currentTask = {
                    id: taskData.id,
                    title: taskData.title || 'Untitled Task',
                    description: taskData.description || '',
                    status: taskData.status || 'todo',
                    priority: taskData.priority || 'medium',
                    due_date: taskData.due_date || null,
                    created_at: taskData.created_at || new Date().toISOString(),
                    task_board: taskData.task_board || null
                };
                
                console.log('Current task set:', currentTask);
                openTaskDetailModal(currentTask);
                
            } catch (parseError) {
                console.error('Error parsing task data:', parseError);
                throw new Error('Invalid task data format');
            }
            
        } catch (error) {
            console.error('Error in task card click handler:', error);
            alert('Could not load task details. ' + error.message);
        }
    });

    // Handle edit button click
    document.addEventListener('click', function(e) {
        const editBtn = e.target.closest('#editTaskBtn');
        if (editBtn) {
            e.preventDefault();
            e.stopPropagation();
            
            if (!currentTask) {
                console.error('No task data available for editing');
                alert('Could not load task details for editing. Please select a task first.');
                return;
            }
            
            console.log('Edit button clicked with task data:', currentTask);
            openEditTaskModal(currentTask);
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !taskDetailModal.classList.contains('hidden')) {
            closeTaskDetailModal();
        }
    });

    // Edit Task Modal Functionality
    const editTaskModal = document.getElementById('editTaskModal');
    const editTaskForm = document.getElementById('editTaskForm');
    const closeEditModal = document.getElementById('closeEditModal');
    const cancelEditTask = document.getElementById('cancelEditTask');

    // Function to close edit modal
    function closeEditModalFn() {
        const editModal = document.getElementById('editTaskModal');
        if (editModal) {
            editModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    // Close edit modal when clicking the X button
    if (closeEditModal) {
        closeEditModal.addEventListener('click', closeEditModalFn);
    }

    // Close edit modal when clicking the Cancel button
    if (cancelEditTask) {
        cancelEditTask.addEventListener('click', closeEditModalFn);
    }

    // Close edit modal when clicking outside the modal
    const editModalBackdrop = document.getElementById('editModalBackdrop');
    if (editModalBackdrop) {
        editModalBackdrop.addEventListener('click', closeEditModalFn);
    }

    // Close edit modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && editTaskModal && !editTaskModal.classList.contains('hidden')) {
            closeEditModalFn();
        }
    });

    // Handle edit form submission
    function handleEditFormSubmit(e) {
        e.preventDefault();
        
        const form = e.target;
        const formData = new FormData(form);
        const taskId = form.getAttribute('data-task-id');
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn ? submitBtn.innerHTML : null;
        
        if (!taskId) {
            alert('Error: Task ID not found');
            return;
        }
        
        // Show loading state
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Saving...';
        }
        
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) {
            console.error('CSRF token not found!');
            alert('Security error: CSRF token missing. Please refresh the page and try again.');
            return;
        }
        
        // Prepare request body
        const requestBody = {
            '_method': 'PUT',
            'title': formData.get('title'),
            'description': formData.get('description'),
            'due_date': formData.get('due_date') || null,
            'priority': formData.get('priority'),
            'status': formData.get('status'),
            'task_board_id': formData.get('task_board_id') || null
        };
        
        console.log('Sending update request for task ID:', taskId, requestBody);
        
        fetch(`/tasks/${taskId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(requestBody)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Failed to update task');
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Task updated successfully:', data);
            closeEditModalFn();
            window.location.reload();
        })
        .catch(error => {
            console.error('Error updating task:', error);
            alert(error.message || 'Failed to update task. Please try again.');
        })
        .finally(() => {
            if (submitBtn) {
                submitBtn.disabled = false;
                if (originalBtnText) submitBtn.innerHTML = originalBtnText;
            }
        });
    }
    
    // Initialize edit form submission
    if (editTaskForm) {
        // Remove any existing event listeners
        const newForm = editTaskForm.cloneNode(true);
        editTaskForm.parentNode.replaceChild(newForm, editTaskForm);
        
        // Get the new form reference and add submit handler
        document.getElementById('editTaskForm').addEventListener('submit', handleEditFormSubmit);
    }

    // Close edit modal handlers
    function setupModalCloseHandlers() {
        // Close edit modal with X button
        const closeEditModal = document.getElementById('closeEditModal');
        if (closeEditModal) {
            closeEditModal.removeEventListener('click', closeEditModalFn); // Remove existing listener
            closeEditModal.addEventListener('click', closeEditModalFn);
        }

        // Close edit modal with Cancel button
        const cancelEditTask = document.getElementById('cancelEditTask');
        if (cancelEditTask) {
            cancelEditTask.removeEventListener('click', closeEditModalFn); // Remove existing listener
            cancelEditTask.addEventListener('click', closeEditModalFn);
        }

        // Close edit modal when clicking outside
        const editModalBackdrop = document.getElementById('editModalBackdrop');
        if (editModalBackdrop) {
            editModalBackdrop.removeEventListener('click', closeEditModalFn); // Remove existing listener
            editModalBackdrop.addEventListener('click', closeEditModalFn);
        }
    }

    // Function to open edit modal
    function openEditTaskModal(taskData) {
        console.log('Opening edit modal with task data:', taskData);
        
        if (!taskData || !taskData.id) {
            console.error('Invalid or missing task data for editing:', taskData);
            alert('Could not load task details for editing. Please try again.');
            return;
        }
        
        try {
            // Hide task detail modal first
            closeTaskDetailModal();
            
            // Get a fresh reference to the form
            const form = document.getElementById('editTaskForm');
            if (!form) {
                console.error('Edit task form not found!');
                alert('Could not load the edit form. Please refresh the page and try again.');
                return;
            }
            
            // Reset the form
            form.reset();
            
            // Helper function to safely set form field values
            const setFormField = (selector, value) => {
                const field = form.querySelector(selector);
                if (field && value !== undefined && value !== null) {
                    field.value = value;
                }
            };
            
            // Helper function to set form field by ID
            const setFieldValue = (id, value) => {
                const field = document.getElementById(id);
                if (field) {
                    field.value = value || '';
                } else {
                    console.error(`Field with ID '${id}' not found`);
                }
            };
            
            // Populate form fields with task data using element IDs
            setFieldValue('editTaskTitle', taskData.title);
            setFieldValue('editTaskDescription', taskData.description);
            setFieldValue('editTaskStatus', taskData.status || 'todo');
            setFieldValue('editTaskPriority', taskData.priority || 'medium');
            
            // Format and set due date if it exists
            if (taskData.due_date) {
                try {
                    const dueDate = new Date(taskData.due_date);
                    if (!isNaN(dueDate.getTime())) {
                        const formattedDate = dueDate.toISOString().split('T')[0];
                        setFieldValue('editTaskDueDate', formattedDate);
                    }
                } catch (dateError) {
                    console.error('Error formatting due date:', dateError);
                }
            }
            
            // Set the task ID in the form
            form.setAttribute('data-task-id', taskData.id);
            
            // Show the edit modal
            const editModal = document.getElementById('editTaskModal');
            if (!editModal) {
                console.error('Edit modal element not found!');
                alert('Could not open the edit form. Please refresh the page and try again.');
                return;
            }
            
            // Show the modal
            editModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Focus the first input field after a short delay to ensure it's visible
            setTimeout(() => {
                const firstInput = form.querySelector('input, select, textarea');
                if (firstInput) firstInput.focus();
            }, 100);
            
            console.log('Edit modal opened successfully for task ID:', taskData.id);
            
        } catch (error) {
            console.error('Error in openEditTaskModal:', error);
            alert('An error occurred while loading the edit form. Please try again.');
            console.error('Edit modal not found!');
        }
    }

    // Close edit modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !editTaskModal.classList.contains('hidden')) {
            closeEditModalFn();
        }
    });


    // Add task form submission
    function setupAddTaskForm() {
        const addTaskForm = document.getElementById('addTaskForm');
        
        if (!addTaskForm) {
            console.log('Add task form not found, will retry...');
            setTimeout(setupAddTaskForm, 100);
            return;
        }
    
        console.log('Add task form found, checking connection status...');
        
        // Check if the form is connected to the DOM
        if (!document.body.contains(addTaskForm)) {
            console.log('Form exists but is not connected to DOM, will retry...');
            setTimeout(setupAddTaskForm, 100);
            return;
        }
    
        console.log('Form is connected to DOM, setting up event listeners...');
        
        // Remove any existing event listeners to prevent duplicates
        const newForm = addTaskForm.cloneNode(true);
        addTaskForm.parentNode.replaceChild(newForm, addTaskForm);
        
        // Store the form reference
        const form = document.getElementById('addTaskForm');
        
        // Add submit event to the form
        form.addEventListener('submit', async function(e) {
            console.log('Form submit event triggered!');
            e.preventDefault();
            
            console.log('Form element in submit handler:', form);
            
            const formData = new FormData(form);
            console.log('Form data before processing:');
            for (let [key, value] of formData.entries()) {
                console.log(`${key}:`, value);
            }
            
            // Check if required fields are present
            const title = formData.get('title');
            if (!title) {
                alert('Title is required');
                return;
            }
            
            const submitBtn = form.querySelector('button[type="submit"]');
            
            try {
                // Disable submit button to prevent double submission
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = 'Adding...';
                }
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (!csrfToken) {
                    throw new Error('CSRF token not found in meta tag');
                }
                
                console.log('CSRF Token:', csrfToken);
                console.log('Sending request to:', form.action);
                
                // Add CSRF token and user ID to form data
                if (!formData.has('_token')) {
                    formData.append('_token', csrfToken);
                }
                
                // Get the authenticated user's ID from the meta tag
                const userId = document.querySelector('meta[name="user-id"]')?.content || '{{ Auth::id() }}';
                if (userId) {
                    formData.append('user_id', userId);
                }
                
                // Try with FormData
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });
                
                console.log('Response status:', response.status);
                
                let data;
                try {
                    data = await response.json();
                    console.log('Response data:', data);
                    
                    // Handle authentication redirect
                    if (response.status === 401 || (data && data.redirect)) {
                        window.location.href = data.redirect || '{{ route("login") }}';
                        return;
                    }
                    
                    // Handle other error responses
                    if (!response.ok) {
                        throw new Error(data.message || 'Failed to create task');
                    }
                    
                    // Success - show success message and reset form
                    alert('Task created successfully!');
                    form.reset();
                    
                    // Reload the page to show the new task
                    window.location.reload();
                    
                } catch (error) {
                    console.error('Error processing response:', error);
                    
                    // If we get a 401 but no JSON response, redirect to login
                    if (response.status === 401) {
                        window.location.href = '{{ route("login") }}';
                        return;
                    }
                    
                    // Show error message to user
                    alert(error.message || 'An error occurred while creating the task');
                } finally {
                    // Re-enable submit button
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Add Task';
                    }
                }
            } catch (error) {
                console.error('Error during form submission:', error);
                alert(error.message || 'An error occurred while creating the task. Please check the console for details.');
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Add Task';
                }
            }
        });
        
        console.log('Successfully set up form submission handler');
    }
    
    // MutationObserver to detect when the form is added to the DOM
    function observeForm() {
        const observer = new MutationObserver(function(mutations, obs) {
            const addTaskForm = document.getElementById('addTaskForm');
            if (addTaskForm && document.body.contains(addTaskForm)) {
                console.log('Form found in DOM via MutationObserver');
                setupAddTaskForm();
                obs.disconnect(); // Stop observing once we've set up the form
            }
        });
    
        // Start observing the document with the configured parameters
        observer.observe(document.body, { 
            childList: true, 
            subtree: true 
        });
    }
    
    // Run setup when Alpine is initialized
    document.addEventListener('alpine:init', function() {
        console.log('Alpine.js initialized, setting up form...');
        setupAddTaskForm();
        observeForm();
    });
    
    // Also try to set up immediately in case Alpine is already loaded
    if (window.Alpine) {
        console.log('Alpine.js already loaded, setting up form...');
        setupAddTaskForm();
        observeForm();
    } else {
        console.log('Alpine.js not yet loaded, will wait for alpine:init event...');
        // Set up a fallback in case alpine:init is never fired
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM fully loaded, setting up form...');
            setupAddTaskForm();
            observeForm();
        });
    }

    // Clean up any duplicate form submission handlers
    if (editTaskForm) {
        console.log('Edit task form initialized');
    }
});

document.addEventListener('submit', async function(e) {
    if (e.target.matches('form[action="{{ route('tasks.store') }}"]')) {
        e.preventDefault();
        
        const form = e.target;
        const formData = new FormData(form);
        
        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (response.ok) {
                // Close modal and refresh the page to show the new task
                window.location.reload();
            } else {
                // Handle validation errors
                if (data.errors) {
                    let errorMessage = Object.values(data.errors).flat().join('\n');
                    alert('Error: ' + errorMessage);
                } else {
                    alert('Error creating task: ' + (data.message || 'Unknown error occurred'));
                }
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while creating the task. Please try again.');
        }
    }
});

const addTaskForm = document.getElementById('addTaskForm');
if (addTaskForm) {
    console.log('Add task form found, adding submit event listener...');
    
    // Log the form element to verify it's found
    console.log('Form element:', addTaskForm);
    
    // Remove any existing event listeners to prevent duplicates
    const newForm = addTaskForm.cloneNode(true);
    addTaskForm.parentNode.replaceChild(newForm, addTaskForm);
    
    // Add a click event to the submit button for debugging
    const submitButton = newForm.querySelector('button[type="submit"]');
    if (submitButton) {
        submitButton.addEventListener('click', function(e) {
            console.log('Submit button clicked!');
            // Let the form submit normally for now to see if it works
            // We'll prevent default in the form's submit handler
        });
    } else {
        console.error('Submit button not found in the form!');
    }
    
    // Add submit event to the form
    newForm.addEventListener('submit', async function(e) {
        console.log('Form submit event triggered!');
        e.preventDefault();
        
        const form = e.target;
        console.log('Form element in submit handler:', form);
        
        const formData = new FormData(form);
        console.log('Form data before processing:');
        for (let [key, value] of formData.entries()) {
            console.log(`${key}:`, value);
        }
        
        // Check if required fields are present
        const title = formData.get('title');
        if (!title) {
            alert('Title is required');
            return;
        }
        
        const submitBtn = form.querySelector('button[type="submit"]');
        
        try {
            // Disable submit button to prevent double submission
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Adding...';
            }
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!csrfToken) {
                throw new Error('CSRF token not found in meta tag');
            }
            
            console.log('CSRF Token:', csrfToken);
            console.log('Sending request to:', form.action);
            
            // Try with FormData first
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });
            
            console.log('Response status:', response.status);
            
            let data;
            try {
                data = await response.json();
                console.log('Response data:', data);
            } catch (jsonError) {
                console.error('Error parsing JSON response:', jsonError);
                const text = await response.text();
                console.error('Raw response:', text);
                throw new Error('Invalid JSON response from server');
            }
            
            if (response.ok) {
                console.log('Task created successfully, reloading page...');
                window.location.reload();
            } else {
                console.error('Server returned error status:', response.status);
                if (data && data.errors) {
                    const errorMessage = Object.values(data.errors).flat().join('\n');
                    throw new Error(`Validation Error: ${errorMessage}`);
                } else {
                    throw new Error(data?.message || 'Failed to create task');
                }
            }
        } catch (error) {
            console.error('Error during form submission:', error);
            alert(error.message || 'An error occurred while creating the task. Please check the console for details.');
        } finally {
            // Re-enable submit button
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Add Task';
            }
        }
    });
    
    // Test if the event listener was added
    console.log('Added event listener to form:', newForm);
} else {
    console.error('Add task form not found!');
    // Check if there are any forms on the page
    console.log('All forms on page:', document.forms);
}
</script>
@endpush