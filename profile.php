<?php
include (dirname(__FILE__)) . "/../db/core.php";
include (dirname(__FILE__)) . "/../functions/user_profile_fxn.php";
isLoggedIn();
$user_id = getUserID();
$profile_details = get_user_info_fxn($user_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile | Plot Twist</title>
    <link rel="stylesheet" href="../assets/css/profile.css">
    <link rel="stylesheet" href="../assets/css/book_card.css">
</head>

<body>
    <!-- Header -->
    <?php include (dirname(__FILE__)) . "/../header.php"; ?>

    <!-- User Profile Section -->
    <section class="profile-container">
        <div class="profile-card">
            <div class="profile-image">
                <img src="../assets/images/avatar.jpeg" alt="User Avatar">
                <button class="edit-btn">Edit Profile</button>
            </div>
            <div class="profile-info">
                <h2><?php echo $profile_details['username'] ?></h2>
                <p><strong>Email:</strong> <?php echo $profile_details['email'] ?></p>
                <p><strong>Joined:</strong> <?php echo $profile_details['date_joined'] ?></p>
            </div>
        </div>

        <!-- Tabs -->
        <div class="profile-tabs">
            <button class="tab active" data-target="preferences">Reading Preferences</button>
            <button class="tab " data-target="history">Reading History</button>
            <button class="tab" data-target="quiz">Personality Quiz</button>
            <button class="tab" data-target="library">Bookshelf</button>
        </div>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Reading Preferences -->
            <div class="content-section active" id="preferences">
                <h3>Reading Preferences</h3>
                <form>
                    <label for="genre">Favorite Genre:</label>
                    <!-- <select id="genre">
                        <option>Thriller</option>
                        <option>Romance</option>
                        <option>Fantasy</option>
                        <option>Self-Improvement</option>
                    </select> -->

                    <?php echo get_reading_preferences_info_fxn($user_id) ?>

                    <label for="format">Preferred Format:</label>
                    <select id="format">
                        <option>eBooks</option>
                        <option>Physical Books</option>
                        <option>Both</option>
                    </select>
                    <button type="submit">Save Preferences</button>


            </div>

            <!-- Reading History -->
            <div class="content-section " id="history">
                <h3>Reading History</h3>
                <ul class="history-list">

                    <?php get_reading_history_fxn($user_id) ?>
                </ul>
            </div>


            <!-- Personality Quiz -->
            <div class="content-section" id="quiz">
                <h3>Personality Quiz Results</h3>
                <?php get_personality_quiz_fxn($user_id) ?>
            </div>

            <!-- Bookshelf Management -->
            <div class="content-section" id="library">
                <h3>My Bookshelf</h3>
                <div class="library-grid">
                    <?php get_bookshelf_fxn($user_id) ?>
                </div>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <!-- <footer>
        <p>&copy; 2024 Plot Twist. All rights reserved.</p>
    </footer> -->

    <script src="../assets/js/profile.js"></script>
</body>

</html>