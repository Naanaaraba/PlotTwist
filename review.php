<?php
include (dirname(__FILE__)) . "/../db/core.php";
isLoggedIn();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review & Rating System | Plot Twist</title>
    <link rel="stylesheet" href="../assets/css/review.css">
</head>

<body>
    <!-- Header -->
    <?php include (dirname(__FILE__)) . "/../header.php"; ?>

    <!-- Main Review Section -->
    <div class="review-container">
        <h1>Reviews & Ratings</h1>


        <div class="rating-aggregation">
            <h2>Overall Rating: 4.5</h2>
            <div class="stars">
                ★★★★☆ (4.5/5)
            </div>
            <p>Based on <strong>124 reviews</strong></p>
        </div>

        <section class="write-review">
            <h2>Write a Review</h2>
            <form id="review-form">
                <label for="name">Your Name:</label>
                <input type="text" id="name" placeholder="Enter your name" required>

                <label for="rating">Your Rating:</label>
                <div class="star-rating">
                    ★★★★★
                    <input type="hidden" id="rating" value="0">
                </div>

                <label for="review-text">Your Review:</label>
                <textarea id="review-text" rows="4" placeholder="Write your review..." required></textarea>
                <button type="submit">Submit Review</button>
            </form>
        </section>

        <section class="reviews">
            <h2>User Reviews</h2>
            <div class="review">
                <div class="review-header">
                    <strong>Jane Doe</strong> - ★★★★★
                </div>
                <p>"This book was absolutely amazing. I loved every page!"</p>
                <div class="review-votes">
                    Was this helpful?
                    <button class="vote-btn" data-vote="helpful">👍 Helpful (10)</button>
                    <button class="vote-btn" data-vote="unhelpful">👎 Unhelpful (1)</button>
                </div>
            </div>

            <div class="review">
                <div class="review-header">
                    <strong>John Smith</strong> - ★★★★☆
                </div>
                <p>"A great read, but I found the ending a bit predictable."</p>
                <div class="review-votes">
                    Was this helpful?
                    <button class="vote-btn" data-vote="helpful">👍 Helpful (7)</button>
                    <button class="vote-btn" data-vote="unhelpful">👎 Unhelpful (0)</button>
                </div>
            </div>
        </section>
    </div>

    <script src="../assets/js/review_rating.js"></script>
</body>

</html>