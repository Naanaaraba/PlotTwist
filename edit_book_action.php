<?php
require_once(dirname(__FILE__) . "/../db/db_connection.php");

if (isset($_POST['editBook'])) {
    // Sanitize and validate inputs
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre_id = $_POST['genre_id'];
    $publication_year = $_POST['publication_year'];
    $isbn = $_POST['isbn'];
    $description = $_POST['description'];

    // Handle file upload (if a new file is uploaded)
    $book_file = null;
    if (!empty($_FILES['book_file']['name'])) {
        $target_dir = "../uploads/";
        $book_file = time() . '_' . basename($_FILES['book_file']['name']);
        $target_path = $target_dir . $book_file;

        if (move_uploaded_file($_FILES['book_file']['tmp_name'], $target_path)) {
            // File upload successful
        } else {
            echo "Failed to upload book file.";
            exit;
        }
    }

    // Prepare SQL query
    if ($book_file) {
        $query = "UPDATE books SET title=?, author=?, genre_id=?, publication_year=?, isbn=?, description=?, book_file=? WHERE book_id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssisssi", $title, $author, $genre_id, $publication_year, $isbn, $description, $book_file, $book_id);
    } else {
        $query = "UPDATE books SET title=?, author=?, genre_id=?, publication_year=?, isbn=?, description=? WHERE book_id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssissi", $title, $author, $genre_id, $publication_year, $isbn, $description, $book_id);
    }

    // Execute query
    if ($stmt->execute()) {
        echo "Book updated successfully!";
    } else {
        echo "Error updating book: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
