<?php
include("../../../bd.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $rut = $_POST["rut"];
    $cargo = $_POST["cargo"];
    $correo = $_POST["correo"];
    $contrasena = password_hash($_POST["contrasena"], PASSWORD_DEFAULT);

    session_start();
    $id_empresa = $_SESSION['id_empresa'];

    $stmt = $conexion->prepare("INSERT INTO gerentes_generales (id_empresa, nombre, apellido, rut, cargo, correo, contrasena) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$id_empresa, $nombre, $apellido, $rut, $cargo, $correo, $contrasena]);

    if ($stmt->rowCount() > 0) {
        // Insertar usuario asociado al gerente general
        $usuario_gerente = $correo;
        $stmt_usuario = $conexion->prepare("INSERT INTO usuarios (id_empresa, tipo_usuario, usuario, contrasena) VALUES (?, 'gerente_general', ?, ?)");
        $stmt_usuario->execute([$id_empresa, $usuario_gerente, $contrasena]);

        if ($stmt_usuario->rowCount() > 0) {
            echo "<script>
                alert('Gerente general agregado correctamente.');
                window.location.href = 'http://localhost/ProyectoOC/secciones/empresas/gerente_general/index_gerente.php';
            </script>";
            exit();
        } else {
            $error_usuario = $stmt_usuario->errorInfo();
            echo "<script>alert('Error al crear usuario asociado al gerente general: " . $error_usuario[2] . "');</script>";
        }
    } else {
        $error_gerente = $stmt->errorInfo();
        echo "<script>alert('Error al agregar gerente general: " . $error_gerente[2] . "');</script>";
    }
}
?>

<?php include("../templates/header_empresa.php"); ?>

<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Agregar Gerente General</h5>
    </div>

    <div class="card-body">
        <p class="lead mb-4">
            Completa el siguiente formulario para agregar un nuevo Gerente General:
        </p>

        <form action="crear_gerente.php" method="post">
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

            <div class="text-center">
                <button type="submit" class="btn btn-primary me-2">Crear Gerente General</button>
                <button type="reset" class="btn btn-danger">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<?php include("../templates/footer_empresa.php"); ?>
