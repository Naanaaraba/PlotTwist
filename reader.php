<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include (dirname(__FILE__)) . "/../db/core.php";
include (dirname(__FILE__)) . "/../functions/get_single_book_fxn.php";
include (dirname(__FILE__)) . "/../functions/get_ratings_fxn.php";
include (dirname(__FILE__)) . "/../functions/get_reviews_fxn.php";
isLoggedIn();
$book_id = isset($_GET["book_id"]) ? $_GET["book_id"] : '';
$book_details = get_single_book_fxn($book_id);
$book_reviews = get_book_reviews_fxn($book_id, $conn);
$review_count = count_book_reviews_fxn($book_id, $conn);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reading Interface | Plot Twist</title>
    <link rel="stylesheet" href="../assets/css/library.css">
</head>

<body>
    <!-- Header -->
    <?php include (dirname(__FILE__)) . "/../header.php"; ?>

    <?php
    if (!empty($book_id)) {
        $book_image = !empty($book_details["cover_file"]) ? $book_details["cover_file"] : "../assets/images/bookart.jpg";
    ?>
        <div class="reading_book_info">
            <div class="cover">
                <img src="<?php echo $book_image; ?>" alt="">
            </div>
            <div class="details">

                <div class="top">
                    <h4>Description</h4>
                    <div class="">
                        <button id="leave review">Leave review</button>
                        <p><?php echo $review_count . ' reviews ' ?></p>
                    </div>
                </div>
                <p><?php echo $book_details["description"]; ?></p>
            </div>
        </div>
    <?php
    }
    ?>

    <div class="reader-container">
        <aside class="sidebar">
            <h3>Chapters</h3>
            <ul id="chapter-list" class="chapter-list">
            </ul>

            <div id="bookmarks-section">
                <h3>Bookmarks</h3>
                <ul id="bookmarks-list"></ul>
            </div>
        </aside>

        <!-- Reader Content -->
        <main class="reader-content">
            <!-- Toolbar -->
            <div class="toolbar">
                <button id="add-bookmark">🔖 Bookmark</button>
                <select id="font-size">
                    <option value="16">Font Size: Small</option>
                    <option value="18" selected>Font Size: Medium</option>
                    <option value="20">Font Size: Large</option>
                </select>
                <button id="theme-toggle">🌙 Night Mode</button>
            </div>

            <!-- Reading Content -->
            <div class="text-content" id="text-content">

            </div>

            <!-- Progress Bar -->
            <div class="progress-bar-container">
                <label>Reading Progress:</label>
                <progress id="progress-bar" value="0" max="100"></progress>
                <span id="progress-percent">0%</span>
            </div>

            <!-- Page Navigation -->
            <div class="page-navigation">
                <button id="prev-page">Previous</button>
                <span id="page-number"></span>
                <button id="next-page">Next</button>
            </div>
        </main>

        <aside class="sidebar review_items">
            <h3>Reviews</h3>
            <?php foreach ($book_reviews as $review) {
            ?>
                <div class="review_item">
                    <h5><?php echo $review["username"]; ?></h5>
                    <p><?php echo $review["review_text"]; ?></p>
                </div>
            <?php
            } ?>
        </aside>
    </div>

    <!-- Review Modal -->
    <div id="reviewModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="close-review-modal">&times;</span>
            <h2>Leave a Review</h2>
            <form id="reviewForm">
                <label for="rating">Rating:</label>
                <?php get_ratings_fxn() ?>

                <label for="review-text">Review:</label><br>
                <textarea id="review-text" name="review-text" rows="5" cols="40"></textarea><br><br>

                <button type="submit" id="submit-review">Submit Review</button>
            </form>
        </div>
    </div>

    <script>
        // Get modal element
        const reviewModal = document.getElementById('reviewModal');
        const leaveReviewBtn = document.getElementById('leave review');
        const closeModalBtn = document.getElementById('close-review-modal');
        const reviewForm = document.getElementById('reviewForm');

        // Open the modal when the "Leave Review" button is clicked
        leaveReviewBtn.addEventListener('click', () => {
            reviewModal.style.display = 'block';
        });

        // Close the modal when the "X" button is clicked
        closeModalBtn.addEventListener('click', () => {
            reviewModal.style.display = 'none';
        });

        // Close the modal if the user clicks outside of the modal
        window.addEventListener('click', (event) => {
            if (event.target === reviewModal) {
                reviewModal.style.display = 'none';
            }
        });

        // Handle form submission
        reviewForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const rating = document.getElementById('rating').value;
            const reviewText = document.getElementById('review-text').value;

            // Validate inputs
            if (!reviewText || !rating) {
                alert("Please provide a rating and a review.");
                return;
            }

            // Prepare data to send to the server (can be handled with an AJAX request)
            const reviewData = {
                book_id: <?php echo $book_id; ?>, // Pass the book ID dynamically
                rating: rating,
                review_text: reviewText
            };

            // Send review data (you can use fetch or XMLHttpRequest)
            fetch('../actions/submit_review_action.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(reviewData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Thank you for your review!");
                        document.location.reload();
                        reviewModal.style.display = 'none'; // Close modal after submission
                    } else {
                        alert("Error submitting review, please try again.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred while submitting your review.");
                });
        });
    </script>

    <!-- Include epub.js library -->

    <script src="../assets/js/zip.min.js"></script>
    <script src="https://unpkg.com/epubjs/dist/epub.min.js"></script>
    <script src="../assets/js/library.js"></script>
</body>

</html>