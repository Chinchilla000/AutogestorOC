
<?php
error_reporting(E_ALL);
include("../../../bd.php");
include("../templates/header_empresa.php");

// Obtener el ID de la empresa actual desde la sesión

$id_empresa_actual = $_SESSION['id_empresa'];

// Verificar si se ha enviado el ID a eliminar
if (isset($_GET['id'])) {
    $id_gerente = $_GET['id'];

    $sentencia = $conexion->prepare("DELETE FROM gerentes_generales WHERE id = :id AND id_empresa = :id_empresa");
    $sentencia->bindParam(":id", $id_gerente);
    $sentencia->bindParam(":id_empresa", $id_empresa_actual);
    $sentencia->execute();
    header("Location: usuarios_gerentes.php");
    exit();
}

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
                                <button class='btn btn-warning btn-sm'>Editar</button>
                                <a href='usuarios_gerentes.php?id=<?php echo $gerenteGeneral['id']; ?>' class='btn btn-danger btn-sm'>Eliminar</a>
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
