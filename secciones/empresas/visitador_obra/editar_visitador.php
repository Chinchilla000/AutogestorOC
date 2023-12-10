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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $rut = $_POST["rut"];
    $cargo = $_POST["cargo"];
    $correo = $_POST["correo"];
    $nueva_contrasena = $_POST["nueva_contrasena"] ?? '';

    if ($correo != $visitador['correo']) {
        $stmt_verificar = $conexion->prepare("SELECT * FROM visitadores_obra WHERE correo = :correo AND id_empresa = :id_empresa AND id != :id_visitador");
        $stmt_verificar->bindParam(':correo', $correo);
        $stmt_verificar->bindParam(':id_empresa', $id_empresa_actual);
        $stmt_verificar->bindParam(':id_visitador', $id_visitador);
        $stmt_verificar->execute();

        if ($stmt_verificar->rowCount() > 0) {
            echo "<script>alert('Ya existe un visitador con el mismo correo electrónico.');</script>";
        } else {
            actualizarDatos();
        }
    } else {
        actualizarDatos();
    }
}

function actualizarDatos() {
    global $conexion, $id_visitador, $id_empresa_actual, $nombre, $apellido, $rut, $cargo, $correo, $nueva_contrasena;

    $query = "UPDATE visitadores_obra SET nombre = ?, apellido = ?, rut = ?, cargo = ?, correo = ?";
    $params = [$nombre, $apellido, $rut, $cargo, $correo];

    if ($nueva_contrasena) {
        $nueva_contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
        $query .= ", contrasena = ?";
        $params[] = $nueva_contrasena_hash;
    }

    $query .= " WHERE id = ? AND id_empresa = ?";
    $params[] = $id_visitador;
    $params[] = $id_empresa_actual;

    $stmt_actualizar = $conexion->prepare($query);
    $stmt_actualizar->execute($params);

    header("Location: index_visitador.php");
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
