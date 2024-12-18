<?php
require_once(dirname(__FILE__) . "/../db/db_connection.php");

function get_book_length_fxn()
{
    global $conn;
    $book_lengths = [];
    $sql = "SELECT length_id, length_name FROM book_length";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $book_lengths[] = $row;
        }
    }


    echo '<select id="length_filter" name="book_length_id" required>';
    echo '<option value="">Select Book Length</option>';

    foreach ($book_lengths as $book_length) {
        echo '<option value="' . $book_length['length_id'] . '">' . $book_length['length_name'] . '</option>';
    }

    echo '</select>';
}
