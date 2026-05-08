<?php require 'app/views/layout/header.php'; ?>

<div class="form-page">
    <h2>Create Auction</h2>

    <?php if ($error): ?>
        <p class="msg error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (empty($my_items)): ?>
        <p>You have no available items to auction. <a href="index.php?page=items&action=add">Add an item first</a>.</p>
    <?php else: ?>
        <form method="POST" action="index.php?page=auctions&action=create">
            <div class="form-group">
                <label for="item_id">Select Item</label>
                <select name="item_id" id="item_id">
                    <?php foreach ($my_items as $it): ?>
                        <?php if ($it['status'] === 'available'): ?>
                            <option value="<?= $it['id'] ?>"><?= htmlspecialchars($it['title']) ?> ($<?= number_format($it['price'], 2) ?>)</option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="start_price">Starting Price ($)</label>
                <input type="number" id="start_price" name="start_price" step="0.01" min="0.01">
            </div>
            <div class="form-group">
                <label for="end_time">Auction End Date &amp; Time</label>
                <input type="datetime-local" id="end_time" name="end_time">
            </div>
            <button type="submit" class="btn">Create Auction</button>
        </form>
    <?php endif; ?>
</div>

<?php require 'app/views/layout/footer.php'; ?>
