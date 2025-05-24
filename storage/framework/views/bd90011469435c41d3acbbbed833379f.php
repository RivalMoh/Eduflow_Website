<?php $__env->startSection('title', 'Sign In - EduFlow'); ?>

<?php $__env->startSection('content'); ?>
    <h2 class="auth-title">Welcome back</h2>
    <p class="auth-subtitle">Please sign in to your account</p>

    <?php if($errors->any()): ?>
        <div class="mb-4 p-4 bg-red-50 text-red-600 rounded-lg text-sm">
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-4">
        <?php echo csrf_field(); ?>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                   placeholder="you@example.com" required autofocus>
        </div>

        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <?php if(Route::has('password.request')): ?>
                    <a href="<?php echo e(route('password.request')); ?>" class="text-sm text-indigo-600 hover:text-indigo-500">
                        Forgot password?
                    </a>
                <?php endif; ?>
            </div>
            <input id="password" type="password" name="password" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                   placeholder="••••••••" required>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox" 
                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-700">
                    Remember me
                </label>
            </div>
        </div>


        <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-indigo-700 transition-colors">
            Sign In
        </button>
    </form>

    <div class="mt-6 text-center text-sm text-gray-600">
        Don't have an account?
        <a href="<?php echo e(route('register')); ?>" class="font-medium text-indigo-600 hover:text-indigo-500">
            Sign up
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\eduflow\resources\views/auth/login.blade.php ENDPATH**/ ?>