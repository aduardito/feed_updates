<?php

/* 
 * log out file
 */

session_start();
$_SESSION = array();
session_destroy();
header("Location: index.php");
?>