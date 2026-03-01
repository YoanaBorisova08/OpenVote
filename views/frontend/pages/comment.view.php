<form method="post" action="index.php?<?php echo http_build_query(['route' => 'addComment', 'id' => $id]) ?>">
        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

        <div class="comment-form">
            <input type="text" name="comment" class="comment-form__input" required>
            <input type="submit" class="comment-form__submit" value="➤">
        </div>

</form>