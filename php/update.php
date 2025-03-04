<?php
$servername = "192.168.1.45";
$username = "mybooking";
$password = "mybooking";
$dbname = "mybooking";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

$_POST["vezeteknek"]



    ?>