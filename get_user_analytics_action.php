<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
require_once(dirname(__FILE__) . "/../db/db_connection.php");

$sql = "SELECT DATE_FORMAT(registration_date, '%M') AS month, COUNT(*) AS new_users
        FROM users
        WHERE YEAR(registration_date) = YEAR(CURDATE())
        GROUP BY DATE_FORMAT(registration_date, '%M')
        ORDER BY DATE_FORMAT(registration_date, '%M')";



$result = mysqli_query($conn, $sql);

$userData = [];

while ($row = mysqli_fetch_assoc($result)) {
    $userData[] = $row;
}

echo json_encode($userData);  // Return the data as JSON
