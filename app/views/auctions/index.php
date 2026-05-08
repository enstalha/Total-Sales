<?php require 'app/views/layout/header.php'; ?>

<div class="page-section">
    <h2>Live Auctions</h2>

    <?php if (empty($auction_list)): ?>
        <p>No active auctions right now.</p>
    <?php else: ?>
        <div class="item-grid">
            <?php foreach ($auction_list as $auc): ?>
                <div class="item-card">
                    <h3><?= htmlspecialchars($auc['title']) ?></h3>
                    <p class="item-meta">Category: <?= htmlspecialchars($auc['category']) ?></p>
                    <p class="item-meta">Seller: <?= htmlspecialchars($auc['seller_name']) ?></p>
                    <p class="item-meta">Ends: <?= $auc['end_time'] ?></p>
                    <p class="item-price">
                        Current Bid:
                        <?php if ($auc['current_bid']): ?>
                            $<?= number_format($auc['current_bid'], 2) ?>
                        <?php else: ?>
                            Starting at $<?= number_format($auc['start_price'], 2) ?>
                        <?php endif; ?>
                    </p>
                    <a href="index.php?page=auctions&action=detail&id=<?= $auc['id'] ?>" class="btn">View Auction</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require 'app/views/layout/footer.php'; ?>
