<?php
require_once(dirname(__FILE__) . "/../db/db_connection.php");

function get_all_books_fxn()
{
    global $conn;
    $books = [];
    $sql = "SELECT * FROM books JOIN genres ON books.genre_id = genres.genre_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
    }



    foreach ($books as $book) {
        echo '<tr>';
        echo '<td>' . $book['book_id'] . '</td>';
        echo '<td>' . htmlspecialchars($book['title']) . '</td>';
        echo '<td>' . $book['author'] . '</td>';
        echo '<td>' . htmlspecialchars($book['description']) . '</td>';
        echo '<td>' . $book['genre_name'] . '</td>';
        echo '<td>' . $book['publication_year'] . '</td>';
        echo '<td>' . htmlspecialchars($book['isbn']) . '</td>';
        echo '<td>
        <button class="view-book" data-book-id="' . htmlspecialchars($book['book_id']) . '" onclick="openModal(\'viewBookModal\')">View</button>
        <button class="edit-book" data-book-id="' . htmlspecialchars($book['book_id']) . '" onclick="openModal(\'editBookModal\')">Edit</button>
        <button style="background: red;" id="deleteBookBtn" onclick="deleteBook(' . htmlspecialchars($book['book_id']) . ')">Delete</button>
        </td>';
        echo '</tr>';
    }
}
