<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'EduFlow'); ?></title>
    
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background-color: #f9fafb;
        }
        .auth-card {
            width: 100%;
            max-width: 28rem;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 2.5rem;
        }
        .auth-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .auth-logo i {
            font-size: 2.5rem;
            color: #4f46e5;
            margin-bottom: 1rem;
        }
        .auth-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #111827;
            text-align: center;
            margin-bottom: 0.5rem;
        }
        .auth-subtitle {
            color: #6b7280;
            text-align: center;
            margin-bottom: 2rem;
        }
    </style>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="antialiased">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-logo">
                <i class="fas fa-graduation-cap"></i>
                <h1 class="text-2xl font-bold text-gray-900">EduFlow</h1>
            </div>
            
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\eduflow\resources\views/layouts/auth.blade.php ENDPATH**/ ?>