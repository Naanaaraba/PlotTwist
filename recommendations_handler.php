<?php
require_once '../db/core.php';
require_once '../functions/display_recommendations_fxn.php';


// Validate and sanitize input
$user_id = getUserID();

// Prepare response array
$recommendations = [];

try {
    // Personality Book Match
    ob_start();
    display_personality_book_match_fxn($user_id);
    $recommendations['personality'] = ob_get_clean();

    // Mood-Based Recommendations
    ob_start();
    display_mood_book_match_fxn();
    $recommendations['mood'] = ob_get_clean();

    // Reading History Analysis
    ob_start();
    display_reading_history_book_match_fxn($user_id);
    $recommendations['reading_history'] = ob_get_clean();

    // Similar Books
    ob_start();
    display_similar_books_fxn($user_id);
    $recommendations['similar_books'] = ob_get_clean();

    // Collaborative Filtering
    ob_start();
    display_collaborative_books_fxn($user_id);
    $recommendations['collaborative'] = ob_get_clean();


    // Send successful response
    echo json_encode([
        'status' => 'success',
        'recommendations' => $recommendations
    ]);
} catch (Exception $e) {
    // Error handling
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to generate recommendations: ' . $e->getMessage()
    ]);
}
ob_end_flush(); // Flush the output buffer
exit;
