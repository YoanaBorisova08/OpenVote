<div class="form-with-errors">
    <form method="post" action="index.php?<?php echo http_build_query(['route' => 'login']) ?>" class="form">
        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

        <div class="form__element">
            <label for="username" class="form__label">Username:</label>
            <input type="text" name="username" id="username" class="form__input" required value="<?php echo ($_POST['first_name'] ?? ''); ?>">
        </div>

        <div class="form__element">
            <label for="password" class="form__label">Password:</label>
            <input type="password" id="password" name="password" class="form__input" required>
        </div>

        <input type="submit" class="form__submit" value="Log In">
    </form>

    <a href="index.php?<?php echo http_build_query(['route' => 'register']) ?>" class="form__register-link">Register</a>
    <?php if (!empty($loginError)): ?>
        <p class="login__error">An error occured, the username and password combination could not be found.</p>
    <?php endif; ?>
</div>