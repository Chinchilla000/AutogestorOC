<?php include("../templates/header_empresa.php"); ?>


<div class="container mt-5">
    <h2>Lista de Visitadores de Obras</h2>
    <p>Aquí se muestra la lista de Visitadores de Obras:</p>

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
                // Ejemplo de Visitadores de Obras (puedes obtener estos datos de tu base de datos)
                $visitadoresObras = [
                    ["Ana", "Martínez", "45678901-2", "Visitador de Obras", "ana@example.com", "clave456"],
                    ["Pedro", "López", "56789012-3", "Visitador de Obras", "pedro@example.com", "contraseña789"],
                    // Puedes agregar más Visitadores de Obras aquí
                ];

                foreach ($visitadoresObras as $visitador) {
                    echo "<tr>";
                    echo "<td>{$visitador[0]}</td>";
                    echo "<td>{$visitador[1]}</td>";
                    echo "<td>{$visitador[2]}</td>";
                    echo "<td>{$visitador[3]}</td>";
                    echo "<td>{$visitador[4]}</td>";
                    echo "<td>{$visitador[5]}</td>";
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
        <a href="<?php echo $url_base2;?>visitador_obra/crear_visitador.php" class="btn btn-primary">Agregar Visitador de Obras</a>
    </div>
</div>



<?php include("../templates/footer_empresa.php"); ?>