<div class="form-with-errors">
    <h2 class="form__header">Edit your suggestion</h2>
    <form method="post" action="index.php?<?php echo http_build_query(['route' => 'edit', 'id' => $suggestion->id]) ?>" class="form">
        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

        <div class="form__element">
            <label for="title" class="form__label">Title:</label>
            <input type="text" name="title" id="title" class="form__input" value="<?php echo e($suggestion->title); ?>" required>
        </div>

        <div class="form__element">
            <label for="description" class="form__label">Description:</label>
            <textarea name="description" id="description" class="form__input form__text" required><?php echo e($suggestion->description); ?></textarea>
        </div>

        <input type="submit" class="form__submit" value="Edit">
    </form>
</div>