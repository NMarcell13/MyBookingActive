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


$checkUser = $conn->prepare("SELECT * FROM ugyfelek WHERE felhasznalonev = ?");
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
$szul_ido = !empty($_POST["szul_ido"]) ? $_POST["szul_ido"] : $userData["szul_ido"];
$szul_hely = !empty($_POST["szul_hely"]) ? $_POST["szul_hely"] : $userData["szul_hely"];
$nem = !empty($_POST["nem"]) ? $_POST["nem"] : $userData["nem"];
$lakcim = !empty($_POST["lakcim"]) ? $_POST["lakcim"] : $userData["lakcim"];
$tajszam = !empty($_POST["tajszam"]) ? $_POST["tajszam"] : $userData["tajszam"];
$a_neve = !empty($_POST["a_neve"]) ? $_POST["a_neve"] : $userData["a_neve"];

try {
    $stmt = $conn->prepare("UPDATE ugyfelek SET 
        vezeteknev = ?, 
        keresztnev = ?, 
        email = ?, 
        telszam = ?, 
        szul_ido = ?, 
        szul_hely = ?, 
        nem = ?, 
        lakcim = ?, 
        tajszam = ?, 
        a_neve = ? 
        WHERE felhasznalonev = ?");

    $stmt->bind_param(
        "sssssssssss",
        $vezeteknev,
        $keresztnev,
        $email,
        $telszam,
        $szul_ido,
        $szul_hely,
        $nem,
        $lakcim,
        $tajszam,
        $a_neve,
        $loggedUsername
    );

    if ($stmt->execute()) {
        echo "Sikeres frissítés!";
        header("Location: ../profil.php");
        $_SESSION["vezeteknev"] = $vezeteknev;
        $_SESSION["keresztnev"] = $keresztnev;
        $_SESSION["email"] = $email;
        $_SESSION["telszam"] = $telszam;
        $_SESSION["szul_ido"] = $szul_ido;
        $_SESSION["szul_hely"] = $szul_hely;
        $_SESSION["nem"] = $nem;
        $_SESSION["lakcim"] = $lakcim;
        $_SESSION["tajszam"] = $tajszam;
        $_SESSION["a_neve"] = $a_neve;
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