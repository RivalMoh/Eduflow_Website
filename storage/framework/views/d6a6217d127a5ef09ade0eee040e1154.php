<aside class="w-16 bg-white border-r border-gray-200 flex-shrink-0 overflow-y-auto flex flex-col" style="height: calc(100vh - 4rem);" x-data="{ activeLink: window.location.pathname === '/' ? 'home' : '' }">
    <div class="flex-1 overflow-y-auto py-6">
        <!-- Navigation -->
        <nav class="py-3">
            <div class="flex flex-col items-center space-y-2">
                <!-- Dashboard -->
                <a href="<?php echo e(route('home')); ?>" 
                   @click="activeLink = 'home'"
                   class="relative w-12 flex flex-col items-center group"
                   :class="{ 'text-indigo-600': activeLink === 'home', 'text-gray-500 hover:text-gray-700': activeLink !== 'home' }">
                    <div class="w-12 h-12 flex items-center justify-center">
                        <i class="fas fa-home text-xl"></i>
                    </div>
                    <div class="w-8 h-1 mt-1">
                        <span x-show="activeLink === 'home'" 
                              class="block w-full h-full bg-indigo-600 rounded-full">
                        </span>
                        <span x-show="activeLink !== 'home'" 
                              class="block w-0 h-full bg-indigo-600 rounded-full group-hover:w-full transition-all duration-200">
                        </span>
                    </div>
                </a>

                <!-- Discussions/Forums -->
                <a href="<?php echo e(route('forums.index')); ?>" 
                   @click="activeLink = 'discussions'"
                   class="relative w-12 flex flex-col items-center group"
                   :class="{ 'text-indigo-600': activeLink === 'discussions', 'text-gray-500 hover:text-gray-700': activeLink !== 'discussions' }"
                   :active="activeLink === 'discussions'">
                    <div class="w-12 h-12 flex items-center justify-center">
                        <i class="fas fa-comments text-xl"></i>
                    </div>
                    <div class="w-8 h-1 mt-1">
                        <span x-show="activeLink === 'discussions'" 
                              class="block w-full h-full bg-indigo-600 rounded-full">
                        </span>
                        <span x-show="activeLink !== 'discussions'" 
                              class="block w-0 h-full bg-indigo-600 rounded-full group-hover:w-full transition-all duration-200">
                        </span>
                    </div>
                </a>

                <!-- Tasks -->
                <a href="<?php echo e(route('tasks.index')); ?>" 
                   @click="activeLink = 'tasks'"
                   class="relative w-12 flex flex-col items-center group"
                   :class="{ 'text-indigo-600': activeLink === 'tasks', 'text-gray-500 hover:text-gray-700': activeLink !== 'tasks' }">
                    <div class="w-12 h-12 flex items-center justify-center">
                        <i class="fas fa-tasks text-xl"></i>
                    </div>
                    <div class="w-8 h-1 mt-1">
                        <span x-show="activeLink === 'tasks'" 
                              class="block w-full h-full bg-indigo-600 rounded-full">
                        </span>
                        <span x-show="activeLink !== 'tasks'" 
                              class="block w-0 h-full bg-indigo-600 rounded-full group-hover:w-full transition-all duration-200">
                        </span>
                    </div>
                </a>

                <!-- Materials 
                <a href="#" 
                   @click="activeLink = 'materials'"
                   class="relative w-12 flex flex-col items-center group"
                   :class="{ 'text-indigo-600': activeLink === 'materials', 'text-gray-500 hover:text-gray-700': activeLink !== 'materials' }">
                    <div class="w-12 h-12 flex items-center justify-center">
                        <i class="fas fa-book text-xl"></i>
                    </div>
                    <div class="w-8 h-1 mt-1">
                        <span x-show="activeLink === 'materials'" 
                              class="block w-full h-full bg-indigo-600 rounded-full">
                        </span>
                        <span x-show="activeLink !== 'materials'" 
                              class="block w-0 h-full bg-indigo-600 rounded-full group-hover:w-full transition-all duration-200">
                        </span>
                    </div>
                </a>-->

                <!-- Notes
                <a href="#" 
                   @click="activeLink = 'notes'"
                   class="relative w-12 flex flex-col items-center group"
                   :class="{ 'text-indigo-600': activeLink === 'notes', 'text-gray-500 hover:text-gray-700': activeLink !== 'notes' }">
                    <div class="w-12 h-12 flex items-center justify-center">
                        <i class="fas fa-sticky-note text-xl"></i>
                    </div>
                    <div class="w-8 h-1 mt-1">
                        <span x-show="activeLink === 'notes'" 
                              class="block w-full h-full bg-indigo-600 rounded-full">
                        </span>
                        <span x-show="activeLink !== 'notes'" 
                              class="block w-0 h-full bg-indigo-600 rounded-full group-hover:w-full transition-all duration-200">
                        </span>
                    </div>
                </a>-->

                <!-- Pomodoro Timer
                <a href="#" 
                   @click="activeLink = 'pomodoro'"
                   class="relative w-12 flex flex-col items-center group"
                   :class="{ 'text-indigo-600': activeLink === 'pomodoro', 'text-gray-500 hover:text-gray-700': activeLink !== 'pomodoro' }">
                    <div class="w-12 h-12 flex items-center justify-center">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <div class="w-8 h-1 mt-1">
                        <span x-show="activeLink === 'pomodoro'" 
                              class="block w-full h-full bg-indigo-600 rounded-full">
                        </span>
                        <span x-show="activeLink !== 'pomodoro'" 
                              class="block w-0 h-full bg-indigo-600 rounded-full group-hover:w-full transition-all duration-200">
                        </span>
                    </div>
                </a>-->
            </div>
        </nav>
    </div>
</aside>
<?php /**PATH C:\xampp\htdocs\eduflow\resources\views/layouts/partials/sidebar.blade.php ENDPATH**/ ?>