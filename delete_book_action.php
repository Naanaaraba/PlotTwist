
<?php
// include database connection file
require_once(dirname(__FILE__) . "/../db/db_connection.php");

if (isset($_POST["deleteBookID"])) {
    // Get form data
    $id = $conn->real_escape_string($_POST['deleteBookID']);

    // Insert data into the database
    $sql = "DELETE FROM books WHERE book_id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo 'Book deleted successfully!';
    } else {
        echo 'Error: ' . $sql . '<br>' . $conn->error;
    }
} else {
    echo "Something went wrong";
}
