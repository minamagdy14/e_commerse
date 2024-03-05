<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "test";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM product";
$result = $conn->query($sql);
$productHTML = '';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productHTML .= "<div class='product'>";
        $productHTML .= "<a href='product_details.php?id=" . $row['ID'] . "'>";
        $productHTML .= "<img src='" . $row['image_name'] . ".jpg' alt='" . $row['Product_name'] . "'>";
        $productHTML .= "<h2>" . $row['Product_name'] . "</h2>";
        $productHTML .= "<p>Price: " . $row['Price'] . " EG</p>";
        $productHTML .= "<button>Add to Cart</button>";
        $productHTML .= "</a>";
        $productHTML .= "</div>";
    }
} else {
    $productHTML = "No products found.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cottonil E-Commerce - Products</title>
    <link rel="stylesheet" href="login.css">
    <style>
        .product {
            display: inline-block;
            width: 30%;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .product img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="nav">
                <ul>
                    <li><a href="home.html">Home</a></li>
                    <li><a href="About.html">About</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="login.php">Log-in</a></li>
                    <li><a href="register.php">Sign-up</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <h1>Our Products</h1>
        <?php echo $productHTML; ?>
    </main>
</body>

</html>