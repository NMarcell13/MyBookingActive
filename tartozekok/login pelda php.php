<?php
$servername = "192.168.1.45";
$username = "mybooking";
$password = "mybooking"; 
$dbname = "user_data";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}
$vnev = $_POST['vnev'];
$knev = $_POST['knev'];
$ev = $_POST['ev'];
$nem = $_POST['nem'];

$stmt = $conn->prepare("INSERT INTO users (vnev, knev, ev, nem) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $vnev, $knev, $ev, $nem);

if ($stmt->execute()) {
    echo "Az adatok sikeresen mentve!";
} else {
    echo "Hiba történt az adatok mentése közben: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>