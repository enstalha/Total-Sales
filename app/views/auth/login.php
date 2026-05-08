<?php require 'app/views/layout/header.php'; ?>

<div class="form-page">
    <h2>Login</h2>

    <?php if ($error): ?>
        <p class="msg error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?page=login" id="loginForm" novalidate>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </div>
        <button type="submit" class="btn">Login</button>
    </form>

    <p>Don't have an account? <a href="index.php?page=register">Register here</a></p>
</div>

<script src="public/js/validation.js"></script>

<?php require 'app/views/layout/footer.php'; ?>
