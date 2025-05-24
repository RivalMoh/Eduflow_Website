<!-- Create Post Modal -->
<div id="createPostModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-2xl mx-auto overflow-hidden transform transition-all">
        <div class="p-5 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold">Create Post</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <div class="p-5">
            <div class="flex items-start space-x-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-medium flex-shrink-0">
                    {{ strtoupper(substr(Auth::check() ? Auth::user()->name : 'Y', 0, 1)) }}
                </div>
                <div class="flex-1">
                    <textarea rows="4" 
                        class="w-full border-0 focus:ring-0 resize-none text-gray-800 placeholder-gray-400 text-base" 
                        placeholder="What's on your mind?"></textarea>
                </div>
            </div>
            
            <!-- Media Preview -->
            <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center mb-4">
                <i class="fas fa-image text-3xl text-gray-300 mb-2"></i>
                <p class="text-sm text-gray-500">Drag photos or videos here, or click to browse</p>
                <input type="file" class="hidden" id="media-upload" multiple>
            </div>
            
            <!-- Post Actions -->
            <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                <div class="flex space-x-2">
                    <button type="button" class="w-10 h-10 rounded-full text-gray-500 hover:bg-gray-100 flex items-center justify-center">
                        <i class="far fa-image"></i>
                    </button>
                    <button type="button" class="w-10 h-10 rounded-full text-gray-500 hover:bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-link"></i>
                    </button>
                    <button type="button" class="w-10 h-10 rounded-full text-gray-500 hover:bg-gray-100 flex items-center justify-center">
                        <i class="far fa-smile"></i>
                    </button>
                </div>
                <button type="button" class="bg-indigo-600 text-white px-6 py-2 rounded-full font-medium hover:bg-indigo-700 transition">
                    Post
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Forum Sidebar Component -->
<div class="space-y-6 py-6">
    <!-- Create Post Card -->
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-medium">
                {{ strtoupper(substr(Auth::check() ? Auth::user()->name : 'Y', 0, 1)) }}
            </div>
            <button 
                class="flex-1 text-left text-gray-500 bg-gray-50 rounded-full px-4 py-2 hover:bg-gray-100 transition text-sm"
                onclick="openModal()">
                What's on your mind?
            </button>
        </div>
    </div>
    
    <!-- About Community -->
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <h3 class="font-semibold text-gray-800 mb-3">About Community</h3>
        <p class="text-gray-600 text-sm mb-4">
            A community for web developers to share knowledge, ask questions, and collaborate on projects. 
            All skill levels are welcome! Discuss frameworks, tools, best practices, and stay updated with 
            the latest in web development.
        </p>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Created</span>
                <span class="font-medium">Jan 1, 2023</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Rules</span>
                <a href="#" class="text-indigo-600 hover:underline font-medium">View</a>
            </div>
        </div>
    </div>
    
    <!-- Online Members -->
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-800">Online Members</h3>
            <span class="text-sm text-indigo-600 font-medium">1,234 online</span>
        </div>
        <div class="flex flex-wrap -mx-1">
            @for($i = 1; $i <= 10; $i++)
                <div class="w-8 h-8 m-1 rounded-full bg-gray-100 overflow-hidden transform transition-transform hover:scale-110" 
                     data-tooltip="User {{ $i }}">
                    <img src="https://i.pravatar.cc/100?img={{ $i }}" 
                         alt="User" 
                         class="w-full h-full object-cover">
                    <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                </div>
            @endfor
        </div>
    </div>
    
    <!-- Trending Topics -->
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <h3 class="font-semibold text-gray-800 mb-4">Trending Topics</h3>
        <div class="space-y-3">
            @foreach(['#laravel', '#vuejs', '#react', '#tailwindcss', '#javascript'] as $topic)
                <a href="#" class="block px-3 py-2 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                    <div class="font-medium text-gray-800">{{ $topic }}</div>
                    <div class="text-xs text-gray-500">{{ rand(100, 1000) }} posts</div>
                </a>
            @endforeach
        </div>
    </div>
    
    <!-- Community Guidelines -->
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <h3 class="font-semibold text-gray-800 mb-3">Community Guidelines</h3>
        <ul class="space-y-2 text-sm text-gray-600">
            <li class="flex items-start">
                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                <span>Be respectful to others</span>
            </li>
            <li class="flex items-start">
                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                <span>No spam or self-promotion</span>
            </li>
            <li class="flex items-start">
                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                <span>Keep discussions on topic</span>
            </li>
            <li class="flex items-start">
                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                <span>No NSFW content</span>
            </li>
        </ul>
        <a href="#" class="inline-block mt-3 text-sm text-indigo-600 hover:underline font-medium">
            Read full guidelines
        </a>
    </div>
</div>

@push('styles')
<style>
    [data-tooltip] {
        position: relative;
        cursor: pointer;
    }
    
    [data-tooltip]:hover::before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%) translateY(-5px);
        background-color: #1F2937;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        z-index: 10;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s ease;
    }
    
    [data-tooltip]:hover::after {
        content: '';
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%) translateY(-10px);
        border-width: 5px;
        border-style: solid;
        border-color: #1F2937 transparent transparent transparent;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s ease;
    }
    
    [data-tooltip]:hover::before,
    [data-tooltip]:hover::after {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(0);
    }
</style>
@endpush

@push('scripts')
<script>
    function openModal() {
        const modal = document.getElementById('createPostModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        document.addEventListener('keydown', handleEscape);
    }

    function closeModal() {
        const modal = document.getElementById('createPostModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.removeEventListener('keydown', handleEscape);
    }

    function handleEscape(event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    }

    // Close modal when clicking outside
    document.getElementById('createPostModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeModal();
        }
    });
</script>
@endpush
