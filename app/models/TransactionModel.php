<?php
// TransactionModel.php

function createTransaction($conn, $item_id, $buyer_id, $seller_id, $amount, $type = 'direct') {
    $item_id   = (int)$item_id;
    $buyer_id  = (int)$buyer_id;
    $seller_id = (int)$seller_id;
    $amount    = (float)$amount;
    $type      = mysqli_real_escape_string($conn, $type);

    $q = "INSERT INTO transactions (item_id, buyer_id, seller_id, amount, type)
          VALUES ($item_id, $buyer_id, $seller_id, $amount, '$type')";
    mysqli_query($conn, $q);
    return mysqli_insert_id($conn);
}

function getTransactionsByUser($conn, $user_id) {
    $user_id = (int)$user_id;
    // get both buy and sell transactions
    $res = mysqli_query($conn, "SELECT transactions.*,
                                       items.title as item_title,
                                       b.username as buyer_name,
                                       s.username as seller_name
                                FROM transactions
                                JOIN items ON transactions.item_id = items.id
                                JOIN users b ON transactions.buyer_id = b.id
                                JOIN users s ON transactions.seller_id = s.id
                                WHERE transactions.buyer_id = $user_id OR transactions.seller_id = $user_id
                                ORDER BY transactions.created_at DESC");
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

function getTransactionById($conn, $txn_id) {
    $txn_id = (int)$txn_id;
    $res = mysqli_query($conn, "SELECT * FROM transactions WHERE id = $txn_id LIMIT 1");
    return mysqli_fetch_assoc($res);
}
