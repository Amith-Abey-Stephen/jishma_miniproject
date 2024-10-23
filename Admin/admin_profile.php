<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['loggedin'])) {
    header("Location: admin_login.php");
    exit;
}

// Handle account deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_account'])) {
    $adminId = $_SESSION['email'];
    require_once 'config.php'; // Assuming you have a PDO instance $pdo in config.php

    $query = "DELETE FROM admins WHERE email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$adminId]);

    // Destroy the session and redirect to the login page
    session_destroy();
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="profile-container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></h1>
        <p>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        <p>Role: Admin</p>
        <form method="POST" action="">
            <button type="submit" name="delete_account" onclick="return confirm('Are you sure you want to delete your account?');">Delete Account</button>
        </form>
    </div>
</body>
</html>