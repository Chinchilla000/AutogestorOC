<?php include("../templates/header_empresa.php"); ?>

<div class="card">
        <div class="card-header bg-primary text-white">
            <h1 class="display-5 mb-4 text-center">Agregar Residente de Obras</h1>
        </div>
        <div class="card-body">
            <p class="lead text-center">
                Completa el siguiente formulario para agregar un nuevo Residente de Obras:
            </p>

            <form action="procesar_agregar_residente_obras.php" method="post">
            <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>

                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido:</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" required>
                </div>

                <div class="mb-3">
                    <label for="rut" class="form-label">Rut:</label>
                    <input type="text" class="form-control" id="rut" name="rut" required>
                </div>

                <div class="mb-3">
                    <label for="cargo" class="form-label">Cargo:</label>
                    <input type="text" class="form-control" id="cargo" name="cargo" value="Gerente General" readonly>
                </div>

                <div class="mb-3">
                    <label for="correo" class="form-label">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="correo" name="correo" required>
                </div>

                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                </div>


                <button type="submit" class="btn btn-primary">Crear Residente de Obras</button>
            </form>
        </div>
    </div>


<?php include("../templates/footer_empresa.php"); ?>