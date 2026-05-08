<?php require 'app/views/layout/header.php'; ?>

<div class="form-page">
    <h2>Rate this Transaction</h2>

    <p>Transaction #<?= $txn['id'] ?> &mdash; Amount: $<?= number_format($txn['amount'], 2) ?></p>

    <?php if ($error): ?>
        <p class="msg error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p class="msg success"><?= htmlspecialchars($success) ?></p>
    <?php else: ?>

        <form method="POST" action="index.php?page=rate&txn_id=<?= $txn['id'] ?>">
            <div class="form-group">
                <label for="stars">Rating (1 to 5 stars)</label>
                <select name="stars" id="stars">
                    <option value="5">&#9733;&#9733;&#9733;&#9733;&#9733; (5 - Excellent)</option>
                    <option value="4">&#9733;&#9733;&#9733;&#9733; (4 - Good)</option>
                    <option value="3">&#9733;&#9733;&#9733; (3 - Okay)</option>
                    <option value="2">&#9733;&#9733; (2 - Poor)</option>
                    <option value="1">&#9733; (1 - Terrible)</option>
                </select>
            </div>
            <div class="form-group">
                <label for="comment">Comment (optional)</label>
                <textarea name="comment" id="comment" rows="4"></textarea>
            </div>
            <button type="submit" class="btn">Submit Rating</button>
        </form>

    <?php endif; ?>

    <p><a href="index.php?page=transactions">&larr; Back to Transactions</a></p>
</div>

<?php require 'app/views/layout/footer.php'; ?>
