<?php
require_once(dirname(__FILE__) . "/../db/db_connection.php");

function get_user_info_fxn($user_id)
{
    global $conn;
    $user = null;
    $sql = "SELECT 
    users.username, 
    users.email, 
    users.profile_picture, 
    DATE_FORMAT(users.registration_date, '%e %M %Y') AS date_joined 
FROM 
    users 
WHERE 
    users.user_id = '$user_id';
";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }

    return $user;
}


function get_reading_preferences_info_fxn($user_id)
{
    global $conn;

    // Query to get the user's genre based on personality mapping
    $userGenreSql = "SELECT 
                        genres.genre_name 
                    FROM 
                        users
                    JOIN 
                        quiz_results ON users.user_id = quiz_results.user_id
                    JOIN 
                        personality_mapping ON quiz_results.personality = personality_mapping.personality_id
                    JOIN 
                        genres ON personality_mapping.genre_id = genres.genre_id
                    WHERE 
                        users.user_id = '$user_id'";

    $userGenreResult = $conn->query($userGenreSql);
    $user_genre = ($userGenreResult && $row = $userGenreResult->fetch_assoc()) ? $row['genre_name'] : null;

    // Query to get all genres
    $allGenresSql = "SELECT genre_name FROM genres";
    $allGenresResult = $conn->query($allGenresSql);

    $all_genres = [];
    if ($allGenresResult) {
        while ($row = $allGenresResult->fetch_assoc()) {
            $all_genres[] = $row['genre_name'];
        }
    }

    // Render the dropdown
    echo '<select id="genre">';
    foreach ($all_genres as $genre) {
        $selected = ($genre === $user_genre) ? 'selected' : '';
        echo "<option value='$genre' $selected>$genre</option>";
    }
    echo '</select>';
}



function get_reading_history_fxn($user_id)
{
    global $conn;

    // SQL query to get the user's reading history from the reading_progress table
    $sql = "SELECT b.title AS book_title, b.author, rs.status_name
            FROM reading_progress AS rp
            JOIN books AS b ON rp.book_id = b.book_id
            JOIN reading_status rs ON rp.status = rs.status_id
            WHERE rp.user_id = '$user_id'";

    $result = $conn->query($sql);

    // Check if there are any books in the reading history
    if ($result && $result->num_rows > 0) {
        // echo '<ul class="history-list">';

        // Loop through the results and display each book's progress
        while ($row = $result->fetch_assoc()) {
            $book_title = $row['book_title'];
            $author = $row['author'];
            $status = $row['status_name'];

            // Output each book's title, author, and status
            echo "<li><strong>$book_title</strong> by $author <span>$status</span></li>";
        }

        // echo '</ul>';
    } else {
        // If there are no results, show a message
        echo '<p>No reading history available.</p>';
    }
}


function get_personality_quiz_fxn($user_id)
{
    global $conn;

    // SQL query to fetch the personality quiz results based on user_id
    $sql = "SELECT p.personality_name, p.description
            FROM quiz_results AS qr
            JOIN personality AS p ON qr.personality = p.personality_id
            WHERE qr.user_id = '$user_id'";

    // Execute the query
    $result = $conn->query($sql);

    // Check if the query returned any result
    if ($result && $result->num_rows > 0) {
        // Fetch and display the personality information
        while ($row = $result->fetch_assoc()) {
            $personality_name = $row['personality_name'];
            $description = $row['description'];

            // Display the result

            echo "<p>Your Reading Personality: <strong> $personality_name</strong></p>";
            echo "<p>$description</p>";
        }
    } else {
        // If no result, display a message
        echo "<p>No personality quiz result available.</p>";
    }
}


function get_bookshelf_fxn($user_id)
{
    global $conn;

    // SQL query to fetch the books the user has been reading
    $sql = "SELECT b.book_id, b.title, b.author, b.cover_file, b.book_file, rp.status
            FROM reading_progress AS rp
            JOIN books AS b ON rp.book_id = b.book_id
            WHERE rp.user_id = '$user_id'";

    // Execute the query
    $result = $conn->query($sql);

    // Check if the query returned any results
    if ($result && $result->num_rows > 0) {
        // Start the bookshelf list


        // Loop through the result set and display each book
        while ($row = $result->fetch_assoc()) {
            $book_id = $row['book_id'];
            $title = $row['title'];
            $author = $row['author'];
            $cover_file = !empty($row['cover_file']) ? $row['cover_file'] : "../assets/images/bookart.jpg"; // default image if no cover exists
            $book_file = $row['book_file']; // e.g., 'In Progress', 'Completed'

            // Display the book in a list item
            echo '
                    <a href="reader.php?book=' . $book_file . '&book_id=' . $book_id . '" class="book-card">
                        <div class="book-cover">
                            <img src="' . $cover_file . '" alt="Book Cover">
                            <div class="book-progress">
                                <div class="progress-bar" style="width: 65%"></div>
                            </div>
                        </div>
                        <div class="book-info">
                            <h4>' . $title . '</h4>
                            <p>' . $author . '</p>
                        </div>
                    </a>
                  ';
        }
    } else {
        // If no books are found
        echo "<p>No books found in your bookshelf.</p>";
    }
}
