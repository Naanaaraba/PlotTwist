<?php
require_once(dirname(__FILE__) . "/../db/db_connection.php");

function get_ratings_fxn()
{
    global $conn;
    $ratings = [];
    $sql = "SELECT rating_id, rating_name FROM ratings";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ratings[] = $row;
        }
    }

    echo '<select id="rating" name="rating" required>';
    echo '<option value="">Select Rating</option>';

    foreach ($ratings as $rating) {
        echo '<option value="' . $rating['rating_id'] . '">' . $rating['rating_name'] . '</option>';
    }

    echo '</select>';
}
