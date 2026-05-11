<?php require 'app/views/layout/header.php'; ?>

<div class="form-page">
    <h2>Add New Item</h2>

    <?php if ($error): ?>
        <p class="msg error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?page=items&action=add" id="addItemForm" enctype="multipart/form-data" novalidate>
        <div class="form-group">
            <label for="title">Item Title</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price ($)</label>
            <input type="number" id="price" name="price" step="0.01" min="0.01"
                   value="<?= htmlspecialchars($_POST['price'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select id="category" name="category">
                <option value="">-- Select Category --</option>
                <option value="Coins">Coins</option>
                <option value="Stamps">Stamps</option>
                <option value="Cards">Trading Cards</option>
                <option value="Figures">Figures / Statues</option>
                <option value="Comics">Comics</option>
                <option value="Vintage">Vintage Items</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="form-group">
            <label for="item_image">Item Image</label>
            <input type="file" id="item_image" name="item_image">
        </div>
        <button type="submit" class="btn">Add Item</button>
    </form>
</div>

<script src="public/js/validation.js"></script>

<?php require 'app/views/layout/footer.php'; ?>
