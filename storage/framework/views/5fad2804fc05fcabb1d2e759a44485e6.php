<div class="flex items-center justify-between h-16 px-6">
    <!-- Left: Logo -->
    <div class="flex items-center">
        <a href="<?php echo e(route('home')); ?>" class="flex items-center">
            <img src="<?php echo e(asset('images/icons/EduFlow-text-black-svg.png')); ?>" alt="X" class="h-8 w-auto">
        </a>
    </div>
    
    <!-- Center: Search -->
    <div class="hidden md:flex items-center justify-center flex-1 max-w-2xl mx-4">
        <div class="relative w-full max-w-xl">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <i class="fas fa-search text-gray-400"></i>
            </span>
            <input 
                type="text" 
                placeholder="Search for discussions, materials, or users..." 
                class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
            >
        </div>
    </div>
        
        <!-- Right: User Controls -->
        <div class="flex items-center space-x-4">
            <!-- Language Selector -->
            <div class="relative" x-data="{ open: false }">
                <button 
                    @click="open = !open"
                    class="flex items-center space-x-1 text-gray-600 hover:text-gray-800 focus:outline-none"
                >
                    <i class="fas fa-globe"></i>
                    <span class="hidden md:inline">EN</span>
                    <i class="fas fa-chevron-down text-xs"></i>
                </button>
                
                <!-- Language Dropdown -->
                <div 
                    x-show="open" 
                    @click.away="open = false"
                    class="absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg py-1 z-50"
                    style="display: none;"
                >
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">English</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Bahasa</a>
                </div>
            </div>
            
            <!-- Auth Buttons / User Menu -->
            <?php if(auth()->guard()->check()): ?>
                <!-- User Dropdown -->
                <div class="relative ml-4" x-data="{ open: false }">
                    <button 
                        @click="open = !open"
                        class="flex items-center space-x-2 focus:outline-none hover:bg-gray-100 px-3 py-1.5 rounded-full transition-colors duration-200"
                    >
                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-medium overflow-hidden flex-shrink-0">
                            <?php if(auth()->user()->profile_photo_path): ?>
                                <img src="<?php echo e(auth()->user()->profile_photo_path); ?>" alt="<?php echo e(auth()->user()->name); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                            <?php endif; ?>
                        </div>
                        <div class="hidden md:flex flex-col items-start">
                            <span class="text-sm font-medium text-gray-900"><?php echo e(auth()->user()->name); ?></span>
                            <span class="text-xs text-gray-500">Free Plan</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div 
                        x-show="open" 
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        @click.away="open = false"
                        class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg py-1 z-50 ring-1 ring-black ring-opacity-5 focus:outline-none"
                        style="display: none;"
                    >
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm text-gray-900 font-medium"><?php echo e(auth()->user()->name); ?></p>
                            <p class="text-sm text-gray-500 truncate"><?php echo e(auth()->user()->email); ?></p>
                        </div>
                        <div class="py-1">
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-3 text-gray-400 w-5"></i>
                                <span>Your Profile</span>
                            </a>
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-3 text-gray-400 w-5"></i>
                                <span>Settings</span>
                            </a>
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-credit-card mr-3 text-gray-400 w-5"></i>
                                <span>Billing</span>
                            </a>
                        </div>
                        <div class="py-1 border-t border-gray-100">
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full text-left flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-3 text-gray-400 w-5"></i>
                                    <span><?php echo e(__('Sign out')); ?></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Login/Register Buttons -->
                <div class="flex items-center space-x-2">
                    <a href="<?php echo e(route('login')); ?>" class="px-3 py-1.5 text-sm font-medium text-gray-700 hover:text-indigo-600">
                        <?php echo e(__('Log in')); ?>

                    </a>
                    <a href="<?php echo e(route('register')); ?>" class="px-3 py-1.5 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                        <?php echo e(__('Sign up')); ?>

                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- Mobile Search (Hidden on larger screens) -->
<div class="md:hidden bg-white px-4 py-2 border-b border-gray-200">
    <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
            <i class="fas fa-search text-gray-400"></i>
        </span>
        <input 
            type="text" 
            placeholder="Search..." 
            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
        >
    </div>
</div><?php /**PATH C:\xampp\htdocs\eduflow\resources\views/layouts/partials/header.blade.php ENDPATH**/ ?>