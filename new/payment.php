<!-- payment.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Payment - Cottonil E-Store</title>
    <link rel="stylesheet" href="payment.css" />
    <style>
        /* Add this style block for consistent styling */
        #address  {
            width: 52%; /* Adjusted width to make it smaller */
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            font-size: 1em; /* Adjusted font size */
            border-radius: 10px;
        }
        #cardNumber{
            width: 100%; /* Adjusted width to make it smaller */
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            font-size: 1em; /* Adjusted font size */
            border-radius: 5px;

        }
        #phoneNumber{
            width: 48%; /* Adjusted width to make it smaller */
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            font-size: 1em; /* Adjusted font size */
            border-radius: 10px;

        }
    </style>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-left: auto;
            margin-right: auto;
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
        .center-content {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="top-right">
            <span>Contact: +968-158-684 | Cottonil E-Store</span>
        </div>
        <nav>
            <div class="button">
                <ul>
                    <li><a href="home.html">Home</a></li>
                    <li><a href="About.html">About</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="login.php">Log-in</a></li>
                    <li><a href="register.php">Sign-up</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <main>
        <div class="center-content">
        <h2>Payment and confirm Order</h2>
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
            echo "</form>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
        } else {
            echo "Your cart is empty.";
        }
       

        $conn->close();
        ?>
    </main>
    <div class="small">
        <h2>Please enter your details:</h2>
        <label for="address">Address </label><br>
        <input type="text" id="address" name="address" /><br>

        <label for="phoneNumber">Phone Number </label><br>
        <input type="text" id="phoneNumber" name="phoneNumber" />
    </div>

    <div class="payment-options">
        <label>
            <input type="radio" name="paymentMethod" value="visa" onclick="toggleVisaDetails(true)" /> Pay with Visa
        </label>
        <div id="visaDetails" class="visa-details" style="display: none;">
            <label for="cardNumber">Card Number:</label>
            <input type="text" id="cardNumber" name="cardNumber" oninput="validateCardNumber(this)" />
            <p id="cardNumberError" style="color: red; display: none;">Please enter a valid 16-digit card number.</p>
        </div>

        <label>
            <input type="radio" name="paymentMethod" value="cash" onclick="toggleVisaDetails(false)" /> Pay with Cash
        </label>
        <div id="cashDetails" class="cash-details" style="display: none;">
            <!-- Additional details for cash payment if needed -->
        </div>
    </div>

    <div class="confirm-button">
        <button onclick="confirmPayment()">Confirm Payment</button>
    </div>
    <script>
    function toggleVisaDetails(show) {
        var visaDetails = document.getElementById("visaDetails");
        var cashDetails = document.getElementById("cashDetails");

        if (show) {
            visaDetails.style.display = "block";
            cashDetails.style.display = "none";
        } else {
            visaDetails.style.display = "none";
            cashDetails.style.display = "block";
        }
    }

    function validateCardNumber(input) {
        var cardNumber = input.value.replace(/\D/g, ''); // Remove non-numeric characters
        var errorElement = document.getElementById("cardNumberError");

        if (cardNumber.length !== 16 || isNaN(cardNumber)) {
            errorElement.style.display = "block";
        } else {
            errorElement.style.display = "none";
        }
    }

    function confirmPayment() {
        var paymentMethod = document.querySelector('input[name="paymentMethod"]:checked');
        var cardNumber = document.getElementById("cardNumber").value.replace(/\D/g, ''); 
        var address = document.getElementById("address").value;
        var phoneNumber = document.getElementById("phoneNumber").value;

        if (paymentMethod) {
            if (paymentMethod.value === "cash") {
                if (address.trim() === "" || phoneNumber.trim() === "") {
                    alert("Please fill in both address and phone number.");
                } else {
                    window.location.href = "home.html";
                }
            } else if (cardNumber.length === 16 && !isNaN(cardNumber)) {
                if (address.trim() === "" || phoneNumber.trim() === "") {
                    alert("Please fill in both address and phone number.");
                } else {
                    // You can add additional validation and payment processing logic for Visa payment here
                    window.location.href = "home.html";
                }
            } else {
                alert("Please enter a valid 16-digit card number.");
            }
        } else {
            alert("Please select a payment method.");
        }
    }
</script>



</body>
</html>
