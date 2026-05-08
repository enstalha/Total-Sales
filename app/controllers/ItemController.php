<?php
// ItemController.php

session_start();
require_once 'config/db.php';
require_once 'app/models/ItemModel.php';
require_once 'app/models/TransactionModel.php';

$action = $_GET['action'] ?? 'index';

if ($action === 'index') {
    $items = getAllItems($conn);
    require 'app/views/items/index.php';

} elseif ($action === 'detail') {
    $item_id = (int)($_GET['id'] ?? 0);
    $item = getItemById($conn, $item_id);

    if (!$item) {
        echo "Item not found.";
        exit;
    }

    require 'app/views/items/detail.php';

} elseif ($action === 'add') {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
        header("Location: index.php?page=login");
        exit;
    }

    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title    = trim($_POST['title'] ?? '');
        $desc     = trim($_POST['description'] ?? '');
        $price    = $_POST['price'] ?? '';
        $category = trim($_POST['category'] ?? '');

        if (empty($title) || empty($price)) {
            $error = "Title and price are required.";
        } elseif (!is_numeric($price) || $price <= 0) {
            $error = "Price must be a positive number.";
        } else {
            addItem($conn, $_SESSION['user_id'], $title, $desc, $price, $category);
            header("Location: index.php?page=items&action=my_listings");
            exit;
        }
    }

    require 'app/views/items/add.php';

} elseif ($action === 'delete') {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
        header("Location: index.php?page=login");
        exit;
    }

    $item_id = (int)($_GET['id'] ?? 0);
    deleteItem($conn, $item_id, $_SESSION['user_id']);
    header("Location: index.php?page=items&action=my_listings");
    exit;

} elseif ($action === 'buy') {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'buyer') {
        header("Location: index.php?page=login");
        exit;
    }

    $item_id = (int)($_GET['id'] ?? 0);
    $item = getItemById($conn, $item_id);

    if (!$item || $item['status'] !== 'available') {
        echo "Item not available.";
        exit;
    }

    // create transaction then mark sold
    $txn_id = createTransaction($conn, $item_id, $_SESSION['user_id'], $item['seller_id'], $item['price'], 'direct');
    markItemSold($conn, $item_id);

    header("Location: index.php?page=transactions");
    exit;

} elseif ($action === 'my_listings') {
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?page=login");
        exit;
    }

    $my_items = getItemsBySeller($conn, $_SESSION['user_id']);
    require 'app/views/items/my_listings.php';
}
