<?php
// AuctionController.php

session_start();
require_once 'config/db.php';
require_once 'app/models/AuctionModel.php';
require_once 'app/models/ItemModel.php';
require_once 'app/models/TransactionModel.php';

$action = $_GET['action'] ?? 'index';

if ($action === 'index') {
    $auction_list = getAllActiveAuctions($conn);
    require 'app/views/auctions/index.php';

} elseif ($action === 'create') {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
        header("Location: index.php?page=login");
        exit;
    }

    $error = '';
    // get seller's available items to pick from
    $my_items = getItemsBySeller($conn, $_SESSION['user_id']);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $item_id     = (int)($_POST['item_id'] ?? 0);
        $start_price = (float)($_POST['start_price'] ?? 0);
        $end_time    = $_POST['end_time'] ?? '';

        if (!$item_id || !$start_price || !$end_time) {
            $error = "All fields are required.";
        } else {
            createAuction($conn, $item_id, $_SESSION['user_id'], $start_price, $end_time);
            header("Location: index.php?page=auctions");
            exit;
        }
    }

    require 'app/views/auctions/create.php';

} elseif ($action === 'detail') {
    $auction_id = (int)($_GET['id'] ?? 0);
    $auction = getAuctionById($conn, $auction_id);

    if (!$auction) {
        echo "Auction not found.";
        exit;
    }

    $bids = getBidsByAuction($conn, $auction_id);
    $error = '';
    $success = '';

    // check if auction ended by time -- buraya bir daha bak
    if (strtotime($auction['end_time']) < time() && $auction['status'] === 'active') {
        endAuction($conn, $auction_id);

        // if someone bid, record the transaction
        if ($auction['highest_bidder_id'] && $auction['current_bid']) {
            createTransaction($conn, $auction['item_id'], $auction['highest_bidder_id'],
                              $auction['seller_id'], $auction['current_bid'], 'auction');
            markItemSold($conn, $auction['item_id']);
        }

        $auction['status'] = 'ended'; // update locally too
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
        if ($_SESSION['role'] !== 'buyer') {
            $error = "Only buyers can place bids.";
        } else {
            $bid_amount = (float)($_POST['bid_amount'] ?? 0);
            $min_bid = $auction['current_bid'] ? $auction['current_bid'] + 0.01 : $auction['start_price'];

            if ($bid_amount < $min_bid) {
                $error = "Bid must be at least $" . number_format($min_bid, 2);
            } elseif ($auction['status'] !== 'active') {
                $error = "This auction has ended.";
            } else {
                placeBid($conn, $auction_id, $_SESSION['user_id'], $bid_amount);
                $success = "Bid placed!";
                // refresh auction data
                $auction = getAuctionById($conn, $auction_id);
                $bids = getBidsByAuction($conn, $auction_id);
            }
        }
    }

    require 'app/views/auctions/detail.php';
}
