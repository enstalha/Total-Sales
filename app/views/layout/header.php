<?php
// header.php -- included at top of every view
// only start session if not already started by the controller
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TotalSales - Collectors Marketplace</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>

<header class="site-header">
    <div class="header-inner">
        <a href="index.php" class="logo">TotalSales</a>
        <nav>
            <a href="index.php">Home</a>
            <a href="index.php?page=items">Listings</a>
            <a href="index.php?page=auctions">Auctions</a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($_SESSION['role'] === 'seller'): ?>
                    <a href="index.php?page=items&action=add">Add Item</a>
                    <a href="index.php?page=items&action=my_listings">My Listings</a>
                    <a href="index.php?page=auctions&action=create">Create Auction</a>
                <?php endif; ?>
                <a href="index.php?page=transactions">Transactions</a>
                <a href="index.php?page=login&action=logout">Logout (<?= htmlspecialchars($_SESSION['username']) ?>)</a>
            <?php else: ?>
                <a href="index.php?page=login">Login</a>
                <a href="index.php?page=register">Register</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="main-content">
