<?php
// index.php -- front controller
// reads $_GET['page'] and routes to the right controller

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home':
        // just show the homepage view directly
        if (session_status() === PHP_SESSION_NONE) session_start();
        require 'app/views/layout/header.php';
        ?>
        <div class="home-hero">
            <h1>Welcome to TotalSales</h1>
            <p class="hero-sub">A marketplace built for collectors. Buy, sell, trade, and auction your collectibles.</p>
            <div class="hero-links">
                <a href="index.php?page=items" class="btn">Browse Listings</a>
                <a href="index.php?page=auctions" class="btn btn-secondary">Live Auctions</a>
            </div>
        </div>

        <div class="home-features">
            <div class="feature-box">
                <h3>List Your Items</h3>
                <p>Sellers can list coins, stamps, cards, figures, and more. Set your own price and manage your inventory.</p>
            </div>
            <div class="feature-box">
                <h3>Bid in Auctions</h3>
                <p>Join live auctions. Place bids and win collectibles from sellers around the community.</p>
            </div>
            <div class="feature-box">
                <h3>Trusted Ratings</h3>
                <p>Rate sellers after every purchase. Build trust in the community with transparent feedback.</p>
            </div>
        </div>
        <?php
        require 'app/views/layout/footer.php';
        break;

    case 'login':
        require 'app/controllers/AuthController.php';
        break;

    case 'register':
        $_GET['action'] = 'register';
        require 'app/controllers/AuthController.php';
        break;

    case 'items':
        require 'app/controllers/ItemController.php';
        break;

    case 'auctions':
        require 'app/controllers/AuctionController.php';
        break;

    case 'transactions':
        require 'app/controllers/TransactionController.php';
        break;

    case 'rate':
        require 'app/controllers/RatingController.php';
        break;

    // AJAX endpoint -- check username availability
    case 'check_username':
        require_once 'config/db.php';
        require_once 'app/models/UserModel.php';
        $uname = $_GET['username'] ?? '';
        $taken = usernameExists($conn, $uname);
        header('Content-Type: application/json');
        echo json_encode(['taken' => $taken]);
        exit;

    // AJAX endpoint -- get current bid for auction
    case 'get_bid':
        require_once 'config/db.php';
        require_once 'app/models/AuctionModel.php';
        $aid = (int)($_GET['auction_id'] ?? 0);
        $bidData = getCurrentBid($conn, $aid);
        header('Content-Type: application/json');
        echo json_encode($bidData);
        exit;

    default:
        if (session_status() === PHP_SESSION_NONE) session_start();
        require 'app/views/layout/header.php';
        echo '<div class="page-section"><h2>404 - Page not found</h2></div>';
        require 'app/views/layout/footer.php';
        break;
}
