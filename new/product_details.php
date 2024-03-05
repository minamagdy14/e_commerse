<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="product.css" />
  <title>Product</title>
</head>

<body>
  <header>
    <nav>
      <ul>
        <li><a href="home.html">Home</a></li>
        <li><a href="About.html">About</a></li>
        <li><a href="products.php">Products</a></li>
        <li><a href="login.php">Log-in</a></li>
        <li><a href="register.php">Sign-up</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "test";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['id'])) {
      $product_id = $_GET['id'];

      $sql = "SELECT * FROM product WHERE ID = $product_id";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<h2>" . $row['Product_name'] . "</h2>";
          echo "<div class='product'>";
          echo "<div class='product-image'>";
          echo "<img src='" . $row['image_name'] . ".jpg' alt='" . $row['Product_name'] . "' />";
          echo "</div>";
          echo "<div>";
          echo "<p class='description'>" . $row['Product_description'] . "</p>";
          echo "<p class='price'>Price: " . $row['Price'] . " EG</p>";
          echo "<form action='cart.php' method='post'>";
          echo "<label for='quantity'>Quantity:</label>";
          echo "<input type='number' id='quantity' name='quantity' value='1' min='1' required>";
          echo "<input type='hidden' name='product_id' value='" . $row['ID'] . "'>";
          echo "<button type='submit'>Add to Cart</button>";
          echo "</form>";
          echo "</div>";
          echo "</div>";
        }
      } else {
        echo "Product not found.";
      }
    } else {
      echo "No product ID provided.";
    }

    $conn->close();
    ?>
  </main>
</body>

</html>
