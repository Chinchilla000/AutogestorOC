<?php
error_reporting(E_ALL);
include("../../../bd.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$id_empresa_actual = $_SESSION['id_empresa'];

// Verificar si se ha enviado el ID a eliminar y la solicitud es GET
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id_visitador = $_GET['id'];

    // Realiza la eliminación
    $sentencia = $conexion->prepare("DELETE FROM visitadores_obra WHERE id=:id AND id_empresa=:id_empresa");
    $sentencia->bindParam(":id", $id_visitador);
    $sentencia->bindParam(":id_empresa", $id_empresa_actual);
    if ($sentencia->execute()) {
        // Redirección si la eliminación fue exitosa
        header("Location: index_visitador.php");
        exit();
    } else {
        // Manejar error si la eliminación falló
        $error = "Error al eliminar el visitador.";
    }
}

include("../templates/header_empresa.php");

// Resto de tu código para mostrar la lista de visitadores
$sentencia = $conexion->prepare("SELECT * FROM visitadores_obra WHERE id_empresa = :id_empresa");
$sentencia->bindParam(":id_empresa", $id_empresa_actual);
$sentencia->execute();
$visitadoresObras = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2>Lista de Visitadores de Obras</h2>
    <p>Aquí se muestra la lista de Visitadores de Obras:</p>

    <?php if ($visitadoresObras) : ?>
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
                    <?php foreach ($visitadoresObras as $visitador) : ?>
                        <tr>
                            <td><?php echo $visitador['nombre']; ?></td>
                            <td><?php echo $visitador['apellido']; ?></td>
                            <td><?php echo $visitador['rut']; ?></td>
                            <td><?php echo $visitador['cargo']; ?></td>
                            <td><?php echo $visitador['correo']; ?></td>
                            <td>
                            <a href='./editar_visitador.php?id=<?php echo $visitador['id']; ?>' class='btn btn-info btn-sm'>Editar</a>
                                <button class='btn btn-danger btn-sm' onclick='confirmarEliminacion(<?php echo $visitador['id']; ?>)'>Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <p>No hay Visitadores de Obras registrados.</p>
    <?php endif; ?>

    <div class="mt-3">
        <a href="<?php echo $url_base2; ?>visitador_obra/crear_visitador.php" class="btn btn-primary">Agregar Visitador de Obras</a>
    </div>
</div>

<?php include("../templates/footer_empresa.php"); ?>

<!-- Agrega este script JavaScript al final del archivo -->
<script>
function confirmarEliminacion(id) {
    var confirmacion = confirm("¡Advertencia!\nEsta acción eliminará permanentemente al visitador y todos los datos asociados. ¿Estás seguro de continuar?");

    if (confirmacion) {
        window.location.href = "index_visitador.php?id=" + id;
    }
}
</script>
