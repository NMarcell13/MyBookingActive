<!DOCTYPE html>
<html lang="hu">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="stiluslap.css">
  <link rel="shortcut icon" href="kepek/MyBookinglco.ico" type="image/x-icon">
  <title>Főoldal - MyBooking</title>

</head>

<body>
  <?php session_start();

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
            <li><a class="dropdown-item" href="logout.php">Kijelentkezés</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <br>

  <div class="container mt-5">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
      <?php
      $services = [
        ['name' => 'Fodrászat', 'image' => 'fodraszat.jpg', 'link' => 'szolgaltatasok/orvosirendelo.php', 'szak' => 'fodrasz'],
        ['name' => 'Orvosi rendelő', 'image' => 'orvosi.jpg', 'link' => 'szolgaltatasok/orvosirendelo.php', 'szak' => 'orvos'],
        ['name' => 'Buli', 'image' => 'buli.jpg', 'link' => 'szolgaltatasok/orvosirendelo.php', 'szak' => 'buli'],
        ['name' => 'Tanulás', 'image' => 'tanulas.jpg', 'link' => 'szolgaltatasok/orvosirendelo.php', 'szak' => 'tanar'],
        ['name' => 'Utazás', 'image' => 'utazas.jpg', 'link' => 'szolgaltatasok/orvosirendelo.php', 'szak' => 'utazas'],
        ['name' => 'Technológia', 'image' => 'tech.jpg', 'link' => 'szolgaltatasok/orvosirendelo.php', 'szak' => 'tech'],
        ['name' => 'Sport', 'image' => 'sport.jpg', 'link' => 'szolgaltatasok/orvosirendelo.php', 'szak' => 'sport'],
        ['name' => 'Autószerelő', 'image' => 'autoszerlo.jpg', 'link' => 'szolgaltatasok/orvosirendelo.php', 'szak' => 'auto']
      ];

      foreach ($services as $service) {
        echo '<div class="col">
          <form id="szol_' . $service['szak'] . '" method="post" action="szolgaltatasok/orvosirendelo.php">
            <div class="service-box position-relative" onclick="submitForm(\'' . $service['szak'] . '\')">
              <img src="kepek/' . $service['image'] . '" alt="' . $service['name'] . '">
              <div class="service-label">' . $service['name'] . '</div>
              <input type="hidden" name="szak" value="' . $service['szak'] . '">
            </div>
          </form>
        </div>';
      }
      ?>
    </div>
  </div>
  <div class="container mt-5 mb-5">
    <div class="row">
      <div class="col-12">
        <div class="card bg-light-blue">
          <div class="card-body p-4">
            <div class="row align-items-center">
              <div class="col-md-8">
                <h2 class="card-title mb-3"> <strong>[Reklámblokk]</strong> Mátészalkai Szakképzési Centrum Gépészeti
                  Technikum és Kollégium</h2>
                <p class="card-text">A <strong>SZAKÉRTELEM</strong> nálunk kezdődik.</p>
                <ul class="list-unstyled">
                  <li><i class="bi bi-check-circle-fill text-primary me-2"></i>5 éves képzés, mely 2 év ágazati
                    alapoktatásból és 3 év szakirányú oktatásból áll.</li>
                  <li><i class="bi bi-check-circle-fill text-primary me-2"></i>A jelentkezéskor csak ágazatot kell
                    választanod, a konkrét szakmára felkészítő szakirányú oktatás a harmadik évtől kezdődik.</li>
                  <li><i class="bi bi-check-circle-fill text-primary me-2"></i>A technikum egyesíti a gimnázium és a
                    szakmatanulás előnyeit.</li>
                </ul>
                <a href="https://mateszalka-gepeszeti.www.intezmeny.edir.hu/" target="_blank"
                  class="btn btn-primary mt-3">Érdekel</a>
              </div>
              <div class="col-md-4 text-center">
                <img src="kepek/gepesz.png" alt="gepeszlogo" class="img-fluid" style="max-width: 300px;">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>





  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
  <script src="script.js"></script>
  <script>
    function submitForm(szak) {
      document.getElementById('szol_' + szak).submit();
    }
  </script>
</body>

</html>