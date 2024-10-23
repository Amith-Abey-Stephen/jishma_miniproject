<?php
session_start();
require_once 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['email'])) {
    header("Location: admin_login.php");
    exit();
}

$adminEmail = $_SESSION['email'];
$shop_name = isset($_GET['shop_name']) ? $_GET['shop_name'] : null;
$location = '';
$description = '';

if ($shop_name) {
    // Fetch shop details for editing
    $sql = "SELECT * FROM shops WHERE shop_name = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $shop_name);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $shop = $result->fetch_assoc();
            $location = $shop['location'];
            $description = $shop['description'];
        } else {
            $error = "Shop not found.";
        }
        $stmt->close();
    } else {
        $error = "Error: " . $mysqli->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $shop_name = $_POST['shop_name'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $adminEmail = $_SESSION['email'];

    if ($shop_name) {
        // Update existing shop
        $sql = "UPDATE shops SET location = ?, description = ? WHERE shop_name = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("sss", $location, $description, $shop_name);
            if ($stmt->execute()) {
                $success = "Shop details updated successfully.";
                header("Location: admin_dashboard.php");
                exit();
            } else {
                $error = "Error updating shop details: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Error: " . $mysqli->error;
        }
    } else {
        // Add new shop
        if (!empty($shop_name)) {
            $sql = "INSERT INTO shops (shop_name, location, description, admin_email) VALUES (?, ?, ?, ?)";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("ssss", $shop_name, $location, $description, $adminEmail);
                if ($stmt->execute()) {
                    $success = "New shop added successfully.";
                    header("Location: admin_dashboard.php");
                    exit();
                } else {
                    echo "Error adding new shop: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $mysqli->error;
            }
            
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $shop_name ? 'Edit Shop' : 'Add New Shop'; ?></title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="container">
        <nav class="sidebar">
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="admin_logout.php">Logout</a></li>
            </ul>
        </nav>
        <section class="dashboard">
            <div class="page">
                <h1><?php echo $shop_name ? 'Edit Shop' : 'Add New Shop'; ?></h1>
                <form action="manage_shop.php<?php echo $shop_name ? '?shop_name=' . urlencode($shop_name) : ''; ?>" method="post">
                    <label for="shop_name">Shop Name:</label>
                    <input type="text" id="shop_name" name="shop_name" value="<?php echo htmlspecialchars($shop_name); ?>" required><br><br>
                    
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($location); ?>" required><br><br>
                    
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required><?php echo htmlspecialchars($description); ?></textarea><br><br>
                    
                    <input type="hidden" name="admin_email" value="<?php echo htmlspecialchars($adminEmail); ?>">
    
                    <input type="submit" value="<?php echo $shop_name ? 'Update Shop' : 'Add Shop'; ?>">
                </form>
                <?php if (isset($success)): ?>
                    <p><?php echo $success; ?></p>
                <?php endif; ?>
                <?php if (isset($error)): ?>
                    <p><?php echo $error; ?></p>
                <?php endif; ?>
            </div>
        </section>
    </div>
</body>
</html>