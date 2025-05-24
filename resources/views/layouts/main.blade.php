<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EduFlow')</title>
    
    <!-- Google Fonts - Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- JavaScript Libraries -->
    <!-- jQuery (required for some Bootstrap functionality) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Tagify -->
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Alpine.js Script-->
    <script src="https://unpkg.com/alpinejs" defer></script>
    
    <style>
        :root {
            --primary: #4F46E5;
            --secondary: #F59E0B;
            --dark: #1F2937;
            --light: #F3F4F6;
            --gray: #9CA3AF;
            --dark-gray: #4B5563;
        }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            @apply bg-gray-50 text-gray-800 h-full;
        }
        
        #app {
            @apply flex h-screen overflow-hidden;
        }
        
        .content-wrapper {
            @apply flex-1 flex flex-col overflow-hidden;
        }
        
        .main-content {
            @apply flex-1 overflow-y-auto p-6 bg-gray-50;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            @apply bg-gray-100;
        }
        
        ::-webkit-scrollbar-thumb {
            @apply bg-gray-300 rounded-full;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            @apply bg-gray-400;
        }
    </style>

    <!-- Custom Scripts -->
    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Initialize popovers
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        });
    </script>
    
    @stack('styles')
</head>
<body class="h-full">
    <div id="app" class="flex flex-col h-screen overflow-hidden">
        <!-- Header -->
        <header class="bg-white border-b border-gray-200">
            @include('layouts.partials.header')
        </header>
        
        <div class="flex flex-1 overflow-hidden">
            <!-- Sidebar -->
            <aside class="h-full">
                @include('layouts.partials.sidebar')
            </aside>
            
            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <div class="p-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>
