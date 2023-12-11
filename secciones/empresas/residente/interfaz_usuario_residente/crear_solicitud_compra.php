<?php 
error_reporting(E_ALL);
include("../../../../bd.php"); 
include("./templates_residente/header_residente.php");

$id_residente = $_SESSION['id_residente'];
$id_empresa = null;

// Obtener el id_empresa
$sentencia = $conexion->prepare("SELECT id_empresa FROM residentes_obra WHERE id = :id_residente");
$sentencia->bindParam(':id_residente', $id_residente, PDO::PARAM_INT);
$sentencia->execute();
$resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

if ($resultado) {
    $id_empresa = $resultado['id_empresa'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $obra = $_POST['obra'];
    $domicilio = $_POST['domicilio'];
    $solicitado_por = $_POST['solicitado_por'];
    $metodo_pago = $_POST['metodo_pago'];

    // Inicializar variables de pago
    $nombre_pago = '';
    $rut_pago = '';
    $correo_pago = '';
    $banco = null;
    $numero_cuenta = null;

    // Asignar valores basados en el método de pago
    if ($metodo_pago == 'efectivo') {
        $nombre_pago = $_POST['nombre_efectivo'] ?? '';
        $rut_pago = $_POST['rut_efectivo'] ?? '';
        $correo_pago = $_POST['correo_efectivo'] ?? '';
    } elseif ($metodo_pago == 'transferencia') {
        $nombre_pago = $_POST['nombre_transferencia'] ?? '';
        $rut_pago = $_POST['rut_transferencia'] ?? '';
        $correo_pago = $_POST['correo_transferencia'] ?? '';
        $banco = $_POST['banco'] ?? '';
        $numero_cuenta = $_POST['numero_cuenta'] ?? '';
    }

    $total_neto = $_POST['total_neto'];
    $iva = $_POST['iva'];
    $total = $_POST['total'];
    
     // Subida de archivo de cotización
// Subida de archivo de cotización
if (isset($_FILES['cotizacion']) && $_FILES['cotizacion']['error'] === UPLOAD_ERR_OK) {
    $archivoCotizacion = $_FILES['cotizacion']['name'];
    $extension = pathinfo($archivoCotizacion, PATHINFO_EXTENSION);

    // Generar un nombre de archivo único
    $nombreArchivoUnico = "cotizacion_" . date('YmdHis') . "_" . uniqid() . "." . $extension;

    // Definir la ruta de destino
    $rutaCarpeta = "../cotizacion_solicitudes/"; // Asegúrate de que esta carpeta exista y tenga permisos de escritura
    $rutaCotizacion = $rutaCarpeta . $nombreArchivoUnico;

    // Mover el archivo subido a la ruta de destino
    if (move_uploaded_file($_FILES['cotizacion']['tmp_name'], $rutaCotizacion)) {
        // El archivo se ha movido correctamente
        // Aquí puedes seguir con la inserción en la base de datos, utilizando $rutaCotizacion
    } else {
        // Manejar el error en caso de que la carga del archivo falle
        echo "Error al subir el archivo.";
    }
} else {
    // Manejar casos en los que no se haya subido un archivo o haya ocurrido un error
    echo "No se subió ningún archivo o se produjo un error.";
}
     // Insertar solicitud en la tabla de solicitudes
     $stmt = $conexion->prepare("INSERT INTO solicitudes_orden_compra (id_residente, id_empresa, obra, domicilio, solicitado_por, total_neto, iva, total, metodo_pago, nombre_pago, rut_pago, correo_pago, banco, numero_cuenta, archivo_cotizacion, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'En espera')");     $stmt->bindParam(1, $id_residente);
     $stmt->bindParam(2, $id_empresa);
    $stmt->bindParam(3, $obra);
    $stmt->bindParam(4, $domicilio);
    $stmt->bindParam(5, $solicitado_por);
    $stmt->bindParam(6, $total_neto);
    $stmt->bindParam(7, $iva);
    $stmt->bindParam(8, $total);
    $stmt->bindParam(9, $metodo_pago);
    $stmt->bindParam(10, $nombre_pago);
    $stmt->bindParam(11, $rut_pago);
    $stmt->bindParam(12, $correo_pago);
    $stmt->bindParam(13, $banco);
    $stmt->bindParam(14, $numero_cuenta);
    $stmt->bindParam(15, $rutaCotizacion);
    $stmt->execute();
    $id_solicitud = $conexion->lastInsertId();


    // Insertar detalles de la solicitud
    $items = $_POST['item'];
    $descripciones = $_POST['descripcion'];
    $unidades = $_POST['unidad'];
    $cantidades = $_POST['cantidad'];
    $precios_unitarios = $_POST['precio_unitario'];
    $totales_item = $_POST['total_item'];

    $stmt = $conexion->prepare("INSERT INTO detalles_solicitud_orden_compra (id_solicitud, item, descripcion, unidad, cantidad, precio_unitario, total_item) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    foreach ($items as $i => $item) {
        $stmt->bindParam(1, $id_solicitud);
        $stmt->bindParam(2, $items[$i]);
        $stmt->bindParam(3, $descripciones[$i]);
        $stmt->bindParam(4, $unidades[$i]);
        $stmt->bindParam(5, $cantidades[$i]);
        $stmt->bindParam(6, $precios_unitarios[$i]);
        $stmt->bindParam(7, $totales_item[$i]);
        $stmt->execute();
    }

    echo "<script>
            alert('Solicitud enviada con éxito.');
            window.location.href = './index_usuario_residente.php';
          </script>";
    exit; // Asegúrate de llamar a exit para detener la ejecución del script.
}
?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h2 class="mb-4">Solicitud de Orden de Compra</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        
        <div class="mb-3">
            <label for="obra" class="form-label">Obra:</label>
            <input type="text" id="obra" name="obra" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="domicilio" class="form-label">Domicilio:</label>
            <input type="text" id="domicilio" name="domicilio" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="solicitado_por" class="form-label">Solicitado por:</label>
            <input type="text" id="solicitado_por" name="solicitado_por" class="form-control" required>
        </div>

        <!-- Detalles de los Ítems -->
        <div id="items_container" class="mb-3">
            <label class="form-label">Ítems:</label>
            <div class="input-group mb-3">
                <input type="text" name="item[]" class="form-control" placeholder="Ítem" required>
                <input type="text" name="descripcion[]" class="form-control" placeholder="Descripción" required>
                <input type="text" name="unidad[]" class="form-control" placeholder="Unidad" required>
                <input type="number" name="cantidad[]" class="form-control" placeholder="Cantidad" required step="1" oninput="calcularTotalItem(this)">
                <input type="number" name="precio_unitario[]" class="form-control" placeholder="Precio Unitario" required step="1" oninput="calcularTotalItem(this)">
                <input type="text" name="total_item[]" class="form-control" placeholder="Total Ítem" readonly>
                <button type="button" onclick="eliminarItem(this)">X</button>
            </div>
        </div>
        <button type="button" id="add_item" class="btn btn-primary mb-3" onclick="agregarItem()">Añadir Ítem</button>

        <!-- Totales -->
        <div class="card mt-4">
        <div class="card-body">
            <h4>Totales</h4>
            <div class="mt-4">
                    <label for="total_neto" class="form-label">Total Neto:</label>
                    <input type="number" id="total_neto" name="total_neto" class="form-control" readonly>
                </div>
                <div class="mt-4">
                    <label for="iva" class="form-label">IVA (19%):</label>
                    <input type="number" id="iva" name="iva" class="form-control" readonly>
                </div>
                <div class="mt-4 mb-4">
                    <label for="total" class="form-label">Total:</label>
                    <input type="number" id="total" name="total" class="form-control" readonly>
                </div>
        </div>
    </div>
        <!-- Subir Cotización -->
        <div class="mb-3">
            <label for="cotizacion" class="form-label">Cotización:</label>
            <input type="file" id="cotizacion" name="cotizacion" class="form-control" accept=".pdf, .jpg, .jpeg, .png">
        </div>

        <!-- Método de Pago -->
        <div class="mb-3">
            <label for="metodo_pago" class="form-label">Método de Pago:</label>
            <select id="metodo_pago" name="metodo_pago" class="form-select">
                <option value="efectivo">Efectivo</option>
                <option value="transferencia">Transferencia</option>
            </select>
        </div>


        <!-- Método de Pago -->
        <div id="datos_pago_transferencia" class="mb-3" style="display:none;">
    <!-- Campos para Transferencia -->
    <label>Nombre:</label>
    <input type="text" name="nombre_transferencia" class="form-control">
    <label>RUT:</label>
    <input type="text" name="rut_transferencia" class="form-control">
    <label>Banco:</label>
    <input type="text" name="banco" class="form-control">
    <label>Número de Cuenta:</label>
    <input type="text" name="numero_cuenta" class="form-control">
    <label>Correo:</label>
    <input type="email" name="correo_transferencia" class="form-control">
</div>


<!-- Datos adicionales de pago -->
<div id="datos_pago_efectivo" class="mb-3" style="display:none;">
    <!-- Campos para Efectivo -->
    <label>Nombre:</label>
    <input type="text" name="nombre_efectivo" class="form-control">
    <label>RUT:</label>
    <input type="text" name="rut_efectivo" class="form-control">
    <label>Correo:</label>
    <input type="email" name="correo_efectivo" class="form-control">
</div>

<!-- Botón de Envío -->
<input type="submit" value="Enviar Solicitud" class="btn btn-success">



    </form>
    </div>
        </div>
    </div>

<!-- Aquí iría el pie de página o cualquier otro contenido adicional -->
<script>
var itemCount = 0; // Mantiene el seguimiento del número de ítems

function agregarItem() {
    if (!todosLosCamposLlenos()) {
        alert("Por favor, complete todos los campos del ítem actual antes de añadir uno nuevo.");
        return;
    }

    var container = document.getElementById('items_container');
    var itemHtml = `
        <div class="input-group mb-3" id="item_${itemCount}">
            <input type="text" name="item[]" class="form-control" placeholder="Ítem" required>
            <input type="text" name="descripcion[]" class="form-control" placeholder="Descripción" required>
            <input type="text" name="unidad[]" class="form-control" placeholder="Unidad" required>
            <input type="number" name="cantidad[]" class="form-control" placeholder="Cantidad" required step="1" oninput="calcularTotalItem(this)">
            <input type="number" name="precio_unitario[]" class="form-control" placeholder="Precio Unitario" required step="1" oninput="calcularTotalItem(this)">
            <input type="text" name="total_item[]" class="form-control" placeholder="Total Ítem" readonly>
            <button type="button" onclick="eliminarItem(${itemCount})">X</button>
        </div>`;

    var newDiv = document.createElement('div');
    newDiv.innerHTML = itemHtml;
    container.appendChild(newDiv);

    asignarEventosOnInput(itemCount);

    itemCount++; // Incrementar el contador de ítems después de agregar uno nuevo
}

function todosLosCamposLlenos() {
    var inputs = document.querySelectorAll('#items_container .input-group:last-child input');
    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].type !== 'button' && inputs[i].value === '') {
            return false;
        }
    }
    return true;
}

