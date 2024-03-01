<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['SESSION_EMAIL'])) {
    http_response_code(403);
    die("Unauthorized access");
}

// Include database connection
include 'config.php';

// Fetch correct options from the database
$query = "SELECT CorrectOpt FROM Questions";
$result = $conn->query($query);
$selectedAnswers = json_decode(urldecode($_GET['answers']));

if ($result->num_rows > 0) {
    $correctOptions = array();
    while ($row = $result->fetch_assoc()) {
        $correctOptions[] = $row['CorrectOpt'];
    }

    // Calculate marks
    $marks = 0;
    for ($i = 0; $i < count($selectedAnswers); $i++) {
        if ($selectedAnswers[$i] === $correctOptions[$i] - 1) {
            $marks++;
        }
    }

    // Retrieve the current user's email
    $email = $_SESSION['SESSION_EMAIL'];

    // Insert marks into the database for the current user
    $insertQuery = "INSERT INTO Marks (email, Marks, isAttempted) VALUES ('$email', $marks, 1)";
    if ($conn->query($insertQuery) === TRUE) {
        echo "Marks inserted successfully!";
    } else {
        http_response_code(500);
        echo "Error inserting marks into the database: " . $conn->error;
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'No correct options found']);
}

// Close database connection
$conn->close();
?>
