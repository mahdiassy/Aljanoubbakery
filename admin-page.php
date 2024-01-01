<!DOCTYPE html>
<html>
<head>
    <title>User Orders</title>

</head>

<body>
    <h1>User Orders</h1>

    <!-- Search Form -->
    <form class="search-form" action="" method="post">
        <label for="search">Search by User ID or Username:</label>
        <input type="text" id="search" name="search" class="search-input" required>
        <button type="submit" class="search-button">Search</button>
    </form>

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

    // Fetch orders data based on search
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $searchTerm = $_POST["search"];
        $sql = "SELECT orders.order_id, orders.item_id, orders.quantity, orders.order_date, orders.user_id, users.username, users.address, users.phone_number, items.name, items.price, orders.status
                FROM orders
                INNER JOIN users ON orders.user_id = users.user_id
                INNER JOIN items ON orders.item_id = items.id
                WHERE orders.user_id = ? OR users.username = ?
                ORDER BY orders.order_date";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        // Fetch all orders if no search
        $today = date("Y-m-d");
        $yesterday = date("Y-m-d", strtotime("-2 day"));

        $sql = "SELECT orders.order_id, orders.item_id, orders.quantity, orders.order_date, orders.user_id, users.username, users.address, users.phone_number, items.name, items.price, orders.status
                FROM orders
                INNER JOIN users ON orders.user_id = users.user_id
                INNER JOIN items ON orders.item_id = items.id
                WHERE DATE(orders.order_date) IN ('$today', '$yesterday')
                ORDER BY orders.order_date";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
    }

    // Update order status
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["markAsDone"])) {
        $orderId = $_POST["orderId"];
    
        // Check the current status of the order
        $checkStatusSql = "SELECT status FROM orders WHERE order_id = ?";
        $checkStatusStmt = $conn->prepare($checkStatusSql);
        $checkStatusStmt->bind_param("i", $orderId);
        $checkStatusStmt->execute();
        $checkStatusResult = $checkStatusStmt->get_result();
    
        if ($checkStatusResult->num_rows > 0) {
            $currentStatus = $checkStatusResult->fetch_assoc()["status"];
    
            // Toggle the status
            $newStatus = ($currentStatus == 'done') ? 'undone' : 'done';
    
            // Update the order status
            $updateSql = "UPDATE orders SET status = ? WHERE order_id = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("si", $newStatus, $orderId);
            $updateStmt->execute();
            $updateStmt->close();
            header("Location: ".$_SERVER['PHP_SELF']); // Redirect to refresh the page
        } else {
            echo "Error checking order status: " . $conn->error;
        }
    
        $checkStatusStmt->close();
    }
    ?>

    <table>
        <thead>
            <tr>
                <th>Item ID</th>
                <th>Order Date</th>
                <th>User ID &amp; Name</th>
                <th>User Address</th>
                <th>User Phone</th>
                <th>Quantity</th>
                <th>Item Name</th>
                <th>Price</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $totalPrice = $row["quantity"] * $row["price"];
                    echo '<tr>
                            <td>' . $row["item_id"] . '</td>
                            <td>' . $row["order_date"] . '</td>
                            <td>' . $row["user_id"] . ' - ' . $row["username"] . '</td>
                            <td>' . $row["address"] . '</td>
                            <td>' . $row["phone_number"] . '</td>
                            <td>' . $row["quantity"] . '</td>
                            <td>' . $row["name"] . '</td>
                            <td>$' . $row["price"] . '</td>
                            <td>$' . $totalPrice . '</td>
                            <td>' . $row["status"] . '</td>
                            <td>
                                <form method="post" style="display: inline;">
                                    <input type="hidden" name="orderId" value="' . $row["order_id"] . '">
                                    <button type="submit" class="action-button" name="markAsDone">Toggle Status</button>
                                </form>
                            </td>
                        </tr>';
                }
            } else {
                echo '<tr><td colspan="9">No orders found</td></tr>';
            }
            ?>
        </tbody>
    </table>

    <div class="action-buttons">
        <button class="action-button" onclick="goToHomePage()">Go to Home Page</button>
        <button class="action-button" onclick="goBack()">Go Back</button>
    </div>

    <script>
        function goToHomePage() {
            window.location.href = "index.php"; // Replace with the actual home page URL
        }

        function goBack() {
            window.history.back();
        }
    </script>

    <?php
    $stmt->close();
    $conn->close();
    ?>
</body>
<style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        td[colspan="4"] {
            text-align: center;
        }

        .search-form {
            margin-top: 20px;
        }

        .search-input {
            padding: 5px;
        }

        .search-button {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .action-buttons {
            margin-top: 20px;
        }

        .action-button {
            padding: 8px 12px;
            margin-right: 10px;
            cursor: pointer;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
        }

        .action-button:hover {
            background-color: #2980b9;
        }
    </style>
</html>
