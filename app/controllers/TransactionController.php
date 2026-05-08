<?php
// TransactionController.php

session_start();
require_once 'config/db.php';
require_once 'app/models/TransactionModel.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?page=login");
    exit;
}

$user_id = $_SESSION['user_id'];
$txns = getTransactionsByUser($conn, $user_id);

require 'app/views/user/transactions.php';
