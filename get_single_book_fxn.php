<?php
require_once(dirname(__FILE__) . "/../db/db_connection.php");

function get_single_book_fxn($book_id)
{
    global $conn;

    // Initialize the array to hold the book and its genre
    $book = null;

    // Query to fetch the book and its genre
    $sql = "SELECT b.book_id, b.title, b.author, b.cover_file, b.description, g.genre_id, g.genre_name
            FROM books b
            JOIN genres g ON b.genre_id = g.genre_id
            WHERE b.book_id = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);  // Bind the book_id parameter

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any rows are returned
    if ($result->num_rows > 0) {
        // Fetch the book data and genres
        while ($row = $result->fetch_assoc()) {
            $book = $row;
        }
    }


    return $book;
}
