<?php
session_start();

// Redirect based on session
if (isset($_SESSION['user_role'])) {
    if ($_SESSION['user_role'] === 'admin') {
        header('Location: admin.php');
        exit;
    } else {
        header('Location: register.php');
        exit;
    }
} else {
    // No session, redirect to login
    header('Location: login.php');
    exit;
}
?>