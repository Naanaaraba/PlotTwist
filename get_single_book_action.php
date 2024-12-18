<?php
require_once(dirname(__FILE__) . "/../db/db_connection.php");

if (isset($_GET['bookId'])) {
    $book_id = $_GET['bookId'];

    $query = "SELECT * FROM books JOIN genres ON books.genre_id=genres.genre_id WHERE book_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Book not found']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'No book ID provided']);
}
