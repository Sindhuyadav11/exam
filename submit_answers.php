<?php
// Establish a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the submitted form data
$options = $_POST['options'];

// Process the answered options
foreach ($options as $questionId => $answeredOptions) {
    // Convert answered options to their corresponding indexes
    $answeredIndexes = array();
    foreach ($answeredOptions as $option) {
        $optionIndex = substr($option, -1);
        $answeredIndexes[] = $optionIndex;
    }

    $answeredOptionsStr = implode(",", $answeredIndexes); // Convert array to comma-separated string
    $sql = "INSERT INTO answered_quiz (question_id, answered_options) VALUES ('$questionId', '$answeredOptionsStr')";
    mysqli_query($conn, $sql);
}

// Retrieve the correct answers and question details from the database
$sql = "SELECT q.question, q.correct_option, ua.answered_options, ua.question_id
        FROM questions AS q
        INNER JOIN answered_quiz AS ua ON q.id = ua.question_id";
$result = mysqli_query($conn, $sql);

// Count the number of correct answers
$correctCount = 0;

// Display the result
if (mysqli_num_rows($result) > 0) {
    echo "<h2>Result</h2>";
    while ($row = mysqli_fetch_assoc($result)) {
        $question = isset($row['question']) ? $row['question'] : "N/A";
        $correctAnswer = isset($row['correct_option']) ? $row['correct_option'] : "N/A";
        $userAnswer = isset($row['answered_options']) ? $row['answered_options'] : "N/A";

        // Check if the user answer matches the correct answer
        if ($userAnswer == $correctAnswer) {
            $correctCount++;
        }
    }
    echo "<p>Result: " . $correctCount . "</p>";
} else {
    echo "No results found.";
}

// Close the database connection
mysqli_close($conn);
?>