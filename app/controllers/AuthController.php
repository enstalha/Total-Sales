<?php
// AuthController.php
// handles login, register, logout

session_start();
require_once 'config/db.php';
require_once 'app/models/UserModel.php';

$action = $_GET['action'] ?? 'login';

if ($action === 'logout') {
    session_destroy();
    header("Location: index.php?page=login");
    exit;
}

$error = '';
$success = '';

if ($action === 'register') {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usr   = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $pass  = $_POST['password'] ?? '';
        $role  = $_POST['role'] ?? 'buyer';

        // basic server-side checks
        if (empty($usr) || empty($email) || empty($pass)) {
            $error = "Please fill in all fields.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email address.";
        } elseif (strlen($pass) < 6) {
            $error = "Password must be at least 6 characters.";
        } elseif (usernameExists($conn, $usr)) {
            $error = "Username is already taken.";
        } elseif (getUserByEmail($conn, $email)) {
            $error = "Email already registered.";
        } else {
            $ok = registerUser($conn, $usr, $email, $pass, $role);
            if ($ok) {
                $success = "Account created! You can now log in.";
            } else {
                $error = "Something went wrong. Try again.";
            }
        }
    }

    require 'app/views/auth/register.php';

} else {
    // default: login page

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usr  = trim($_POST['username'] ?? '');
        $pass = $_POST['password'] ?? '';

        if (empty($usr) || empty($pass)) {
            $error = "Enter username and password.";
        } else {
            $user = loginUser($conn, $usr, $pass);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role']    = $user['role'];
                header("Location: index.php");
                exit;
            } else {
                $error = "Wrong username or password.";
            }
        }
    }

    require 'app/views/auth/login.php';
}
