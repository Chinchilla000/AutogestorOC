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

    // Verificar si ya existe un residente con el mismo correo electrónico
    $stmt_verificar = $conexion->prepare("SELECT * FROM residentes_obra WHERE correo = :correo AND id_empresa = :id_empresa");
    $stmt_verificar->bindParam(':correo', $correo);
    $stmt_verificar->bindParam(':id_empresa', $id_empresa);
    $stmt_verificar->execute();

    if ($stmt_verificar->rowCount() > 0) {
        echo "<script>alert('Ya existe un residente con el mismo correo electrónico.');</script>";
    } else {
        $stmt = $conexion->prepare("INSERT INTO residentes_obra (id_empresa, nombre, apellido, rut, cargo, correo, contrasena) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$id_empresa, $nombre, $apellido, $rut, $cargo, $correo, $contrasena]);

        if ($stmt->rowCount() > 0) {
            echo "<script>
                alert('Residente de obras agregado correctamente.');
                window.location.href = 'index_residente.php';
            </script>";
            exit();
        } else {
            $error_residente = $stmt->errorInfo();
            echo "<script>alert('Error al agregar residente de obras: " . $error_residente[2] . "');</script>";
        }
    }
}
?>

<?php include("../templates/header_empresa.php"); ?>

<div class="card">
        <div class="card-header bg-primary text-white">
            <h1 class="display-5 mb-4 text-center">Agregar Residente de Obras</h1>
        </div>
        <div class="card-body">
            <p class="lead text-center">
                Completa el siguiente formulario para agregar un nuevo Residente de Obras:
            </p>

            <form action="crear_residente.php" method="post">
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
                    <input type="text" class="form-control" id="cargo" name="cargo" value="Residente de Obras" readonly>
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