<?php require 'app/views/layout/header.php'; ?>

<div class="page-section">
    <h2>Browse Listings</h2>

    <?php if (empty($items)): ?>
        <p>No items listed yet.</p>
    <?php else: ?>
        <div class="item-grid">
            <?php foreach ($items as $item): ?>
                <div class="item-card">
                    <?php if (!empty($item['image'])): ?>
                        <img src="public/uploads/<?php echo $item['image']; ?>" width="300">
                    <?php endif; ?>
                    <h3><?= htmlspecialchars($item['title']) ?></h3>
                    <p class="item-meta">Category: <?= htmlspecialchars($item['category']) ?></p>
                    <p class="item-meta">Seller: <?= htmlspecialchars($item['seller_name']) ?></p>
                    <p class="item-price">$<?= number_format($item['price'], 2) ?></p>
                    <a href="index.php?page=items&action=detail&id=<?= $item['id'] ?>" class="btn">View Details</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require 'app/views/layout/footer.php'; ?>
