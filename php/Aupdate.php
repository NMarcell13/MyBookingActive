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

function hiba_log($data)
{
    error_log(print_r($data, true));
}

$checkUser = $conn->prepare("SELECT * FROM adok WHERE felhasznalonev = ? LIMIT 1");
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

$mezok = ['vezeteknev', 'keresztnev', 'email', 'telszam', 'szak', 'hely', 'leiras'];
$updateData = [];
foreach ($mezok as $mezo) {
    $updateData[$mezo] = isset($_POST[$mezo]) && !empty(trim($_POST[$mezo])) ? trim($_POST[$mezo]) : $userData[$mezo];
}

$cel_fajl = $userData["kep"];
if (!empty($_FILES["kepfeltoltes"]["name"]) && $_FILES["kepfeltoltes"]["error"] === UPLOAD_ERR_OK) {
    $eleresi_ut = "../adoprofilkepek/";
    if (is_dir($eleresi_ut) && is_writable($eleresi_ut)) {
        $fajl_nev = uniqid() . '_' . basename($_FILES["kepfeltoltes"]["name"]);
        $cel_fajl = $eleresi_ut . $fajl_nev;
        $fajl_tipus = strtolower(pathinfo($cel_fajl, PATHINFO_EXTENSION));

        if ($_FILES["kepfeltoltes"]["size"] <= 5 * 1024 * 1024 && in_array($fajl_tipus, ['jpg', 'png', 'jpeg', 'gif'])) {
            if (!move_uploaded_file($_FILES["kepfeltoltes"]["tmp_name"], $cel_fajl)) {
                hiba_log("Feltöltés sikertelen");
                $cel_fajl = $userData["kep"];
            }
        } else {
            hiba_log("Érvénytelen fájlformátum vagy méret túl nagy");
        }
    } else {
        hiba_log("Könyvtár nem létezik vagy nem írható");
    }
}

try {
    $stmt = $conn->prepare("UPDATE adok SET 
        vezeteknev = ?, 
        keresztnev = ?, 
        email = ?, 
        telszam = ?, 
        szak = ?,
        hely = ?,
        leiras = ?,
        kep = ?
        WHERE felhasznalonev = ?");

    $stmt->bind_param(
        "sssssssss",
        $updateData['vezeteknev'],
        $updateData['keresztnev'],
        $updateData['email'],
        $updateData['telszam'],
        $updateData['szak'],
        $updateData['hely'],
        $updateData['leiras'],
        $cel_fajl,
        $loggedUsername
    );

    if ($stmt->execute()) {
        foreach ($mezok as $mezo) {
            $_SESSION[$mezo] = $updateData[$mezo];
        }
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