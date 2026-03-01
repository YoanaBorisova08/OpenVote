<div class="form-with-errors">
    <h2 class="form__header">Make a suggestion!</h2>
    <form method="post" action="index.php?<?php echo http_build_query(['route' => 'create']) ?>" class="form">
        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

        <div class="form__element">
            <label for="title" class="form__label">Title:</label>
            <input type="text" name="title" id="title" class="form__input" required>
        </div>

        <div class="form__element">
            <label for="description" class="form__label">Description:</label>
            <textarea name="description" id="description" class="form__input form__text" required></textarea>
        </div>

        <input type="submit" class="form__submit" value="Suggest">
    </form>

    <?php if (!empty($loginError)): ?>
        <p class="login__error"><?php echo e($loginError); ?></p>
    <?php endif; ?>
</div>