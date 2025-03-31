<?php
session_start();
// Redirect if already logged in
if (isset($_SESSION['user_role'])) {
    if ($_SESSION['user_role'] === 'admin') {
        header('Location: admin.php');
        exit;
    } else {
        header('Location: register.php');
        exit;
    }
}

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    $password = $_POST['password']; 

    if ($password == 'admin') {
        $_SESSION['user_role'] = 'admin';
        header('Location: admin.php');
        exit;
    } elseif ($password == 'user') {
        $_SESSION['user_role'] = 'user';
        header('Location: register.php');
        exit;
    } else {
        $error_message = "Invalid password. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System - Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-card">
                <h1>Student Management System</h1>
                <h2>Login</h2>
                
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-error">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                
                <form action="" method="post">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" required>
                        <p class="form-hint">Use "admin" for admin access or "user" for student registration</p>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>