<?php
session_start();

// Logout logic
if (isset($_POST['logout'])) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session.
    session_destroy();

    // Clear session cookies by setting their expiration to the past
    setcookie(session_name(), '', time() - 3600);

    // Redirect to the admin login page after logout
    header("Location: adminLogin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Admin Panel - Brave Coder</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Admin Panel" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Style-CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!-- //Style-CSS -->

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

    <style>
        /* Custom CSS for navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            margin-bottom: 20px;
            height: auto; /* Set height to auto */
        }

        .navbar * {
            margin: 0; /* Reset margin for all elements inside navbar */
            padding: 0; /* Reset padding for all elements inside navbar */
            box-sizing: border-box; /* Include padding and border in the element's total width and height */
        }

        .navbar-brand img {
            height: 50px;
            margin-right: 15px;
        }

        .navbar-buttons button {
            margin-left: 15px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-brand">
            <!-- Brand/logo -->
            <img style="height: 50px; margin: 0 15px;" src="./images/logo.png" alt="logo">
        </div>
        <div class="navbar-buttons">
            <!-- Logout button -->
            <form action="" method="post">
                <button class="btn" name="logout" type="submit">Logout</button>
            </form>
        </div>
    </nav>
    <!-- //Navbar -->

    <!-- Admin panel content -->
    <section class="w3l-mockup-form">
        <div class="container">
            <div class="content-wthree">
                <h2>Welcome to Admin Panel</h2>
                <!-- Set questions and view results buttons -->
                <div style="text-align: center;">
                    <form action="questionsPanel.php" method="get">
                        <button class="btn" type="submit">Set Questions</button>
                    </form>
                    <form action="getResults.php" method="get">
                        <button class="btn" type="submit">View Results</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- //Admin panel content -->

    <script src="js/jquery.min.js"></script>

</body>

</html>
