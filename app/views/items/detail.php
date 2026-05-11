<?php require 'app/views/layout/header.php'; ?>

<div class="page-section detail-page">
    <a href="index.php?page=items" class="back-link">&larr; Back to Listings</a>

    <h2><?= htmlspecialchars($item['title']) ?></h2>

    <?php if (!empty($item['image'])): ?>
        <img src="public/uploads/<?php echo $item['image']; ?>" width="300">
    <?php endif; ?>

    <table class="detail-table">
        <tr><th>Category</th><td><?= htmlspecialchars($item['category']) ?></td></tr>
        <tr><th>Seller</th><td><?= htmlspecialchars($item['seller_name']) ?></td></tr>
        <tr><th>Price</th><td>$<?= number_format($item['price'], 2) ?></td></tr>
        <tr><th>Status</th><td><?= $item['status'] ?></td></tr>
    </table>

    <div class="item-description">
        <h4>Description</h4>
        <p><?= nl2br(htmlspecialchars($item['description'])) ?></p>
    </div>

    <?php if ($item['status'] === 'available'): ?>
        <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'buyer'): ?>
            <a href="index.php?page=items&action=buy&id=<?= $item['id'] ?>" class="btn"
               onclick="return confirm('Confirm purchase for $<?= number_format($item['price'], 2) ?>?')">
                Buy Now
            </a>
        <?php elseif (!isset($_SESSION['user_id'])): ?>
            <p><a href="index.php?page=login">Login</a> to purchase this item.</p>
        <?php endif; ?>
    <?php else: ?>
        <p class="msg error">This item has been sold.</p>
    <?php endif; ?>
</div>

<?php require 'app/views/layout/footer.php'; ?>
