<?php
session_start();
require_once 'config.php';

$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Prepare a select statement
    $sql = "SELECT name, email, password FROM admins WHERE email = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
            $stmt->store_result();
            
            // Check if email exists, if yes then verify password
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($name, $email, $hashed_password);
                if ($stmt->fetch()) {
                    if (password_verify($password, $hashed_password)) {
                        // Password is correct, so start a new session
                        
                        header("location: admin_dashboard.php");
                       
                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["name"] = $name;
                        $_SESSION["email"] = $email;
                        
                        // Redirect user to welcome page
                        header("location: admin_dashboard.php");
                    } else {
                        // Display an error message if password is not valid
                        $error = "The password you entered was not valid.";
                    }
                }
            } else {
                // Display an error message if email doesn't exist
                $error = "No account found with that email.";
            }
        } else {
            $error = "Oops! Something went wrong. Please try again later.";
        }

        $stmt->close();
    }


$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <section class="verif_body">
        
        <div class="card" >
            <h1>Admin Login</h1>
            <form action="admin_login.php" method="post">
                <label for="email">Email-ID:</label>
                <input type="email" id="email" name="email" placeholder="abhijith@example.com" required><br><br>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br><br>
                
                <input type="submit" value="Login">
            </form>
            <p class="trylogin">Don't have an account? <a href="admin_signup.php">Signup</a></p>
            <?php if (isset($error)): ?>
                <p><?php echo $error; ?></p>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>