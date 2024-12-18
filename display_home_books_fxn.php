<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once(dirname(__FILE__) . "/../db/db_connection.php");

function display_currently_reading_books_fxn($user_id)
{
    global $conn;
    $books = [];
    $sql = "SELECT * FROM books 
    JOIN genres ON books.genre_id = genres.genre_id
    JOIN reading_progress ON books.book_id = reading_progress.book_id
    JOIN reading_status ON reading_progress.status = reading_status.status_id
    JOIN users ON reading_progress.user_id = users.user_id
    WHERE reading_status.status_id = 1 AND users.user_id='$user_id'";
    $result = $conn->query($sql);

    if ($result) {
        $all_books = $result->fetch_all(MYSQLI_ASSOC);

        if (!empty($all_books)) {
            foreach ($all_books as $book) {
                $book_image = !empty($book["cover_file"]) ? $book["cover_file"] : "../assets/images/bookart.jpg";
                echo '<a href="reader.php?book=' . $book["book_file"] . '&book_id=' . $book["book_id"] . '" class="book-card">
                        <div class="book-cover">
                            <img src="' . $book_image . '" alt="Book Cover">
                            <div class="book-progress">
                                <div class="progress-bar" style="width: 65%"></div>
                            </div>
                        </div>
                        <div class="book-info">
                            <h4>' . $book["title"] . '</h4>
                            <p>' . $book["author"] . '</p>
                            <div class="book-actions">
                                <button class="bookmark-btn">
                                    <i class="bx bx-bookmark"></i>
                                </button>
                                <span class="progress-text">' . $book["progress_count"] . '%</span>
                            </div>
                        </div>
                    </a>';
            }
        } else {
            echo "<span><i>Nothing to show</i></span>";
        }
    } else {
        echo "<span><i>Nothing to show</i></span>";
    }
}

function display_recently_finished_books_fxn($user_id)
{
    global $conn;
    $books = [];
    $sql = "SELECT 
    books.book_id, 
    books.title, 
    books.author, 
    books.book_file, 
    books.cover_file, 
    genres.genre_name, 
    users.username, 
    reading_progress.date_started, 
    reading_progress.progress_count, 
    reading_progress.date_completed
FROM books 
JOIN genres ON books.genre_id = genres.genre_id
JOIN reading_progress ON books.book_id = reading_progress.book_id
JOIN reading_status ON reading_progress.status = reading_status.status_id
JOIN users ON reading_progress.user_id = users.user_id
WHERE reading_status.status_id = 2 
  AND users.user_id = '$user_id' 
  AND reading_progress.progress_count = 100
ORDER BY reading_progress.date_completed DESC;
";
    $result = $conn->query($sql);

    if ($result) {
        $all_books = $result->fetch_all(MYSQLI_ASSOC);

        if (!empty($all_books)) {
            foreach ($all_books as $book) {
                $book_image = !empty($book["cover_file"]) ? $book["cover_file"] : "../assets/images/bookart.jpg";
                echo '<a href="reader.php?book=' . $book["book_file"] . '&book_id=' . $book["book_id"] . '" class="book-card">
                        <div class="book-cover">
                            <img src="' . $book_image . '" alt="Book Cover">
                            <div class="book-progress">
                                <div class="progress-bar" style="width: 65%"></div>
                            </div>
                        </div>
                        <div class="book-info">
                            <h4>' . $book["title"] . '</h4>
                            <p>' . $book["author"] . '</p>
                            <div class="book-actions">
                                <button class="bookmark-btn">
                                    <i class="bx bx-bookmark"></i>
                                </button>
                                <span class="progress-text">' . $book["progress_count"] . '%</span>
                            </div>
                        </div>
                    </a>';
            }
        } else {
            echo "<span><i>Nothing to show</i></span>";
        }
    } else {
        echo "<span><i>Nothing to show</i></span>";
    }
}



function display_recommended_books_fxn($user_id)
{
    global $conn;

    // Step 1: Retrieve the user's personality ID
    $personality_sql = "SELECT personality 
        FROM quiz_results 
        WHERE user_id = ?
    ";

    $stmt = $conn->prepare($personality_sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $personality_id = null;

    if ($result && $row = $result->fetch_assoc()) {
        $personality_id = $row['personality'];
    }
    $stmt->close();

    // Step 2: Fetch books based on genres linked to the personality
    if ($personality_id) {
        $books_sql = "SELECT books.book_id, books.title, books.author, books.book_file, books.cover_file, genres.genre_name
            FROM books
            JOIN genres ON books.genre_id = genres.genre_id
            JOIN personality_mapping ON genres.genre_id = personality_mapping.genre_id
            WHERE personality_mapping.personality_id = ?
            ORDER BY books.title ASC
        ";

        $stmt = $conn->prepare($books_sql);
        $stmt->bind_param("i", $personality_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Step 3: Display books
        if ($result && $result->num_rows > 0) {
            while ($book = $result->fetch_assoc()) {
                $book_image = !empty($book["cover_file"]) ? $book["cover_file"] : "../assets/images/bookart.jpg";
                echo '<a href="reader.php?book=' . $book["book_file"] . '&book_id=' . $book["book_id"] . '" class="book-card">
                        <div class="book-cover">
                            <img src="' . $book_image . '" alt="Book Cover">
                        </div>
                        <div class="book-info">
                            <h4>' . htmlspecialchars($book["title"]) . '</h4>
                            <p>' . htmlspecialchars($book["author"]) . '</p>
                            <span class="genre">Genre: ' . htmlspecialchars($book["genre_name"]) . '</span>
                        </div>
                    </a>';
            }
        } else {
            echo "<span><i>No books found for your personality type.</i></span>";
        }

        $stmt->close();
    } else {
        echo "<span><i>Please complete the quiz to see your personalized book recommendations.</i></span>";
    }
}
