<?php
include("../../bd.php");

$sentencia = $conexion->prepare("SELECT * FROM empresas");
$sentencia->execute();
$lista_empresas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include("templates/header_adm.php"); ?>
<div class="container mt-5">
    <h2>Bienvenido al Panel de Administración</h2>
    <p>Aquí puedes controlar y administrar todas las funciones del sitio.</p>

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
                <!-- Agrega más columnas según tu tabla -->
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
                    <!-- Agrega más columnas según tu tabla -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>
<?php include("templates/footer_adm.php"); ?>