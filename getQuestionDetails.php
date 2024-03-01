<?php
// Database connection
include 'config.php';

// Function to sanitize user input
function sanitizeInput($conn, $data) {
    return mysqli_real_escape_string($conn, $data);
}

// Check if questionNumber is set in the GET request
if (isset($_GET['questionNumber'])) {
    // Sanitize the input
    $questionNumber = sanitizeInput($conn, $_GET['questionNumber']);
    
    // SQL query to fetch question details
    $sql = "SELECT * FROM Questions WHERE QueNo = '$questionNumber'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch question details as an associative array
        $row = $result->fetch_assoc();
        // Return JSON response with question details
        echo json_encode($row);
    } else {
        // If no question found with the given number, return empty JSON object
        echo json_encode((object)[]);
    }
} else {
    // If questionNumber is not set in the GET request, return empty JSON object
    echo json_encode((object)[]);
}

// Close database connection
$conn->close();
?>
