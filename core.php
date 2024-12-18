<?php

session_start();
require_once(dirname(__FILE__) . "/../db/db_connection.php");

// check if user is logged in
function isLoggedIn()
{
    if (isset($_SESSION["user_role"]) && isset($_SESSION["user_id"])) {
        return true;
    }

    header("Location: ../index.php");
}

function checkQuizCompletionState()
{
    // Check if user needs to take quiz
    global $conn;
    $user_id = $_SESSION['user_id'];
    $query = "SELECT first_login_quiz_completed FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // If quiz not completed, redirect to quiz page
    if (!$user['first_login_quiz_completed']) {
        header("Location: quiz.php");
        exit();
    }
}


function isAdminLoggedIn()
{
    if (isset($_SESSION["user_role"]) && isset($_SESSION["user_id"]) && $_SESSION["user_role"] == 1) {
        return true;
    }
    header("Location: ../../index.php");
}

// get userid
function getUserID()
{
    return $_SESSION["user_id"];
}

// get username
function getUsername()
{
    return $_SESSION["username"];
}


// get user role
function getUserRole()
{
    return $_SESSION["user_role"];
}
