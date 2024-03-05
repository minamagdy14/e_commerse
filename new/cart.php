<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="cart.css" />
    <title>Cart</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 100px;
            height: auto;
        }

        .product-info {
            display: flex;
            align-items: center;
        }

        .product-info p {
            margin: 0;
            margin-left: 10px;
        }

        .total-price {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }

        .delete-btn {
            background-color: #ff6666;
            color: white;
            border: none;
            padding: 8px;
            cursor: pointer;
        }

        .confirm-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px;
            cursor: pointer;
        }

        .action-column {
            display: flex;
            align-items: center;
        }

        tr {
            border-bottom: 2px solid #ddd; 
        }
    </style>
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
        <h2>Shopping Cart</h2>
        <?php
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "test";

        $conn = new mysqli($host, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["product_id"]) && isset($_POST["quantity"])) {
            $product_id = $_POST["product_id"];
            $quantity = $_POST["quantity"];
        
            $sql = "INSERT INTO cart (product_id, quantity) VALUES ($product_id, $quantity)";
        
            if ($conn->query($sql) === TRUE) {
                echo "Product added to cart successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        

        if (isset($_POST["delete_id"])) {
            $delete_id = $_POST["delete_id"];
            $delete_sql = "DELETE FROM cart WHERE id = $delete_id";
            if ($conn->query($delete_sql) === TRUE) {
                echo "Product deleted from cart successfully!";
            } else {
                echo "Error deleting product: " . $conn->error;
            }
        }
        if (isset($_POST["confirm_order"])) {
            // Redirect to payment.php with total price as a session variable
            session_start();
            $_SESSION['total_price'] = $totalPrice;
            header("Location: payment.php");
            exit();
        }
        


        

        $cart_sql = "SELECT cart.*, product.Product_name, product.Price, product.image_name FROM cart 
                     JOIN product ON cart.product_id = product.ID";
        $cart_result = $conn->query($cart_sql);

        if ($cart_result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Image</th><th>Product</th><th>Quantity</th><th>Price</th><th>Action</th></tr>";
            $totalPrice = 0;
            while ($cart_row = $cart_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td><img src='" . $cart_row['image_name'] . ".jpg' alt='" . $cart_row['Product_name'] . "' /></td>";
                echo "<td class='product-info'>";
                echo "<p>" . $cart_row['Product_name'] . "</p>";
                echo "</td>";
                echo "<td>" . $cart_row['quantity'] . "</td>";
                $productPrice = $cart_row['Price'] * $cart_row['quantity'];
                echo "<td>" . $productPrice . " EG</td>";
                echo "<td class='action-column'>";
                echo "<form method='post' action=''>";
                echo "<input type='hidden' name='delete_id' value='" . $cart_row['id'] . "'>";
                echo "<button type='submit' class='delete-btn'>Delete</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
                $totalPrice += $productPrice;
            }
            echo "<tr>";
            echo "<td colspan='3'><strong>Total Price</strong></td>";
            echo "<td colspan='2' class='total-price'>" . $totalPrice . " EG</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td colspan='5' class='action-column'>";
            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='confirm_order' value='1'>";
            echo "<button type='submit' class='confirm-btn'>Confirm Order</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
        } else {
            echo "Your cart is empty.";
        }
        if (isset($_POST["confirm_order"])) {
            // Redirect to payment.php with total price as a query parameter
            header("Location: payment.php?totalPrice=$totalPrice");
            exit();
        }

        $conn->close();
        ?>
    </main>
</body>

</html>
