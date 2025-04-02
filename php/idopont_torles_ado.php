<?php
$servername = "192.168.1.45";
$username = "mybooking";
$password = "mybooking";
$dbname = "mybooking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

if (!isset($_POST["idopont"]) || !isset($_POST["ki"])) {
    die("Hibás adatok küldése!");
}

$idopont = $conn->real_escape_string($_POST["idopont"]);
$ki = $conn->real_escape_string($_POST["ki"]);

$sql = "SELECT * FROM idopontok WHERE ado='$ki' AND idopontok='$idopont'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Nincs ilyen időpont!");
}

$row = $result->fetch_assoc();
$conn->begin_transaction();

try {
    $delete_sql = "DELETE FROM idopontok WHERE ado='$ki' AND idopontok='$idopont'";
    
    if ($row["foglalt"] == "true") {
        $delete_sql_second = "DELETE FROM foglalt_idopontok WHERE kinel = '$ki' AND melyik_idopont = '$idopont'";
    } else {
        $delete_sql_second = null;
    }
    
    if ($conn->query($delete_sql) === TRUE) {
        if ($delete_sql_second && $conn->query($delete_sql_second) !== TRUE) {
            throw new Exception("Törlés hiba: " . $conn->error);
        }
        $conn->commit();
        echo "success";
    } else {
        throw new Exception("Törlés sikertelen: " . $conn->error);
    }
} catch (Exception $e) {
    $conn->rollback();
    echo "error: " . $e->getMessage();
}

$conn->close();
?>
