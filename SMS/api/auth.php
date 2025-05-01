<?php
session_start();

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['USER_ID']);
}

// Check user role
function isAdmin() {
    return isset($_SESSION['USER_TYPE']) && ($_SESSION['USER_TYPE'] === 'ADMIN' || $_SESSION['USER_TYPE'] === 'SUPERADMIN');
}

function isSuperAdmin() {
    return isset($_SESSION['USER_TYPE']) && $_SESSION['USER_TYPE'] === 'SUPERADMIN';
}


// Redirect if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /views/login.php');
        exit();
    }
}

// Redirect if not admin
function requireAdmin() {
    if (!isAdmin()) {
        header('Location: /views/dashboard.php');
        exit();
    }
}

// Redirect if not super admin
function requireSuperAdmin() {
    if (!isSuperAdmin()) {
        header('Location: /views/dashboard.php');
        exit();
    }
}
?>
