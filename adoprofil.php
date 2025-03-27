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

        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #e6f3ff;
            color: #007bff;
            border: 1px dashed #007bff;
            border-radius: 8px;
            padding: 10px 15px;
            cursor: pointer;
            transition: all 0.3s;
            height: 100%;
            min-height: 58px;
        }

        .file-upload-label:hover {
            background-color: #d1e7ff;
        }

        .file-upload-label i {
            margin-right: 8px;
            font-size: 1.2rem;
        }

        .file-upload input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-name {
            margin-top: 5px;
            font-size: 0.85rem;
            color: #6c757d;
            text-align: center;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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
                    <form action="php/Aupdate.php" method="post" enctype="multipart/form-data">
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
                                    <option value="Fodrász">Fodrász</option>
                                    <option value="Orvos">Orvos</option>
                                    <option value="Buli szervező">Buli</option>
                                    <option value="Tanár">Tanár</option>
                                    <option value="Utazási asszisztens">Utazási asszisztens</option>
                                    <option value="Tech">Tech</option>
                                    <option value="Sport szakértő">Sport szakértő</option>
                                    <option value="Autószerelő">Autószerelő</option>
                                </select>

                            </div>
                            <div class="col-md-6 mb-3">
                                <h5>Profilkép:</h5>

                                <div class="file-upload" class="inp">
                                    <label for="kepfeltoltes" class="file-upload-label">
                                        <i class="bi bi-cloud-arrow-up"></i>
                                        <span id="file-chosen">Válasszon képet...</span>
                                    </label>
                                    <input type="file" id="kepfeltoltes" name="kepfeltoltes" class="form-control inp"
                                        accept="image/*">
                                    <div id="file-name" class="file-name"></div>
                                </div>

                            </div>

                            <div class="col-md-6 mb-3">
                                <h5>Helyszín:</h5>
                                <input type="tel" class="form-control inp" id="hely" name="hely"
                                    placeholder="<?php echo $_SESSION["hely"] ?>" disabled>

                            </div>

                            <div class="col-md-6 mb-3">
                                <h5>Leírás:</h5>
                                <input type="tel" class="form-control inp" id="leiras" name="leiras"
                                    placeholder="<?php echo $_SESSION["leiras"] ?>" disabled>

                            </div>

                            <div class="col-md-6 mb-3">
                                <button type="button" class="btn btn-primary w-100 mt-4" id="szerkesztes"
                                    onclick="szerkesztess()">Profil adatainak
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

            const fileInput = document.getElementById('kepfeltoltes');
            const fileChosen = document.getElementById('file-chosen');
            const fileName = document.getElementById('file-name');

            fileInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    fileChosen.textContent = 'Kép kiválasztva';
                    fileName.textContent = this.files[0].name;
                } else {
                    fileChosen.textContent = 'Válasszon képet...';
                    fileName.textContent = '';
                }
            });
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