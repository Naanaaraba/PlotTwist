<?php
require_once(dirname(__FILE__) . "/../db/db_connection.php");

function get_mood_fxn()
{
    global $conn;
    $moods = [];
    $sql = "SELECT mood_id, mood_name FROM mood";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $moods[] = $row;
        }
    }


    echo '<select id="mood_filter" name="mood_id" required>';
    echo '<option value="">Select Mood</option>';

    foreach ($moods as $mood) {
        echo '<option value="' . $mood['mood_id'] . '">' . $mood['mood_name'] . '</option>';
    }

    echo '</select>';
}
