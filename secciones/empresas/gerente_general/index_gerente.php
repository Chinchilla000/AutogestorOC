<?php
error_reporting(E_ALL);
include("../../../bd.php");
include("../templates/header_empresa.php");

// Obtener el ID de la empresa actual desde la sesión
$id_empresa_actual = $_SESSION['id_empresa'];

// Función para mostrar mensajes y recargar la página
function mostrarMensaje($mensaje, $esError = false) {
    echo "<script>alert('$mensaje'); window.location.href = 'index_gerente.php';</script>";
    exit();
}

// Verificar si se ha enviado el ID a eliminar y la solicitud es GET
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id_gerente = $_GET['id'];

    // Consulta la base de datos para obtener información antes de la eliminación
    // ...

    // Luego, realiza la eliminación
    $sentencia = $conexion->prepare("DELETE FROM gerentes_generales WHERE id=:id AND id_empresa=:id_empresa");
    $sentencia->bindParam(":id", $id_gerente);
    $sentencia->bindParam(":id_empresa", $id_empresa_actual);
    $sentencia->execute();
    header("Location: index_gerente.php");
    exit();
}

// Resto de tu código para procesar el formulario y mostrar la lista de gerentes

$sentencia = $conexion->prepare("SELECT * FROM gerentes_generales WHERE id_empresa = :id_empresa");
$sentencia->bindParam(":id_empresa", $id_empresa_actual);
$sentencia->execute();
$gerentesGenerales = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2>Lista de Gerentes Generales</h2>
    <p>Aquí se muestra la lista de Gerentes Generales:</p>

    <?php if ($gerentesGenerales) : ?>
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
                    <?php foreach ($gerentesGenerales as $gerenteGeneral) : ?>
                        <tr>
                            <td><?php echo $gerenteGeneral['nombre']; ?></td>
                            <td><?php echo $gerenteGeneral['apellido']; ?></td>
                            <td><?php echo $gerenteGeneral['rut']; ?></td>
                            <td><?php echo $gerenteGeneral['cargo']; ?></td>
                            <td><?php echo $gerenteGeneral['correo']; ?></td>
                            <td>
                                <!-- Botones de acciones con espacio en blanco -->
                                <a href='./editar_gerente.php?id=<?php echo $gerenteGeneral['id']; ?>' class='btn btn-info btn-sm'>Editar</a>
                                <button class='btn btn-danger btn-sm' onclick='confirmarEliminacion(<?php echo $gerenteGeneral['id']; ?>)'>Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <p>No hay Gerentes Generales registrados.</p>
    <?php endif; ?>

    <div class="mt-3">
        <a href="<?php echo $url_base2; ?>gerente_general/crear_gerente.php" class="btn btn-primary">Agregar Gerente General</a>
    </div>

    <?php include("../templates/footer_empresa.php"); ?>
</div>

<!-- Agrega este script JavaScript al final del archivo -->
<script>
function confirmarEliminacion(id) {
    var confirmacion = confirm("¡Advertencia!\nEsta acción eliminará permanentemente al gerente y todos los datos asociados. ¿Estás seguro de continuar?");

    if (confirmacion) {
        window.location.href = "index_gerente.php?id=" + id;
    }
}
</script>
