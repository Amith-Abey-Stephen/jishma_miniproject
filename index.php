<?php
session_start();


require_once 'routes.php';

// Get the current path
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Check if the path exists in the routes array
if (array_key_exists($path, $routes)) {
    require $routes[$path];
} else {
    // Handle 404 Not Found
    http_response_code(404);
    echo "404 Not Found";
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VRS</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <ul class="navul">
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <li class="navli">
            <a href="profile.php"><?php echo htmlspecialchars($_SESSION['name']); ?></a>
            <ul class="dropdown">
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </li>
    <?php else: ?>
        <li class="navli"><a href="login.php">Login</a></li>
    <?php endif; ?>
    <li class="navli"><a href="location.php">Find Now</a></li>
    <li class="navli"><a href="index.php#contact">Contact</a></li>
    <li class="navli"><a href="index.php#about">About</a></li>
    <li class="navli"><a href="index.php">Home</a></li>
    </ul>
    
   
    <div class="container" id="home">
        <h1>Service at your
        <br> finger tip.</h1>
        <p> 
            Lorem ipsum dolor sit amet, consectetur<br>
            adipiscing elit, sed do eiusmod tempor<br>
            incididunt ut labore et dolore
        </p>
        
        <form >
            <a href="location.php"><input type="button"  value="Find Now" name="Find Now" id="findnow" ></a>
        </form>
    </div>


    <section class="about" id="about">
        <h1>About </h1>
        <div class="abcontent" >
        <h2 class="head">Who We Are</h2>
        <p>
            We are a passionate team dedicated to providing innovative solutions in the field of technology.<br>
            Our mission is to empower individuals and organizations with cutting-edge tools that improve productivity,</br>
            foster creativity, and drive progress.
        </p>

        <h2>Our Journey</h2>
        
        <p>
            Since our inception in 2020, we have grown from a small startup into a vibrant community of tech enthusiasts
            and professionals. Our commitment to excellence and customer satisfaction has driven our success,
            and we continue to push the boundaries of what's possible.
        </p>
        </div>
    </section>


 


    

<section id="contact" >
        <h1>CONTACT</h1>
        
        <div class="form-container">
            <div class="left-column">
                <form id="contact-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="text" id="name" name="name" placeholder="NAME" required>
                    <input type="email" id="email" name="email" placeholder="EMAIL" required>
                    <textarea id="message" name="message" placeholder="MESSAGE" required></textarea>
                    <button type="submit">Send</button>
                </form>
            </div>
            <div class="right-column">
                <div class="contact-info">
                    <p><i>📍</i> City, State</p>
                    <p><i>📞</i> (212) 555-2368</p>
                    <p><i>✉️</i> hitmeup@gmail.com</p>
                </div>
                <div class="social-icons">
                    <a href="#" title="GitHub">
                        <i>
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
                        </i>
                    </a>
                    <a href="#" title="CodeSandbox">
                        <i>
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="7.5 4.21 12 6.81 16.5 4.21"></polyline><polyline points="7.5 19.79 7.5 14.6 3 12"></polyline><polyline points="21 12 16.5 14.6 16.5 19.79"></polyline><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        </i>
                    </a>
                    <a href="#" title="Twitter">
                        <i>
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                        </i>
                    </a>
                    <a href="#" title="Instagram">
                        <i>
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                        </i>
                    </a>
                </div>
            </div>
        </div>
        <div class="footer">
            © ALL OF THE RIGHTS RESERVED
        </div>

        <?php
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $user_message = $_POST['message'] ?? '';
    
    // Here you would typically process the form data, such as sending an email
    // For this example, we'll just create a success message
    $message = "Thank you, $name! Your message has been received.";
    
    // In a real-world scenario, you might use the mail() function or a library like PHPMailer
    // mail('your@email.com', 'New Contact Form Submission', $user_message, "From: $email");
}
?>
        </section>

  
</body>
</html>