function asignarEventosOnInput(index) {
    var cantidadInputs = document.getElementsByName('cantidad[]')[index];
    var precioUnitarioInputs = document.getElementsByName('precio_unitario[]')[index];

    cantidadInputs.oninput = function() { calcularTotalItem(this); };
    precioUnitarioInputs.oninput = function() { calcularTotalItem(this); };
}

function eliminarItem(index) {
    var itemDiv = document.getElementById('item_' + index);
    if (itemDiv) {
        itemDiv.parentNode.removeChild(itemDiv);
    }
}

function calcularTotalItem(input) {
    var itemDiv = input.closest('.input-group');
    var cantidad = itemDiv.querySelector('[name="cantidad[]"]').value;
    var precioUnitario = itemDiv.querySelector('[name="precio_unitario[]"]').value;
    var totalItem = itemDiv.querySelector('[name="total_item[]"]');
    var total = parseFloat(cantidad) * parseFloat(precioUnitario);
    
    if (!isNaN(total)) {
        totalItem.value = total.toFixed(2);
    }
}
//totales

function calcularTotales() {
    var totalNeto = 0;
    var totalItems = document.getElementsByName('total_item[]');
    
    for (var i = 0; i < totalItems.length; i++) {
        totalNeto += parseFloat(totalItems[i].value) || 0;
    }

    var iva = Math.round(totalNeto * 0.19); // Redondea el 19% de IVA
    var total = Math.round(totalNeto + iva); // Redondea el total

    document.getElementById('total_neto').value = Math.round(totalNeto);
    document.getElementById('iva').value = iva;
    document.getElementById('total').value = total;
}

