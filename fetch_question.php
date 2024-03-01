<?php
// Database connection
include 'config.php';

// Function to sanitize user input
function sanitizeInput($conn, $data) {
    return mysqli_real_escape_string($conn, $data);
}

// Check if question number is provided in the POST request
if (isset($_POST['questionNumber'])) {
    // Sanitize input to prevent SQL injection
    $questionNumber = sanitizeInput($conn, $_POST['questionNumber']);

    // Query to fetch question details from the database
    $sql = "SELECT * FROM Questions WHERE QueNo = '$questionNumber'";
    $result = $conn->query($sql);

    // Check if query was successful
    if ($result) {
        // Check if question exists
        if ($result->num_rows > 0) {
            // Fetch question details
            $row = $result->fetch_assoc();
            $question = $row['Question'];
            $opt1 = $row['Opt1'];
            $opt2 = $row['Opt2'];
            $opt3 = $row['Opt3'];
            $opt4 = $row['Opt4'];

            // Construct JSON response
            $response = array(
                'success' => true,
                'question' => $question,
                'opt1' => $opt1,
                'opt2' => $opt2,
                'opt3' => $opt3,
                'opt4' => $opt4
            );
            // Send JSON response
            echo json_encode($response);
        } else {
            // Question not found
            $response = array('success' => false);
            echo json_encode($response);
        }
    } else {
        // Query failed
        $response = array('success' => false);
        echo json_encode($response);
    }
} else {
    // Question number not provided
    $response = array('success' => false);
    echo json_encode($response);
}

// Close database connection
$conn->close();
?>
