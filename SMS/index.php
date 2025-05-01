<?php
// Start session if needed
session_start();

// Example check (you can expand this)
$isLoggedIn = isset($_SESSION['USER_ID']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            background-color:rgba(15, 29, 42, 0.89);
            color:white;
        }
        nav{
            border-radius: 10px;
            background-color:rgba(15, 29, 42, 0.78);
        }
    </style>
</head>
<body class=" p-3">

<nav class="navbar navbar-expand-lg navbar-dark p-3 mb-2  text-white ">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="images/logo.png" alt="" srcset="" style="height:40px"> SchoolMS</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <?php if ($isLoggedIn): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="views/login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="text-center ">Welcome to the School Management System</h1>
    <p class="text-center text-white">Manage students, teachers, parents, and more from a centralized platform.</p>

    <?php if (!$isLoggedIn): ?>
        <div class="text-center mt-4">
            <a href="views/login.php" class="btn btn-primary p-2">Login to Continue</a>
        </div>
    <?php else: ?>
        <div class="alert alert-success text-center mt-4">
            You are logged in. <a href="dashboard.php">Go to Dashboard</a>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