function calcularTotalItem(input) {
    var itemDiv = input.closest('.input-group');
    var cantidad = itemDiv.querySelector('[name="cantidad[]"]').value;
    var precioUnitario = itemDiv.querySelector('[name="precio_unitario[]"]').value;
    var totalItem = itemDiv.querySelector('[name="total_item[]"]');
    var total = parseFloat(cantidad) * parseFloat(precioUnitario);

    if (!isNaN(total)) {
        totalItem.value = Math.round(total);
        calcularTotales(); // Actualizar totales cada vez que se cambia un ítem
    }
}
// Función para manejar el cambio en el método de pago
function cambiarMetodoPago() {
        var metodo = document.getElementById('metodo_pago').value;
        var datosTransferencia = document.getElementById('datos_pago_transferencia');
        var datosEfectivo = document.getElementById('datos_pago_efectivo');

        // Mostrar/Ocultar campos basados en la selección
        if (metodo === 'transferencia') {
            datosTransferencia.style.display = 'block';
            datosEfectivo.style.display = 'none';
        } else if (metodo === 'efectivo') {
            datosTransferencia.style.display = 'none';
            datosEfectivo.style.display = 'block';
        }
    }

    // Agregar listener al selector de método de pago
    document.getElementById('metodo_pago').addEventListener('change', cambiarMetodoPago);

    // Ejecutar al cargar para establecer el estado inicial
    window.onload = function() {
        cambiarMetodoPago(); // Ajustar la visibilidad inicial de los campos
    };
</script>



<?php include("./templates_residente/footer_residente.php"); ?>

