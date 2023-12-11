<?php
error_reporting(E_ALL);
include("../../../bd.php");

session_start();
$id_empresa_actual = $_SESSION['id_empresa'];

$id_gerente = $_GET['id'] ?? null;
if (!$id_gerente) {
    echo "ID del gerente no proporcionado.";
    exit();
}

$stmt = $conexion->prepare("SELECT * FROM gerentes_generales WHERE id = :id AND id_empresa = :id_empresa");
$stmt->bindParam(":id", $id_gerente, PDO::PARAM_INT);
$stmt->bindParam(":id_empresa", $id_empresa_actual, PDO::PARAM_INT);
$stmt->execute();
$gerente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$gerente) {
    echo "Gerente no encontrado. Verifique que el ID es correcto y pertenece a su empresa.";
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
    if ($rut != $gerente['rut']) {
        // Verificar si el nuevo RUT ya existe en la base de datos
        $stmt_verificar_rut = $conexion->prepare("SELECT * FROM gerentes_generales WHERE rut = :rut AND id != :id_gerente");
        $stmt_verificar_rut->bindParam(':rut', $rut);
        $stmt_verificar_rut->bindParam(':id_gerente', $id_gerente, PDO::PARAM_INT);
        $stmt_verificar_rut->execute();

        if ($stmt_verificar_rut->rowCount() > 0) {
            $mensajeError = 'Ya existe un gerente con el mismo RUT, ingrese otro.';
        }
    }

    if ($correo != $gerente['correo']) {
        $stmt_verificar = $conexion->prepare("SELECT * FROM gerentes_generales WHERE correo = :correo AND id_empresa = :id_empresa AND id != :id_gerente");
        $stmt_verificar->bindParam(':correo', $correo);
        $stmt_verificar->bindParam(':id_empresa', $id_empresa_actual);
        $stmt_verificar->bindParam(':id_gerente', $id_gerente);
        $stmt_verificar->execute();

        if ($stmt_verificar->rowCount() > 0) {
            $mensajeError = 'Ya existe un gerente con el mismo correo electrónico, ingrese otro.';
        }
    }

    if (empty($mensajeError)) {
        actualizarDatos($conexion, $id_gerente, $id_empresa_actual, $nombre, $apellido, $rut, $cargo, $correo, $nueva_contrasena);
        $actualizacionExitosa = true;
    }
}

function actualizarDatos($conexion, $id_gerente, $id_empresa, $nombre, $apellido, $rut, $cargo, $correo, $nueva_contrasena) {
    $query = "UPDATE gerentes_generales SET nombre = ?, apellido = ?, rut = ?, cargo = ?, correo = ?";
    $params = [$nombre, $apellido, $rut, $cargo, $correo];

    if ($nueva_contrasena) {
        $nueva_contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
        $query .= ", contrasena = ?";
        $params[] = $nueva_contrasena_hash;
    }

    $query .= " WHERE id = ? AND id_empresa = ?";
    $params[] = $id_gerente;
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
    header("Location: index_gerente.php");
    exit();
}

include("../templates/header_empresa.php");
?>

<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Editar Gerente General</h5>
    </div>

    <div class="card-body">
        <p class="lead mb-4">
            Completa el siguiente formulario para editar los datos del Gerente General:
        </p>

        <form action="" method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($gerente['nombre']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido:</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo htmlspecialchars($gerente['apellido']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="rut" class="form-label">Rut:</label>
                <input type="text" class="form-control" id="rut" name="rut" value="<?php echo htmlspecialchars($gerente['rut']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="cargo" class="form-label">Cargo:</label>
                <input type="text" class="form-control" id="cargo" name="cargo" value="<?php echo htmlspecialchars($gerente['cargo']); ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico:</label>
                <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($gerente['correo']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="nueva_contrasena" class="form-label">Nueva Contraseña (opcional):</label>
                <input type="password" class="form-control" id="nueva_contrasena" name="nueva_contrasena">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary me-2">Guardar Cambios</button>
                <a href="index_gerente.php" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php include("../templates/footer_empresa.php"); ?>
