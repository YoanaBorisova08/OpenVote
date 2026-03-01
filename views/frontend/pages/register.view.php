<div class="form-with-errors">
    <form method="post" action="index.php?<?php echo http_build_query(['route' => 'register']) ?>" class="form">
        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

        <div class="form__element">
            <label for="first_name" class="form__label">First name:</label>
            <input type="text" name="first_name" id="first_name" class="form__input" required value="<?php echo ($_POST['first_name'] ?? ''); ?>">
        </div>

        <div class="form__element">
            <label for="last_name" class="form__label">Last name:</label>
            <input type="text" name="last_name" id="last_name" class="form__input" required value="<?php echo ($_POST['last_name'] ?? ''); ?>">
        </div>

        <div class="form__element">
            <label for="email" class="form__label">Email:</label>
            <input type="email" name="email" id="email" class="form__input" value="<?php echo ($_POST['email'] ?? ''); ?>">
        </div>

        <div class="form__element">
            <label for="username" class="form__label">Username:</label>
            <input type="text" name="username" id="username" class="form__input" required value="<?php echo ($_POST['username'] ?? ''); ?>">
        </div>

        <div class="form__element">
            <label for="password" class="form__label">Password:</label>
            <input type="password" id="password" name="password" class="form__input" required>
        </div>

        <input type="submit" class="form__submit" value="Register">
    </form>

    <a href="index.php?<?php echo http_build_query(['route' => 'login']) ?>" class="form__register-link">Log In</a>
    <?php if (!empty($loginError)): ?>
        <p class="login__error"><?php echo e($loginError); ?></p>
    <?php endif; ?>
</div>