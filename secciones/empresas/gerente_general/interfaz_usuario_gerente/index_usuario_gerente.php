<?php
error_reporting(E_ALL);
include("../../../../bd.php");
include("./templates_gerente/header_gerente.php");

// Obtener el ID del Gerente General
$gerenteId = $_SESSION['id_gerente'];

// Definir la ruta de la carpeta donde se guardarán las firmas en tu servidor
$rutaCarpeta = "C:/xampp/htdocs/proyectooc/firmas/";

// Obtener la firma actual del Gerente General desde la base de datos
$selectQuery = "SELECT firma_path FROM gerentes_generales WHERE id = :gerente_id";
$stmt = $conexion->prepare($selectQuery);
$stmt->bindParam(':gerente_id', $gerenteId);
$stmt->execute();
$gerente = $stmt->fetch(PDO::FETCH_ASSOC);

$firmaActual = isset($gerente['firma_path']) ? $gerente['firma_path'] : "";

// Verifica si se ha enviado el formulario para cargar la firma
if (isset($_FILES['firma']) && $_FILES['firma']['error'] === UPLOAD_ERR_OK) {
    // Generar un nombre de archivo único basado en el ID y la fecha actual
    $nombreArchivoUnico = $gerenteId . "_" . date("YmdHis") . ".png"; // Ajusta la extensión según el tipo de archivo

    // Definir la ruta completa del archivo en el servidor
    $rutaCotizacion = $rutaCarpeta . $nombreArchivoUnico;

    // Mover el archivo subido a la ruta de destino en el servidor
    if (move_uploaded_file($_FILES['firma']['tmp_name'], $rutaCotizacion)) {
        // El archivo se ha movido correctamente

        // Actualizar la base de datos con la ruta de la nueva firma para el Gerente General
        $updateQuery = "UPDATE gerentes_generales SET firma_path = :firma_path WHERE id = :gerente_id";
        $stmt = $conexion->prepare($updateQuery);
        $stmt->bindParam(':firma_path', $nombreArchivoUnico);
        $stmt->bindParam(':gerente_id', $gerenteId);
        $stmt->execute();

        // Redireccionar para evitar envío de formulario repetido
        header("Location: index_usuario_gerente.php");
        exit();
    } else {
        // Manejar el error en caso de que la carga del archivo falle
        echo "Error al subir el archivo.";
    }
}
?>
<div class="container mt-5">
    <h2>Bienvenido a la Plataforma de Gestión de la Gerente General</h2>
    <br>
    <h2><?php echo $_SESSION['nombre_gerente']; ?></h2>
    <br>
    <p>En esta página, puedes ver y administrar tus órdenes de compras de la Empresa: <?php echo $nombre_empresa; ?>.</p>

   
    </div>
</div>

<?php
include("./templates_gerente/footer_gerente.php");
?>
