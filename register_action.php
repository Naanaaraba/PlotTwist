<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// include database connection file
require_once(dirname(__FILE__) . "/../db/db_connection.php");

if (isset($_POST["signUpButton"])) {
    // accessing the database connection variable from the connection file
    global $conn;
    // get the form data
    $username = trim($_POST["username"]);
    $email = trim($_POST["useremail"]);
    $password = trim($_POST["userpassword"]);
    $confirmPassword = trim($_POST["confirmPassword"]);

    // check if input is not empty
    if (empty($username) && empty($email) && empty($password) && empty($confirmPassword) && ($password != $confirmPassword)) {
        return;
    }

    // hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // create sql query
    $sql = "INSERT INTO users(username, email, password_hash) VALUES ('$username', '$email', '$hashed_password')";

    // execute sql query using database connection
    if ($conn->query($sql) === TRUE) {
        echo "Account created successfully";
    } else {
        echo "Error: An error occurred while creating the account. Please try again";
    }
}
