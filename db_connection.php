<?php

require_once(dirname(__FILE__) . "/../db/db_credentials.php");

// mysqli connection to database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_errno) {
    die("Failed to connect: " . $conn->connect_error);
}
