<?php require 'app/views/layout/header.php'; ?>

<div class="form-page">
    <h2>Create Account</h2>

    <?php if ($error): ?>
        <p class="msg error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p class="msg success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?page=register" id="registerForm" novalidate>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            <span id="username-feedback" class="feedback-msg"></span>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </div>
        <div class="form-group">
            <label for="role">Register as</label>
            <select id="role" name="role">
                <option value="buyer" <?= (($_POST['role'] ?? '') === 'buyer') ? 'selected' : '' ?>>Buyer</option>
                <option value="seller" <?= (($_POST['role'] ?? '') === 'seller') ? 'selected' : '' ?>>Seller</option>
            </select>
        </div>
        <button type="submit" class="btn">Register</button>
    </form>

    <p>Already have an account? <a href="index.php?page=login">Login</a></p>
</div>

<script src="public/js/validation.js"></script>
<script src="public/js/ajax.js"></script>

<?php require 'app/views/layout/footer.php'; ?>
