<?php
// UserModel.php - handles user-related queries

function getUserByUsername($conn, $username) {
    $username = mysqli_real_escape_string($conn, $username);
    $res = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' LIMIT 1");
    return mysqli_fetch_assoc($res);
}

function getUserByEmail($conn, $email) {
    $email = mysqli_real_escape_string($conn, $email);
    $res = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' LIMIT 1");
    return mysqli_fetch_assoc($res);
}

function registerUser($conn, $username, $email, $password, $role) {
    $username = mysqli_real_escape_string($conn, $username);
    $email    = mysqli_real_escape_string($conn, $email);
    $role     = mysqli_real_escape_string($conn, $role);
    $hashed   = hash('sha256', $password);

    $q = "INSERT INTO users (username, email, password, role)
          VALUES ('$username', '$email', '$hashed', '$role')";
    return mysqli_query($conn, $q);
}

function loginUser($conn, $username, $password) {
    $hashed = hash('sha256', $password);
    $username = mysqli_real_escape_string($conn, $username);
    $res = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$hashed' LIMIT 1");
    return mysqli_fetch_assoc($res);
}

function getUserById($conn, $id) {
    $id = (int)$id;
    $res = mysqli_query($conn, "SELECT * FROM users WHERE id = $id LIMIT 1");
    return mysqli_fetch_assoc($res);
}

// check if username exists -- used by AJAX
function usernameExists($conn, $username) {
    $username = mysqli_real_escape_string($conn, $username);
    $res = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
    return mysqli_num_rows($res) > 0;
}
