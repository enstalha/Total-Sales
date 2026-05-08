<?php
// RatingController.php

session_start();
require_once 'config/db.php';
require_once 'app/models/RatingModel.php';
require_once 'app/models/TransactionModel.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'buyer') {
    header("Location: index.php?page=login");
    exit;
}

$txn_id = (int)($_GET['txn_id'] ?? 0);
$txn = getTransactionById($conn, $txn_id);

// make sure this transaction belongs to this buyer
if (!$txn || $txn['buyer_id'] != $_SESSION['user_id']) {
    echo "Invalid transaction.";
    exit;
}

$error = '';
$success = '';

if (alreadyRated($conn, $txn_id)) {
    $success = "You already rated this transaction.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($success)) {
    $stars   = (int)($_POST['stars'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');

    if ($stars < 1 || $stars > 5) {
        $error = "Please select a rating between 1 and 5.";
    } else {
        addRating($conn, $txn_id, $_SESSION['user_id'], $txn['seller_id'], $stars, $comment);
        $success = "Rating submitted. Thank you!";
    }
}

require 'app/views/user/rate.php';
