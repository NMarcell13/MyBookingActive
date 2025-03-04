<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="shortcut icon" href="kepek/MyBookinglco.ico" type="image/x-icon">
    <title>Adatok - MyBooking</title>
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

        .profile-card {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <?php session_start() ?>

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
                    <a class="nav-link dropdown-toggle btn btn-outline-primary" href="#" id="navbarDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $_SESSION["vezeteknev"], " ", $_SESSION["keresztnev"] ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="adoprofil.php">Adatok</a></li>
                        <li><a class="dropdown-item" href="index.html">Kijelentkezés</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="profile-card p-4">
                    <h1 class="text-center mb-4">Személyes adatok</h1>
                    <form action="php/Aupdate.php" method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h5>Vezetéknév:</h5>
                            <input type="text" class="form-control inp" id="vezeteknev" name="vezeteknev"
                                    placeholder="<?php echo $_SESSION["vezeteknev"] ?>" disabled>
                            
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5>Keresztnév:</h5>
                            <input type="text" class="form-control inp" id="keresztnev" name="keresztnev"
                                    placeholder="<?php echo $_SESSION["keresztnev"] ?>" disabled>
                           
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5>Email:</h5>
                            <input type="text" class="form-control inp" id="email" name="email"
                                    placeholder="<?php echo $_SESSION["email"] ?>" disabled>
                            
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5>Telefonszám:</h5>
                            <input type="tel" class="form-control inp" id="telszam" name="telszam"
                                    placeholder="<?php echo $_SESSION["telszam"] ?>" disabled>
                            
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5>Szakterület:</h5>
                            <select name="szak" id="szak" class="form-control inp" disabled>
                                    <option value="" disabled selected><?php echo $_SESSION["szak"] ?></option>
                                    <option value="fodrasz">Fodrász</option>
                                    <option value="orvos">Orvos</option>
                                    <option value="buli">Buli</option>
                                    <option value="tanar">Tanár</option>
                                    <option value="utazas">Utazási asszisztens</option>
                                    <option value="tech">Tech</option>
                                    <option value="sport">Sport szakértő</option>
                                    <option value="auto">Autószerelő</option>
                                </select>
                            
                        </div>
                        <div class="col-md-6 mb-3">
                        <h5>Profilkép:</h5>
                        
                        <input type="file" id="kepfeltoltes" class="inp" name="kepfeltoltes" accept="image/*" disabled>
                            
                        </div>

                        <div class="col-md-6 mb-3">
                            <button type="button" class="btn btn-primary w-100 mt-4" id="szerkesztes"  onclick="szerkesztess()">Profil adatainak
                                szerkesztése</button>
                        </div>
                        <div class="col-md-6 mb-3">
                                <button type="submit" class="btn btn-primary w-100 mt-4" id="mentes"
                                    hidden>Mentés</button>
                            </div>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script> function szerkesztess() {
            let mentes = document.getElementById('mentes');
            mentes.hidden = false;
            document.querySelectorAll('.inp').forEach(el => el.removeAttribute('disabled'));
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