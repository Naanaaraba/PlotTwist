<?php
require_once(dirname(__FILE__) . "/../db/db_connection.php");

function get_genre_fxn()
{
    global $conn;
    $genres = [];
    $sql = "SELECT genre_id, genre_name FROM genres";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $genres[] = $row;
        }
    }


    echo '<select id="genre_filter" name="genre_id" required>';
    echo '<option value="">Select Genre</option>';

    foreach ($genres as $genre) {
        echo '<option value="' . $genre['genre_id'] . '">' . $genre['genre_name'] . '</option>';
    }

    echo '</select>';
}
