<div class="confirm-box">
    <h2 class="delete-msg">Are you sure you want to delete this suggestion?</h2>
    <p class="delete-title"><strong><?php echo e($suggestion->title); ?></strong></p>
    <form method="post" class="delete-form" action="index.php?<?php echo http_build_query(['route' => 'delete', 'id' => $suggestion->id]); ?>">
        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
        <button class="delete-btn" type="submit" name="confirm" value="yes">Yes, delete</button>
        <button class="delete-btn" type="submit" name="confirm" value="no">Cancel</button>
    </form>
</div>