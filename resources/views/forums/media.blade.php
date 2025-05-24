@extends('forums.components.feed-layout', ['activeTab' => 'media'])

@push('styles')
<style>
    .media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }
    
    .media-item {
        position: relative;
        aspect-ratio: 1/1;
        border-radius: 0.5rem;
        overflow: hidden;
        display: block;
        transition: transform 0.2s ease-in-out;
    }
    
    .media-item:hover {
        transform: translateY(-4px);
    }
    
    .media-item img,
    .media-item .video-placeholder {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .media-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.8));
        color: white;
        padding: 1rem;
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
    }
    
    .media-item:hover .media-overlay {
        opacity: 1;
    }
    
    .video-placeholder {
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
    }
    
    .video-icon {
        font-size: 2rem;
    }
</style>
@endpush

@section('content')
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Media Posts</h2>
    
    <!-- Media Grid -->
    <div class="media-grid">
        @for($i = 1; $i <= 9; $i++)
        <a href="#" class="media-item group">
            @if($i % 3 === 0)
                <!-- Video placeholder with play icon -->
                <video class="video-placeholder" muted loop playsinline preload="auto">
                    <source src="#" type="video/mp4">
                    <div class="text-center">
                        <div class="video-icon mb-2">
                            <i class="fas fa-play-circle"></i>
                        </div>
                        <div class="text-sm">Video Content</div>
                    </div>
                </video>
            @else
                <img src="{{ asset('images/image_placeholder.jpg') }}" 
                     alt="Media {{ $i }}" 
                     loading="lazy"
                     class="w-full h-full object-cover">
            @endif
            <div class="media-overlay">
                <div class="font-medium">Post Title {{ $i }}</div>
                <div class="text-sm opacity-90">By User{{ $i }}</div>
            </div>
        </a>
        @endfor
    </div>
    
    <!-- Load More Button -->
    <div class="mt-8 text-center">
        <button class="bg-indigo-50 text-indigo-600 px-6 py-2 rounded-full font-medium hover:bg-indigo-100 transition">
            Load More Media
        </button>
    </div>
@endsection
