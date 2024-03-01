<?php
    session_start();
    if (isset($_SESSION['ADMIN_SESSION_EMAIL'])) {
        header("Location: adminPanel.php");
        die();
    }

    $msg = "";

    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Hardcoded admin credentials
        $admin_username = "Admin@123";
        $admin_password = "AdminLogin@123";

        if ($username === $admin_username && $password === $admin_password) {
            $_SESSION['ADMIN_SESSION_EMAIL'] = $username;
            header("Location: adminPanel.php");
        } else {
            $msg = "<div class='alert alert-danger'>Incorrect username or password.</div>";
        }
    }
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Admin Login - Quizz-App</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Admin Login" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Style-CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!-- //Style-CSS -->

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>

    <!-- form section start -->
    <section class="w3l-mockup-form">
        <div class="container">
            <!-- form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="alert-close">
                        <span class="fa fa-close"></span>
                    </div>
                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                            <img src="images/image.svg" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Admin Login</h2>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="text" class="email" name="username" placeholder="Enter Your Username" required>
                            <input type="password" class="password" name="password" placeholder="Enter Your Password" required>
                            <button name="submit" class="btn" type="submit">Login</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->

    <script src="js/jquery.min.js"></script>
    <script>
        $(document).ready(function (c) {
            $('.alert-close').on('click', function (c) {
                $('.main-mockup').fadeOut('slow', function (c) {
                    $('.main-mockup').remove();
                });
            });
        });
    </script>

</body>

</html>
