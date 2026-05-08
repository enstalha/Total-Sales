<?php require 'app/views/layout/header.php'; ?>

<div class="page-section">
    <h2>My Listings</h2>

    <?php if (empty($my_items)): ?>
        <p>You haven't listed any items yet. <a href="index.php?page=items&action=add">Add one now</a>.</p>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Listed On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($my_items as $it): ?>
                <tr>
                    <td><a href="index.php?page=items&action=detail&id=<?= $it['id'] ?>"><?= htmlspecialchars($it['title']) ?></a></td>
                    <td><?= htmlspecialchars($it['category']) ?></td>
                    <td>$<?= number_format($it['price'], 2) ?></td>
                    <td><?= $it['status'] ?></td>
                    <td><?= $it['created_at'] ?></td>
                    <td>
                        <?php if ($it['status'] === 'available'): ?>
                            <a href="index.php?page=items&action=delete&id=<?= $it['id'] ?>"
                               onclick="return confirm('Delete this item?')" class="btn btn-danger">Delete</a>
                        <?php else: ?>
                            &mdash;
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php require 'app/views/layout/footer.php'; ?>
