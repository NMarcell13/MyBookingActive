<!DOCTYPE html>
<html lang="hu">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
  <link rel="shortcut icon" href="kepek/MyBookinglco.ico" type="image/x-icon">
  <title>Főoldal - MyBooking</title>
  <style>
    body {
      background-color: #f0f8ff;
    }

    .bg-light-blue {
      background-color: #e6f3ff;
    }

    .logo-circle {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background-color: #ffffff;
      display: flex;
      justify-content: center;
      align-items: center;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin: 0 auto;
    }

    .navbar-nav .btn {
      color: #007bff;
      border-color: #007bff;
    }

    .navbar-nav .btn:hover {
      background-color: #007bff;
      color: #ffffff;
    }

    .doctor-card {
      background-color: #ffffff;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      margin-bottom: 2rem;
    }

    .doctor-info {
      padding: 1.5rem;
    }

    .doctor-image {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .time-slots {
      background-color: #ffffff;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      padding: 1.5rem;
    }

    .time-slot {
      margin-bottom: 1rem;
    }

    .custom-date {
      margin-top: 2rem;
    }

    .book-button {
      background-color: #007bff;
      color: #ffffff;
      border: none;
      border-radius: 5px;
      padding: 0.5rem 1rem;
      margin-top: 1rem;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    

    .time-buttons {
      margin-bottom: 1.5rem;
    }

    .time-slot-btn {
      margin-bottom: 0.5rem;
      margin-right: 0.5rem;
      position: relative;
    }

    /* New styles for hover effect */
    .time-slot-btn:hover {
      border: 2px solid #dc3545 !important;
      background-color: #dc3545;
    }

    .delete-icon {
      position: absolute;
      top: -10px;
      right: -10px;
      background-color: white;
      border-radius: 50%;
      padding: 3px;
      color: #dc3545;
      display: none;
      cursor: pointer;
      z-index: 10;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }

    .time-slot-btn:hover .delete-icon {
      display: block;
    }
  </style>

</head>

<body>
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

  if ($_SESSION["titulus"] == "admin") {
    $adatprofil = "adminprofil.php";

  }
  if ($_SESSION["titulus"] == "ugyfel") {
    $adatprofil = "profil.php";

  }
  if ($_SESSION["titulus"] == "ado") {
    $adatprofil = "adoprofil.php";
  }

  

  ?>

  <nav class="navbar navbar-expand-lg navbar-light bg-light-blue">
    <div class="container">
      <div class="navbar-nav w-100 justify-content-between align-items-center">
        <a class="nav-link btn btn-outline-primary" href="rolunk.html">Rólunk</a>
        <a class="navbar-brand" href="fooldal.php">
          <div class="logo-circle">
            <img src="kepek/MyBooking.png" alt="MyBooking Logo" height="60" />
          </div>
        </a>
        <div class="nav-item dropdown">
          <a class="nav-link dropdown-toggle btn btn-outline-primary" href="#" id="navbarDropdown" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $_SESSION["vezeteknev"], " ", $_SESSION["keresztnev"] ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="<?php echo $adatprofil ?>">Adatok</a></li>
            <li><a class="dropdown-item" href="idopontok.php" <?php echo $_foglalt_hidden; ?>>Foglalt Időpontok</a></li>
            <li><a class="dropdown-item" href="logout.php">Kijelentkezés</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <br>

  <div class="time-slots">
    <h3 class="mb-4">Foglalt Időpontok : </h3>
    <form method="POST" action="foglalas.php">
      <div class="row">
        <label for="date">Időpontok:</label>
        <br>
        <br>
        <?php
        $sql = "SELECT melyik_idopont FROM foglalt_idopontok WHERE ki = '" . $_SESSION["felhasznalo"] . "'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          echo "<div class='time-buttons d-flex flex-wrap'>";
          while ($row = $result->fetch_assoc()) {
            $idopont = $row["melyik_idopont"];
            $kinel=$row["kinel"];
            echo "<div class='position-relative'>";
            echo "<button type='button' class='btn btn-outline-primary time-slot-btn' onclick='selectTimeSlot(this)' name='selected_time' value='" . $idopont . "'>" . $idopont;
            echo "<span class='delete-icon' onclick='deleteTimeSlot(event, \"" . $idopont . "\")'><i class='bi bi-trash-fill'></i></span>";
            echo "</button>";
            echo "</div>";
          }
          echo "</div>";
          echo "<input type='hidden' id='selected_time_input' name='selected_time_input'>";
        } else {
          echo "<p>Nincs még időpont feltöltve.</p>";
        }
        ?>
        <br>
        <br>
    </form>
  </div>
  <br>

  <script>
    function selectTimeSlot(button) {
      const buttons = document.querySelectorAll('.time-slot-btn');
      buttons.forEach(btn => btn.classList.remove('btn-primary'));
      buttons.forEach(btn => btn.classList.add('btn-outline-primary'));

      button.classList.remove('btn-outline-primary');
      button.classList.add('btn-primary');

      document.getElementById('selected_time_input').value = button.value;
    }

    function deleteTimeSlot(event, idopont) {
      event.stopPropagation(); 
      if (confirm('Biztosan törölni szeretné ezt az időpontot?')) {
        <?php
        
        $update_sql = "UPDATE idopontok SET foglalt = 'false' 
        WHERE ado = '$kinel' AND idopontok = '$selected_time' AND foglalt = 'true'";

        $conn->query($update_sql);
         ?>
      }
      
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
</body>

</html>