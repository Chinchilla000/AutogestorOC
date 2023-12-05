<?php
error_reporting(E_ALL);
include("../../../bd.php");

// Verificar si se ha enviado el ID a eliminar
if (isset($_GET['id'])) {
    $id_residente = (isset($_GET['id'])) ? $_GET['id'] : "";

    $sentencia = $conexion->prepare("DELETE FROM residentes_obra WHERE id=:id");
    $sentencia->bindParam(":id", $id_residente);
    $sentencia->execute();
    header("Location: usuarios_residentes.php");
    exit();
}

$sentencia = $conexion->prepare("SELECT * FROM residentes_obra");
$sentencia->execute();
$residentesObras = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../templates/header_empresa.php"); ?>

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
                        <th scope="col">Contraseña</th>
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
                            <td><?php echo $residente['contrasena']; ?></td>
                            <td>
                                <button class='btn btn-warning btn-sm'>Editar</button>
                                <a href='usuarios_residentes.php?id=<?php echo $residente['id']; ?>' class='btn btn-danger btn-sm'>Eliminar</a>
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
