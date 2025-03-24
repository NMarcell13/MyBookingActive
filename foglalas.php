<?php
$servername = "192.168.1.45";
$username = "mybooking";
$password = "mybooking";
$dbname = "mybooking";

session_start();
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

$_add_hidden = "hidden";
$_add_disabled = "";

if ($_SESSION["titulus"] == "admin") {
    $adatprofil = "adminprofil.php";
    $_add_hidden = "";
    $_add_disabled = "";
} elseif ($_SESSION["titulus"] == "ugyfel") {
    $adatprofil = "profil.php";
    $_add_hidden = "hidden";
    $_add_disabled = "";
} elseif ($_SESSION["titulus"] == "ado") {
    $adatprofil = "adoprofil.php";
}

if (isset($_POST["nev"])) {
    $nev = $_POST["nev"];
}

$sql = "SELECT * FROM adok WHERE felhasznalonev = '" . $nev . "'";
$result = $conn->query($sql);
$row = mysqli_fetch_assoc($result);

if ($_SESSION["titulus"] == "ado") {
    if ($_SESSION["felhasznalo"] == $nev) {
        $_add_hidden = "";
        $_add_disabled = "disabled";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idopont = $_POST['ido_plus'];
    $stmt = $conn->prepare("INSERT INTO idopontok (ado, idopontok) VALUES (?, ?)");

    if ($stmt === false) {
        die("Hiba van a lekérdezésben: " . $conn->error);
    }

    $ado = $_SESSION['felhasznalo'];

    $stmt->bind_param("ss", $ado,  $idopont);

    if ($stmt->execute()) {
        header('Location: foglalo.php');
        exit();
    } else {
        echo "Hiba történt a mentésben: " . $stmt->error;
    }

    
}


$stmt->close();
$conn->close();
?>