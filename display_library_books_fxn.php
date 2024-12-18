<?php
require_once(dirname(__FILE__) . "/../db/db_connection.php");

function display_all_books_fxn()
{
    global $conn;
    $books = [];
    $sql = "SELECT DISTINCT books.book_id, books.title, books.author, books.cover_file, books.book_file, 
                    genres.genre_name, reading_progress.progress_count
            FROM books 
            JOIN genres ON books.genre_id = genres.genre_id
            LEFT JOIN reading_progress ON books.book_id = reading_progress.book_id
            LEFT JOIN reading_status ON reading_progress.status = reading_status.status_id
            LEFT JOIN users ON reading_progress.user_id = users.user_id";
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
