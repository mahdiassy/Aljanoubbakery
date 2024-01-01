<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="button.css">

  <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <script src="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <title>AL Janoub Bakery </title>

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

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 10;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
        }

        .register-link {
            margin-top: 10px;
            text-align: center;
            color: blue;
            cursor: pointer;
        }

        .logout-form{
          background-image: none;
        }
    </style>
<body>

  <header>
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
   
      
        <?php
                session_start();
                if (isset($_SESSION["user_id"])) {
                    echo '<li><form class="logout-form" action="logout.php" method="post">
                            <button type="submit" class="bn632-hover bn19">Logout</button>
                          </form></li>';
                } else {
                    echo '<a><button onclick="toggleForms()" class="bn632-hover bn19">Log in</button></a>';
                }
                ?>
                <!DOCTYPE html>

  
 

</html>

      </ul>
      
    </nav>

  </header>

  <section class="welcome">

    <p>At My Bakery, We bake the freshest and most delicious cakes, Pizzas, and Breads.</p>
    <p>Visit our menu page to view our selection and place an order.</p>
    <a href="menu.php"><button onclick="alert('Thank you for visiting our website!')">Visit Us Today</button>
    </a>
  </section>

  <div id="carouselExampleIndicators" class="carousel slide">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
        aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
        aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
        aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="images/cake1.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="images/3layercake.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="images/dark chocolate.jpg" class="d-block w-100" alt="...">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
      data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
      data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <div class="best-seller">
    <h1>
      Best Seller
    </h1>
  </div>

  <div class="container-fluid">

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
        
      
        

        // Fetch best-seller items from the database
        $query = "SELECT items.id, items.name, items.image FROM items JOIN best_seller ON items.id = best_seller.item_id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '
                <div class="card" style="width: 15rem;">
                    <img src="' . $row['image'] . '" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">' . $row['name'] . '</h5>
                    </div>
                </div>';
            }
            mysqli_free_result($result);
        }

        mysqli_close($conn);
        ?>

    </div>
    <div class="footer-basic">
    <footer>

      <div class="social"><a href="#"><i class="icon ion-social-instagram"></i></a><a href="#"><i
            class="icon ion-social-facebook"></i></a></div>
      <ul class="list-inline">

        <li class="list-inline-item"><a href="contact.php">Contact us</a></li>


      </ul>
      <p class="copyright">Al Janoub Bakery © 2023</p>
    </footer>
  </div>

  <div class="overlay" id="overlay">
        <div class="form-container" id="login-form">
            <form action="signin.php" method="post">
                <h2>Sign In</h2>
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="password" placeholder="Password">
                <button type="submit">Sign In</button>
                <div class="register-link" onclick="showRegisterForm()">Don't have an account? Register here.</div>
            </form>
        </div>
        <div class="form-container" id="register-form" style="display: none;">
            <form action="register.php" method="post">
                <h2>Register</h2>
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="password" placeholder="Password">
                <input type="text" name="address" placeholder="Address">
                <input type="text" name="phone_number" placeholder="Phone Number">
                <button type="submit">Register</button>
                <div class="register-link" onclick="showLoginForm()">Already have an account? Sign in here.</div>
            </form>
        </div>
    </div>
    <script>
        function toggleForms() {
            var overlay = document.getElementById("overlay");
            overlay.style.display = (overlay.style.display === "none" || overlay.style.display === "") ? "flex" : "none";
            showLoginForm(); // Show the login form by default
        }

        function showRegisterForm() {
            document.getElementById("login-form").style.display = "none";
            document.getElementById("register-form").style.display = "block";
        }

        function showLoginForm() {
            document.getElementById("register-form").style.display = "none";
            document.getElementById("login-form").style.display = "block";
        }
    </script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

</body>
<script src="script.js"></script>

</html>