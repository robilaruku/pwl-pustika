<?php
// Get error message from query parameters
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
?>
<?php \Core\View::startSection('title'); ?>
Login Page
<?php \Core\View::endSection(); ?>

<?php \Core\View::startSection('content'); ?>
<div class="login-container">
    <div class="login-form">
        <h1>Sign In</h1>
        <?php if (isset($error)): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <br>
        <form action="/auth/login" method="POST">
            <input type="hidden" name="_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</div>
<?php \Core\View::endSection(); ?>