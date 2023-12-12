<?php 
error_reporting(E_ALL);
include("../../../../bd.php");
include("./templates_residente/header_residente.php"); 

$id_residente = $_SESSION['id_residente'] ?? null;

// Lógica para eliminar una solicitud
if (isset($_GET['eliminar']) && isset($_GET['id_solicitud'])) {
    $id_solicitud = $_GET['id_solicitud'];

    // Verificar si el estado de la solicitud es 'En espera'
    $stmt = $conexion->prepare("SELECT estado FROM solicitudes_orden_compra WHERE id_solicitud = :id_solicitud");
    $stmt->bindParam(':id_solicitud', $id_solicitud, PDO::PARAM_INT);
    $stmt->execute();
    $solicitud = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($solicitud && $solicitud['estado'] == 'En espera') {
        // Primero, eliminar los detalles relacionados
        $stmt = $conexion->prepare("DELETE FROM detalles_solicitud_orden_compra WHERE id_solicitud = :id_solicitud");
        $stmt->bindParam(':id_solicitud', $id_solicitud, PDO::PARAM_INT);
        $stmt->execute();

        // Luego, eliminar la solicitud
        $stmt = $conexion->prepare("DELETE FROM solicitudes_orden_compra WHERE id_solicitud = :id_solicitud");
        $stmt->bindParam(':id_solicitud', $id_solicitud, PDO::PARAM_INT);
        $stmt->execute();

        // Mensaje de alerta
        echo "<script>alert('Solicitud eliminada con éxito.'); window.location.href='estado_solicitudes.php';</script>";
        exit;
    } else {
        echo "<script>alert('No se puede eliminar la solicitud.'); window.location.href='estado_solicitudes.php';</script>";
        exit;
    }
}
if ($id_residente) {
    $stmt = $conexion->prepare("SELECT * FROM solicitudes_orden_compra WHERE id_residente = :id_residente ORDER BY fecha_creacion DESC");
    $stmt->bindParam(':id_residente', $id_residente, PDO::PARAM_INT);
    $stmt->execute();
    $solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<div class='container mt-5'>";
    echo "<h3>Sus Solicitudes Enviadas</h3>";
    echo "<table class='table'>";
    echo "<thead><tr><th>N° Solicitud</th><th>Obra</th><th>Domicilio</th><th>Total</th><th>Fecha de Creación</th><th>Estado</th><th>Archivo Cotización</th><th>Acciones</th></tr></thead>";
    echo "<tbody>";

    foreach ($solicitudes as $solicitud) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($solicitud['id_solicitud']) . "</td>";
        echo "<td>" . htmlspecialchars($solicitud['obra']) . "</td>";
        echo "<td>" . htmlspecialchars($solicitud['domicilio']) . "</td>";
        echo "<td>" . htmlspecialchars($solicitud['total']) . "</td>";
        echo "<td>" . htmlspecialchars($solicitud['fecha_creacion']) . "</td>";
        echo "<td>" . htmlspecialchars($solicitud['estado']) . "</td>";

        if (!empty($solicitud['archivo_cotizacion'])) {
            echo "<td><a href='" . htmlspecialchars($solicitud['archivo_cotizacion']) . "' target='_blank'>Ver Cotización</a></td>";
        } else {
            echo "<td>No disponible</td>";
        }

        // Acciones disponibles solo si el estado es "espera"
        if ($solicitud['estado'] == 'En espera') {
            echo "<td><a class='btn btn-primary btn-sm' href='editar_solicitud.php?id_solicitud=" . $solicitud['id_solicitud'] . "'>Editar</a> <a class='btn btn-danger btn-sm' href='?eliminar=1&id_solicitud=" . $solicitud['id_solicitud'] . "' onclick='return confirm(\"¿Estás seguro de querer eliminar esta solicitud?\")'>Eliminar</a></td>";
        } else {
            echo "<td>Acciones no disponibles</td>";
        }

        echo "</tr>";
    }

    echo "</tbody></table></div>";
} else {
    echo "<div class='container mt-5'><p>Error: No se pudo identificar al residente.</p></div>";
}

include("./templates_residente/footer_residente.php"); 
?>