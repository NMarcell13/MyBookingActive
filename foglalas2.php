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

// Ellenőrizzük, hogy a form adatok megérkeztek-e
if (isset($_POST['selected_time_input']) && isset($_POST['ado_username'])) {
    $selected_time = $_POST['selected_time_input'];
    $ado_username = $_POST['adoneve'];
    $felhasznalo = $_SESSION['felhasznalo']; // A bejelentkezett felhasználó

    // 1. Frissítjük az idopontok táblában a foglalt mezőt "false"-ról "true"-ra
    // Fontos: szöveges értékként kezeljük, nem boolean-ként
    $check_sql = "SELECT * FROM idopontok WHERE idopontok='$selected_time' AND ado='$ado_username'";
    $result = $conn->query($check_sql);
    $row = $result->fetch_assoc();
    if ($row["foglalt"] == "false") {

        $update_sql = "UPDATE idopontok SET foglalt = 'true' 
        WHERE ado = '$ado_username' AND idopontok = '$selected_time' AND foglalt = 'false'";

        $conn->query($update_sql);

        // 2. Beszúrjuk az adatokat a foglalt_idopontok táblába
        $insert_sql = "INSERT INTO foglalt_idopontok (kinel, ki, melyik_idopont) 
        VALUES ('$ado_username', '$felhasznalo', '$selected_time')";

        if ($conn->query($insert_sql) === TRUE) {
            echo "<script>alert('Sikeres időpontfoglalás!'); window.location.href='foglalo.php';</script>";
        } else {
            echo "<script>alert('Hiba történt a foglalás során: " . $conn->error . "'); window.location.href='fooldal.php';</script>";
        }

    } else {
        echo "<script>alert('Ez az időpont foglalt'); window.location.href='foglalo.php';</script>";

    }





} else {
    // Ha nincs kiválasztva időpont
    echo "<script>alert('Kérjük válasszon időpontot!'); window.location.href='fooldal.php';</script>";
}




$conn->close();
?>