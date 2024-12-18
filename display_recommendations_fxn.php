<?php
require_once(dirname(__FILE__) . "/../db/db_connection.php");

function display_personality_book_match_fxn($user_id)
{
    global $conn;
    $books = [];
    $sql = "SELECT b.*
        FROM books AS b
        JOIN genres AS g ON b.genre_id = g.genre_id
        JOIN personality_mapping AS pm ON g.genre_id = pm.genre_id
        JOIN quiz_results AS qr ON pm.personality_id = qr.personality
        WHERE qr.user_id = '$user_id'
        ORDER BY RAND()
        LIMIT 1;";
    $result = $conn->query($sql);

    if ($result) {
        $all_books = $result->fetch_all(MYSQLI_ASSOC);

        if (!empty($all_books)) {
            foreach ($all_books as $book) {
                $book_image = !empty($book["cover_file"]) ? $book["cover_file"] : "../assets/images/bookart.jpg";
                echo '<a href="reader.php?book=' . $book["book_file"] . '&book_id=' . $book["book_id"] . '" class="book-card">
                        <div class="book">
                            <img src="' . $book_image . '" alt="Book Cover">
                            <div class="book-info">
                                <h4>' . $book["title"] . '</h4>
                                <p>' . $book["author"] . '</p>
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

function display_mood_book_match_fxn()
{
    global $conn;
    $books = [];
    $sql = "SELECT b.*
        FROM books AS b
        JOIN genres AS g ON b.genre_id = g.genre_id
        JOIN mood AS m ON m.mood_id = b.mood_id
        WHERE m.mood_name IN ('happy', 'thrilling')
        ORDER BY RAND()
        LIMIT 1;";

    $result = $conn->query($sql);

    if ($result) {
        $all_books = $result->fetch_all(MYSQLI_ASSOC);

        if (!empty($all_books)) {
            foreach ($all_books as $book) {
                $book_image = !empty($book["cover_file"]) ? $book["cover_file"] : "../assets/images/bookart.jpg";
                echo '<a href="reader.php?book=' . $book["book_file"] . '&book_id=' . $book["book_id"] . '" class="book-card">
                        <div class="book">
                            <img src="' . $book_image . '" alt="Book Cover">
                            <div class="book-info">
                                <h4>' . $book["title"] . '</h4>
                                <p>' . $book["author"] . '</p>
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


function display_reading_history_book_match_fxn($user_id)
{
    global $conn;
    $books = [];
    $sql = "SELECT 
            b.book_id, 
            b.title, 
            b.author, 
            b.book_file, 
            g.genre_name,
            m.mood_name,
            bl.length_name,
            COUNT(*) AS recommendation_score
        FROM 
            books b
        JOIN 
            genres g ON b.genre_id = g.genre_id
        JOIN 
            mood m ON b.mood_id = m.mood_id
        JOIN 
            book_length bl ON b.length_id = bl.length_id
        WHERE 
            -- Exclude books the user has already read
            b.book_id NOT IN (
                SELECT book_id 
                FROM reading_progress 
                WHERE user_id = '$user_id' AND status = 2  -- Finished books
            )
            AND (
                -- Recommend based on similar genres of previously read books
                b.genre_id IN (
                    SELECT DISTINCT books.genre_id
                    FROM reading_progress rp
                    JOIN books ON rp.book_id = books.book_id
                    WHERE rp.user_id = '$user_id' AND rp.status = 2
                )
                
                -- Or recommend based on similar personalities
                OR b.genre_id IN (
                    SELECT pm.genre_id
                    FROM quiz_results qr
                    JOIN personality_mapping pm ON qr.personality = pm.personality_id
                    WHERE qr.user_id = '$user_id'
                )
            )
        GROUP BY 
            b.book_id, 
            b.title, 
            b.author, 
            g.genre_name,
            m.mood_name,
            bl.length_name
        
        ORDER BY RAND()
        LIMIT 1;";
    $result = $conn->query($sql);

    if ($result) {
        $all_books = $result->fetch_all(MYSQLI_ASSOC);

        if (!empty($all_books)) {
            foreach ($all_books as $book) {
                $book_image = !empty($book["cover_file"]) ? $book["cover_file"] : "../assets/images/bookart.jpg";
                echo '<a href="reader.php?book=' . $book["book_file"] . '&book_id=' . $book["book_id"] . '" class="book-card">
                        <div class="book">
                            <img src="' . $book_image . '" alt="Book Cover">
                            <div class="book-info">
                                <h4>' . $book["title"] . '</h4>
                                <p>' . $book["author"] . '</p>
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


function display_similar_books_fxn($user_id)
{
    global $conn;
    $books = [];
    $sql = "WITH UserReadBooks AS (
            SELECT DISTINCT 
                b.genre_id, 
                b.mood_id, 
                b.length_id
            FROM 
                reading_progress rp
            JOIN 
                books b ON rp.book_id = b.book_id
            WHERE 
                rp.user_id = '$user_id' AND rp.status = 2
        ),
        UserPreferences AS (
            SELECT 
                genre_id, 
                mood_id, 
                length_id,
                COUNT(*) as preference_count
            FROM 
                UserReadBooks
            GROUP BY 
                genre_id, mood_id, length_id
            ORDER BY 
                RAND()
            LIMIT 1
        )
    SELECT 
        b.book_id, 
        b.title, 
        b.author, 
        b.book_file,
        b.cover_file,
        g.genre_name,
        m.mood_name,
        bl.length_name,
        (
            (CASE WHEN b.genre_id IN (SELECT genre_id FROM UserPreferences) THEN 3 ELSE 0 END) +
            (CASE WHEN b.mood_id IN (SELECT mood_id FROM UserPreferences) THEN 2 ELSE 0 END) +
            (CASE WHEN b.length_id IN (SELECT length_id FROM UserPreferences) THEN 1 ELSE 0 END)
        ) AS recommendation_score
    FROM 
        books b
    JOIN 
        genres g ON b.genre_id = g.genre_id
    JOIN 
        mood m ON b.mood_id = m.mood_id
    JOIN 
        book_length bl ON b.length_id = bl.length_id
    WHERE 
        b.book_id NOT IN (
            SELECT book_id 
            FROM reading_progress 
            WHERE user_id = '$user_id' AND status = 2
        )
        AND (
            b.genre_id IN (SELECT genre_id FROM UserPreferences) OR
            b.mood_id IN (SELECT mood_id FROM UserPreferences) OR
            b.length_id IN (SELECT length_id FROM UserPreferences)
        )
    ORDER BY 
        RAND()
    LIMIT 1";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($book = $result->fetch_assoc()) {
            $book_image = !empty($book["cover_file"]) ? $book["cover_file"] : "../assets/images/bookart.jpg";
            echo '<a href="reader.php?book=' . $book["book_file"] . '&book_id=' . $book["book_id"] . '" class="book-card">
                    <div class="book">
                        <img src="' . $book_image . '" alt="Book Cover">
                        <div class="book-info">
                            <h4>' . htmlspecialchars($book["title"]) . '</h4>
                            <p>' . htmlspecialchars($book["author"]) . '</p>
                            <small>' . htmlspecialchars($book["genre_name"]) . ' | ' . htmlspecialchars($book["mood_name"]) . '</small>
                        </div>
                    </div>
                </a>';
        }
    } else {
        echo "<span><i>No similar books found</i></span>";
    }
}


function display_collaborative_books_fxn($user_id)
{
    global $conn;
    $sql = "WITH UserReadBooks AS (
        -- Find books this user has read and finished
        SELECT book_id 
        FROM reading_progress 
        WHERE user_id = '$user_id' AND status = 2
    ),
    SimilarUsers AS (
        -- Find users with similar reading patterns
        SELECT 
            rp.user_id, 
            COUNT(DISTINCT rp.book_id) AS shared_books
        FROM 
            reading_progress rp
        JOIN 
            UserReadBooks urb ON rp.book_id IN (urb.book_id)
        WHERE 
            rp.user_id != '$user_id' AND rp.status = 2
        GROUP BY 
            rp.user_id
        ORDER BY 
            shared_books DESC
        LIMIT 5  -- Top 5 most similar users
    ),
    CollaborativeRecommendations AS (
        -- Find books read by similar users that this user hasn't read
        SELECT 
            b.book_id, 
            b.title, 
            b.author, 
            b.book_file,
            b.cover_file,
            g.genre_name,
            m.mood_name,
            COUNT(DISTINCT rp.user_id) AS recommendation_strength
        FROM 
            reading_progress rp
        JOIN 
            books b ON rp.book_id = b.book_id
        JOIN 
            genres g ON b.genre_id = g.genre_id
        JOIN 
            mood m ON b.mood_id = m.mood_id
        JOIN 
            SimilarUsers su ON rp.user_id = su.user_id
        WHERE 
            rp.status = 2
            AND b.book_id NOT IN (
                SELECT book_id 
                FROM reading_progress 
                WHERE user_id = '$user_id' AND status = 2
            )
        GROUP BY 
            b.book_id, 
            b.title, 
            b.author, 
            b.book_file,
            b.cover_file,
            g.genre_name,
            m.mood_name
        ORDER BY 
            recommendation_strength DESC
        LIMIT 5
    )

    -- Final select to retrieve recommendations
    SELECT * FROM CollaborativeRecommendations";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo '<div class="collaborative-recommendations">';
        echo '<h3>Books Similar Users Enjoyed</h3>';

        while ($book = $result->fetch_assoc()) {
            $book_image = !empty($book["cover_file"]) ? $book["cover_file"] : "../assets/images/bookart.jpg";
            echo '<a href="reader.php?book=' . $book["book_file"] . '&book_id=' . $book["book_id"] . '" class="book-card">
                    <div class="book">
                        <img src="' . $book_image . '" alt="Book Cover">
                        <div class="book-info">
                            <h4>' . htmlspecialchars($book["title"]) . '</h4>
                            <p>' . htmlspecialchars($book["author"]) . '</p>
                            <small>' . htmlspecialchars($book["genre_name"]) . ' | ' . htmlspecialchars($book["mood_name"]) .
                ' | Recommended by ' . htmlspecialchars($book["recommendation_strength"]) . ' similar users</small>
                        </div>
                    </div>
                </a>';
        }

        echo '</div>';
    } else {
        echo "<span><i>No collaborative recommendations found</i></span>";
    }
}


function display_similar_book_name_fxn($user_id)
{
    global $conn;
    $books = [];
    $sql = "WITH UserReadBooks AS (
            SELECT DISTINCT 
                b.genre_id, 
                b.mood_id, 
                b.length_id
            FROM 
                reading_progress rp
            JOIN 
                books b ON rp.book_id = b.book_id
            WHERE 
                rp.user_id = '$user_id' AND rp.status = 2
        ),
        UserPreferences AS (
            SELECT 
                genre_id, 
                mood_id, 
                length_id,
                COUNT(*) as preference_count
            FROM 
                UserReadBooks
            GROUP BY 
                genre_id, mood_id, length_id
            ORDER BY 
                RAND()
            LIMIT 1
        )
    SELECT 
        b.book_id, 
        b.title, 
        b.author, 
        b.book_file,
        b.cover_file,
        g.genre_name,
        m.mood_name,
        bl.length_name,
        (
            (CASE WHEN b.genre_id IN (SELECT genre_id FROM UserPreferences) THEN 3 ELSE 0 END) +
            (CASE WHEN b.mood_id IN (SELECT mood_id FROM UserPreferences) THEN 2 ELSE 0 END) +
            (CASE WHEN b.length_id IN (SELECT length_id FROM UserPreferences) THEN 1 ELSE 0 END)
        ) AS recommendation_score
    FROM 
        books b
    JOIN 
        genres g ON b.genre_id = g.genre_id
    JOIN 
        mood m ON b.mood_id = m.mood_id
    JOIN 
        book_length bl ON b.length_id = bl.length_id
    WHERE 
        b.book_id NOT IN (
            SELECT book_id 
            FROM reading_progress 
            WHERE user_id = '$user_id' AND status = 2
        )
        AND (
            b.genre_id IN (SELECT genre_id FROM UserPreferences) OR
            b.mood_id IN (SELECT mood_id FROM UserPreferences) OR
            b.length_id IN (SELECT length_id FROM UserPreferences)
        )
    ORDER BY 
        RAND()
    LIMIT 1";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($book = $result->fetch_assoc()) {
            // Ensure that the book name is not already in the user's read list
            if ($book['title'] != "") {

                echo  $book["title"];
            }
        }
    } else {
        echo "<span><i>No similar books found</i></span>";
    }
}
