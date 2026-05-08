<?php require 'app/views/layout/header.php'; ?>

<div class="page-section">
    <h2>Transaction History</h2>

    <?php if (empty($txns)): ?>
        <p>No transactions yet.</p>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Buyer</th>
                    <th>Seller</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Date</th>
                    <?php if ($_SESSION['role'] === 'buyer'): ?>
                        <th>Rate</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($txns as $t): ?>
                <tr>
                    <td><?= $t['id'] ?></td>
                    <td><?= htmlspecialchars($t['item_title']) ?></td>
                    <td><?= htmlspecialchars($t['buyer_name']) ?></td>
                    <td><?= htmlspecialchars($t['seller_name']) ?></td>
                    <td>$<?= number_format($t['amount'], 2) ?></td>
                    <td><?= $t['type'] ?></td>
                    <td><?= $t['created_at'] ?></td>
                    <?php if ($_SESSION['role'] === 'buyer'): ?>
                        <td>
                            <?php if ($t['buyer_id'] == $_SESSION['user_id']): ?>
                                <a href="index.php?page=rate&txn_id=<?= $t['id'] ?>" class="btn btn-secondary">Rate</a>
                            <?php else: ?>
                                &mdash;
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php require 'app/views/layout/footer.php'; ?>
