<?php
session_start();

if (!isset($_SESSION["felhasznalo"]) || empty($_SESSION["felhasznalo"])) {
    echo "Nincs bejelentkezve! Session változó üres.";
    exit();
}

$loggedUsername = $_SESSION["felhasznalo"];
echo "Bejelentkezett felhasználó: " . $loggedUsername;

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
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('" . $output . "' );</script>";
}

$checkUser = $conn->prepare("SELECT * FROM adok WHERE felhasznalonev = ?");
$checkUser->bind_param("s", $loggedUsername);
$checkUser->execute();
$result = $checkUser->get_result();

if ($result->num_rows === 0) {
    echo "A felhasználó nem található az adatbázisban: " . $loggedUsername;
    $checkUser->close();
    $conn->close();
    exit();
}


$userData = $result->fetch_assoc();
$checkUser->close();

$vezeteknev = !empty($_POST["vezeteknev"]) ? $_POST["vezeteknev"] : $userData["vezeteknev"];
$keresztnev = !empty($_POST["keresztnev"]) ? $_POST["keresztnev"] : $userData["keresztnev"];
$email = !empty($_POST["email"]) ? $_POST["email"] : $userData["email"];
$telszam = !empty($_POST["telszam"]) ? $_POST["telszam"] : $userData["telszam"];
$szak = !empty($_POST["szak"]) ? $_POST["szak"] : $userData["szak"];

$cel_fajl = "";

if (isset($_FILES["kepfeltoltes"]) && $_FILES["kepfeltoltes"]["error"] == 0) {
    $eleresi_ut = "../adoprofilkepek/";
    $cel_fajl = $eleresi_ut . uniqid() . basename($_FILES["kepfeltoltes"]["name"]);
    $fajl_tipus = strtolower(pathinfo($cel_fajl, PATHINFO_EXTENSION));


    if ($_FILES["kepfeltoltes"]["size"] > 5 * 1024 * 1024) {
        hiba_log("A fájl túl nagy.");
        $cel_fajl = $userData["kep"];

        exit;
    }


    if (
        $fajl_tipus != "jpg" && $fajl_tipus != "png" && $fajl_tipus != "jpeg"
        && $fajl_tipus != "gif"
    ) {
        hiba_log("Nem engedélyezett fájltípus.");
        $cel_fajl = $userData["kep"];

        exit;
    }




    if (move_uploaded_file($_FILES["kepfeltoltes"]["tmp_name"], $cel_fajl)) {
        hiba_log("A fájl sikeresen feltöltve.");

    } else {
        hiba_log("Hiba történt a fájl feltöltésekor. marad a régi kép ");
        $cel_fajl = $userData["kep"];

        exit;
    }
} else {
    hiba_log("Nincs fájl feltöltve vagy hiba történt a feltöltés során. marad a régi kép");


    $cel_fajl = $userData["kep"];
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
        $vezeteknev,
        $keresztnev,
        $email,
        $telszam,
        $szak,
        $cel_fajl,
        $loggedUsername
    );

    if ($stmt->execute()) {
        echo "Sikeres frissítés!";

        $_SESSION["vezeteknev"] = $vezeteknev;
        $_SESSION["keresztnev"] = $keresztnev;
        $_SESSION["email"] = $email;
        $_SESSION["telszam"] = $telszam;
        $_SESSION["szak"] = $szak;
        $_SESSION["kep"] = $cel_fajl;

        header("Location: ../adoprofil.php");
        exit();
    } else {
        echo "Hiba történt a frissítés során: " . $stmt->error;
    }
} catch (mysqli_sql_exception $e) {
    echo "Adatbázis hiba: " . $e->getMessage();
    exit();
}

$stmt->close();
$conn->close();
?>