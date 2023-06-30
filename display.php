<!DOCTYPE html>
<html>
<head>
    <title>Display Questions</title>
    <style>
        .question {
            margin-bottom: 20px;
        }
        .question p {
            font-weight: bold;
        }
        .options {
            padding-left: 20px;
        }
        .options label {
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <h2>Display Questions</h2>
    <form action="submit_answers.php" method="post">
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

        // Retrieve questions from the database
        $sql = "SELECT * FROM questions";
        $result = mysqli_query($conn, $sql);

        // Display questions and options
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='question'>";
                echo "<p>" . $row['question'] . "</p>";
                echo "<div class='options'>";
                echo "<label><input type='checkbox' name='options[" . $row['id'] . "][]' value='option1'>" . $row['option1'] . "</label>";
                echo "<label><input type='checkbox' name='options[" . $row['id'] . "][]' value='option2'>" . $row['option2'] . "</label>";
                echo "<label><input type='checkbox' name='options[" . $row['id'] . "][]' value='option3'>" . $row['option3'] . "</label>";
                echo "<label><input type='checkbox' name='options[" . $row['id'] . "][]' value='option4'>" . $row['option4'] . "</label>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "No questions found.";
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
        <input type="submit" value="Submit Answers">
    </form>
</body>
</html>