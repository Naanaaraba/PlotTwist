<?php
// Include necessary files
include_once(dirname(__FILE__) . "/../db/core.php");

// Set response header
header('Content-Type: application/json');

// Initialize response array
$response = [
    'success' => false,
    'message' => ''
];

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Validate input
    if (!isset($data['book_id']) || !isset($data['rating']) || !isset($data['review_text'])) {
        $response['message'] = 'Invalid input';
        echo json_encode($response);
        exit;
    }

    // Sanitize and validate inputs
    $book_id = mysqli_real_escape_string($conn, $data['book_id']);
    $rating_id = mysqli_real_escape_string($conn, $data['rating']);
    $review_text = mysqli_real_escape_string($conn, trim($data['review_text']));

    // Get the current user's ID
    $user_id = $_SESSION['user_id']; // Assuming you store user ID in session

    // Check if user has already reviewed this book
    $check_review_sql = "SELECT book_id FROM user_book_ratings 
                         WHERE user_id = '$user_id' AND book_id = '$book_id'";
    $check_result = mysqli_query($conn, $check_review_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $response['message'] = 'You have already reviewed this book';
        echo json_encode($response);
        exit;
    }

    // Prepare SQL to insert review
    $insert_sql = "INSERT INTO user_book_ratings (
        user_id, 
        book_id, 
        review_text, 
        date_added,
        rating_id
    ) VALUES (
        '$user_id', 
        '$book_id', 
        '$review_text', 
        NOW(),
        '$rating_id'
    )";

    // Execute the query
    if (mysqli_query($conn, $insert_sql)) {
        // Optional: Update book's average rating if needed
        $response['success'] = true;
        $response['message'] = 'Review submitted successfully';
    } else {
        $response['message'] = 'Error submitting review: ' . mysqli_error($conn);
    }
} else {
    $response['message'] = 'Invalid request method';
}

// Send JSON response
echo json_encode($response);
exit;
