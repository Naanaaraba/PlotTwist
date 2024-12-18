<?php
require_once(dirname(__FILE__) . "/../db/db_connection.php");

if (isset($_POST['user_id'])) {
    $user_id = (int)$_POST['user_id'];

    // Prepare the SQL statement to prevent SQL injection
    $sql = "DELETE FROM users WHERE user_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            echo "User deleted successfully.";
        } else {
            echo "Error deleting user.";
        }

        $stmt->close();
    } else {
        echo "SQL statement preparation failed.";
    }
} else {
    echo "No user ID provided.";
}
