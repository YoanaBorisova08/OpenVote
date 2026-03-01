<div class="form-with-errors">
    <h2 class="form__header">Edit the suggestion</h2>
    <form method="post" action="index.php?<?php echo http_build_query(['route' => 'adminEdit', 'id' => $suggestion->id]) ?>" class="form">
        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

        <div class="form__element">
            <label for="title" class="form__label">Title:</label>
            <input type="text" name="title" id="title" class="form__input" value="<?php echo e($suggestion->title); ?>" required>
        </div>

        <div class="form__element">
            <label for="description" class="form__label">Description:</label>
            <textarea name="description" id="description" class="form__input form__text" required><?php echo e($suggestion->description); ?></textarea>
        </div>

        <div class="form__element">
            <label for="status" class="form__label">Status:</label>
            <select class="forum__extra-select" name="status" id="status">
                <?php foreach($statusOptions as $o): ?>
                    <option class="forum__extra-option" value="<?php echo e($o);?>"><?php echo e($o);?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <input type="submit" class="form__submit" value="Edit">
    </form>
</div>