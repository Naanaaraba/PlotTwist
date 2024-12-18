
<?php
// include database connection file
require_once(dirname(__FILE__) . "/../db/db_connection.php");

if (isset($_POST["addBook"])) {
    // Get form data
    $title = $conn->real_escape_string($_POST['title']);
    $author =  $_POST['author'];
    $genre_id = (int) $_POST['genre_id'];
    $mood_id = (int) $_POST['mood_id'];
    $length_id = (int) $_POST['book_length_id'];
    $publication_year = $_POST['publication_year'];
    $page_count = $_POST['page_count'];
    $isbn = $conn->real_escape_string($_POST['isbn']);
    $description = $conn->real_escape_string($_POST['description']);

    // Handle file upload
    $book_file = $_FILES['book_file'];
    $target_dir = '../assets/book_uploads/';
    $file_name = basename($book_file['name']);
    $target_book_file = $target_dir . $file_name;

    // Handle cover file upload
    $cover_file = $_FILES['cover_file'];
    $target_dir_covers = '../assets/cover_uploads/';
    $cover_file_name = basename($cover_file['name']);
    $target_cover_file = $target_dir_covers . $cover_file_name;

    // Check if the file upload is valid
    // if (move_uploaded_file($book_file['tmp_name'], $target_file)) {
    //     // Insert data into the database
    //     $sql = "INSERT INTO books (title, author, genre_id, publication_year, isbn, description, book_file) 
    //             VALUES ('$title', '$author', $genre_id, '$publication_year', '$isbn', '$description', '$target_file')";

    //     if ($conn->query($sql) === TRUE) {
    //         echo 'Book added successfully!';
    //     } else {
    //         echo 'Error: ' . $sql . '<br>' . $conn->error;
    //     }
    // } else {
    //     echo 'Error uploading the file. Please  try again.';
    // }

    // Check if the book file upload is valid
    if (move_uploaded_file($book_file['tmp_name'], $target_book_file)) {
        // Check if the cover file upload is valid
        if (move_uploaded_file($cover_file['tmp_name'], $target_cover_file)) {
            // Insert data into the database
            $sql = "INSERT INTO books (title, author, genre_id, mood_id, length_id, publication_year, isbn, description, book_file, page_count, cover_file) 
                    VALUES ('$title', '$author', $genre_id, '$mood_id', '$length_id', '$publication_year', '$isbn', '$description', '$target_book_file', '$page_count', '$target_cover_file')";

            if ($conn->query($sql) === TRUE) {
                echo 'Book and cover added successfully!';
            } else {
                echo 'Error: ' . $sql . '<br>' . $conn->error;
            }
        } else {
            echo 'Error uploading the cover file. Please try again.';
        }
    } else {
        echo 'Error uploading the book file. Please try again.';
    }
}
