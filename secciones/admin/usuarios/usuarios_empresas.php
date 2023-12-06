<?php
error_reporting(E_ALL);
include("../../../bd.php");

// Verificar si se ha enviado el ID a eliminar y la solicitud es GET
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id_empresa = $_GET['id'];

    // Consulta la base de datos para obtener información antes de la eliminación
    // ...

    // Luego, realiza la eliminación
    $sentencia = $conexion->prepare("DELETE FROM empresas WHERE id=:id");
    $sentencia->bindParam(":id", $id_empresa);
    $sentencia->execute();
    header("Location: usuarios_empresas.php");
    exit();
}

$sentencia = $conexion->prepare("SELECT * FROM empresas");
$sentencia->execute();
$lista_empresas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../templates/header_adm.php"); ?>
<div class="container mt-5">
    <h2>Panel de Usuarios</h2>
    <p>Aquí puedes controlar y administrar todos los Usuarios Empresas.</p>

    <?php if (count($lista_empresas) > 0) : ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre de Usuario</th>
                        <th scope="col">Nombre o Razón Social</th>
                        <th scope="col">Rut de la Empresa</th>
                        <th scope="col">Giro Comercial</th>
                        <th scope="col">Correo Electrónico de la Empresa</th>
                        <th scope="col">Número de Contacto</th>
                        <th scope="col">Fecha de Registro</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_empresas as $empresa) : ?>
                        <tr>
                            <td><?php echo $empresa['id']; ?></td>
                            <td><?php echo $empresa['nombre_usuario']; ?></td>
                            <td><?php echo $empresa['nombre_empresa']; ?></td>
                            <td><?php echo $empresa['rut_empresa']; ?></td>
                            <td><?php echo $empresa['giro_comercial']; ?></td>
                            <td><?php echo $empresa['correo_empresa']; ?></td>
                            <td><?php echo $empresa['numero_contacto']; ?></td>
                            <td><?php echo $empresa['fecha_registro']; ?></td>
                            <td>
                                <!-- Botones de acciones con espacio en blanco -->
                                <a href="usuarios_empresas.php?id=<?php echo $empresa['id']; ?>" class="btn btn-warning btn-sm">Editar</a>&nbsp;
                                <button class="btn btn-danger btn-sm" onclick="confirmarEliminacion(<?php echo $empresa['id']; ?>)">Eliminar</button>
                            </td>
                            <!-- Agrega más columnas según tu tabla -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <p>No hay Usuarios Empresas registrados.</p>
    <?php endif; ?>
</div>

<?php include("../templates/footer_adm.php"); ?>

<!-- Agrega este script JavaScript al final del archivo -->
<script>
function confirmarEliminacion(id) {
    var confirmacion = confirm("¡Advertencia!\nEsta acción eliminará permanentemente la empresa y todos los usuarios asociados. ¿Estás seguro de continuar?");

    if (confirmacion) {
        window.location.href = "usuarios_empresas.php?id=" + id;
    }
}
</script>
