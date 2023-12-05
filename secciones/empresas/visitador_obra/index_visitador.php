<?php
error_reporting(E_ALL);
include("../../../bd.php");

// Verificar si se ha enviado el ID a eliminar
if (isset($_GET['id'])) {
    $id_visitador = (isset($_GET['id'])) ? $_GET['id'] : "";

    $sentencia = $conexion->prepare("DELETE FROM visitadores_obra WHERE id=:id");
    $sentencia->bindParam(":id", $id_visitador);
    $sentencia->execute();
    header("Location: usuarios_visitadores.php");
    exit();
}

$sentencia = $conexion->prepare("SELECT * FROM visitadores_obra");
$sentencia->execute();
$visitadoresObras = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../templates/header_empresa.php"); ?>

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
                        <th scope="col">Contraseña</th>
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
                            <td><?php echo $visitador['contrasena']; ?></td>
                            <td>
                                <button class='btn btn-warning btn-sm'>Editar</button>
                                <a href='usuarios_visitadores.php?id=<?php echo $visitador['id']; ?>' class='btn btn-danger btn-sm'>Eliminar</a>
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
