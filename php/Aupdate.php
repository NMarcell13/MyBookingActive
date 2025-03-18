<?php
session_start();

if (!isset($_SESSION["felhasznalo"]) || empty($_SESSION["felhasznalo"])) {
    $_SESSION['hiba'] = "Nincs bejelentkezve!";
    header("Location: ../adoprofil.php");
    exit();
}

$loggedUsername = $_SESSION["felhasznalo"];

$servername = "192.168.1.45";
$username = "mybooking";
$password = "mybooking";
$dbname = "mybooking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

function hiba_log($data) {
    $output = $data;
    if (is_array($output)) $output = implode(',', $output);
    error_log($output); 
}

$checkUser = $conn->prepare("SELECT * FROM adok WHERE felhasznalonev = ?");
$checkUser->bind_param("s", $loggedUsername);
$checkUser->execute();
$result = $checkUser->get_result();

if ($result->num_rows === 0) {
    $_SESSION['hiba'] = "Felhasználó nem található";
    header("Location: ../adoprofil.php");
    exit();
}

$userData = $result->fetch_assoc();
$checkUser->close();


$mezok = ['vezeteknev', 'keresztnev', 'email', 'telszam', 'szak'];
$updateData = [];
foreach ($mezok as $mezo) {
    $updateData[$mezo] = !empty($_POST[$mezo]) ? $_POST[$mezo] : $userData[$mezo];
}


$cel_fajl = $userData["kep"]; 

if (isset($_FILES["kepfeltoltes"]) && $_FILES["kepfeltoltes"]["error"] == UPLOAD_ERR_OK) {
    $eleresi_ut = "../adoprofilkepek/";
    if (!is_dir($eleresi_ut)) {
        hiba_log("Könyvtár nem létezik");
    } elseif (!is_writable($eleresi_ut)) {
        hiba_log("Könyvtár nem írható");
    } else {
        $fajl_nev = uniqid() . '_' . basename($_FILES["kepfeltoltes"]["name"]);
        $cel_fajl = $eleresi_ut . $fajl_nev;
        $fajl_tipus = strtolower(pathinfo($cel_fajl, PATHINFO_EXTENSION));

        // Ellenőrzések
        if ($_FILES["kepfeltoltes"]["size"] > 5 * 1024 * 1024) {
            hiba_log("A fájl túl nagy");
        } elseif (!in_array($fajl_tipus, ['jpg', 'png', 'jpeg', 'gif'])) {
            hiba_log("Nem támogatott formátum");
        } elseif (!move_uploaded_file($_FILES["kepfeltoltes"]["tmp_name"], $cel_fajl)) {
            hiba_log("Feltöltés sikertelen");
            $cel_fajl = $userData["kep"];
        }
    }
}

try {
    $stmt = $conn->prepare("UPDATE adok SET 
        vezeteknev = ?, 
        keresztnev = ?, 
        email = ?, 
        telszam = ?, 
        szak = ?,
        kep = ?
        WHERE felhasznalonev = ?");

    $stmt->bind_param(
        "sssssss",
        $updateData['vezeteknev'],
        $updateData['keresztnev'],
        $updateData['email'],
        $updateData['telszam'],
        $updateData['szak'],
        $cel_fajl,
        $loggedUsername
    );

    if ($stmt->execute()) {
        
        $_SESSION["vezeteknev"] = $updateData['vezeteknev'];
        $_SESSION["keresztnev"] = $updateData['keresztnev'];
        $_SESSION["email"] = $updateData['email'];
        $_SESSION["telszam"] = $updateData['telszam'];
        $_SESSION["szak"] = $updateData['szak'];
        $_SESSION["kep"] = $cel_fajl;
        
        $_SESSION['siker'] = "Sikeres frissítés!";
    } else {
        $_SESSION['hiba'] = "Adatbázis hiba: " . $stmt->error;
    }
} catch (mysqli_sql_exception $e) {
    $_SESSION['hiba'] = "Adatbázis hiba: " . $e->getMessage();
}

$stmt->close();
$conn->close();

header("Location: ../adoprofil.php");
exit();
?>