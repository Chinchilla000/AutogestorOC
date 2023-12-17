<?php 
error_reporting(E_ALL);
include("../../../../bd.php"); 
include("./templates_residente/header_residente.php");

$id_residente = $_SESSION['id_residente'];
$id_empresa = null;

// Obtener el último número de solicitud y calcular el nuevo número
$stmt = $conexion->prepare("SELECT MAX(id_solicitud) AS ultimo_id FROM solicitudes_orden_compra");
$stmt->execute();
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

$ultimoNumero = 0;
if ($resultado && $resultado['ultimo_id']) {
    $ultimoNumero = intval($resultado['ultimo_id']);
}
$nuevoNumero = $ultimoNumero + 1;

$numeroSolicitud = str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT) . "-" . date('Y');

// Obtener la fecha actual
$fechaActual = date('d/m/Y');


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
    $direccion = $_POST['direccion'];
    $solicitado_por = $_POST['solicitado_por'];
    $metodo_pago = $_POST['metodo_pago'];

    // Inicializar variables de pago
    $nombre_pago = '';
    $rut_pago = '';
    $correo_pago = '';
    $banco = null;
    $numero_cuenta = null;

     // Asignar valores basados en el método de pago
     $nombre_pago = $_POST['nombre_pago'] ?? '';
     $rut_pago = $_POST['rut_pago'] ?? '';
     $correo_pago = $_POST['correo_pago'] ?? '';
     $banco = $_POST['banco'] ?? ''; 
     $numero_cuenta = $_POST['numero_cuenta'] ?? '';
     $fecha_pago = $_POST['fecha_pago'] ?? '';

    

    $total_neto = $_POST['total_neto'];
    $iva = $_POST['iva'];
    $total = $_POST['total'];
    
    // Lógica para manejar la fecha de pago
    if ($metodo_pago == 'efectivo') {
        $fecha_pago = NULL; // Fecha de pago en NULL si es efectivo
    } else {
        $fecha_pago = $_POST['fecha_pago'] ?? NULL;
    }



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
     $stmt = $conexion->prepare("INSERT INTO solicitudes_orden_compra 
     (id_residente, id_empresa, obra, direccion, solicitado_por, total_neto, iva, total, metodo_pago, nombre_pago, rut_pago, correo_pago, banco, numero_cuenta, archivo_cotizacion, estado, fecha_pago) 
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'En espera', ?)");

    // Vinculación de los parámetros a la consulta
    $stmt->bindParam(1, $id_residente);
    $stmt->bindParam(2, $id_empresa);
    $stmt->bindParam(3, $obra);
    $stmt->bindParam(4, $direccion);
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
    $stmt->bindParam(16, $fecha_pago); // Vincula la fecha de pago
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

    // Redirección tras la inserción exitosa
        echo "<script>
        alert('Solicitud enviada con éxito.');
        window.location.href = './index_usuario_residente.php';
        </script>";
        exit;
        }
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header text-center">
            <h2>Solicitud de Orden de Compra</h2>
        </div>
        <div class="card-body">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                <!-- Encabezado con número de solicitud y fecha/hora -->
                <div class="row ">
                <div class="col text-center">
                        <strong>Número de Solicitud: <?php echo $numeroSolicitud; ?></strong>
                    </div>
                    <div class="col text-center">
                        <strong>Fecha: <?php echo $fechaActual; ?></strong>
                    </div>
                    
                </div>
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label for="obra" class="form-label"><strong>Obra:</strong></label>
                        <input type="text" id="obra" name="obra" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="direccion" class="form-label"><strong>Dirección:</strong></label>
                        <input type="text" id="direccion" name="direccion" class="form-control" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="solicitado_por" class="form-label"><strong>Solicitado por:</strong></label>
                    <input type="text" id="solicitado_por" name="solicitado_por" class="form-control" required>
                </div>

                <!-- Detalles de los Ítems -->
                <div id="items_container" class="mb-3">
            <label class="form-label"><strong>Ítems:</strong></label>
            <div class="input-group mb-3" id="item_${itemCount}">
    <input type="text" name="item[]" class="form-control" placeholder="Ítem" required>
    <input type="text" name="descripcion[]" class="form-control" placeholder="Descripción" required>
    <select name="unidad[]" class="form-control" required>
        <option value="" disabled selected>Seleccionar Unidad</option>
        <option value="m2">m2</option>
        <option value="m3">m3</option>
        <option value="c/u">c/u</option>
        <option value="GL">GL</option>
    </select>
    <input type="number" name="cantidad[]" class="form-control" placeholder="Cantidad" required step="1" oninput="calcularTotalItem(this)">
    <span class="input-group-text">$</span>
    <input type="number" name="precio_unitario[]" class="form-control" placeholder="Precio Unitario" required step="1" oninput="calcularTotalItem(this)">
    <span class="input-group-text">$</span>
    <input type="text" name="total_item[]" class="form-control" placeholder="Total Ítem" readonly>
    <button type="button" onclick="eliminarItem(${itemCount})">X</button>
</div>
            </div>
                <button type="button" id="add_item" class="btn btn-primary mb-3" onclick="agregarItem()">Añadir Ítem</button>

                 <!-- Sección Totales, utilizando prepend en los campos -->
                 <div class="row mt-4">
                <div class="col-md-4">
                    <label for="total_neto" class="form-label"><strong>Total Neto:</strong></label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">$</span>
                        <input type="text" id="total_neto" name="total_neto" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="iva" class="form-label"><strong>IVA (19%):</strong></label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon2">$</span>
                        <input type="text" id="iva" name="iva" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="total" class="form-label"><strong>Total:</strong></label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon3">$</span>
                        <input type="text" id="total" name="total" class="form-control" readonly>
                    </div>
                </div>
            </div>



        <!-- Subir Cotización -->
        <div class="mb-3">
                    <label for="cotizacion" class="form-label"><strong>Cotización:</strong></label>
                    <input type="file" id="cotizacion" name="cotizacion" class="form-control" accept=".pdf, .jpg, .jpeg, .png" required>
                </div>


