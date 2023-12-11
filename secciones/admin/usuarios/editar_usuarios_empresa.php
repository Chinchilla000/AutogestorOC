<?php
include("../../../bd.php");

$id_empresa = $_GET['id'] ?? null;

if (!$id_empresa) {
    echo "ID de empresa no proporcionado.";
    exit();
}

$stmt = $conexion->prepare("SELECT * FROM empresas WHERE id = :id");
$stmt->bindParam(":id", $id_empresa);
$stmt->execute();
$empresa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$empresa) {
    echo "Empresa no encontrada.";
    exit();
}

$mensajeError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST['nombre_usuario'];
    $nombre_empresa = $_POST['nombre_empresa'];
    $rut_empresa = $_POST['rut_empresa'];
    $giro_comercial = $_POST['giro_comercial'];
    $correo_empresa = $_POST['correo_empresa'];
    $numero_contacto = $_POST['numero_contacto'];
    $password = $_POST['password'];

    // Verificación de existencia de datos
    $stmtVerificacion = $conexion->prepare("SELECT * FROM empresas WHERE (nombre_usuario = ? OR nombre_empresa = ? OR rut_empresa = ? OR correo_empresa = ? OR numero_contacto = ?) AND id != ?");
    $stmtVerificacion->execute([$nombre_usuario, $nombre_empresa, $rut_empresa, $correo_empresa, $numero_contacto, $id_empresa]);

    $registroExistente = $stmtVerificacion->fetch(PDO::FETCH_ASSOC);
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
        $updateQuery = "UPDATE empresas SET nombre_usuario = ?, nombre_empresa = ?, rut_empresa = ?, giro_comercial = ?, correo_empresa = ?, numero_contacto = ?";
        $params = [$nombre_usuario, $nombre_empresa, $rut_empresa, $giro_comercial, $correo_empresa, $numero_contacto];

        if (!empty($password)) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $updateQuery .= ", password = ?";
            $params[] = $passwordHash;
        }

        $updateQuery .= " WHERE id = ?";
        $params[] = $id_empresa;

        $updateStmt = $conexion->prepare($updateQuery);
        $updateStmt->execute($params);

        header("Location: usuarios_empresas.php");
        exit();
    }
}

include("../templates/header_adm.php");
?>

<div class="container mt-5">
    <h2>Editar Empresa</h2>
    <?php if ($mensajeError): ?>
        <div class="alert alert-danger"><?php echo $mensajeError; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="nombre_usuario" class="form-label">Nombre de Usuario:</label>
            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="<?php echo $empresa['nombre_usuario']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="nombre_empresa" class="form-label">Nombre o Razón Social:</label>
            <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa" value="<?php echo $empresa['nombre_empresa']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="rut_empresa" class="form-label">Rut de la Empresa:</label>
            <input type="text" class="form-control" id="rut_empresa" name="rut_empresa" value="<?php echo $empresa['rut_empresa']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="giro_comercial" class="form-label">Giro Comercial:</label>
            <input type="text" class="form-control" id="giro_comercial" name="giro_comercial" value="<?php echo $empresa['giro_comercial']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="correo_empresa" class="form-label">Correo Electrónico de la Empresa:</label>
            <input type="email" class="form-control" id="correo_empresa" name="correo_empresa" value="<?php echo $empresa['correo_empresa']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="numero_contacto" class="form-label">Número de Contacto:</label>
            <input type="text" class="form-control" id="numero_contacto" name="numero_contacto" value="<?php echo $empresa['numero_contacto']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Nueva Contraseña (opcional):</label>
            <input type="password" class="form-control" id="password" name="password">
            <small>Dejar en blanco para mantener la contraseña actual.</small>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary me-2">Actualizar Empresa</button>
            <a href="usuarios_empresas.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<?php include("../templates/footer_adm.php"); ?>