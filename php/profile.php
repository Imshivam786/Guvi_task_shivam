<?php
require 'functions.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$row = $_SESSION['PROFILE'];
// Convert the PHP array to a JSON string
$jsonData = json_encode($row);

echo $jsonData;