<!-- Método de Pago y Campos Relacionados -->
<div class="row mt-4">
    <!-- Campos adicionales que aparecen según el método de pago seleccionado -->
    <div id="datos_pago_credito_efectivo" class="col-md-6 mb-3" style="display:none;">
        <div class="row">
            <div class="col-md-6">
                <label><strong>Nombre:</strong></label>
                <input type="text" name="nombre_pago" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label><strong>RUT:</strong></label>
                <input type="text" name="rut_pago" class="form-control" required>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-6">
                <label><strong>Correo:</strong></label>
                <input type="email" name="correo_pago" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label><strong>Banco:</strong></label>
                <input type="text" name="banco" class="form-control" required>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-6">
                <label><strong>Número de Cuenta:</strong></label>
                <input type="text" name="numero_cuenta" class="form-control" required>
            </div>
            <div id="fecha_pago_credito" class="col-md-6 mb-3" style="display:none;">
        <label><strong>Fecha de Pago:</strong></label>
        <select name="fecha_pago" class="form-select" required>
            <option value="">Selecciona</option>
            <option value="15">15 días</option>
            <option value="30">30 días</option>
            <option value="45">45 días</option>
            <option value="60">60 días</option>
        </select>
    </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label for="metodo_pago" class="form-label"><strong>Método de Pago:</strong></label>
        <select id="metodo_pago" name="metodo_pago" class="form-select" onchange="mostrarCamposPago()">
            <option value="efectivo">Efectivo</option>
            <option value="credito">Crédito</option>
        </select>
    </div>


        <!-- Botón de Envío -->
        <div class="text-center mt-4">
                    <input type="submit" value="Enviar Solicitud" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Aquí iría el pie de página o cualquier otro contenido adicional -->
<script>
var itemCount = 0; // Mantiene el seguimiento del número de ítems
function formatearNumero(numero) {
    return numero.toLocaleString('es-CL'); // Cambia 'es-ES' según tu localización deseada
}
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
            <select name="unidad[]" class="form-control" required>
                <option value="" disabled selected>Seleccionar Unidad</option>
                <option value="m2">m2</option>
                <option value="m3">m3</option>
                <option value="c/u">c/u</option>
                <option value="GL">GL</option>
            </select>
            <input type="number" name="cantidad[]" class="form-control" placeholder="Cantidad" required step="1" oninput="calcularTotalItem(this)">
            <span class="input-group-text">$</span>
            <input type="number" name="precio_unitario[]" class="form-control" placeholder="Precio Unitario" required step="1" oninput="calcularTotalItem(this)">
            <span class="input-group-text">$</span>
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
        calcularTotales(); // Actualizar los totales después de eliminar un ítem
    }
}

function calcularTotalItem(input) {
    var itemDiv = input.closest('.input-group');
    var cantidad = parseFloat(itemDiv.querySelector('[name="cantidad[]"]').value.replace(/\./g, '').replace(',', '.')) || 0;
    var precioUnitario = parseFloat(itemDiv.querySelector('[name="precio_unitario[]"]').value.replace(/\./g, '').replace(',', '.')) || 0;

    var total = cantidad * precioUnitario;
    var totalItem = itemDiv.querySelector('[name="total_item[]"]');

    if (!isNaN(total)) {
        totalItem.value = Math.floor(total); // Muestra el total como número entero
        calcularTotales(); // Actualizar totales cada vez que se cambia un ítem
    }
}

function calcularTotales() {
    var totalNeto = 0;
    var totalItems = document.getElementsByName('total_item[]');

    for (var i = 0; i < totalItems.length; i++) {
        var totalItemValue = totalItems[i].value.replace(/\./g, '').replace(',', '.');
        totalNeto += parseFloat(totalItemValue) || 0;
    }

    var iva = totalNeto * 0.19;
    var total = totalNeto + iva;

    // Asigna los valores directamente sin formatear como número entero
    document.getElementById('total_neto').value = totalNeto.toFixed(0);
    document.getElementById('iva').value = iva.toFixed(0);
    document.getElementById('total').value = total.toFixed(0);
}






// Función para manejar el cambio en el método de pago
function mostrarCamposPago() {
    var metodo = document.getElementById('metodo_pago').value;
    var fechaPagoCredito = document.getElementById('fecha_pago_credito');
    var selectFechaPago = document.querySelector('select[name="fecha_pago"]');

    // Mostrar siempre los campos comunes
    var datosCreditoEfectivo = document.getElementById('datos_pago_credito_efectivo');
    datosCreditoEfectivo.style.display = 'block';

    // Controlar la visibilidad y requerimiento del campo Fecha de Pago
    if (metodo === 'credito') {
        fechaPagoCredito.style.display = 'block';
        selectFechaPago.required = true;
    } else {
        fechaPagoCredito.style.display = 'none';
        selectFechaPago.required = false;
    }
}

// Asegúrate de llamar a mostrarCamposPago al cargar la página para configurar el estado inicial
window.onload = mostrarCamposPago;

    
    document.addEventListener("DOMContentLoaded", function() {
    var formulario = document.querySelector('form.needs-validation');

    formulario.addEventListener('submit', function(event) {
        if (!formulario.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        formulario.classList.add('was-validated');
    }, false);
});
</script>



<?php include("./templates_residente/footer_residente.php"); ?>