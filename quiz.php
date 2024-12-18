<?php
include (dirname(__FILE__)) . "/../db/core.php";
isLoggedIn();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personality Quiz | Plot Twist</title>
    <link rel="stylesheet" href="../assets/css/quiz.css">
</head>

<body>
    <!-- Header -->
    <?php include (dirname(__FILE__)) . "/../header.php"; ?>

    <!-- Quiz Section -->
    <main class="quiz-container">
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
    </main>

    <!-- JavaScript -->
    <script src="../assets/js/quiz.js"></script>
</body>

</html>