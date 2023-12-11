<?php
error_reporting(E_ALL);
include("../../../bd.php");

session_start();
$id_empresa_actual = $_SESSION['id_empresa'];

$id_visitador = $_GET['id'] ?? null;
if (!$id_visitador) {
    echo "ID del visitador no proporcionado.";
    exit();
}

$stmt = $conexion->prepare("SELECT * FROM visitadores_obra WHERE id = :id AND id_empresa = :id_empresa");
$stmt->bindParam(":id", $id_visitador, PDO::PARAM_INT);
$stmt->bindParam(":id_empresa", $id_empresa_actual, PDO::PARAM_INT);
$stmt->execute();
$visitador = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$visitador) {
    echo "Visitador no encontrado. Verifique que el ID es correcto y pertenece a su empresa.";
    exit();
}

$actualizacionExitosa = false;
$mensajeError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $rut = $_POST["rut"];
    $cargo = $_POST["cargo"];
    $correo = $_POST["correo"];
    $nueva_contrasena = $_POST["nueva_contrasena"] ?? '';

    // Verificar si el RUT proporcionado es diferente del actual
    if ($rut != $visitador['rut']) {
        $stmt_verificar_rut = $conexion->prepare("SELECT * FROM visitadores_obra WHERE rut = :rut AND id != :id_visitador");
        $stmt_verificar_rut->bindParam(':rut', $rut);
        $stmt_verificar_rut->bindParam(':id_visitador', $id_visitador);
        $stmt_verificar_rut->execute();

        if ($stmt_verificar_rut->rowCount() > 0) {
            $mensajeError = 'Ya existe un visitador con el mismo RUT, ingrese otro.';
        }
    }

    // Verificar si el correo electrónico proporcionado es diferente del actual
    if (empty($mensajeError) && $correo != $visitador['correo']) {
        $stmt_verificar_correo = $conexion->prepare("SELECT * FROM visitadores_obra WHERE correo = :correo AND id_empresa = :id_empresa AND id != :id_visitador");
        $stmt_verificar_correo->bindParam(':correo', $correo);
        $stmt_verificar_correo->bindParam(':id_empresa', $id_empresa_actual);
        $stmt_verificar_correo->bindParam(':id_visitador', $id_visitador);
        $stmt_verificar_correo->execute();

        if ($stmt_verificar_correo->rowCount() > 0) {
            $mensajeError = 'Ya existe un visitador con el mismo correo electrónico, ingrese otro.';
        }
    }

    // Actualizar datos si no hay errores
    if (empty($mensajeError)) {
        actualizarDatos($conexion, $id_visitador, $id_empresa_actual, $nombre, $apellido, $rut, $cargo, $correo, $nueva_contrasena);
        $actualizacionExitosa = true;
    }
}

function actualizarDatos($conexion, $id_visitador, $id_empresa, $nombre, $apellido, $rut, $cargo, $correo, $nueva_contrasena) {
    $query = "UPDATE visitadores_obra SET nombre = ?, apellido = ?, rut = ?, cargo = ?, correo = ?";
    $params = [$nombre, $apellido, $rut, $cargo, $correo];

    if (!empty($nueva_contrasena)) {
        $nueva_contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
        $query .= ", contrasena = ?";
        $params[] = $nueva_contrasena_hash;
    }

    $query .= " WHERE id = ? AND id_empresa = ?";
    $params[] = $id_visitador;
    $params[] = $id_empresa;

    $stmt_actualizar = $conexion->prepare($query);
    $stmt_actualizar->execute($params);
}

// Mostrar mensaje de error si es necesario
if (!$actualizacionExitosa && !empty($mensajeError)) {
    echo "<script>alert('$mensajeError');</script>";
}

// Redireccionar solo si la actualización fue exitosa
if ($actualizacionExitosa) {
    echo "<script>alert('Datos del visitador actualizados correctamente.'); window.location.href = 'index_visitador.php';</script>";
    exit();
}

include("../templates/header_empresa.php");
?>
<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Editar Visitador</h5>
    </div>

    <div class="card-body">
        <p class="lead mb-4">
            Completa el siguiente formulario para editar los datos del Visitador:
        </p>

        <form action="" method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($visitador['nombre']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido:</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo htmlspecialchars($visitador['apellido']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="rut" class="form-label">Rut:</label>
                <input type="text" class="form-control" id="rut" name="rut" value="<?php echo htmlspecialchars($visitador['rut']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="cargo" class="form-label">Cargo:</label>
                <input type="text" class="form-control" id="cargo" name="cargo" value="<?php echo htmlspecialchars($visitador['cargo']); ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico:</label>
                <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($visitador['correo']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="nueva_contrasena" class="form-label">Nueva Contraseña:</label>
                <input type="password" class="form-control" id="nueva_contrasena" name="nueva_contrasena">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary me-2">Guardar Cambios</button>
                <a href="index_visitador.php" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<?php include("../templates/footer_empresa.php"); ?>
