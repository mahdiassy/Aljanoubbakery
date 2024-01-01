<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bakery_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user ID from the session (assuming it's stored after login)
    session_start();

    if (!isset($_SESSION['user_authenticated']) || $_SESSION['user_authenticated'] !== true) {
        echo "<script>alert('Error: User not authenticated. Please sign in to place an order.')</script>";
        echo "<script>window.location.href='menu.php';</script>";
        exit;
    } 
    $userId = $_SESSION["user_id"];

    // Get the item ID from the form
    $itemId = $_POST['item_id'];

    // Construct the dynamic quantity field name
    $quantityFieldName = 'quantity' . $itemId;

    // Check if the quantity field is set in the $_POST array
    if (isset($_POST[$quantityFieldName])) {
        $quantity = $_POST[$quantityFieldName];

        // Insert the order into the database with the user ID
        $insertQuery = "INSERT INTO orders (user_id, item_id, quantity) VALUES ('$userId', '$itemId', '$quantity')";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            echo "<script>alert(Order placed successfully.')</script>";
            echo "<script>window.location.href='menu.php';</script>";
        } else {
            echo "Error placing order: " . mysqli_error($conn);
        }
    } else {
        echo "Quantity field not set in the form.";
    }
}

mysqli_close($conn);
?>
