

<?php $__env->startSection('title', 'Tasks - EduFlow'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .task-card {
        @apply bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md;
    }
    
    .note-card {
        @apply bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md;
    }
    
    .pomodoro-card {
        @apply bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden;
    }
    
    .action-btn {
        @apply flex items-center justify-center p-2 rounded-lg hover:bg-gray-100 text-gray-600 hover:text-indigo-600 transition-colors duration-200;
    }

    /* Kanban Board Colors */
    .bg-sky-50 { background-color: #f0f9ff !important; }
    .text-sky-700 { color: #0369a1 !important; }
    .bg-sky-200 { background-color: #bae6fd !important; }
    .text-sky-800 { color: #075985 !important; }
    .border-sky-500 { border-color: #0ea5e9 !important; }
    
    .bg-amber-50 { background-color: #fffbeb !important; }
    .text-amber-700 { color: #b45309 !important; }
    .bg-amber-200 { background-color: #fde68a !important; }
    .text-amber-800 { color: #92400e !important; }
    .border-amber-500 { border-color: #f59e0b !important; }
    
    .bg-fuchsia-50 { background-color: #fdf4ff !important; }
    .text-fuchsia-700 { color: #a21caf !important; }
    .bg-fuchsia-200 { background-color: #f5d0fe !important; }
    .text-fuchsia-800 { color: #86198f !important; }
    .border-fuchsia-500 { border-color: #d946ef !important; }
    
    .bg-emerald-50 { background-color: #ecfdf5 !important; }
    .text-emerald-700 { color: #047857 !important; }
    .bg-emerald-200 { background-color: #a7f3d0 !important; }
    .text-emerald-800 { color: #065f46 !important; }
    .border-emerald-500 { border-color: #10b981 !important; }
    
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Main Content - 2/3 width on large screens -->
            <div class="flex-1 min-w-0">
                <!-- Kanban Board -->
                <div class="task-card mb-6 rounded-lg shadow-md bg-white border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b border-gray-100">My Tasks</h2>
                        <?php echo $__env->make('tasks.partials.kanban', ['tasks' => $tasks], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                </div>

                <!-- Notes Section -->
                <div class="note-card bg-white rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                    <div class="p-4">
                        <?php echo $__env->make('tasks.partials.notes', ['notes' => $notes], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar - 1/3 width on large screens -->
            <div class="lg:w-64 flex-shrink-0">
                <div class="sticky top-4 space-y-6">
                    <!-- Pomodoro Timer -->
                    <?php echo $__env->make('tasks.partials.pomodoro', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    
                    <!-- Add other sidebar widgets here if needed -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo e($slot ?? ''); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\eduflow\resources\views/tasks/index.blade.php ENDPATH**/ ?>