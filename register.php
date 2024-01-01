<?php
session_start();
$_SESSION['user_authenticated'] = true;

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password
    $address = $_POST["address"];
    $phone_number = $_POST["phone_number"];

    $sql = "INSERT INTO users (username, password, address, phone_number) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $password, $address, $phone_number);

    if ($stmt->execute()) {
        $_SESSION["user_id"] = $stmt->insert_id; // Save user_id in session
        header("Location: index.php"); // Redirect to home page or wherever you want
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
