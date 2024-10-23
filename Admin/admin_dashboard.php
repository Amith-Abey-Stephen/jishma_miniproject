<?php
session_start();
require_once 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['email'])) {
    header("Location: admin_login.php");
    exit();
}

// Get the admin email from the session
$adminEmail = $_SESSION['email'];

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch shop details for the logged-in admin
$sql = "
    SELECT shops.*
    FROM shops
    JOIN admins ON shops.admin_email = admins.email
    WHERE admins.email = ?
";
$stmt = $mysqli->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $mysqli->error);
}

$stmt->bind_param("s", $adminEmail);
$stmt->execute();
$result = $stmt->get_result();
$shops = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="container">
        <nav class="sidebar">
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="admin_profile.php">Profile</a></li>
                <li><a href="admin_logout.php">Logout</a></li>
            </ul>
        </nav>
        <section class="dashboard">
            <h1>Admin Dashboard</h1>
            <div class="page">
                <h2>Shop Details</h2>
                <button onclick="window.location.href='manage_shop.php'">Add New Shop</button>
                <table>
                    <thead>
                        <tr>
                            <th>Shop Name</th>
                            <th>Location</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($shops as $shop): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($shop['shop_name']); ?></td>
                                <td><?php echo htmlspecialchars($shop['location']); ?></td>
                                <td><?php echo htmlspecialchars($shop['description']); ?></td>
                                <td><a href="manage_shop.php?shop_name=<?php echo urlencode($shop['shop_name']); ?>">Edit</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>
</html>