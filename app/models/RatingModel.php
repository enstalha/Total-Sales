<?php
// RatingModel.php

function addRating($conn, $transaction_id, $buyer_id, $seller_id, $stars, $comment) {
    $transaction_id = (int)$transaction_id;
    $buyer_id       = (int)$buyer_id;
    $seller_id      = (int)$seller_id;
    $stars          = (int)$stars;
    $comment        = mysqli_real_escape_string($conn, $comment);

    $q = "INSERT INTO ratings (transaction_id, buyer_id, seller_id, stars, comment)
          VALUES ($transaction_id, $buyer_id, $seller_id, $stars, '$comment')";
    return mysqli_query($conn, $q);
}

function getRatingsBySeller($conn, $seller_id) {
    $seller_id = (int)$seller_id;
    $res = mysqli_query($conn, "SELECT ratings.*, users.username as buyer_name
                                FROM ratings
                                JOIN users ON ratings.buyer_id = users.id
                                WHERE ratings.seller_id = $seller_id
                                ORDER BY ratings.created_at DESC");
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

function getAvgRating($conn, $seller_id) {
    $seller_id = (int)$seller_id;
    $res = mysqli_query($conn, "SELECT AVG(stars) as avg_stars, COUNT(*) as total FROM ratings WHERE seller_id = $seller_id");
    return mysqli_fetch_assoc($res);
}

// check if buyer already rated this transaction
function alreadyRated($conn, $transaction_id) {
    $transaction_id = (int)$transaction_id;
    $res = mysqli_query($conn, "SELECT id FROM ratings WHERE transaction_id = $transaction_id");
    return mysqli_num_rows($res) > 0;
}
