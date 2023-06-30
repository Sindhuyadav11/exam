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
$question = $_POST['question'];
$options = $_POST['options'];
$correct_options = $_POST['correct_options'];

// Insert the question into the database
$sql = "INSERT INTO questions (question, correct_option) VALUES ('$question', '$correct_options')";
if (mysqli_query($conn, $sql)) {
    $questionId = mysqli_insert_id($conn); // Get the auto-generated question ID
    
    // Insert options into the database
    foreach ($options as $index => $option) {
        $optionNumber = $index + 1; // Option number (1-based index)
        $sql = "UPDATE questions SET option$optionNumber = '$option' WHERE id = '$questionId'";
        mysqli_query($conn, $sql);
    }
    
    echo "Question added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>