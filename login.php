<?php
/**
 * this file will be in charge of log in,
 * create session
 */
include("includes/Connection.php");
 
$user = $_POST['user_name'];
$pass = $_POST['user_pass'];

$conn = new Connection();
if ( $conn->validateUser($user, $pass) ) 
{
    session_start();
    $_SESSION['user_name'] = $username;
    $_SESSION['user_pass'] = $row->email;
    header("Location: read_feeds.php");
}
else
{
    session_start();
    $_SESSION = array();
    session_destroy();
    header("Location: index.php?msg=incorrect_data");
}
 
?>