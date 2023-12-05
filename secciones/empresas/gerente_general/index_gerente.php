<?php include("../templates/header_empresa.php"); ?>

<div class="container mt-5">
    <h2>Lista de Gerentes Generales</h2>
    <p>Aquí se muestra la lista de Gerentes Generales:</p>

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
                <?php
                // Ejemplo de Gerentes Generales (puedes obtener estos datos de tu base de datos)
                $gerentesGenerales = [
                    ["Juan", "Pérez", "12345678-9", "Gerente General", "juan@example.com", "contraseña123"],
                    ["María", "Gómez", "98765432-1", "Gerente General", "maria@example.com", "clave456"],
                    // Puedes agregar más Gerentes Generales aquí
                ];

                foreach ($gerentesGenerales as $gerenteGeneral) {
                    echo "<tr>";
                    echo "<td>{$gerenteGeneral[0]}</td>";
                    echo "<td>{$gerenteGeneral[1]}</td>";
                    echo "<td>{$gerenteGeneral[2]}</td>";
                    echo "<td>{$gerenteGeneral[3]}</td>";
                    echo "<td>{$gerenteGeneral[4]}</td>";
                    echo "<td>{$gerenteGeneral[5]}</td>";
                    echo "<td>
                            <button class='btn btn-warning btn-sm'>Editar</button>
                            <button class='btn btn-danger btn-sm'>Eliminar</button>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        <a href="<?php echo $url_base2;?>gerente_general/crear_gerente.php" class="btn btn-primary">Agregar Gerente General</a>
    </div>

    <?php include("../templates/footer_empresa.php"); ?>
