
<?php
// include database connection file
require_once(dirname(__FILE__) . "/../db/db_connection.php");
require_once(dirname(__FILE__) . "/../db/core.php");

if (isset($_POST["submitQuiz"])) {
    // Get form data
    $user = getUserID();
    $personality = $_POST['personality'];

    // Check if a quiz result exists for the user
    $check_sql = "SELECT * FROM quiz_results WHERE user_id = '$user'";
    $result = $conn->query($check_sql);

    if ($result && $result->num_rows > 0) {
        // Update the existing record
        $update_sql = "UPDATE quiz_results SET personality = '$personality' WHERE user_id = '$user'";
        if ($conn->query($update_sql) === TRUE) {
            echo 'success';
        } else {
            echo 'Failed to update quiz result';
        }
    } else {
        // Insert a new record
        $insert_sql = "INSERT INTO quiz_results (user_id, personality) VALUES ('$user', '$personality')";
        if ($conn->query($insert_sql) === TRUE) {
            echo 'success';
        } else {
            echo 'Failed to insert quiz result';
        }
    }

    // Update quiz status
    $update_quiz_status = "UPDATE users SET first_login_quiz_completed = 1 WHERE user_id = '$user'";
    if (!$conn->query($update_quiz_status)) {
        echo 'Failed to update quiz status';
    }
}


if (isset($_POST["fetchQuizStatus"])) {
    // Get form data
    $user = getUserID();

    // Insert data into the database
    $sql = "SELECT first_login_quiz_completed FROM users WHERE user_id='$user'";

    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        $quizCompleted = $row['first_login_quiz_completed'];

        echo $quizCompleted;
    }
}
