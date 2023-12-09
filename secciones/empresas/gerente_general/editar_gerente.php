<?php
error_reporting(E_ALL);
include("../../../bd.php");

session_start();
$id_empresa_actual = $_SESSION['id_empresa'];

// Obtener el ID de gerente de la URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID del gerente no proporcionado.";
    exit();
}

$id_gerente = $_GET['id'];

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
    $stmt_actualizar_datos = $conexion->prepare("UPDATE gerentes_generales SET nombre = ?, apellido = ?, rut = ?, cargo = ?, correo = ? WHERE id = ? AND id_empresa = ?");
    $params_datos = [$nombre, $apellido, $rut, $cargo, $correo, $id_gerente, $id_empresa_actual];
    $stmt_actualizar_datos->execute($params_datos);

    // Incluir la nueva contraseña en la actualización si se proporciona
    if ($nueva_contrasena !== null) {
        $stmt_actualizar_contrasena = $conexion->prepare("UPDATE gerentes_generales SET contrasena = ? WHERE id = ? AND id_empresa = ?");
        $params_contrasena = [$nueva_contrasena, $id_gerente, $id_empresa_actual];
        $stmt_actualizar_contrasena->execute($params_contrasena);
    }

    // Redireccionar a la página de lista después de la actualización
    header("Location: index_gerente.php");
    exit();
}

// Si no se ha enviado el formulario, obtén los datos del gerente para mostrarlos en el formulario
$stmt = $conexion->prepare("SELECT * FROM gerentes_generales WHERE id = :id AND id_empresa = :id_empresa");
$stmt->bindParam(":id", $id_gerente, PDO::PARAM_INT);
$stmt->bindParam(":id_empresa", $id_empresa_actual, PDO::PARAM_INT);
$stmt->execute();
$gerente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$gerente) {
    echo "Gerente no encontrado. Verifique que el ID es correcto y pertenece a su empresa.";
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
