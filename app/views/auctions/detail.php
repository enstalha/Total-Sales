<?php require 'app/views/layout/header.php'; ?>

<div class="page-section detail-page">
    <a href="index.php?page=auctions" class="back-link">&larr; Back to Auctions</a>

    <h2><?= htmlspecialchars($auction['title']) ?></h2>

    <table class="detail-table">
        <tr><th>Category</th><td><?= htmlspecialchars($auction['category']) ?></td></tr>
        <tr><th>Seller</th><td><?= htmlspecialchars($auction['seller_name']) ?></td></tr>
        <tr><th>Starting Price</th><td>$<?= number_format($auction['start_price'], 2) ?></td></tr>
        <tr><th>Current Bid</th>
            <td id="current-bid-display">
                <?php if ($auction['current_bid']): ?>
                    $<?= number_format($auction['current_bid'], 2) ?>
                <?php else: ?>
                    No bids yet
                <?php endif; ?>
            </td>
        </tr>
        <tr><th>Ends</th><td><?= $auction['end_time'] ?></td></tr>
        <tr><th>Status</th><td><?= $auction['status'] ?></td></tr>
    </table>

    <div class="item-description">
        <h4>Description</h4>
        <p><?= nl2br(htmlspecialchars($auction['description'])) ?></p>
    </div>

    <?php if ($auction['status'] === 'active'): ?>
        <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'buyer'): ?>

            <?php if ($error): ?>
                <p class="msg error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <?php if ($success): ?>
                <p class="msg success"><?= htmlspecialchars($success) ?></p>
            <?php endif; ?>

            <form method="POST" action="index.php?page=auctions&action=detail&id=<?= $auction['id'] ?>">
                <div class="form-group">
                    <label for="bid_amount">Your Bid ($)</label>
                    <input type="number" id="bid_amount" name="bid_amount" step="0.01" min="0.01">
                </div>
                <button type="submit" class="btn">Place Bid</button>
            </form>

            <!-- refresh bid without reload -->
            <p>
                <button id="refresh-bid-btn" class="btn btn-secondary">Refresh Current Bid</button>
            </p>

        <?php elseif (!isset($_SESSION['user_id'])): ?>
            <p><a href="index.php?page=login">Login</a> to place a bid.</p>
        <?php elseif ($_SESSION['role'] === 'seller'): ?>
            <p>Only buyers can bid on auctions.</p>
        <?php endif; ?>
    <?php else: ?>
        <p class="msg error">This auction has ended.</p>
    <?php endif; ?>

    <!-- bid history -->
    <?php if (!empty($bids)): ?>
        <h3>Bid History</h3>
        <table class="data-table">
            <thead>
                <tr><th>Bidder</th><th>Amount</th><th>Time</th></tr>
            </thead>
            <tbody>
                <?php foreach ($bids as $bid): ?>
                <tr>
                    <td><?= htmlspecialchars($bid['username']) ?></td>
                    <td>$<?= number_format($bid['amount'], 2) ?></td>
                    <td><?= $bid['bid_time'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<script>
    // pass auction id to ajax.js
    var currentAuctionId = <?= (int)$auction['id'] ?>;
</script>
<script src="public/js/ajax.js"></script>

<?php require 'app/views/layout/footer.php'; ?>
