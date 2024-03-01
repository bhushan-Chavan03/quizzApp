<?php
session_start();
if (!isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: index.php");
    die();
}

include 'config.php';

$query = mysqli_query($conn, "SELECT * FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}'");

if (mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_assoc($query);
    $userName = $row['name'];
}

// Check if the test has already been attempted by the user
$isAttemptedQuery = mysqli_query($conn, "SELECT isAttempted FROM Marks WHERE email='{$_SESSION['SESSION_EMAIL']}'");
$isAttempted = mysqli_fetch_assoc($isAttemptedQuery)['isAttempted'];

if ($isAttempted) {
    $message = "Test already attempted. You can view your results.";
} else {
    $message = "";
}

?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Welcome - Quizz-App</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Welcome" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Style-CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!-- //Style-CSS -->

    <style>
        /* Custom CSS for welcome page */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        .welcome-message {
            font-size: 32px;
            margin-bottom: 20px;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
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

        .logout-link {
            display: block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .logout-link:hover {
            color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="welcome-message">Welcome, <?php echo $userName; ?>!</div>
        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
            <div class="button-group">
            <a href="view_results.php?email=<?php echo $_SESSION['SESSION_EMAIL']; ?>" class="button">View Results</a>

            </div>
        <?php else: ?>
            <div class="button-group">
                <a href="test.php?email=<?php echo $_SESSION['SESSION_EMAIL']; ?>" class="button">Take Test</a>
                <a href="view_results.php?email=<?php echo $_SESSION['SESSION_EMAIL']; ?>" class="button">View Results</a>

            </div>
        <?php endif; ?>
        <a href="logout.php" class="logout-link">Logout</a>
    </div>

</body>

</html>
