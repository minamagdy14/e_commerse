<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
    $host = "localhost"; // Your MySQL host
    $username = "root"; // Your MySQL username
    $password = ""; // Your MySQL password
    $dbname = "test"; // Your MySQL database name

    // Create a database connection
    $conn = new mysqli($host, $username, $password, $dbname);

    // Check if the connection is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get user input from the form
    $username = $_POST["name"];
    $password = $_POST["password"];
    $location = $_POST["location"];
    $email = $_POST["email"];

    // Insert user data into the "users" table
    $sql = "INSERT INTO users (username, password, location, email) VALUES ('$username', '$password', '$location', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "User registered successfully!";

        // Redirect to login.php
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Cottonil E-Commerce</title>
    <link rel="stylesheet" href="login.css"> 
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
            <h2 style="color: yellow;">Sign-up - Cottonil E-Commerce</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="name">User Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" required>

                <label for="location">Select Your Location:</label>
                <select id="location" name="location">
                    <option value="Egypt">Egypt</option>
                    <option value="USA">USA</option>
                    <option value="Canada">Canada</option>
                    <option value="UK">UK</option>
                    <option value="Australia">Australia</option>
                    <option value="Germany">Germany</option>
                </select>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="remember">
                    <input type="checkbox" id="remember" name="remember"> Remember me</label>

                <button type="submit">Sign-up</button>
                <p>Already have an account? <a href="login.php" style="color: yellow;">Login here</a></p>
            </form>
        </section>
    </main>
</body>

</html>

