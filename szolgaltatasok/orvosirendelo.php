<!DOCTYPE html>
<html lang="hu">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="shortcut icon" href="../kepek/MyBookinglco.ico" type="image/x-icon">
  <title>MyBooking</title>

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
      transition: transform 0.3s ease;
    }

    .doctor-card:hover {
      transform: translateY(-5px);
    }

    .doctor-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .doctor-card .card-body {
      padding: 1.5rem;
    }

    .doctor-card .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
      width: 100%;
    }

    .doctor-card .btn-primary:hover {
      background-color: #0056b3;
      border-color: #0056b3;
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
  } elseif ($_SESSION["titulus"] == "ugyfel") {
    $adatprofil = "profil.php";
  } elseif ($_SESSION["titulus"] == "ado") {
    $adatprofil = "adoprofil.php";

  }

  if (isset($_POST["szak"])) {
    $_SESSION["szak"] = $_POST["szak"];
  }

  $sql = "SELECT * FROM adok WHERE szak = '" . $_SESSION["szak"] . "'";
  $result = $conn->query($sql);

  ?>



  <nav class="navbar navbar-expand-lg navbar-light bg-light-blue">
    <div class="container">
      <div class="navbar-nav w-100 justify-content-between align-items-center">
        <a class="nav-link btn btn-outline-primary" href="../rolunk.html">Rólunk</a>
        <a class="navbar-brand" href="../fooldal.php">
          <div class="logo-circle">
            <img src="../kepek/MyBookinglogo.png" alt="MyBooking Logo" height="60" />
          </div>
        </a>
        <div class="nav-item dropdown">
          <a class="nav-link dropdown-toggle btn btn-outline-primary" href="#" id="navbarDropdown" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $_SESSION["vezeteknev"] . " " . $_SESSION["keresztnev"]; ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="../<?php echo $adatprofil; ?>">Adatok</a></li>
            <li><a class="dropdown-item" href="idopontok.php" <?php echo $_foglalt_hidden; ?>>Foglalt Időpontok</a></li>
            <li><a class="dropdown-item" href="../logout.php">Kijelentkezés</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <div class="container mt-5">




    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
      <?php



      while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="col">
          <form id="ado_' . $row['felhasznalonev'] . '" action="../foglalo.php" method="post">
                  <div class="doctor-card">
                    <img src="' . $row['kep'] . '" alt="' . $row['vezeteknev'] . ' ' . $row['keresztnev'] . '" class="card-img-top">
                    <div class="card-body">
                      <h5 class="card-title">' . $row["vezeteknev"] . " " . $row["keresztnev"] . '</h5>
                      <p class="card-text"></p>
                      <input type="hidden" name="nev" value="' . $row['felhasznalonev'] . '">
                      
                      <input type="submit" class="btn btn-primary" value="Időpontok megtekintése">
                    </div>
                  </div>
                  </form>
                </div>';
      }

      ?>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>

</body>

</html>