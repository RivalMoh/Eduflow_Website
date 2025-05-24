<!-- Forum Banner Component -->
<div class="forum-banner bg-white border-4 border-white rounded-xl relative h-60 md:h-60 overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="<?php echo e(asset('images/forum/banner.jpg')); ?>" 
             alt="Forum Banner" 
             class="min-w-full min-h-full object-cover w-auto h-auto max-w-none"
             style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); filter: brightness(0.8) blur(1px);">
    </div>
    
    <!-- Dark overlay with gradient -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/40 to-black/70"></div>
    
    <!-- Content -->
    <div class="relative z-10 p-6 md:p-8 h-full flex flex-col">
        <div class="flex-1">
            <!-- Forum Name -->
            <div class="flex flex-col md:flex-row md:items-end">
                <div class="flex items-center md:items-end space-x-4 md:space-x-6">
                    <div class="forum-avatar">
                        <img src="<?php echo e(asset('images/forum/avatar.jpg')); ?>" alt="Forum Avatar" class="w-full h-full object-cover rounded-xl">
                    </div>
                    <div class="mt-4 md:mt-0">
                        <h1 class="text-2xl md:text-4xl font-bold text-white drop-shadow-lg">Web Development Forum</h1>
                        <div class="flex flex-wrap items-center mt-2 space-x-3">
                            <span class="text-sm bg-white/30 text-white px-3 py-1 rounded-full backdrop-blur-sm font-medium">#webdev</span>
                            <span class="text-sm bg-white/30 text-white px-3 py-1 rounded-full backdrop-blur-sm font-medium">#programming</span>
                        </div>
                    </div>
                </div>
            </div>            
            <!-- Forum Stats -->
            <div class="mt-6">
                <div class="flex items-center space-x-8">
                    <div class="stat-item">
                        <div class="text-2xl md:text-3xl font-semibold text-white drop-shadow px-2">1.2k</div>
                        <div class="text-sm text-white text-center">Members</div>
                    </div>
                    <div class="stat-item">
                        <div class="text-2xl md:text-3xl font-semibold text-white drop-shadow px-2">5.7k</div>
                        <div class="text-sm text-white text-center">Posts</div>
                    </div>
                    <div class="stat-item">
                        <div class="text-2xl md:text-3xl font-semibold text-white drop-shadow px-2">120</div>
                        <div class="text-sm text-white text-center">Online</div>
                    </div>
                </div>
            </div>
            <!-- Join Community Button -->
            <div class="mt-4 md:mt-2 md:ml-auto">
                <button class="bg-white text-indigo-600 px-6 py-2 rounded-full font-medium hover:bg-opacity-90 transition shadow-md hover:shadow-lg">
                    Join Community
                </button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\eduflow\resources\views/forums/components/forum-banner.blade.php ENDPATH**/ ?>