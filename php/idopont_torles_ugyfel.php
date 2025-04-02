<?php
session_start();
$servername = "192.168.1.45";
$username = "mybooking";
$password = "mybooking";
$dbname = "mybooking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['idopont']) && isset($_POST['kinel']) && isset($_POST['ki'])) {
        $idopont = $_POST['idopont'];
        $kinel = $_POST['kinel'];
        $ki = $_POST['ki'];

        
        $update_sql = "UPDATE idopontok SET foglalt = 'false' WHERE ado = '$kinel' AND idopontok = '$idopont' AND foglalt = 'true'";
        
        
        $delete_sql = "DELETE FROM foglalt_idopontok WHERE kinel = '$kinel' AND melyik_idopont = '$idopont' AND ki = '$ki'";

        
        $conn->begin_transaction();

        try {
            
            if ($conn->query($update_sql) === TRUE) {
                
                if ($conn->query($delete_sql) === TRUE) {
                    $conn->commit();
                    echo "success";
                } else {
                    throw new Exception("Törlés hiba: " . $conn->error);
                }
            } else {
                throw new Exception("Frissítés hiba: " . $conn->error);
            }
        } catch (Exception $e) {
            // Hiba esetén visszavonás
            $conn->rollback();
            echo "error: " . $e->getMessage();
        }
    }
}

$conn->close();
?>
