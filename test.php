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

?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Test - Quizz-App</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Test" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>

<body>



    <div class="container">
        <!-- Left section with question boxes -->
        <div class="left-section">
            <div class="question-boxes">
                <?php
                // Loop to generate 50 question boxes
                for ($i = 1; $i <= 50; $i++) {
                    echo "<div class='question-box' data-question='$i'>$i</div>";
                }
                ?>
            </div>
        </div>

        <!-- Right section with question details -->
        <div class="right-section">
            <div class="question-details">
                <div class="question">Click the box to load question!</div>
                <div class="options">
                    <div class="option">Option 1</div>
                    <div class="option">Option 2</div>
                    <div class="option">Option 3</div>
                    <div class="option">Option 4</div>
                </div>
                <div class="button-group">
                    <button class="button" id="previous">Previous</button>
                    <button class="button" id="next">Next</button>
                </div>
                <div class="button-group" style="display:flex; justify-content:center;">
                    <button class="button" id="submitBtn">Submit test</button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script>
        
        $(document).ready(function () {
            // Array to store selected answers
            var selectedAnswers = new Array(50).fill(null);
            var currentQuestion = 1;

            // Update question boxes with answers
            updateQuestionBoxes();

            // Event listener for clicking on a question box
            $(".question-box").click(function () {
                var questionNumber = $(this).data("question");
                displayQuestion(questionNumber);
            });

            // Event listener for clicking on an option
            $(".option").click(function () {
                var optionIndex = $(this).index();
                var questionNumber = $(".question-box.active").data("question");

                // Update selected answer in the array
                selectedAnswers[questionNumber - 1] = optionIndex;
                console.log(selectedAnswers);

                // Remove selected class from all options
                $(".option").removeClass("selected");
                // Add selected class to the clicked option
                $(this).addClass("selected");

                // Update the color of the question box based on whether it has an answer
                $(".question-box").eq(questionNumber - 1).addClass("has-answer");
            });

            // Event listener for "Previous" button
            $("#previous").click(function () {
                if (currentQuestion > 1) {
                    currentQuestion--;
                    displayQuestion(currentQuestion);
                }
            });

            // Event listener for "Next" button
            $("#next").click(function () {
                if (currentQuestion < 50) {
                    currentQuestion++;
                    displayQuestion(currentQuestion);
                }
            });

            // Function to display the question and its options
            // function displayQuestion(questionNumber) {
            //     // Remove active class from all question boxes
            //     $(".question-box").removeClass("active");
            //     // Add active class to the question box corresponding to the current question
            //     $(".question-box[data-question='" + questionNumber + "']").addClass("active");

            //     // Dummy code to simulate loading question details
            //     $(".question").text("Question " + questionNumber + ":");
            //     // Update the options based on selected answer for this question
            //     updateOptions(selectedAnswers[questionNumber - 1]);
            // }


            // Function to display the question and its options
function displayQuestion(questionNumber) {
    // Remove active class from all question boxes
    $(".question-box").removeClass("active");
    // Add active class to the question box corresponding to the current question
    $(".question-box[data-question='" + questionNumber + "']").addClass("active");

    // AJAX call to fetch question details from the server
    $.ajax({
        url: 'fetch_question.php', // PHP script to fetch question details
        method: 'POST',
        data: { questionNumber: questionNumber },
        dataType: 'json',
        success: function(response) {
            // Check if response is successful
            if (response.success) {
                // Update question and options
                $(".question").text("Question " + questionNumber + ": " + response.question);
                $(".option").eq(0).text(response.opt1);
                $(".option").eq(1).text(response.opt2);
                $(".option").eq(2).text(response.opt3);
                $(".option").eq(3).text(response.opt4);
                
                // Update the options based on selected answer for this question
                updateOptions(selectedAnswers[questionNumber - 1]);
            } else {
                // Display error message if question not found
                $(".question").text("Question " + questionNumber + ": Not found");
                $(".options").empty(); // Clear options
            }
        },
        error: function(xhr, status, error) {
            // Display error message if AJAX request fails
            console.error(xhr.responseText);
            $(".question").text("Error loading question");
            $(".options").empty(); // Clear options
        }
    });
}


    $("#submitBtn").click(function () {
    // Construct the URL with query parameters
    var url = 'result.php?email=<?php echo urlencode($_SESSION['SESSION_EMAIL']); ?>&answers=' + encodeURIComponent(JSON.stringify(selectedAnswers));
    
    // Redirect to the next page
      window.location.href = url;
     });

            // Function to update options based on selected answer
            function updateOptions(selectedOptionIndex) {
                // Remove selected class from all options
                $(".option").removeClass("selected");
                // Add selected class to the option if it matches the selected answer
                if (selectedOptionIndex != null) {
                    $(".options .option").eq(selectedOptionIndex).addClass("selected");
                }
            }

            // Function to update question boxes with answers
            function updateQuestionBoxes() {
                $(".question-box").each(function () {
                    var questionNumber = $(this).data("question");
                    if (selectedAnswers[questionNumber - 1] != null) {
                        $(this).addClass("has-answer");
                    }
                });
            }
        });
    </script>

</body>

</html>