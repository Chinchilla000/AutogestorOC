<?php
error_reporting(E_ALL);
include("../../../bd.php");
include("../templates/header_empresa.php");

// Obtener el ID de residente de la URL
$id_residente = $_GET['id'];

// Obtener datos del residente para prellenar el formulario
$stmt = $conexion->prepare("SELECT * FROM residentes_obra WHERE id = :id AND id_empresa = :id_empresa");
$stmt->bindParam(":id", $id_residente);
$stmt->bindParam(":id_empresa", $id_empresa_actual);
$stmt->execute();
$residente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$residente) {
    // Manejar el caso en que el residente no existe o no pertenece a la empresa actual
    echo "Residente no encontrado.";
    exit();
}

// Manejar el formulario enviado para realizar la actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $rut = $_POST["rut"];
    $cargo = $_POST["cargo"];
    $correo = $_POST["correo"];
    $nueva_contrasena = isset($_POST["nueva_contrasena"]) ? password_hash($_POST["nueva_contrasena"], PASSWORD_DEFAULT) : null;

    // Actualizar los datos en la base de datos
    $query = "UPDATE residentes_obra SET nombre = ?, apellido = ?, rut = ?, cargo = ?, correo = ?";
    $params = [$nombre, $apellido, $rut, $cargo, $correo];

    // Incluir la nueva contraseña en la actualización si se proporciona
    if ($nueva_contrasena !== null) {
        $query .= ", contrasena = ?";
        $params[] = $nueva_contrasena;
    }

    $query .= " WHERE id = ? AND id_empresa = ?";
    $params[] = $id_residente;
    $params[] = $id_empresa_actual;

    $stmt_actualizar = $conexion->prepare($query);
    $stmt_actualizar->execute($params);

    // Redireccionar a la página de lista después de la actualización
    header("Location: index_residente.php");
    exit();
}

// Obtener la lista actualizada de residentes de obras después de la posible actualización
$sentencia = $conexion->prepare("SELECT * FROM residentes_obra WHERE id_empresa = :id_empresa");
$sentencia->bindParam(":id_empresa", $id_empresa_actual);
$sentencia->execute();
$residentesObras = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Editar Residente de Obras</h5>
    </div>

    <div class="card-body">
        <p class="lead mb-4">
            Completa el siguiente formulario para editar los datos del Residente de Obras:
        </p>

        <form action="" method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($residente['nombre']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido:</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo htmlspecialchars($residente['apellido']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="rut" class="form-label">Rut:</label>
                <input type="text" class="form-control" id="rut" name="rut" value="<?php echo htmlspecialchars($residente['rut']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="cargo" class="form-label">Cargo:</label>
                <input type="text" class="form-control" id="cargo" name="cargo" value="<?php echo htmlspecialchars($residente['cargo']); ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico:</label>
                <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($residente['correo']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="nueva_contrasena" class="form-label">Nueva Contraseña:</label>
                <input type="password" class="form-control" id="nueva_contrasena" name="nueva_contrasena">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary me-2">Guardar Cambios</button>
                <a href="index_residente.php" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<?php include("../templates/footer_empresa.php"); ?>
