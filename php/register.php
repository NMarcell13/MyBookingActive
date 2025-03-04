<?php
$servername = "192.168.1.45";
$username = "mybooking";
$password = "mybooking";
$dbname = "mybooking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}
$username = $_POST['username'];
$password = $_POST['password'];
$password = password_hash($password, PASSWORD_DEFAULT);
$vnev = $_POST['vnev'];
$knev = $_POST['knev'];
$email = $_POST['email'];
$telszam = $_POST['telszam'];
$szulev = $_POST['szulev'];
$szulhely = $_POST['szulhely'];
$nem = $_POST['nem'];
$lakcim = $_POST['lakcim'];
$taj = $_POST['taj'];
$aneve = $_POST['aneve'];

try {
    $stmt = $conn->prepare("INSERT INTO ugyfelek (felhasznalonev, jelszo, vezeteknev, keresztnev, email, telszam, szul_ido, szul_hely, nem, lakcim, tajszam, a_neve) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssss", $username, $password, $vnev, $knev, $email, $telszam, $szulev, $szulhely, $nem, $lakcim, $taj, $aneve);

    if ($stmt->execute()) {
        header("Location: ../index.html");
        exit();
    }
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1062) {
        echo '<script>
    
        if (confirm("Ez a felhasználónév már foglalt!")) {
            
            window.open("../register.html","_self")
            
        } else {
           
            window.open("../register.html","_self")
        }
        
        
        </script>';
    } else {
        echo '<script>
    
        if (confirm("Hiba történt!")) {
            
            window.open("../register.html","_self")
            
        } else {
           
            window.open("../register.html","_self")
        }
        
        
        </script>';
    }
    exit();
}


$stmt->close();
$conn->close();