<?php
// Function to count reviews for a specific book
function count_book_reviews_fxn($book_id, $conn)
{
    // Sanitize input
    $book_id = mysqli_real_escape_string($conn, $book_id);

    // Count reviews
    $count_sql = "SELECT COUNT(*) AS review_count 
                  FROM user_book_ratings 
                  WHERE book_id = '$book_id'";

    $count_result = mysqli_query($conn, $count_sql);

    if ($count_result) {
        $count_row = mysqli_fetch_assoc($count_result);
        return $count_row['review_count'];
    }

    return 0;
}

// Function to get book reviews with user details and ratings
function get_book_reviews_fxn($book_id, $conn)
{
    // Sanitize input
    $book_id = mysqli_real_escape_string($conn, $book_id);

    // Query to get reviews with user details and rating information
    $reviews_sql = "SELECT 
                        ubr.review_text, 
                        ubr.date_added, 
                        u.username, 
                        r.rating_id,
                        r.rating_name
                    FROM user_book_ratings ubr
                    JOIN users u ON ubr.user_id = u.user_id
                    JOIN ratings r ON ubr.rating_id = r.rating_id
                    WHERE ubr.book_id = '$book_id'
                    ORDER BY ubr.date_added DESC";

    $reviews_result = mysqli_query($conn, $reviews_sql);

    $reviews = [];
    if ($reviews_result && mysqli_num_rows($reviews_result) > 0) {
        while ($review = mysqli_fetch_assoc($reviews_result)) {
            $reviews[] = $review;
        }
    }

    return $reviews;
}

// Example usage in a book details page:
// $book_id = $_GET['book_id']; // Assuming you're passing book ID

// Count reviews

// Get reviews


// Displaying reviews (example)
// echo "<h3>Reviews ($review_count)</h3>";
// foreach ($book_reviews as $review) {
//     echo "<div class='review'>
//             <p><strong>{$review['username']}</strong> rated it {$review['rating_name']} ({$review['rating_value']}/5)</p>
//             <p>{$review['review_text']}</p>
//             <small>Posted on " . date('F j, Y', strtotime($review['date_added'])) . "</small>
//           </div>";
// }
