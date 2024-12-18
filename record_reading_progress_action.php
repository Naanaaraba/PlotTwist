<?php

// include database connection file
require_once(dirname(__FILE__) . "/../db/core.php");
require_once(dirname(__FILE__) . "/../db/db_connection.php");


if (isset($_GET["book_id"], $_GET["action"], $_GET["location"], $_GET["progress"])) {
    global $conn;
    $book_id = $_GET["book_id"];
    $action = $_GET["action"];
    $location = $_GET["location"];
    $progress = $_GET["progress"];
    $user_id = getUserID(); // Replace with actual user ID (e.g., from session)

    // Handle start action
    if ($action === 'start') {
        // Check if a progress record already exists for the user and book
        $query = "SELECT * FROM reading_progress WHERE user_id = ? AND book_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $user_id, $book_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            // Insert new record if no progress record exists
            $query = "INSERT INTO reading_progress (user_id, book_id, status, date_started, current_page_location) VALUES (?, ?, 1, NOW(), ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iis", $user_id, $book_id, $location);
            $stmt->execute();
            echo json_encode(['status' => 'success', 'message' => 'Progress started']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Progress already started']);
        }
    } elseif ($action === 'update') {
        // Determine the new status based on the progress
        $new_status = $progress === '100' ? 2 : 1; // 2 means completed, 1 means in progress
        // $date_completed = ($new_status === 2) ? date("Y-m-d H:i:s") : NULL;

        // Handle update action
        $query = "UPDATE reading_progress 
                  SET status = ?, 
                      date_completed = CASE WHEN ? = 2 THEN NOW() ELSE NULL END, 
                      current_page_location = ?, 
                      progress_count = ? 
                  WHERE user_id = ? AND book_id = ?";

        $stmt = $conn->prepare($query);
        // Bind parameters: new_status (int), location (string), progress (int), user_id (int), book_id (int)
        $stmt->bind_param("iisiii", $new_status, $new_status, $location, $progress, $user_id, $book_id);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Progress updated']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No progress found to update', 'jj' => $new_status]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Missing required parameters']);
}
