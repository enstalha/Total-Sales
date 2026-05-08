<?php
// AuctionModel.php

function createAuction($conn, $item_id, $seller_id, $start_price, $end_time) {
    $item_id     = (int)$item_id;
    $seller_id   = (int)$seller_id;
    $start_price = (float)$start_price;
    $end_time    = mysqli_real_escape_string($conn, $end_time);

    $q = "INSERT INTO auctions (item_id, seller_id, start_price, end_time)
          VALUES ($item_id, $seller_id, $start_price, '$end_time')";
    return mysqli_query($conn, $q);
}

function getAllActiveAuctions($conn) {
    $res = mysqli_query($conn, "SELECT auctions.*, items.title, items.description, items.category,
                                       users.username as seller_name
                                FROM auctions
                                JOIN items ON auctions.item_id = items.id
                                JOIN users ON auctions.seller_id = users.id
                                WHERE auctions.status = 'active'
                                ORDER BY auctions.end_time ASC");
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

function getAuctionById($conn, $auction_id) {
    $auction_id = (int)$auction_id;
    $res = mysqli_query($conn, "SELECT auctions.*, items.title, items.description, items.category, items.status as item_status,
                                       users.username as seller_name
                                FROM auctions
                                JOIN items ON auctions.item_id = items.id
                                JOIN users ON auctions.seller_id = users.id
                                WHERE auctions.id = $auction_id LIMIT 1");
    return mysqli_fetch_assoc($res);
}

function placeBid($conn, $auction_id, $bidder_id, $amount) {
    $auction_id = (int)$auction_id;
    $bidder_id  = (int)$bidder_id;
    $amount     = (float)$amount;

    // insert bid record
    $q1 = "INSERT INTO bids (auction_id, bidder_id, amount) VALUES ($auction_id, $bidder_id, $amount)";
    mysqli_query($conn, $q1);

    // update current bid on auction -- not sure if this is the best way but it works
    $q2 = "UPDATE auctions SET current_bid=$amount, highest_bidder_id=$bidder_id WHERE id=$auction_id";
    return mysqli_query($conn, $q2);
}

function getCurrentBid($conn, $auction_id) {
    $auction_id = (int)$auction_id;
    $res = mysqli_query($conn, "SELECT current_bid, highest_bidder_id FROM auctions WHERE id=$auction_id");
    return mysqli_fetch_assoc($res);
}

function endAuction($conn, $auction_id) {
    $auction_id = (int)$auction_id;
    return mysqli_query($conn, "UPDATE auctions SET status='ended' WHERE id=$auction_id");
}

function getBidsByAuction($conn, $auction_id) {
    $auction_id = (int)$auction_id;
    $res = mysqli_query($conn, "SELECT bids.*, users.username
                                FROM bids
                                JOIN users ON bids.bidder_id = users.id
                                WHERE bids.auction_id = $auction_id
                                ORDER BY bids.amount DESC");
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}
