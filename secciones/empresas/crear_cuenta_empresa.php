<?php include("../../templates/header.php"); ?>

<?php
include("../../bd.php");

$mensajeError = '';

if ($_POST) {
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo_empresa = $_POST['correo_empresa'];
    $nombre_empresa = $_POST['nombre_empresa'];
    $rut_empresa = $_POST['rut_empresa'];
    $numero_contacto = $_POST['numero_contacto'];

    // Verificar existencia de nombre de usuario, nombre o razón social, rut, correo y número de contacto
    $stmtExistencia = $conexion->prepare("SELECT * FROM empresas WHERE nombre_usuario = ? OR nombre_empresa = ? OR rut_empresa = ? OR correo_empresa = ? OR numero_contacto = ?");
    $stmtExistencia->execute([$nombre_usuario, $nombre_empresa, $rut_empresa, $correo_empresa, $numero_contacto]);

    $registroExistente = $stmtExistencia->fetch(PDO::FETCH_ASSOC);
    if ($registroExistente) {
        if ($registroExistente['nombre_usuario'] === $nombre_usuario) {
            $mensajeError = "El nombre de usuario ya existe.";
        } elseif ($registroExistente['nombre_empresa'] === $nombre_empresa) {
            $mensajeError = "El nombre o razón social ya existe.";
        } elseif ($registroExistente['rut_empresa'] === $rut_empresa) {
            $mensajeError = "El RUT de la empresa ya existe.";
        } elseif ($registroExistente['correo_empresa'] === $correo_empresa) {
            $mensajeError = "El correo electrónico de la empresa ya existe.";
        } elseif ($registroExistente['numero_contacto'] === $numero_contacto) {
            $mensajeError = "El número de contacto ya existe.";
        }
    } else {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $conexion->prepare("INSERT INTO empresas (nombre_usuario, password, nombre_empresa, rut_empresa, giro_comercial, correo_empresa, numero_contacto) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$nombre_usuario, $password, $nombre_empresa, $rut_empresa, $_POST['giro_comercial'], $correo_empresa, $numero_contacto])) {
            echo "<script>
                if (confirm('Registro exitoso. ¿Deseas iniciar sesión ahora?')) {
                    window.location.href = '../../iniciar_sesion.php';
                } else {
                    window.location.href = '../../index.php';
                }
            </script>";
            exit();
        } else {
            $mensajeError = "Error en el registro.";
        }
    }
}
?>


<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Registro de Empresa</h5>
    </div>

    <div class="card-body">
        <p class="lead mb-4">
            Bienvenido al registro de empresa. Aquí puedes registrar tu empresa y comenzar a administrarla.
        </p>

        <?php if ($mensajeError): ?>
            <div class="alert alert-danger"><?php echo $mensajeError; ?></div>
        <?php endif; ?>

        <form method="post" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombre_usuario" class="form-label">Nombre de Usuario:</label>
                <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" placeholder="Nombre con el cual iniciará sesión como administrador de la empresa" required>
            </div>

            <div class="mb-3">
                <label for="nombre_empresa" class="form-label">Nombre o Razón Social:</label>
                <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa" required>
            </div>

            <div class="mb-3">
                <label for="rut_empresa" class="form-label">Rut de la Empresa:</label>
                <input type="text" class="form-control" id="rut_empresa" name="rut_empresa" required>
            </div>

            <div class="mb-3">
                <label for="giro_comercial" class="form-label">Giro Comercial:</label>
                <input type="text" class="form-control" id="giro_comercial" name="giro_comercial" required>
            </div>

            <div class="mb-3">
                <label for="correo_empresa" class="form-label">Correo Electrónico de la Empresa:</label>
                <input type="email" class="form-control" id="correo_empresa" name="correo_empresa" required>
            </div>

            <div class="mb-3">
                <label for="numero_contacto" class="form-label">Número de Contacto:</label>
                <input type="text" class="form-control" id="numero_contacto" name="numero_contacto" required>
            </div>
        
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary me-2">Registrar Empresa</button>
                <button type="reset" class="btn btn-danger">Cancelar</button>
            </div>
        </form>
    </div>
</div>
<br>

<?php include("../../templates/footer.php"); ?>
