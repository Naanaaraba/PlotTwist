<?php
include (dirname(__FILE__)) . "/../db/core.php";
include (dirname(__FILE__)) . "/../functions/display_recommendations_fxn.php";
isLoggedIn();
$user_id = getUserID();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommendation Eng Plot Twist</title>
    <link rel="stylesheet" href="../assets/css/recommendation.css">
</head>

<body>

    <!-- Header -->
    <?php include (dirname(__FILE__)) . "/../header.php"; ?>

    <!-- Main Container -->
    <div class="recommendation-container">
        <!-- Introduction Section -->
        <section class="intro">
            <h1>Personalized Recommendations</h1>
            <p>Discover books that match your personality, mood, and reading habits.</p>
            <button id="refresh-btn">🔄 Refresh Recommendations</button>
        </section>

        <!-- Recommendation Categories -->
        <div id="recommendationsContent" class="recommendation-sections">

            <!-- Personality Match -->
            <section class="recommendation-box">
                <h2>📚 Personality Book Match</h2>
                <p>Based on your personality profile, we recommend:</p>
                <?php display_personality_book_match_fxn($user_id);  ?>
            </section>

            <!-- Mood-based Suggestions -->
            <section class="recommendation-box">
                <h2>🎭 Mood-Based Recommendations</h2>
                <p>Feeling adventurous today? Try these:</p>
                <?php display_mood_book_match_fxn();  ?>
            </section>

            <!-- Reading History Analysis -->
            <section class="recommendation-box">
                <h2>🔍 Based on Your Reading History</h2>
                <p>Readers like you loved:</p>
                <?php display_reading_history_book_match_fxn($user_id);  ?>
            </section>

            <!-- Similar Books -->
            <section class="recommendation-box">
                <h2>📖 Similar Books</h2>
                <p>If you enjoyed <strong><?php display_similar_book_name_fxn($user_id);  ?></strong>, you might like:</p>
                <?php display_similar_books_fxn($user_id);  ?>
            </section>

            <!-- Collaborative Filtering -->
            <section class="recommendation-box">
                <h2>🤝 Collaborative Filtering</h2>
                <p>Other readers with similar tastes recommend:</p>
                <?php display_collaborative_books_fxn($user_id);  ?>
            </section>
        </div>
    </div>

    <script src="../assets/js/recommendation.js"></script>
</body>

</html>