<?php for($i = 1; $i <= 3; $i++): ?>
<article class="post-card bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md" x-data="{ showComments: false }">
    <div class="p-5">
        <!-- Post Header -->
        <header class="flex items-start justify-between mb-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-medium">
                    U<?php echo e($i); ?>

                </div>
                <div>
                    <h3 class="font-medium">User <?php echo e($i); ?></h3>
                    <p class="text-xs text-gray-500"><?php echo e(now()->subHours(rand(1, 24))->diffForHumans()); ?></p>
                </div>
            </div>
            <button class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-ellipsis-h"></i>
            </button>
        </header>

        <!-- Post Content -->
        <div class="mb-4">
            <p class="text-gray-800 mb-3">
                This is a sample forum post #<?php echo e($i); ?>. Here's some content to demonstrate how a post might look in the forum.
                <?php if($i % 2 === 0): ?>
                    This post contains an image below to showcase how media will be displayed within the forum.
                <?php endif; ?>
            </p>
            
            <?php if($i % 2 === 0): ?>
            <div class="mt-3 rounded-lg overflow-hidden">
                <img src="<?php echo e(asset('images/image_placeholder.jpg')); ?>" 
                     alt="Post image" 
                     class="w-full h-auto rounded-lg">
            </div>
            <?php endif; ?>
        </div>

        <!-- Post Actions -->
        <div class="flex items-center justify-between text-gray-500 pt-3 border-t">
            <div class="flex space-x-4">
                <button class="flex items-center space-x-1 hover:text-indigo-600">
                    <i class="far fa-thumbs-up"></i>
                    <span><?php echo e(rand(5, 50)); ?></span>
                </button>
                <button class="flex items-center space-x-1 hover:text-indigo-600" @click="showComments = !showComments">
                    <i class="far fa-comment"></i>
                    <span><?php echo e(rand(0, 15)); ?></span>
                </button>
            </div>
            <div>
                <button class="flex items-center space-x-1 hover:text-indigo-600">
                    <i class="far fa-share-square"></i>
                    <span>Share</span>
                </button>
            </div>
        </div>

        <!-- Comments Section -->
        <div x-show="showComments" x-transition class="space-y-3 mt-4 pt-4 border-t border-gray-100">
            <?php for($j = 1; $j <= 2; $j++): ?>
            <div class="flex items-start space-x-2">
                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 text-xs font-medium flex-shrink-0">
                    <?php echo e(strtoupper(substr("User $j", 0, 1))); ?>

                </div>
                <div class="flex-1 bg-gray-50 rounded-lg p-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium">User <?php echo e($j); ?></span>
                        <span class="text-xs text-gray-400"><?php echo e(now()->subMinutes(rand(5, 60))->diffForHumans()); ?></span>
                    </div>
                    <p class="text-sm text-gray-700 mt-1">This is a sample comment on the post.</p>
                </div>
            </div>
            <?php endfor; ?>

            <!-- Add Comment -->
            <div class="flex items-center space-x-2 pt-2">
                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 text-xs font-medium flex-shrink-0">
                    <?php echo e(strtoupper(substr("You", 0, 1))); ?>

                </div>
                <div class="flex-1 relative">
                    <input type="text" 
                           placeholder="Write a comment..." 
                           class="w-full bg-gray-50 border-0 rounded-full px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-300">
                    <button class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-indigo-600">
                        <i class="far fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</article>
<?php endfor; ?>

<!-- Load More Button -->
<div class="mt-8 text-center">
    <button class="bg-indigo-50 text-indigo-600 px-6 py-2 rounded-full font-medium hover:bg-indigo-100 transition">
        Load More Posts
    </button>
</div>
<?php /**PATH C:\xampp\htdocs\eduflow\resources\views/forums/partials/posts.blade.php ENDPATH**/ ?>