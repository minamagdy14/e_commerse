<?php
session_start(); // Start the session at the beginning of the script

$error_message = ""; // Initialize an empty error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
    $host = "localhost"; // Your MySQL host
    $username = "root"; // Your MySQL username
    $password = ""; // Your MySQL password
    $database = "test"; // Your MySQL database name

    // Create a database connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check if the connection is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get user input from the login form
    $username = $_POST["name"];
    $password = $_POST["password"];
    $location = $_POST["location"];

    // Retrieve user data from the "users" table
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password' AND location='$location'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, set a session with user details
        $_SESSION["username"] = $username;

        // Close the database connection
        $conn->close();

        // Redirect to home.html with a welcome message
        header("Location: home.html?message=Welcome, $username!");
        exit; // Terminate the script to prevent further execution
    } else {
        // User not found, set an error message
        $error_message = "Wrong username or password. Please try again.";
    }
} else {
    // If the form is not submitted, show the login page
    // ...
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cottonil E-Commerce</title>
    <link rel="stylesheet" href="login.css"> <!-- Link to your CSS file -->
</head>

<body>
    <header>
        <nav>
            <div class="nav">
                <ul>
                    <li><a href="home.html">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="login.php">Log-in</a></li>
                    <li><a href="register.php">Sign-up</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <section id="contact">
            <h2 style="color: yellow;">Login - Cottonil E-Commerce</h2>

            <?php if (!empty($error_message)) : ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <form action="login.php" method="post">
                <label for="name">User Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="location">Select Your Location:</label>
                <select id="location" name="location">
                    <option value="Egypt">Egypt</option>
                    <option value="USA">USA</option>
                    <option value="Canada">Canada</option>
                    <option value="UK">UK</option>
                    <option value="Australia">Australia</option>
                    <option value="Germany">Germany</option>
                </select>

                <label for="remember">
                    <input type="checkbox" id="remember" name="remember"> Remember me
                </label>

                <button type="submit">Log-in</button>

                <section class="about" style="color: rgb(255, 255, 255);">
                    <p>Don't have an account? <a href="register.php" style="color: yellow;">Sign up here</a></p>
                </section>
            </form>
        </section>
    </main>
</body>

</html>