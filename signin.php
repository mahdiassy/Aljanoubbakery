<?php
session_start();

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
    $password = $_POST["password"];

    $sql = "SELECT user_id, password, status FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION["user_id"] = $row['user_id']; // Save user_id in session
            if ($row['status'] == 1) {
                // Redirect admin to the admin page
                header("Location: admin-page.php");
                exit;
            } else {
                // Redirect regular users to their dashboard or home page
                header("Location: index.php");
                exit;
            }
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "<script>alert('Username not found')</script>";
        echo "<script>window.location.href='index.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
