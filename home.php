<?php
include (dirname(__FILE__)) . "/../db/core.php";
include (dirname(__FILE__)) . "/../functions/display_home_books_fxn.php";
isLoggedIn();
$user_id = getUserID();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Plot Twist</title>
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/css/book_card.css">
    <link rel="stylesheet" href="../assets/css/quiz.css">
    <link rel="stylesheet" href="../assets/boxicons/css/boxicons.min.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            position: relative;
        }

        .close-modal {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-modal:hover,
        .close-modal:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <?php include (dirname(__FILE__)) . "/../header.php"; ?>

    <!-- Main Content -->
    <main class="home-container">
        <!-- Currently Reading Section -->
        <section class="currently-reading">
            <h2>Currently Reading</h2>
            <div class="books-grid">
                <?php display_currently_reading_books_fxn($user_id) ?>
            </div>
        </section>

        <!-- Recommended Section -->
        <section class="recommended">
            <h2>Recommended For You</h2>
            <div class="books-grid">
                <?php
                $user_id = getUserID();
                display_recommended_books_fxn($user_id);
                ?>
            </div>
        </section>

        <!-- Recently Finished Section -->
        <section class="recently-finished">
            <h2>Recently Finished</h2>
            <div class="books-grid">
                <?php display_recently_finished_books_fxn($user_id) ?>
            </div>
        </section>

        <!-- quiz modal -->
        <div id="quiz-modal" class="modal">
            <div class="modal-content">
                <span class="close-modal">&times;</span>

                <section class="quiz-intro">
                    <h1>Discover Your Reading Personality</h1>
                    <p>Take this quick personality quiz and explore book recommendations tailored just for you!</p>
                    <button id="start-quiz">Start Quiz</button>
                </section>

                <!-- Quiz Questions -->
                <section class="quiz-questions" id="quiz-section" style="display: none;">
                    <form id="quiz-form">
                        <div class="question">
                            <h3>1. What kind of books do you usually read?</h3>
                            <label><input type="radio" name="q1" value="Thriller"> Thrillers</label>
                            <label><input type="radio" name="q1" value="Romance"> Romance</label>
                            <label><input type="radio" name="q1" value="Fantasy"> Fantasy</label>
                            <label><input type="radio" name="q1" value="Non-Fiction"> Non-Fiction</label>
                        </div>

                        <div class="question">
                            <h3>2. How do books make you feel?</h3>
                            <label><input type="radio" name="q2" value="Excited"> Excited and Energized</label>
                            <label><input type="radio" name="q2" value="Relaxed"> Calm and Relaxed</label>
                            <label><input type="radio" name="q2" value="Curious"> Curious and Intrigued</label>
                            <label><input type="radio" name="q2" value="Reflective"> Reflective and Inspired</label>
                        </div>

                        <div class="question">
                            <h3>3. Choose your ideal reading environment:</h3>
                            <label><input type="radio" name="q3" value="Library"> Quiet Library</label>
                            <label><input type="radio" name="q3" value="Cafe"> Cozy Cafe</label>
                            <label><input type="radio" name="q3" value="Nature"> Outdoor/Nature</label>
                            <label><input type="radio" name="q3" value="Home"> Snuggled at Home</label>
                        </div>

                        <button type="submit" class="submit-btn">Submit Quiz</button>
                    </form>
                </section>

                <!-- Quiz Results -->
                <section class="quiz-results" id="results-section" style="display: none;">
                    <h2>Your Reading Personality:</h2>
                    <p id="personality-result"></p>
                    <button id="restart-quiz">Retake Quiz</button>
                </section>

            </div>
        </div>
    </main>

    <script src="../assets/js/quiz.js"></script>
</body>

</html>