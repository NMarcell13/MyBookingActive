<?php
$servername = "192.168.1.45";
$username = "mybooking";
$password = "mybooking";
$dbname = "mybooking";
$loggedUsername;
$loggedPassword;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}
$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM adminok WHERE felhasznalonev = '$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_row($result);


if (password_verify($password, $row[2])) {
    echo "<h1><center> Login successful </center></h1>";
    $loggedUsername = $username;
    $loggedPassword = $password;

    session_start();
    $_SESSION["felhasznalo"] = "[ADMIN]" . $loggedUsername;
    $_SESSION["vezeteknev"] = "[ADMIN]";
    $_SESSION["admin"] = "[ADMIN]";
    $_SESSION["keresztnev"] = $loggedUsername;
    $_SESSION["nev"] = $row[3];
    $_SESSION["titulus"] = "admin";

    header("Location: ../fooldal.php");


    exit();
} else {
    echo '<script>
    
    if (confirm("Hibás felhasználónév vagy jelszó!")) {
        
        window.open("../admin.html","_self")
        
    } else {
       
        window.open("../admin.html","_self")
    }
    
    
    </script>';





}


$conn->close();