<?php
// Database connection
include 'config.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize user input
function sanitizeInput($conn, $data) {
    return mysqli_real_escape_string($conn, $data);
}

// Function to fetch question details from the database
function getQuestionDetails($conn, $questionNumber) {
    $questionNumber = sanitizeInput($conn, $questionNumber);
    $sql = "SELECT * FROM Questions WHERE QueNo = '$questionNumber'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return false;
    }
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all fields are set
    if (isset($_POST['question-number']) && isset($_POST['question-text']) && isset($_POST['option1']) && isset($_POST['option2']) && isset($_POST['option3']) && isset($_POST['option4']) && isset($_POST['correct-option'])) {
        // Sanitize user input
        $questionNumber = sanitizeInput($conn, $_POST['question-number']);
        $questionText = sanitizeInput($conn, $_POST['question-text']);
        $option1 = sanitizeInput($conn, $_POST['option1']);
        $option2 = sanitizeInput($conn, $_POST['option2']);
        $option3 = sanitizeInput($conn, $_POST['option3']);
        $option4 = sanitizeInput($conn, $_POST['option4']);
        $correctOption = sanitizeInput($conn, $_POST['correct-option']);

        // SQL query to update question in the database
        $sql = "UPDATE Questions
        SET Question = '$questionText', Opt1 = '$option1', Opt2 = '$option2', Opt3 = '$option3', Opt4 = '$option4', CorrectOpt = '$correctOption'
        WHERE QueNo = '$questionNumber'
        ";

        if ($conn->query($sql) === TRUE) {
            echo "Question saved successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "All fields are required";
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Question Panel -Quizz-App</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Question Panel" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Style-CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!-- //Style-CSS -->

    <style>
        /* Custom CSS for question panel */
        .question-boxes {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            gap: 10px;
        }

        .question-box {
            width: calc(12% - 6px); 
            height: 35px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .question-box:hover {
            background-color: #ddd;
        }

        .question-box.active {
            background-color: #b3d7ff;
        }

        .question-details {
            margin-top: 20px;
        }

        .question-details h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .question-details input[type="text"],
        .question-details input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .question-details button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .question-details button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

  <section style="display:flex;">

  <section class="w3l-mockup-form">
        <div class="container">
            <div class="content-wthree">
                <div class="question-boxes">
                    <?php
                    // Loop to generate 50 question boxes
                    for ($i = 1; $i <= 50; $i++) {
                        echo "<div class='question-box' data-question='$i'>$i</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <!-- //Left section with question boxes -->

    <!-- Right section with question details -->
    <section class="w3l-mockup-form question-details" style="display: none;">
        <div class="container">
            <div class="content-wthree">
                <div class="question-info">
                    <h2>Question <span id="question-number"></span></h2>
                    <input type="text" id="question" placeholder="Enter your question" required>
                    <input type="text" id="option1" placeholder="Option 1" required>
                    <input type="text" id="option2" placeholder="Option 2" required>
                    <input type="text" id="option3" placeholder="Option 3" required>
                    <input type="text" id="option4" placeholder="Option 4" required>
                    <select style="height:25px; margin:10px;" id="correct-option" required>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                        <option value="4">Option 4</option>
                    </select>
                    <button id="submit-question" type="button">Submit</button>
                </div>
            </div>
        </div>
    </section>


  </section>

    <script src="js/jquery.min.js"></script>

    <script>
       $(document).ready(function () {
    // Event listener for clicking on a question box
    $(".question-box").click(function () {
        // Remove active class from all question boxes
        $(".question-box").removeClass("active");
        // Add active class to the clicked question box
        $(this).addClass("active");

        // Show the right section with question details
        $(".question-details").show();

        // Get the question number from data attribute of clicked question box
        var questionNumber = $(this).data("question");
        // Set the question number in the question details section
        $("#question-number").text(questionNumber);
        
        // Call the function to fetch and display question details
        showQuestion(questionNumber);
    });

    // Function to fetch and display question details
    function showQuestion(questionNumber) {
        // Perform AJAX request to fetch question details
        $.ajax({
            type: "GET",
            url: "getQuestionDetails.php",
            data: { questionNumber: questionNumber },
            success: function (response) {
                // Parse JSON response
                var questionDetails = JSON.parse(response);
                // Populate input fields with retrieved question details
                $("#question-number").text(questionDetails.QueNo);
                $("#question").val(questionDetails.Question);
                $("#option1").val(questionDetails.Opt1);
                $("#option2").val(questionDetails.Opt2);
                $("#option3").val(questionDetails.Opt3);
                $("#option4").val(questionDetails.Opt4);
                $("#correct-option").val(questionDetails.CorrectOpt);
            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText);
            }
        });
    }

    // Event listener for submitting question details
    $("#submit-question").click(function () {
        // Get question details
        var questionNumber = $("#question-number").text();
        var question = $("#question").val();
        var option1 = $("#option1").val();
        var option2 = $("#option2").val();
        var option3 = $("#option3").val();
        var option4 = $("#option4").val();
        var correctOption = $("#correct-option").val();

        // AJAX request to submit the form data
        $.ajax({
            type: "POST",
            url: "", // Leave this empty to submit to the same file
            data: {
                'question-number': questionNumber,
                'question-text': question,
                'option1': option1,
                'option2': option2,
                'option3': option3,
                'option4': option4,
                'correct-option': correctOption
            },
            success: function (response) {
                // Display success message or handle response as needed
                alert("Data inserted successfully");
            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText);
            }
        });
    });
});

    </script>

</body>

</html>
