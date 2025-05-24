

<?php $__env->startSection('forum-content'); ?>
    <?php echo $__env->make('forums.partials.posts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('forums.components.feed-layout', ['activeTab' => 'all'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\eduflow\resources\views/forums/index.blade.php ENDPATH**/ ?>