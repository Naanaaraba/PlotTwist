<?php
require_once(dirname(__FILE__) . "/../db/db_connection.php");

function get_all_users_fxn()
{
    global $conn;
    $users = [];
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }



    foreach ($users as $user) {
        echo '<tr>';
        echo '<td>' . $user['user_id'] . '</td>';
        echo '<td>' . htmlspecialchars($user['username']) . '</td>';
        echo '<td>' . $user['email'] . '</td>';
        echo '<td>' . htmlspecialchars($user['user_role']) . '</td>';
        echo '<td>' . htmlspecialchars($user['registration_date']) . '</td>';

        echo '<td>
        <button style="background: red;" id="deleteUserBtn" onclick="deleteUser(' . htmlspecialchars($user['user_id']) . ')">Delete</button>
        </td>';
        echo '</tr>';
    }
}
