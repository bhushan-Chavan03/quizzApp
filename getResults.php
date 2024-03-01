<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: normal;
        }

        .name {
            font-weight: bold;
        }

        .marks {
            color: #007bff;
        }

        .reallow-test-btn {
            padding: 6px 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .reallow-test-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Results</h1>
        <table>
            <tr>
                <th>Name</th>
                <th>Marks Obtained</th>
                <th>Action</th>
            </tr>
            <?php
            // Start the session
            session_start();

            // Include database connection
            include 'config.php';

            // Fetch user names and their corresponding marks from the Marks table
            $query = "SELECT email, name, Marks FROM Marks";
            $result = $conn->query($query);

            // Check if query was successful
            if ($result) {
                // Loop through the results and output each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='name'>" . $row['name'] . "</td>";
                    echo "<td class='marks'>" . $row['Marks'] . "</td>";
                    echo "<td><button class='reallow-test-btn' onclick='confirmReallow(\"" . $row['name'] . "\", \"" . $row['email'] . "\")'>Reallow Test</button></td>";
                    echo "</tr>";
                }
            } else {
                // Error handling if query fails
                echo "<tr><td colspan='3'>Error: " . $conn->error . "</td></tr>";
            }

            // Close database connection
            $conn->close();
            ?>
        </table>
    </div>

    <script>
        function confirmReallow(name, email) {
            if (confirm("Are you sure you want to reallow the test for " + name + "?")) {
                reallowTest(email);
            }
        }

        function reallowTest(email) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "<?php echo $_SERVER['PHP_SELF']; ?>", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Reload the page to reflect changes
                    location.reload();
                }
            };
            xhr.send("email=" + email);
        }
    </script>

<?php
// Handle POST request to update isAttempted field
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email parameter is set
    if (isset($_POST['email'])) {
        // Include database connection
        include 'config.php';

        // Sanitize input to prevent SQL injection
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        
        // Update isAttempted to 0 in the Marks table for the given email
        $updateQuery = "UPDATE Marks SET isAttempted = 0 WHERE email = '$email'";
        if ($conn->query($updateQuery) === TRUE) {
            // Success message (you can customize this message as needed)
            echo "<script>alert('Test reallowed successfully for the selected user.');</script>";
        } else {
            // Error message (you can customize this message as needed)
            echo "<script>alert('Error reallowing test: " . $conn->error . "');</script>";
        }

        // Close database connection
        $conn->close();
    } else {
        // Debugging: Output message if email parameter is not set
        echo "<script>alert('Email parameter is not set.');</script>";
    }
}
?>

</body>

</html>
