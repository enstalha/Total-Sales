<?php
// ItemModel.php

function getAllItems($conn) {
    $result = mysqli_query($conn, "SELECT items.*, users.username as seller_name
                                   FROM items
                                   JOIN users ON items.seller_id = users.id
                                   WHERE items.status = 'available'
                                   ORDER BY items.created_at DESC");
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getItemById($conn, $id) {
    $id = (int)$id;
    $res = mysqli_query($conn, "SELECT items.*, users.username as seller_name
                                FROM items
                                JOIN users ON items.seller_id = users.id
                                WHERE items.id = $id LIMIT 1");
    return mysqli_fetch_assoc($res);
}

function getItemsBySeller($conn, $seller_id) {
    $seller_id = (int)$seller_id;
    $res = mysqli_query($conn, "SELECT * FROM items WHERE seller_id = $seller_id ORDER BY created_at DESC");
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

function addItem($conn, $seller_id, $title, $desc, $price, $category) {
    $seller_id = (int)$seller_id;
    $title     = mysqli_real_escape_string($conn, $title);
    $desc      = mysqli_real_escape_string($conn, $desc);
    $price     = (float)$price;
    $category  = mysqli_real_escape_string($conn, $category);

    $q = "INSERT INTO items (seller_id, title, description, price, category)
          VALUES ($seller_id, '$title', '$desc', $price, '$category')";
    return mysqli_query($conn, $q);
}

function deleteItem($conn, $item_id, $seller_id) {
    // make sure only the owner can delete
    $item_id   = (int)$item_id;
    $seller_id = (int)$seller_id;
    return mysqli_query($conn, "DELETE FROM items WHERE id=$item_id AND seller_id=$seller_id");
}

function markItemSold($conn, $item_id) {
    $item_id = (int)$item_id;
    return mysqli_query($conn, "UPDATE items SET status='sold' WHERE id=$item_id");
}
