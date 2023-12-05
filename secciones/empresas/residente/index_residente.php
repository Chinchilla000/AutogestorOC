<?php include("../templates/header_empresa.php"); ?>
<div class="container mt-5">
    <h2>Lista de Residentes de Obras</h2>
    <p>Aquí se muestra la lista de Residentes de Obras:</p>

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
                // Ejemplo de Residentes de Obras (puedes obtener estos datos de tu base de datos)
                $residentesObras = [
                    ["Carlos", "Rodríguez", "23456789-0", "Residente de Obras", "carlos@example.com", "clave789"],
                    ["Laura", "González", "34567890-1", "Residente de Obras", "laura@example.com", "contraseña999"],
                    // Puedes agregar más Residentes de Obras aquí
                ];

                foreach ($residentesObras as $residente) {
                    echo "<tr>";
                    echo "<td>{$residente[0]}</td>";
                    echo "<td>{$residente[1]}</td>";
                    echo "<td>{$residente[2]}</td>";
                    echo "<td>{$residente[3]}</td>";
                    echo "<td>{$residente[4]}</td>";
                    echo "<td>{$residente[5]}</td>";
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
        <a href="<?php echo $url_base2;?>residente/crear_residente.php" class="btn btn-primary">Agregar Residente de Obras</a>
    </div>
</div>
<?php include("../templates/footer_empresa.php"); ?>