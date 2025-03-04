<?php
$servername = "192.168.1.45";
$username = "mybooking";
$password = "mybooking";
$dbname = "mybooking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}
$cel_fajl = "";
function hiba_log($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('" . $output . "' );</script>";
}

if (isset($_FILES["kepfeltoltes"]) && $_FILES["kepfeltoltes"]["error"] == 0) {
    $eleresi_ut = "../adoprofilkepek/";
    $cel_fajl = $eleresi_ut . uniqid() . basename($_FILES["kepfeltoltes"]["name"]);
    $fajl_tipus = strtolower(pathinfo($cel_fajl, PATHINFO_EXTENSION));


    if ($_FILES["kepfeltoltes"]["size"] > 5 * 1024 * 1024) {
        hiba_log("A fájl túl nagy.");

        exit;
    }


    if (
        $fajl_tipus != "jpg" && $fajl_tipus != "png" && $fajl_tipus != "jpeg"
        && $fajl_tipus != "gif"
    ) {
        hiba_log("Nem engedélyezett fájltípus.");

        exit;
    }




    if (move_uploaded_file($_FILES["kepfeltoltes"]["tmp_name"], $cel_fajl)) {
        hiba_log("A fájl sikeresen feltöltve.");

    } else {
        hiba_log("Hiba történt a fájl feltöltésekor.");

        exit;
    }
} else {
    hiba_log("Nincs fájl feltöltve vagy hiba történt a feltöltés során.");


    $cel_fajl = "../kepek/blankprofile.jpg";
}

$username = $_POST['username'];
$password = $_POST['password'];
$password = password_hash($password, PASSWORD_DEFAULT);
$vnev = $_POST['vnev'];
$knev = $_POST['knev'];
$email = $_POST['email'];
$telszam = $_POST['telszam'];
$szak = $_POST['szak'];
$profilkep = $cel_fajl;
$hely = $_POST['hely'];
$leiras = $_POST['leiras'];


try {
    $stmt = $conn->prepare("INSERT INTO adok (felhasznalonev, jelszo, vezeteknev, keresztnev, email, telszam, szak, kep, hely, leiras) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $username, $password, $vnev, $knev, $email, $telszam, $szak, $profilkep, $hely, $leiras);

    if ($stmt->execute()) {
        header("Location: ../adologin.html");
        exit();
    }
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1062) {
        echo '<script>
    
        if (confirm("Ez a felhasználónév már foglalt!")) {
            
            window.open("../adoregister.html","_self")
            
        } else {
           
            window.open("../adoregister.html","_self")
        }
        
        
        </script>';
    } else {
        echo '<script>
    
        if (confirm("Hiba történt! ' . $e->getCode() . '")) {
            
            window.open("../adoregister.html","_self")
            
        } else {
           
            window.open("../adoregister.html","_self")
        }
        
        
        </script>';

    }
    exit();
}


$stmt->close();
$conn->close();