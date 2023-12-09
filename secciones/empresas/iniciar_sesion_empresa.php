<?php
include("../../bd.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión Cuenta Empresa</title>
    <link rel="icon" href="../../img/Logo2.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Tu hoja de estilo personalizada -->
    <link rel="stylesheet" href="../../CSS/styles.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    
    <br><br>
    <main class="form-signin w-100 m-auto container flex-grow-1">

        <form action="procesar_inicio_sesion_empresa.php" method="post">
            <img class="mb-4" src="../../img/logo.png" alt="Logo" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Iniciar Sesión: Cuenta Empresa</h1>

            <div class="form-floating">
                <input type="email" class="form-control" id="floatingInput" name="correo" placeholder="name@example.com" required>
                <label for="floatingInput">Correo Electrónico</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" name="contrasena" placeholder="Contraseña" required>
                <label for="floatingPassword">Contraseña</label>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger" role="alert">
                    Correo electrónico o contraseña incorrecta.
                </div>
            <?php endif; ?>

    <div class="form-check text-start my-3">
        <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
        <label class="form-check-label" for="flexCheckDefault">
            Recordar usuario
        </label>
    </div>
    <button class="btn btn-primary w-100 py-2" type="submit">Iniciar Sesión</button>
    <p class="mt-3 text-muted"> Para regresar click <a href="../../iniciar_sesion.php">aqui.</a></p>
</form>
    </main>


    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
