<?php
include("../../../../bd.php");
include("./templates_gerente/header_gerente.php");

if (!isset($_GET['id'])) {
    header("Location: ordenes_compra.php");
    exit;
}

$id_orden_compra = $_GET['id'];

try {
    // Consulta para obtener los detalles de la orden de compra
    $queryOrdenCompra = "SELECT * FROM ordenes_de_compra WHERE id_orden_compra = ?";
    $stmt = $conexion->prepare($queryOrdenCompra);
    $stmt->bindParam(1, $id_orden_compra, PDO::PARAM_INT);
    $stmt->execute();
    $ordenCompra = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($ordenCompra) {
        // Consulta para obtener los ítems relacionados
        $queryItems = "SELECT * FROM detalles_solicitud_orden_compra WHERE id_orden_compra = ?";
        $stmtItems = $conexion->prepare($queryItems);
        $stmtItems->bindParam(1, $id_orden_compra, PDO::PARAM_INT);
        $stmtItems->execute();
        $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

        // Función para formatear números en formato chileno
        function formatoChileno($numero) {
            return number_format($numero, 0, ',', '.');
        }
?>
        <div class="container mt-5">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Detalle de Orden de Compra #<?php echo str_pad($id_orden_compra, 4, '0', STR_PAD_LEFT) . "-" . date('Y'); ?></h2>
                </div>
                <div class="card-body">
                    <!-- Encabezado con número de orden de compra y fecha -->
                    <div class="row mb-4">
                        <div class="col text-center">
                            <strong>Número de Orden de Compra: <?php echo str_pad($id_orden_compra, 4, '0', STR_PAD_LEFT) . "-" . date('Y'); ?></strong>
                        </div>
                        <div class="col text-center">
                            <strong>Fecha de Creación: <?php echo date('d/m/Y', strtotime($ordenCompra['fecha_creacion'])); ?></strong>
                        </div>
                    </div>

                    <!-- Información General -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>Obra:</strong></label>
                            <input type="text" class="form-control" value="<?php echo $ordenCompra['obra']; ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>Dirección:</strong></label>
                            <input type="text" class="form-control" value="<?php echo $ordenCompra['direccion']; ?>" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Solicitado por:</strong></label>
                        <input type="text" class="form-control" value="<?php echo $ordenCompra['solicitado_por']; ?>" readonly>
                    </div>

                    <!-- Detalles de los Ítems -->
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th>Ítem</th>
                                    <th>Descripción</th>
                                    <th>Unidad</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Total Ítem</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td><?php echo $item['item']; ?></td>
                                        <td><?php echo $item['descripcion']; ?></td>
                                        <td><?php echo $item['unidad']; ?></td>
                                        <td><?php echo $item['cantidad']; ?></td>
                                        <td>$<?php echo formatoChileno($item['precio_unitario']); ?></td>
                                        <td>$<?php echo formatoChileno($item['total_item']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Método de Pago y Campos Relacionados -->
                    <div class="row mt-4">
                        <!-- Columna izquierda con detalles del método de pago -->
                        <div class="col-md-6 mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Nombre:</strong></label>
                                    <input type="text" class="form-control" value="<?php echo $ordenCompra['nombre_pago']; ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><strong>RUT:</strong></label>
                                    <input type="text" class="form-control" value="<?php echo $ordenCompra['rut_pago']; ?>" readonly>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Correo:</strong></label>
                                    <input type="email" class="form-control" value="<?php echo $ordenCompra['correo_pago']; ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Banco:</strong></label>
                                    <input type="text" class="form-control" value="<?php echo $ordenCompra['banco']; ?>" readonly>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Número de Cuenta:</strong></label>
                                    <input type="text" class="form-control" value="<?php echo $ordenCompra['numero_cuenta']; ?>" readonly>
                                </div>
                                <?php if ($ordenCompra['metodo_pago'] == 'credito'): ?>
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Fecha de Pago:</strong></label>
                                    <input type="text" class="form-control" value="<?php echo $ordenCompra['fecha_pago']; ?>" readonly>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Columna derecha con selección de método de pago -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>Método de Pago:</strong></label>
                            <input type="text" class="form-control" value="<?php echo $ordenCompra['metodo_pago']; ?>" readonly>
                        </div>
                    </div>

                    <!-- Botón para volver atrás -->
                    <div class="text-center mt-3">
                        <a href="historial_ordenes_compra.php" class="btn btn-secondary btn-lg">Volver a Historial OC</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        // Manejo de caso en el que no se encontraron resultados
        echo "No se encontraron resultados para esta orden de compra.";
    }
} catch (PDOException $e) {
    // Manejo de errores de la base de datos
    echo "Error en la base de datos: " . $e->getMessage();
    exit();
}

include("./templates_gerente/footer_gerente.php");
?>