<!-- process_payment.php -->

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm_payment"])) {
    // Process the payment, handle card details, etc.

    // After processing, redirect back to the home page
    header("Location: home.html");
    exit();
} else {
    // Redirect to home.html if accessed without proper submission
    header("Location: home.html");
    exit();
}
?>
