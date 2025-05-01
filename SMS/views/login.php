<?php 
session_start();
require_once('../api/db.php');

$errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $USER_ID = $_POST['USER_ID'];
    $PASSWORD = $_POST['PASSWORD'];
    $result = login($USER_ID, $PASSWORD);
    
    if ($result) {
        $_SESSION['USER_ID'] = $result['USER_ID'];
        $_SESSION['USER_TYPE'] = $result['USER_TYPE'];
        $successMsg = "Login successful! Redirecting to dashboard...";
        echo "<script>
            setTimeout(function() {
                window.location.href = 'dashboard.php';
            }, 2000);
        </script>";
    } else {
        $errorMsg = "Invalid User ID or Password";
    }
}

function login($USER_ID, $PASSWORD){
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE USER_ID = ?");
    $stmt->bind_param("s", $USER_ID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($PASSWORD, $user['PASS'])) {
            return $user;
        }
    }

    return false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0f1d2a;
            color: white;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-box {
            background-color: #1f2e3d;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
        }
        .form-control {
            background-color: #2e3e50;
            border: none;
            color: white;
        }
        .form-control:focus {
            box-shadow: none;
            background-color: #2e3e50;
            color: white;
        }
        .btn-primary {
            background-color: #0069d9;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        a.text-info:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2 class="text-center mb-4">Login</h2>
        <form method="post">
            <?php if (!empty($errorMsg)): ?>
                <div class="alert alert-danger"><?php echo $errorMsg; ?></div>
            <?php elseif (!empty($successMsg)): ?>
                <div class="alert alert-success"><?php echo $successMsg; ?></div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="USER_ID" class="form-label">User ID</label>
                <input type="text" class="form-control" id="USER_ID" name="USER_ID" required>
            </div>
            <div class="mb-3">
                <label for="PASSWORD" class="form-label">Password</label>
                <input type="password" class="form-control" id="PASSWORD" name="PASSWORD" required>
            </div>
            <div class="d-grid mb-2">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
            <p class="text-center">Don't have an account? <a href="register.php" class="text-info">Register</a></p>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
