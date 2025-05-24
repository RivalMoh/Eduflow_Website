

<?php $__env->startSection('title', 'Forums - EduFlow'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .post-card {
        @apply bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md;
    }
    
    .action-btn {
        @apply flex items-center justify-center p-2 rounded-lg hover:bg-gray-100 text-gray-600 hover:text-indigo-600 transition-colors duration-200;
    }
    
    .forum-banner {
        @apply relative w-full min-h-[200px] md:min-h-[250px] rounded-xl overflow-hidden mb-6;
    }
    
    .forum-banner-bg {
        @apply absolute inset-0 w-full h-full object-cover brightness-75;
    }
    
    .forum-banner-overlay {
        @apply absolute inset-0 bg-gradient-to-b from-black/30 to-black/80;
    }
    
    .forum-banner-content {
        @apply relative z-10 p-6 md:p-8 h-full flex flex-col;
    }
    
    .tab-active {
        @apply text-indigo-600 border-b-2 border-indigo-600;
    }
    
    .tab-inactive {
        @apply text-gray-500 hover:text-gray-700;
    }
    
    .forum-avatar {
        @apply rounded-lg border-4 border-white shadow-lg overflow-hidden;
        width: 80px;
        height: 80px;
    }
    
    .forum-stats {
        @apply flex flex-wrap gap-4 md:gap-6 mt-6;
    }
    
    .stat-item {
        @apply text-center;
    }
    
    .stat-value {
        @apply text-xl md:text-2xl font-bold text-white;
    }
    
    .stat-label {
        @apply text-sm text-white/80;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Forum Banner -->
        <?php echo $__env->make('forums.components.forum-banner', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Main Content -->
            <div class="flex-1 min-w-0 py-6">
                <!-- Feed Tabs -->
                <div class="bg-white rounded-xl p-1 mb-6 flex border-b border-gray-200">
                    <a href="<?php echo e(route('forums.index')); ?>" 
                       class="flex-1 py-3 px-4 text-center font-medium <?php echo e($activeTab === 'all' ? 'tab-active' : 'tab-inactive'); ?>">
                        <i class="fas fa-stream mr-2"></i>All Posts
                    </a>
                    <div class="h-9 border-r border-gray-200 mx-auto w-px"></div>
                    <a href="<?php echo e(route('forums.media')); ?>" 
                       class="flex-1 py-3 px-4 text-center font-medium <?php echo e($activeTab === 'media' ? 'tab-active' : 'tab-inactive'); ?>">
                        <i class="fas fa-image mr-2"></i>Media
                    </a>
                </div>

                <!-- Feed Content -->
                <div class="space-y-6">
                    <?php echo $__env->yieldContent('forum-content'); ?>
                </div>
            </div>
            
            <!-- Right Sidebar -->
            <div class="lg:w-80 flex-shrink-0">
                <?php echo $__env->make('forums.components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
    </div>
</div>

<!-- Create Post Modal -->
<div id="createPostModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" x-data="{ show: false }" x-show="show" x-transition>
    <div class="bg-white rounded-xl w-full max-w-2xl mx-4 overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold">Create Post</h3>
                <button @click="show = false" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <div class="p-5">
            <div class="flex items-start space-x-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-medium">
                    <?php echo e(strtoupper(substr(Auth::check() ? Auth::user()->name : 'Y', 0, 1))); ?>

                </div>
                <div class="flex-1">
                    <textarea rows="4" class="w-full border-0 focus:ring-0 resize-none text-gray-800 placeholder-gray-400" 
                              placeholder="What's on your mind?"></textarea>
                </div>
            </div>
            
            <!-- Media Preview -->
            <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center mb-4">
                <i class="fas fa-image text-3xl text-gray-300 mb-2"></i>
                <p class="text-sm text-gray-500">Drag photos or videos here, or click to browse</p>
            </div>
            
            <!-- Post Actions -->
            <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                <div class="flex space-x-2">
                    <button class="w-10 h-10 rounded-full text-gray-500 hover:bg-gray-100 flex items-center justify-center">
                        <i class="far fa-image"></i>
                    </button>
                    <button class="w-10 h-10 rounded-full text-gray-500 hover:bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-link"></i>
                    </button>
                    <button class="w-10 h-10 rounded-full text-gray-500 hover:bg-gray-100 flex items-center justify-center">
                        <i class="far fa-smile"></i>
                    </button>
                </div>
                <button class="bg-indigo-600 text-white px-6 py-2 rounded-full font-medium hover:bg-indigo-700 transition">
                    Post
                </button>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Toggle create post modal
    function toggleCreatePost() {
        const modal = document.getElementById('createPostModal');
        modal.classList.toggle('hidden');
        modal.classList.toggle('flex');
    }
    
    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('createPostModal');
        if (event.target === modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });

    // Make the function globally available
    window.toggleCreatePost = toggleCreatePost;
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\eduflow\resources\views/forums/components/feed-layout.blade.php ENDPATH**/ ?>