<?php
error_reporting(E_ALL);
include("../../../bd.php");
include("../templates/header_empresa.php");

// Obtener el ID de la empresa actual desde la sesión
$id_empresa_actual = $_SESSION['id_empresa'];

// Función para mostrar mensajes y recargar la página
function mostrarMensaje($mensaje, $esError = false) {
    echo "<script>alert('$mensaje'); window.location.href = 'index_residente.php';</script>";
    exit();
}

// Verificar si se ha enviado el ID a eliminar y la solicitud es GET
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id_residente = $_GET['id'];

    // Consulta la base de datos para obtener información antes de la eliminación
    // ...

    // Luego, realiza la eliminación
    $sentencia = $conexion->prepare("DELETE FROM residentes_obra WHERE id=:id AND id_empresa=:id_empresa");
    $sentencia->bindParam(":id", $id_residente);
    $sentencia->bindParam(":id_empresa", $id_empresa_actual);
    $sentencia->execute();
    header("Location: index_residente.php");
    exit();
}

$sentencia = $conexion->prepare("SELECT * FROM residentes_obra WHERE id_empresa = :id_empresa");
$sentencia->bindParam(":id_empresa", $id_empresa_actual);
$sentencia->execute();
$residentesObras = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2>Lista de Residentes de Obras</h2>
    <p>Aquí se muestra la lista de Residentes de Obras:</p>

    <?php if ($residentesObras) : ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Rut</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Correo Electrónico</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($residentesObras as $residente) : ?>
                        <tr>
                            <td><?php echo $residente['nombre']; ?></td>
                            <td><?php echo $residente['apellido']; ?></td>
                            <td><?php echo $residente['rut']; ?></td>
                            <td><?php echo $residente['cargo']; ?></td>
                            <td><?php echo $residente['correo']; ?></td>
                            <td>
                                <!-- Botones de acciones con espacio en blanco -->
                                <a href='./editar_residente.php?id=<?php echo $residente['id']; ?>' class='btn btn-info btn-sm'>Editar</a>
                                <button class='btn btn-danger btn-sm' onclick='confirmarEliminacion(<?php echo $residente['id']; ?>)'>Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <p>No hay Residentes de Obras registrados.</p>
    <?php endif; ?>

    <div class="mt-3">
        <a href="<?php echo $url_base2; ?>residente/crear_residente.php" class="btn btn-primary">Agregar Residente de Obras</a>
    </div>
</div>

<?php include("../templates/footer_empresa.php"); ?>

<!-- Agrega este script JavaScript al final del archivo -->
<script>
function confirmarEliminacion(id) {
    var confirmacion = confirm("¡Advertencia!\nEsta acción eliminará permanentemente al residente y todos los datos asociados. ¿Estás seguro de continuar?");

    if (confirmacion) {
        window.location.href = "index_residente.php?id=" + id;
    }
}
</script>
