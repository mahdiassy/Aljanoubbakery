<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Al Janoub Bakery</title>
    <link rel="stylesheet" href="index.css">
</head>
<style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .footer-basic {
            margin-top: auto;
        }
    </style>
<body>

<header id='menu-header'>
    <div class="logo">
      <img src="images/logo.jpg" alt="">
      <h1>Al Janoub Bakery</h1>
    </div>
    <nav class="nav-bar">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="menu.php">Menu</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
 
      
       
      </ul>
      
    </nav>

  </header>

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

    // Fetch items from the database
    $query = "SELECT * FROM items";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo '<div class="container-fluid">';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '
                <div class="card" style="width: 15rem;">
                    <img src="' . $row['image'] . '" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">' . $row['name'] . '</h5>
                        <p class="card-text">' . $row['description'] . '</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Price: $' . $row['price'] . '</li>
                        <form method="post" action="process_order.php">
                        <input type="hidden" name="item_id" value="' . $row['id'] . '">
                        <input type="submit" class="order-btn" value="Order">
                        <li class="list-group-item">Quantity: <input type="number" min="1" max="5" name="quantity' . $row['id'] . '"></li>
                    </form>
                    </ul>
                    
                </div>
            ';
        }
        echo '</div>';
        mysqli_free_result($result);
    }

    mysqli_close($conn);
    ?>

<div class="footer-basic">
        <footer>
            <div class="social">
                <a href="#"><i class="icon ion-social-instagram"></i></a>
                <a href="#"><i class="icon ion-social-facebook"></i></a>
            </div>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="contact.php">Contact us</a></li>
            </ul>
            <p class="copyright">Al Janoub Bakery © 2023</p>
        </footer>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <script src="script.js"></script>

</body>

</html>
