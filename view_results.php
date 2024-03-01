<?php
session_start();
if (!isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: index.php");
    die();
}

include 'config.php';

// Retrieve marks for the current user
$query = mysqli_query($conn, "SELECT Marks FROM Marks WHERE email='{$_SESSION['SESSION_EMAIL']}'");

if (mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_assoc($query);
    $marks = $row['Marks'];
} else {
    $error_message = "No marks found for the current user.";
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>View Results - Quizz-App</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="View Results" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Style-CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!-- //Style-CSS -->

    <style>
        /* Custom CSS for View Results page */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top: 50px;
        }

        h1 {
            font-size: 36px;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 20px;
            color: #666;
            margin-bottom: 30px;
        }

        .button {
            padding: 12px 24px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>View Results</h1>
        <?php if (isset($error_message)) : ?>
            <p><?php echo $error_message; ?></p>
        <?php elseif (isset($marks)) : ?>
            <p>Your marks: <?php echo $marks; ?></p>
        <?php endif; ?>
        <a href="welcome.php" class="button">Back to Home</a>
    </div>

</body>

</html>
